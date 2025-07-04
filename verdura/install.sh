#!/bin/bash

# Script de instalación automática para Gestor de Pedidos Pro
# Uso: sudo bash install.sh

set -e

echo "=== Instalación de Gestor de Pedidos Pro ==="

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Función para mostrar mensajes
log() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
    exit 1
}

# Verificar que se ejecute como root
if [[ $EUID -ne 0 ]]; then
   error "Este script debe ejecutarse como root (usa sudo)"
fi

# Detectar distribución
if [ -f /etc/debian_version ]; then
    DISTRO="debian"
    PKG_MANAGER="apt"
elif [ -f /etc/redhat-release ]; then
    DISTRO="redhat"
    PKG_MANAGER="yum"
else
    error "Distribución no soportada"
fi

log "Distribución detectada: $DISTRO"

# Actualizar sistema
log "Actualizando sistema..."
if [ "$DISTRO" = "debian" ]; then
    apt update && apt upgrade -y
else
    yum update -y
fi

# Instalar dependencias
log "Instalando dependencias..."
if [ "$DISTRO" = "debian" ]; then
    apt install -y apache2 php php-mysql php-mbstring mysql-server unzip wget curl
    a2enmod rewrite
    systemctl enable apache2 mysql
    systemctl start apache2 mysql
else
    yum install -y httpd php php-mysql php-mbstring mariadb-server unzip wget curl
    systemctl enable httpd mariadb
    systemctl start httpd mariadb
fi

# Configurar MySQL
log "Configurando base de datos..."
read -p "Ingresa la contraseña para el usuario de base de datos: " -s DB_PASSWORD
echo

mysql -u root <<EOF
CREATE DATABASE IF NOT EXISTS order_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'order_user'@'localhost' IDENTIFIED BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON order_manager.* TO 'order_user'@'localhost';
FLUSH PRIVILEGES;
EOF

# Descargar CodeIgniter
log "Descargando CodeIgniter..."
cd /var/www/html
if [ -d "order-manager" ]; then
    warn "El directorio order-manager ya existe. Creando backup..."
    mv order-manager order-manager.backup.$(date +%Y%m%d_%H%M%S)
fi

wget -q https://github.com/bcit-ci/CodeIgniter/archive/3.1.13.zip
unzip -q 3.1.13.zip
mv CodeIgniter-3.1.13 order-manager
rm 3.1.13.zip

# Configurar permisos
log "Configurando permisos..."
chown -R www-data:www-data /var/www/html/order-manager
chmod -R 755 /var/www/html/order-manager
chmod -R 777 /var/www/html/order-manager/application/cache
chmod -R 777 /var/www/html/order-manager/application/logs

# Configurar Apache
log "Configurando Apache..."
cat > /etc/apache2/sites-available/order-manager.conf <<EOF
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot /var/www/html/order-manager
    
    <Directory /var/www/html/order-manager>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog \${APACHE_LOG_DIR}/order-manager_error.log
    CustomLog \${APACHE_LOG_DIR}/order-manager_access.log combined
</VirtualHost>
EOF

if [ "$DISTRO" = "debian" ]; then
    a2ensite order-manager.conf
    systemctl reload apache2
else
    # Para CentOS/RHEL
    cp /etc/apache2/sites-available/order-manager.conf /etc/httpd/conf.d/
    systemctl reload httpd
fi

# Generar clave de encriptación
ENCRYPTION_KEY=$(openssl rand -hex 16)

# Configurar aplicación
log "Configurando aplicación..."
read -p "Ingresa el dominio o IP del servidor (ej: localhost, midominio.com): " DOMAIN

# Crear archivo de configuración de base de datos
cat > /var/www/html/order-manager/application/config/database.php <<EOF
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

\$active_group = 'default';
\$query_builder = TRUE;

\$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'order_user',
    'password' => '$DB_PASSWORD',
    'database' => 'order_manager',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
EOF

# Actualizar configuración principal
sed -i "s|http://localhost/order-manager/|http://$DOMAIN/|g" /var/www/html/order-manager/application/config/config.php
sed -i "s|tu_clave_secreta_de_32_caracteres_aqui|$ENCRYPTION_KEY|g" /var/www/html/order-manager/application/config/config.php

