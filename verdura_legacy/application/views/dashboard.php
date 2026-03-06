<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestor de Pedidos Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .product-card {
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-2px);
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantity-display {
            min-width: 60px;
            text-align: center;
            font-weight: bold;
            font-size: 1.2em;
        }
        .tab-content {
            margin-top: 2rem;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .order-card {
            border-left: 4px solid #667eea;
        }
        .status-badge {
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-shopping-cart me-2"></i>
                Gestor de Pedidos Pro
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Bienvenido, <?= $user->name ?> (<?= $user->role === 'admin' ? 'Administrador' : 'Usuario' ?>)
                </span>
                <a class="btn btn-outline-light btn-sm" href="<?= base_url('logout') ?>">
                    <i class="fas fa-sign-out-alt me-1"></i>Salir
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shopping-cart fa-2x me-3"></i>
                            <div>
                                <h5 class="card-title mb-0">Total Pedidos</h5>
                                <h2 class="mb-0"><?= $stats['total'] ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar fa-2x me-3"></i>
                            <div>
                                <h5 class="card-title mb-0">Este Mes</h5>
                                <h2 class="mb-0"><?= $stats['this_month'] ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="mainTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="order-tab" data-bs-toggle="tab" data-bs-target="#order" type="button">
                    <i class="fas fa-plus me-2"></i>Nuevo Pedido
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button">
                    <i class="fas fa-history me-2"></i>Historial
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button">
                    <i class="fas fa-cog me-2"></i>Configuración
                </button>
            </li>
            <?php if ($user->role === 'admin'): ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button">
                    <i class="fas fa-users me-2"></i>Administración
                </button>
            </li>
            <?php endif; ?>
        </ul>

        <div class="tab-content" id="mainTabsContent">
            <!-- Nuevo Pedido Tab -->
            <div class="tab-pane fade show active" id="order" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Crear Nuevo Pedido</h5>
                        <small class="text-muted">Cantidades sugeridas para hoy (<?= getDayName() ?>)</small>
                    </div>
                    <div class="card-body">
                        <!-- Filtros -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="searchProducts" placeholder="Buscar productos...">
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="categoryFilter">
                                    <option value="all">Todas las categorías</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->category ?>"><?= $category->category ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Lista de Productos -->
                        <div id="productsList" class="row">
                            <?php if (empty($products)): ?>
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay productos disponibles</p>
                                <?php if ($user->role === 'admin'): ?>
                                <p class="text-muted">Ve a la pestaña de Administración para agregar productos</p>
                                <?php endif; ?>
                            </div>
                            <?php else: ?>
                            <?php foreach ($products as $product): ?>
                            <div class="col-md-6 col-lg-4 mb-3 product-item" data-category="<?= $product->category ?>" data-name="<?= strtolower($product->name) ?>">
                                <div class="card product-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="card-title mb-1"><?= $product->name ?></h6>
                                                <span class="badge bg-secondary"><?= $product->category ?></span>
                                                <small class="d-block text-muted"><?= $product->unit ?></small>
                                            </div>
                                        </div>
                                        <div class="quantity-controls">
                                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity(<?= $product->id ?>, -1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <div class="quantity-display" id="qty-<?= $product->id ?>">0</div>
                                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity(<?= $product->id ?>, 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted d-block mt-2">
                                            Sugerido: <?= getDayQuantity($product) ?> <?= $product->unit ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Notas del pedido -->
                        <div class="mt-4">
                            <label for="orderNotes" class="form-label">Aclaraciones para el proveedor (opcional)</label>
                            <textarea class="form-control" id="orderNotes" rows="3" placeholder="Ej: Entregar antes de las 10am, tomates bien maduros..."></textarea>
                        </div>

                        <!-- Email del proveedor -->
                        <div class="mt-3">
                            <label for="supplierEmail" class="form-label">Email del proveedor</label>
                            <input type="email" class="form-control" id="supplierEmail" value="proveedor@ejemplo.com" placeholder="proveedor@ejemplo.com">
                        </div>

                        <!-- Botón de envío -->
                        <div class="mt-4 text-center">
                            <button class="btn btn-primary btn-lg" id="sendOrderBtn" onclick="sendOrder()" disabled>
                                <i class="fas fa-envelope me-2"></i>Enviar Pedido por Email
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial Tab -->
            <div class="tab-pane fade" id="history" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Historial de Pedidos</h5>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download me-1"></i>Exportar
                        </button>
                    </div>
                    <div class="card-body">
                        <?php if (empty($orders)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay pedidos registrados</p>
                        </div>
                        <?php else: ?>
                        <div class="row">
                            <?php foreach ($orders as $order): ?>
                            <div class="col-12 mb-3">
                                <div class="card order-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-title">
                                                    Pedido #<?= $order->id ?>
                                                    <?php if ($user->role === 'admin'): ?>
                                                    - <?= $order->user_name ?>
                                                    <?php endif; ?>
                                                </h6>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y H:i', strtotime($order->created_at)) ?>
                                                </small>
                                                <div class="mt-2">
                                                    <?php 
                                                    if (isset($order->items)) {
                                                        $items = explode('|', $order->items);
                                                        foreach ($items as $item): 
                                                            $item_parts = explode(':', $item);
                                                            if (count($item_parts) >= 2):
                                                    ?>
                                                    <small class="d-block">• <?= $item_parts[0] ?>: <?= $item_parts[1] ?></small>
                                                    <?php 
                                                            endif;
                                                        endforeach; 
                                                    }
                                                    ?>
                                                </div>
                                                <?php if (!empty($order->notes)): ?>
                                                <div class="mt-2">
                                                    <small class="text-muted"><strong>Notas:</strong> <?= $order->notes ?></small>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-<?= getStatusColor($order->status) ?> status-badge">
                                                    <?= getStatusText($order->status) ?>
                                                </span>
                                                <div class="mt-2">
                                                    <strong>$<?= number_format($order->total, 0, ',', '.') ?></strong>
                                                </div>
                                                <?php if ($user->role === 'admin'): ?>
                                                <select class="form-select form-select-sm mt-2" onchange="updateOrderStatus(<?= $order->id ?>, this.value)">
                                                    <option value="pending" <?= $order->status === 'pending' ? 'selected' : '' ?>>Pendiente</option>
                                                    <option value="sent" <?= $order->status === 'sent' ? 'selected' : '' ?>>Enviado</option>
                                                    <option value="delivered" <?= $order->status === 'delivered' ? 'selected' : '' ?>>Entregado</option>
                                                </select>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Configuración Tab -->
            <div class="tab-pane fade" id="settings" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Configuración General</h5>
                    </div>
                    <div class="card-body">
                        <form id="settingsForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="companyName" class="form-label">Nombre de la empresa</label>
                                        <input type="text" class="form-control" id="companyName" name="company_name" value="Gestor de Pedidos Pro">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="currency" class="form-label">Moneda</label>
                                        <select class="form-select" id="currency" name="currency">
                                            <option value="ARS">ARS ($)</option>
                                            <option value="USD">USD ($)</option>
                                            <option value="EUR">EUR (€)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="supplierEmailSetting" class="form-label">Email del proveedor por defecto</label>
                                <input type="email" class="form-control" id="supplierEmailSetting" name="supplier_email" value="proveedor@ejemplo.com">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Configuración
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Admin Tab -->
            <?php if ($user->role === 'admin'): ?>
            <div class="tab-pane fade" id="admin" role="tabpanel">
                <div class="row">
                    <!-- Gestión de Productos -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Gestión de Productos</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2 mb-3">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                                        <i class="fas fa-plus me-2"></i>Agregar Producto
                                    </button>
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
                                        <i class="fas fa-upload me-2"></i>Carga Masiva
                                    </button>
                                </div>
                                <div style="max-height: 400px; overflow-y: auto;">
                                    <?php foreach ($products as $product): ?>
                                    <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                                        <div>
                                            <strong><?= $product->name ?></strong>
                                            <small class="d-block text-muted"><?= $product->category ?> • <?= $product->unit ?></small>
                                        </div>
                                        <div>
                                            <button class="btn btn-sm btn-outline-primary me-1" onclick="editProduct(<?= $product->id ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteProduct(<?= $product->id ?>, '<?= $product->name ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gestión de Usuarios -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Gestión de Usuarios</h5>
                            </div>
                            <div class="card-body">
                                <button class="btn btn-primary mb-3 w-100" data-bs-toggle="modal" data-bs-target="#userModal">
                                    <i class="fas fa-user-plus me-2"></i>Crear Usuario
                                </button>
                                <div style="max-height: 400px; overflow-y: auto;">
                                    <?php if (isset($users)): ?>
                                    <?php foreach ($users as $userData): ?>
                                    <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                                        <div>
                                            <strong><?= $userData->name ?></strong>
                                            <small class="d-block text-muted"><?= $userData->email ?></small>
                                            <span class="badge bg-<?= $userData->role === 'admin' ? 'primary' : 'secondary' ?>">
                                                <?= $userData->role === 'admin' ? 'Admin' : 'Usuario' ?>
                                            </span>
                                        </div>
                                        <div>
                                            <?php if ($userData->id != $user->id): ?>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteUser(<?= $userData->id ?>, '<?= $userData->name ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modales -->
    <!-- Modal de Producto -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalTitle">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <input type="hidden" id="productId" name="id">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="productName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="productUnit" class="form-label">Unidad</label>
                            <input type="text" class="form-control" id="productUnit" name="unit" placeholder="kg, unidades, litros..." required>
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="productCategory" name="category" required>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Precio (opcional)</label>
                            <input type="number" class="form-control" id="productPrice" name="price" min="0" step="0.01">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="qtyDomMie" class="form-label">Dom-Mié</label>
                                <input type="number" class="form-control" id="qtyDomMie" name="qty_dom_mie" min="0">
                            </div>
                            <div class="col-md-4">
                                <label for="qtyJue" class="form-label">Jueves</label>
                                <input type="number" class="form-control" id="qtyJue" name="qty_jue" min="0">
                            </div>
                            <div class="col-md-4">
                                <label for="qtyVie" class="form-label">Viernes</label>
                                <input type="number" class="form-control" id="qtyVie" name="qty_vie" min="0">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveProduct()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Carga Masiva -->
    <div class="modal fade" id="bulkUploadModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Carga Masiva de Productos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="csvData" class="form-label">Datos CSV</label>
                        <textarea class="form-control" id="csvData" rows="10" placeholder="name,unit,category,price,qty_dom_mie,qty_jue,qty_vie
Tomates,kg,Verduras,2500,5,8,10
Lechuga,unidades,Verduras,1200,3,5,7"></textarea>
                    </div>
                    <div class="alert alert-info">
                        <strong>Formato:</strong> name,unit,category,price,qty_dom_mie,qty_jue,qty_vie<br>
                        <strong>Ejemplo:</strong> Tomates,kg,Verduras,2500,5,8,10
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="bulkUpload()">Cargar Productos</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Usuario -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" id="userName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="userPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Rol</label>
                            <select class="form-select" id="userRole" name="role" required>
                                <option value="user">Usuario</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveUser()">Crear Usuario</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentOrder = {};
        const products = <?= json_encode($products) ?>;
        let editingProductId = null;

        function updateQuantity(productId, change) {
            if (!currentOrder[productId]) {
                currentOrder[productId] = 0;
            }
            
            currentOrder[productId] = Math.max(0, currentOrder[productId] + change);
            document.getElementById('qty-' + productId).textContent = currentOrder[productId];
            
            updateSendButton();
        }

        function updateSendButton() {
            const hasItems = Object.values(currentOrder).some(qty => qty > 0);
            document.getElementById('sendOrderBtn').disabled = !hasItems;
        }

        function sendOrder() {
            const orderItems = [];
            let total = 0;
            
            for (let productId in currentOrder) {
                if (currentOrder[productId] > 0) {
                    const product = products.find(p => p.id == productId);
                    if (product) {
                        orderItems.push({
                            name: product.name,
                            quantity: currentOrder[productId],
                            unit: product.unit,
                            price: product.price || 0
                        });
                        total += (product.price || 0) * currentOrder[productId];
                    }
                }
            }
            
            if (orderItems.length === 0) {
                alert('Selecciona al menos un producto');
                return;
            }
            
            const formData = new FormData();
            formData.append('items', JSON.stringify(orderItems));
            formData.append('total', total);
            formData.append('supplier_email', document.getElementById('supplierEmail').value);
            formData.append('notes', document.getElementById('orderNotes').value);
            
            fetch('<?= base_url('orders/create') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pedido enviado exitosamente');
                    currentOrder = {};
                    document.querySelectorAll('.quantity-display').forEach(el => el.textContent = '0');
                    document.getElementById('orderNotes').value = '';
                    updateSendButton();
                    
                    // Generar email
                    generateEmailLink(orderItems, total);
                } else {
                    alert('Error al enviar pedido: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                alert('Error de conexión');
            });
        }

        function generateEmailLink(items, total) {
            const subject = 'Pedido - Gestor de Pedidos Pro';
            let body = 'Hola,\n\nPedido de: <?= $user->name ?>\n';
            body += 'Fecha: ' + new Date().toLocaleDateString('es-ES') + '\n\n';
            body += 'Productos solicitados:\n\n';
            
            items.forEach(item => {
                body += '- ' + item.name + ': ' + item.quantity + ' ' + item.unit + '\n';
            });
            
            const notes = document.getElementById('orderNotes').value;
            if (notes) {
                body += '\nAclaraciones:\n' + notes + '\n';
            }
            
            body += '\nTotal: $' + total.toLocaleString('es-AR') + '\n\nGracias.';
            
            const supplierEmail = document.getElementById('supplierEmail').value;
            const mailtoLink = 'mailto:' + supplierEmail + '?subject=' + 
                encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
            
            window.open(mailtoLink);
        }

        function updateOrderStatus(orderId, status) {
            const formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('status', status);
            
            fetch('<?= base_url('orders/update_status') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al actualizar estado');
                }
            });
        }

        // Filtros de productos
        document.getElementById('searchProducts').addEventListener('input', filterProducts);
        document.getElementById('categoryFilter').addEventListener('change', filterProducts);

        function filterProducts() {
            const search = document.getElementById('searchProducts').value.toLowerCase();
            const category = document.getElementById('categoryFilter').value;
            
            document.querySelectorAll('.product-item').forEach(item => {
                const name = item.dataset.name;
                const itemCategory = item.dataset.category;
                
                const matchesSearch = name.includes(search);
                const matchesCategory = category === 'all' || itemCategory === category;
                
                item.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
            });
        }

        // Gestión de productos
        function saveProduct() {
            const form = document.getElementById('productForm');
            const formData = new FormData(form);
            
            const url = editingProductId ? 
                '<?= base_url('products/edit/') ?>' + editingProductId : 
                '<?= base_url('products/create') ?>';
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(editingProductId ? 'Producto actualizado' : 'Producto creado');
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                alert('Error de conexión');
            });
        }

        function editProduct(id) {
            editingProductId = id;
            document.getElementById('productModalTitle').textContent = 'Editar Producto';
            
            fetch('<?= base_url('products/edit/') ?>' + id)
            .then(response => response.json())
            .then(product => {
                document.getElementById('productName').value = product.name;
                document.getElementById('productUnit').value = product.unit;
                document.getElementById('productCategory').value = product.category;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('qtyDomMie').value = product.qty_dom_mie;
                document.getElementById('qtyJue').value = product.qty_jue;
                document.getElementById('qtyVie').value = product.qty_vie;
                
                new bootstrap.Modal(document.getElementById('productModal')).show();
            });
        }

        function deleteProduct(id, name) {
            if (confirm('¿Estás seguro de eliminar el producto "' + name + '"?')) {
                fetch('<?= base_url('products/delete/') ?>' + id, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Producto eliminado');
                        location.reload();
                    } else {
                        alert('Error al eliminar producto');
                    }
                });
            }
        }

        function bulkUpload() {
            const csvData = document.getElementById('csvData').value;
            if (!csvData.trim()) {
                alert('Ingresa los datos CSV');
                return;
            }
            
            const formData = new FormData();
            formData.append('csv_data', csvData);
            
            fetch('<?= base_url('products/bulk_upload') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Error desconocido'));
                }
            });
        }

        // Gestión de usuarios
        function saveUser() {
            const form = document.getElementById('userForm');
            const formData = new FormData(form);
            
            fetch('<?= base_url('admin/create_user') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Usuario creado exitosamente');
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Error desconocido'));
                }
            });
        }

        function deleteUser(id, name) {
            if (confirm('¿Estás seguro de eliminar el usuario "' + name + '"?')) {
                fetch('<?= base_url('admin/delete_user/') ?>' + id, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Usuario eliminado');
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Error desconocido'));
                    }
                });
            }
        }

        // Configuración
        document.getElementById('settingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('<?= base_url('settings/save') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Configuración guardada');
                } else {
                    alert('Error al guardar configuración');
                }
            });
        });

        // Reset modal cuando se cierra
        document.getElementById('productModal').addEventListener('hidden.bs.modal', function() {
            editingProductId = null;
            document.getElementById('productModalTitle').textContent = 'Agregar Producto';
            document.getElementById('productForm').reset();
        });

        // Inicializar
        updateSendButton();
    </script>
</body>
</html>

<?php
function getDayQuantity($product) {
    $day = date('w');
    if ($day >= 0 && $day <= 3) {
        return $product->qty_dom_mie;
    } elseif ($day == 4) {
        return $product->qty_jue;
    } elseif ($day == 5) {
        return $product->qty_vie;
    } else {
        return $product->qty_dom_mie;
    }
}

function getDayName() {
    $day = date('w');
    if ($day >= 0 && $day <= 3) {
        return 'Dom-Mié';
    } elseif ($day == 4) {
        return 'Jueves';
    } elseif ($day == 5) {
        return 'Viernes';
    } else {
        return 'Dom-Mié';
    }
}

function getStatusColor($status) {
    switch ($status) {
        case 'delivered': return 'success';
        case 'sent': return 'warning';
        case 'pending': return 'secondary';
        default: return 'secondary';
    }
}

function getStatusText($status) {
    switch ($status) {
        case 'delivered': return 'Entregado';
        case 'sent': return 'Enviado';
        case 'pending': return 'Pendiente';
        default: return 'Pendiente';
    }
}
?>
