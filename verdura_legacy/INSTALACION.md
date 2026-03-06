# Instalación del Gestor de Pedidos Pro

## Requisitos del Sistema

- Apache 2.4+
- PHP 7.4+ (recomendado PHP 8.0+)
- MySQL 5.7+ o MariaDB 10.3+
- Extensiones PHP: mysqli, mbstring, json

## Instalación Paso a Paso

### 1. Preparar el Servidor

#### Ubuntu/Debian:
\`\`\`bash
sudo apt update
sudo apt install apache2 php php-mysql php-mbstring mysql-server
sudo a2enmod rewrite
sudo systemctl restart apache2
\`\`\`

#### CentOS/RHEL:
\`\`\`bash
sudo yum install httpd php php-mysql php-mbstring mariadb-server
sudo systemctl enable httpd mariadb
sudo systemctl start httpd mariadb
\`\`\`

### 2. Descargar CodeIgniter

\`\`\`bash
cd /var/www/html
wget https://github.com/bcit-ci/CodeIgniter/archive/3.1.13.zip
unzip 3.1.13.zip
mv CodeIgniter-3.1.13 order-manager
\`\`\`

### 3. Configurar Permisos

\`\`\`bash
sudo chown -R www-data:www-data /var/www/html/order-manager
sudo chmod -R 755 /var/www/html/order-manager
sudo chmod -R 777 /var/www/html/order-manager/application/cache
sudo chmod -R 777 /var/www/html/order-manager/application/logs
\`\`\`

### 4. Configurar Base de Datos

\`\`\`bash
sudo mysql -u root -p
\`\`\`

\`\`\`sql
CREATE DATABASE order_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'order_user'@'localhost' IDENTIFIED BY 'tu_password_seguro';
GRANT ALL PRIVILEGES ON order_manager.* TO 'order_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
\`\`\`

Importar el schema:
\`\`\`bash
mysql -u order_user -p order_manager < database/schema.sql
\`\`\`

### 5. Configurar Apache

Crear archivo `/etc/apache2/sites-available/order-manager.conf`:

```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    DocumentRoot /var/www/html/order-manager
    
    <Directory /var/www/html/order-manager>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/order-manager_error.log
    CustomLog ${APACHE_LOG_DIR}/order-manager_access.log combined
</VirtualHost>