# Importar schema de base de datos
log "Importando schema de base de datos..."
mysql -u order_user -p$DB_PASSWORD order_manager <<EOF
-- Tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'approved',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_by INT NULL,
    approved_at TIMESTAMP NULL,
    FOREIGN KEY (approved_by) REFERENCES users(id)
);

-- Tabla de productos
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    unit VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) DEFAULT 0,
    qty_dom_mie INT DEFAULT 0,
    qty_jue INT DEFAULT 0,
    qty_vie INT DEFAULT 0,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Tabla de pedidos
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'sent', 'delivered') DEFAULT 'pending',
    supplier_email VARCHAR(255),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabla de items de pedidos
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    unit VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- Tabla de configuraciones
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(255) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Datos iniciales
INSERT INTO users (email, password, name, role, status) VALUES 
('admin@empresa.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'admin', 'approved'),
('usuario@empresa.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Usuario Demo', 'user', 'approved');

INSERT INTO products (name, unit, category, price, qty_dom_mie, qty_jue, qty_vie, created_by) VALUES
('Tomates', 'kg', 'Verduras', 2500, 5, 8, 10, 1),
('Lechuga', 'unidades', 'Verduras', 1200, 3, 5, 7, 1),
('Pan', 'barras', 'Panadería', 800, 10, 15, 20, 1);

INSERT INTO settings (setting_key, setting_value) VALUES
('company_name', 'Gestor de Pedidos Pro'),
('default_supplier_email', 'proveedor@ejemplo.com'),
('currency', 'ARS');
EOF

# Configurar backup automático
log "Configurando backup automático..."
mkdir -p /backups
cat > /usr/local/bin/backup-order-manager.sh <<EOF
#!/bin/bash
DATE=\$(date +%Y%m%d_%H%M%S)
mysqldump -u order_user -p'$DB_PASSWORD' order_manager > /backups/order_manager_\$DATE.sql
tar -czf /backups/order_manager_files_\$DATE.tar.gz /var/www/html/order-manager
find /backups -name "order_manager_*" -mtime +7 -delete
EOF

chmod +x /usr/local/bin/backup-order-manager.sh

# Agregar a crontab para backup diario a las 2 AM
(crontab -l 2>/dev/null; echo "0 2 * * * /usr/local/bin/backup-order-manager.sh") | crontab -

# Configurar firewall básico
log "Configurando firewall..."
if command -v ufw &> /dev/null; then
    ufw allow 80/tcp
    ufw allow 443/tcp
    ufw allow 22/tcp
    ufw --force enable
elif command -v firewall-cmd &> /dev/null; then
    firewall-cmd --permanent --add-service=http
    firewall-cmd --permanent --add-service=https
    firewall-cmd --permanent --add-service=ssh
    firewall-cmd --reload
fi

# Mostrar información final
log "¡Instalación completada exitosamente!"
echo
echo "=== INFORMACIÓN DE ACCESO ==="
echo "URL: http://$DOMAIN"
echo "Credenciales por defecto:"
echo "  Admin: admin@empresa.com / admin123"
echo "  Usuario: usuario@empresa.com / user123"
echo
echo "=== INFORMACIÓN DE BASE DE DATOS ==="
echo "Base de datos: order_manager"
echo "Usuario: order_user"
echo "Contraseña: $DB_PASSWORD"
echo
echo "=== ARCHIVOS IMPORTANTES ==="
echo "Aplicación: /var/www/html/order-manager"
echo "Logs Apache: /var/log/apache2/ (o /var/log/httpd/)"
echo "Logs aplicación: /var/www/html/order-manager/application/logs/"
echo "Backups: /backups/"
echo
echo "=== PRÓXIMOS PASOS ==="
echo "1. Cambia las contraseñas por defecto"
echo "2. Configura SSL/HTTPS para producción"
echo "3. Personaliza la configuración en la aplicación"
echo
warn "IMPORTANTE: Cambia las contraseñas por defecto antes de usar en producción"

# Reiniciar servicios
systemctl restart apache2 2>/dev/null || systemctl restart httpd 2>/dev/null
systemctl restart mysql 2>/dev/null || systemctl restart mariadb 2>/dev/null

log "Servicios reiniciados. El sistema está listo para usar."
