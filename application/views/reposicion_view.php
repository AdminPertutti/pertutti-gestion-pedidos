<?php
$ci = &get_instance();
$ci->load->model("reposicion_model");
echo $respuesta;
?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Reposición | Pertutti Lomas</title>

    <!-- CSS Moderno -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --dark-color: #2c3e50;
            --light-bg: #f8f9fa;
            --sidebar-width: 280px;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 18px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Botón hamburguesa */
        .hamburger-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            z-index: 1002;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .hamburger-btn:hover {
            background: #2980b9;
            transform: scale(1.05);
        }

        .hamburger-btn.active {
            background: var(--danger-color);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: -280px;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--dark-color) 0%, #34495e 100%);
            z-index: 1001;
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-title {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-subtitle {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Buscador de lote */
        .sidebar-search {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .search-form {
            display: flex;
            gap: 5px;
        }

        .search-input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 5px;
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 0.9rem;
        }

        .search-input::placeholder {
            color: rgba(255,255,255,0.6);
        }

        .search-btn {
            padding: 8px 12px;
            background: var(--primary-color);
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover:not(:disabled) {
            background: #2980b9;
        }

        .search-btn:disabled {
            background: rgba(255,255,255,0.2);
            cursor: not-allowed;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 30px;
        }

        .nav-section-title {
            color: rgba(255,255,255,0.6);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 20px 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--primary-color);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: rgba(52, 152, 219, 0.2);
            color: white;
            border-left-color: var(--primary-color);
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        /* Submenu */
        .nav-submenu {
            background: rgba(0,0,0,0.2);
            margin-top: 5px;
        }

        .nav-submenu .nav-link {
            padding-left: 50px;
            font-size: 0.9rem;
        }

        /* Overlay para cerrar sidebar */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .content-wrapper {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin: 20px;
            overflow: hidden;
            padding: 0;
            padding-bottom: 100px;
            transition: all 0.3s ease;
        }

        .content-header {
            background: linear-gradient(135deg, var(--primary-color), #2980b9);
            color: white;
            padding: 2rem;
            text-align: center;
            margin: 0;
            padding-top: 80px;
        }

        .content-header h1 {
            color: white;
            margin-bottom: 0.5rem;
            font-size: 2.2rem;
            font-weight: 700;
        }

        .content-header small {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
        }

        .category-section {
            margin: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .category-header {
            background: linear-gradient(135deg, var(--success-color), #229954);
            color: white;
            padding: 1.2rem 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.3rem;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.2rem;
            padding: 1.8rem;
        }

        .product-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 1.3rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.15);
            transform: translateY(-2px);
        }

        .product-card.selected {
            border-color: var(--success-color);
            background: linear-gradient(135deg, #d5f4e6, #fafffe);
        }

        .product-name {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1.2rem;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
            line-height: 1.4;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }

        .quantity-input-group {
            display: flex;
            align-items: center;
            background: var(--light-bg);
            border-radius: 30px;
            padding: 8px;
            flex: 1;
        }

        .quantity-btn {
            width: 42px;
            height: 42px;
            border: none;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 16px;
        }

        .quantity-btn:hover {
            background: #2980b9;
            transform: scale(1.1);
        }

        .quantity-btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
        }

        .quantity-input {
            border: none;
            background: transparent;
            text-align: center;
            font-weight: 700;
            font-size: 1.4rem;
            width: 70px;
            color: var(--dark-color);
            padding: 8px;
        }

        .quantity-input:focus {
            outline: none;
        }

        .quick-add-btns {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .quick-add-btn {
            border: none;
            border-radius: 18px;
            padding: 8px 14px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            color: white;
            min-width: 45px;
        }

        .quick-add-btn.add-5, .quick-add-btn.add-10 {
            background: var(--warning-color);
        }

        .quick-add-btn.clear {
            background: var(--danger-color);
            padding: 8px 12px;
        }

        .quick-add-btn:hover {
            transform: scale(1.05);
        }

        .quick-add-btn.add-5:hover, .quick-add-btn.add-10:hover {
            background: #e67e22;
        }

        .quick-add-btn.clear:hover {
            background: #c0392b;
        }

        .quick-add-btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
        }

        .total-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: var(--success-color);
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 700;
        }

        /* Contenedor flotante para móviles */
        .floating-cart-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

        .floating-cart-container.hidden {
            transform: translateY(-150px);
            opacity: 0;
        }

        .floating-total {
            background: var(--success-color);
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 1.6rem;
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
            transition: all 0.3s ease;
        }

        .floating-submit-mobile {
            background: linear-gradient(135deg, var(--success-color), #229954);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 24px;
            font-size: 2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.4);
            display: none;
        }

        .floating-submit-mobile:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.5);
        }

        .floating-submit-mobile:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: 0 4px 15px rgba(189, 195, 199, 0.3);
        }

        .floating-submit-desktop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--success-color), #229954);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 1.5rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
            z-index: 1001;
            display: none;
        }

        .floating-submit-desktop:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 35px rgba(39, 174, 96, 0.5);
        }

        .floating-submit-desktop:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: 0 4px 15px rgba(189, 195, 199, 0.3);
        }

        .floating-submit-desktop.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .recent-orders {
            background: white;
            border-radius: 15px;
            margin: 2rem;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .recent-orders-header {
            background: linear-gradient(135deg, var(--warning-color), #e67e22);
            color: white;
            padding: 1.2rem 1.5rem;
            font-weight: 700;
            font-size: 2.8rem;
        }

        .order-item {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-info {
            flex: 1;
        }

        .order-date {
            font-weight: 700;
            color: var(--dark-color);
            font-size: 1.2rem;
        }

        .order-details {
            color: #7f8c8d;
            font-size: 1.1rem;
            margin-top: 6px;
            line-height: 1.4;
        }

        .status-badge {
            background: var(--primary-color);
            color: white;
            padding: 8px 16px;
            border-radius: 18px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .reprint-btn {
            background: var(--success-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            margin-left: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 1.1rem;
        }

        .reprint-btn:hover {
            background: #229954;
            transform: scale(1.1);
        }

        /* Mobile Optimizations */
        @media (max-width: 768px) {
            body {
                font-size: 18px;
            }

            .content-wrapper {
                margin: 10px;
                border-radius: 15px;
                padding-bottom: 120px;
            }

            .product-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 1.2rem;
            }

            .content-header {
                padding: 1.8rem 1.2rem;
                padding-top: 80px;
            }

            .content-header h1 {
                font-size: 2rem;
            }

            .content-header small {
                font-size: 1.2rem;
            }

            .quantity-controls {
                flex-direction: column;
                gap: 18px;
            }

            .quantity-input-group {
                order: 1;
                justify-content: center;
            }

            .quick-add-btns {
                order: 2;
            }

            .category-section {
                margin: 1.2rem;
            }

            .recent-orders {
                margin: 1.2rem;
            }

            .product-name {
                font-size: 1.8rem;
                text-align: center;
            }

            .quantity-input {
                font-size: 1.8rem;
            }

            .quantity-btn {
                width: 48px;
                height: 48px;
                font-size: 18px;
            }

            .quick-add-btn {
                font-size: 1rem;
                padding: 10px 16px;
            }

            .floating-total {
                font-size: 2.2rem;
                padding: 14px 28px;
            }

            .order-date {
                font-size: 2.1rem;
            }

            .order-details {
                font-size: 2.05rem;
            }

            .floating-submit-mobile {
                display: block;
                font-size: 2.1rem;
                padding: 14px 28px;
            }

            .floating-submit-desktop {
                display: none !important;
            }

            .floating-cart-container {
                top: 15px;
                right: 15px;
            }

            .hamburger-btn {
                top: 15px;
                left: 15px;
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }

            .sidebar {
                width: 100vw;
                left: -100vw;
            }

            .sidebar.open {
                left: 0;
            }
        }

        @media (min-width: 769px) {
            .floating-submit-mobile {
                display: none;
            }

            .floating-submit-desktop.show {
                display: flex;
            }
        }

        /* Ocultar elementos antiguos */
        .box, .col-md-12, .main-header, .navbar, .main-sidebar {
            display: none !important;
        }
    </style>
</head>
<body>
    <!-- Botón hamburguesa -->
    <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleSidebar()">
        <i class="fas fa-bars" id="hamburgerIcon"></i>
    </button>

    <!-- Overlay para cerrar sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar con menú original -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">
                <i class="fas fa-utensils"></i>
                Pedidos LOMAS
            </h3>
            <p class="sidebar-subtitle">Sistema de Gestión</p>
        </div>

        <!-- Buscador de lote -->
        <div class="sidebar-search">
            <form class="search-form" method="get">
                <input type="number" id="buscarlote" name="lote" class="search-input"
                       placeholder="Buscar por lote..." min="1" max="366">
                <button type="submit" name="buscar" id="buscar-btn" class="search-btn" disabled>
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">MENU PRINCIPAL</div>

                <div class="nav-item">
                    <a href="<?php echo base_url('inicio/'); ?>" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        Inicio
                    </a>
                </div>

                <div class="nav-item">
                    <a href="<?php echo base_url('pedidos'); ?>" class="nav-link">
                        <i class="fas fa-shopping-bag nav-icon"></i>
                        Pedidos
                    </a>
                </div>

                <div class="nav-item">
                    <a href="<?php echo base_url('reclamo/'); ?>" class="nav-link">
                        <i class="fas fa-exclamation-circle nav-icon"></i>
                        Reclamos
                    </a>
                </div>

                <div class="nav-item">
                    <a href="<?php echo base_url('enviar'); ?>" class="nav-link">
                        <i class="fas fa-truck nav-icon"></i>
                        Enviar Mercaderia
                    </a>
                </div>

                <div class="nav-item">
                    <a href="<?php echo base_url('delivery'); ?>" class="nav-link">
                        <i class="fas fa-motorcycle nav-icon"></i>
                        Calcular envío
                    </a>
                </div>

                <div class="nav-item">
                    <a href="<?php echo base_url('registrarse'); ?>" class="nav-link">
                        <i class="fas fa-home nav-icon"></i>
                        Cargar nuevo local
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">MERCADERIA</div>

                <div class="nav-item">
                    <a href="<?php echo base_url('articulos'); ?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        Artículos
                    </a>
                </div>

                <div class="nav-item">
                    <a href="<?php echo base_url('categorias'); ?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        Categorías
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">GESTIÓN</div>

                <div class="nav-item">
                    <a href="<?php echo base_url('reposicion'); ?>" class="nav-link active">
                        <i class="fas fa-edit nav-icon"></i>
                        Reposición
                    </a>
                </div>

                <div class="nav-item">
                    <a href="<?php echo base_url('facturar'); ?>" class="nav-link">
                        <i class="fas fa-file-text nav-icon"></i>
                        Facturación
                    </a>
                </div>

                <div class="nav-item">
                    <a href="<?php echo base_url('procesar'); ?>" class="nav-link">
                        <i class="fas fa-desktop nav-icon"></i>
                        Procesar Manualmente
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">USUARIO</div>

                <div class="nav-item">
                    <a href="<?php echo base_url('perfil'); ?>" class="nav-link">
                        <i class="fas fa-user nav-icon"></i>
                        Perfil
                    </a>
                </div>

                <div class="nav-item">
                    <a href="<?php echo base_url('login/logout'); ?>" class="nav-link">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        Salir
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Contenedor flotante con contador y botón -->
    <div class="floating-cart-container hidden" id="floatingCartContainer">
        <div class="floating-total">
            <i class="fas fa-shopping-cart"></i> Total: <span id="totalCount">0</span>
        </div>
        <button class="floating-submit-mobile" id="floatingSubmitMobile" onclick="confirmarepo()" disabled>
            <i class="fas fa-paper-plane"></i> Enviar Reposición
        </button>
    </div>

    <!-- Botón flotante para desktop -->
    <button class="floating-submit-desktop" id="floatingSubmitDesktop" onclick="confirmarepo()" disabled title="Enviar Reposición">
        <i class="fas fa-paper-plane"></i>
    </button>

    <div class="content-wrapper">
        <!-- Header -->
        <section class="content-header">
            <h1>
                <i class="fas fa-boxes"></i> Reposición
                <br><small>Enviar reposición de productos a los sectores</small>
            </h1>
        </section>

        <!-- Órdenes Recientes -->
        <div class="recent-orders">
            <div class="recent-orders-header">
                <i class="fas fa-history"></i> Últimas Reposiciones
            </div>
            <?php foreach ($repo as $repos) { ?>
            <div class="order-item">
                <div class="order-info">
                    <div class="order-date">
                        <?php
                        $fecha_pedido = date_create($repos['fecha_repo']);
                        echo $fecha_pedido->format('d/m H:i:s');
                        ?> - #<?php echo $repos['idRepo']; ?>
                    </div>
                    <div class="order-details">
                        <?php echo $ci->reposicion_model->detalle_reposicion($repos['detalle']); ?>
                    </div>
                </div>
                <span class="status-badge">Impreso</span>
                <button class="reprint-btn" onclick="reimprimir(<?php echo $repos['idRepo']; ?>)">
                    <i class="fas fa-print"></i>
                </button>
            </div>
            <?php } ?>
        </div>

        <!-- Formulario -->
        <form action="<?php echo base_url()."reposicion/enviar";?>" name="repo" method="post" id="reposicionForm">
            <div id="productSection">
                <?php foreach ($categorias as $categoria) { ?>
                <div class="category-section">
                    <div class="category-header">
                        <i class="fas fa-tags"></i>
                        <?php echo $categoria['descripcion']; ?>
                    </div>
                    <div class="product-grid">
                        <?php foreach ($datos as $dato) {
                            if ($dato['idCategoria'] == $categoria['idCategoria']) { ?>
                        <div class="product-card" data-id="<?php echo $dato['idArt']; ?>">
                            <div class="product-name">
                                <i class="fas fa-barcode"></i>
                                <?php echo $dato['nombre']; ?>
                            </div>

                            <div class="quantity-controls">
                                <div class="quantity-input-group">
                                    <button type="button" class="quantity-btn" onclick="decreaseQuantity(<?php echo $dato['idArt']; ?>)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="quantity-input" id="display<?php echo $dato['idArt']; ?>" value="0"
                                           onchange="updateQuantity(<?php echo $dato['idArt']; ?>, this.value)" min="0" max="99">
                                    <button type="button" class="quantity-btn" onclick="increaseQuantity(<?php echo $dato['idArt']; ?>)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="quick-add-btns">
                                <button type="button" class="quick-add-btn add-5" onclick="addQuantity(<?php echo $dato['idArt']; ?>, 5)">+5</button>
                                <button type="button" class="quick-add-btn add-10" onclick="addQuantity(<?php echo $dato['idArt']; ?>, 10)">+10</button>
                                <button type="button" class="quick-add-btn clear" onclick="clearQuantity(<?php echo $dato['idArt']; ?>)"
                                        id="clear<?php echo $dato['idArt']; ?>" disabled title="Poner en 0">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </div>

                            <input id="cant<?php echo $dato['idArt']; ?>" name="cant<?php echo $dato['idArt']; ?>" type="hidden" value="0">
                            <input id="sector<?php echo $dato['idArt']; ?>" name="sector<?php echo $dato['idArt']; ?>" type="hidden" value="<?php echo $dato['sector']; ?>">
                        </div>
                        <?php } } ?>
                    </div>
                </div>
                <?php } ?>
            </div>

            <?php foreach ($ultimo as $last) { ?>
            <input id="total" name="total" type="hidden" value="<?php echo $last['idArt']; ?>">
            <?php } ?>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let totalItems = 0;

        // Funciones del sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const hamburgerIcon = document.getElementById('hamburgerIcon');

            sidebar.classList.add('open');
            overlay.classList.add('show');
            hamburgerBtn.classList.add('active');
            hamburgerIcon.className = 'fas fa-times';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const hamburgerIcon = document.getElementById('hamburgerIcon');

            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            hamburgerBtn.classList.remove('active');
            hamburgerIcon.className = 'fas fa-bars';
        }

        // Funcionalidad del buscador de lote
        document.getElementById('buscarlote').addEventListener('input', function() {
            const searchBtn = document.getElementById('buscar-btn');
            searchBtn.disabled = this.value.trim() === '';
        });

        // Cerrar sidebar con tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        function updateQuantity(id, value) {
            value = parseInt(value) || 0;
            if (value < 0) value = 0;
            if (value > 99) value = 99;

            document.getElementById(`display${id}`).value = value;
            document.getElementById(`cant${id}`).value = value;

            updateProductCard(id, value);
            updateTotals();
        }

        function increaseQuantity(id) {
            const input = document.getElementById(`display${id}`);
            let value = parseInt(input.value) || 0;
            if (value < 99) {
                updateQuantity(id, value + 1);
            }
        }

        function decreaseQuantity(id) {
            const input = document.getElementById(`display${id}`);
            let value = parseInt(input.value) || 0;
            if (value > 0) {
                updateQuantity(id, value - 1);
            }
        }

        function addQuantity(id, amount) {
            const input = document.getElementById(`display${id}`);
            let value = parseInt(input.value) || 0;
            updateQuantity(id, Math.min(value + amount, 99));
        }

        function clearQuantity(id) {
            updateQuantity(id, 0);
        }

        function updateProductCard(id, quantity) {
            const card = document.querySelector(`[data-id="${id}"]`);
            const badge = card.querySelector('.total-badge');
            const clearBtn = document.getElementById(`clear${id}`);

            if (quantity > 0) {
                card.classList.add('selected');
                clearBtn.disabled = false;

                if (!badge) {
                    const newBadge = document.createElement('div');
                    newBadge.className = 'total-badge';
                    newBadge.textContent = quantity;
                    card.appendChild(newBadge);
                } else {
                    badge.textContent = quantity;
                }
            } else {
                card.classList.remove('selected');
                clearBtn.disabled = true;

                if (badge) {
                    badge.remove();
                }
            }
        }

        function updateTotals() {
            totalItems = 0;
            const inputs = document.querySelectorAll('input[name^="cant"]');

            inputs.forEach(input => {
                totalItems += parseInt(input.value) || 0;
            });

            document.getElementById('totalCount').textContent = totalItems;

            const floatingSubmitMobile = document.getElementById('floatingSubmitMobile');
            const floatingSubmitDesktop = document.getElementById('floatingSubmitDesktop');

            floatingSubmitMobile.disabled = totalItems === 0;
            floatingSubmitDesktop.disabled = totalItems === 0;

            const floatingCartContainer = document.getElementById('floatingCartContainer');
            if (totalItems > 0) {
                floatingCartContainer.classList.remove('hidden');
            } else {
                floatingCartContainer.classList.add('hidden');
            }
        }

        function resetForm() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Se perderán todos los cambios realizados',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reposicionForm').reset();
                    document.querySelectorAll('.product-card').forEach(card => {
                        card.classList.remove('selected');
                        const badge = card.querySelector('.total-badge');
                        if (badge) badge.remove();
                    });
                    document.querySelectorAll('input[name^="cant"]').forEach(input => {
                        input.value = '0';
                    });
                    document.querySelectorAll('.quantity-input').forEach(input => {
                        input.value = '0';
                    });
                    document.querySelectorAll('.quick-add-btn.clear').forEach(btn => {
                        btn.disabled = true;
                    });
                    updateTotals();
                }
            });
        }

        function confirmarepo() {
            if (totalItems === 0) {
                Swal.fire({
                    title: 'Sin productos',
                    text: 'Debes seleccionar al menos un producto',
                    icon: 'warning',
                    confirmButtonColor: '#3498db'
                });
                return;
            }

            Swal.fire({
                title: 'Confirmar Reposición',
                text: `¿Enviar reposición con ${totalItems} productos?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#27ae60',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Sí, enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reposicionForm').submit();
                }
            });
        }

        function reimprimir(id) {
            Swal.fire({
                title: 'Reimprimiendo...',
                text: `Reimprimiendo orden #${id}`,
                icon: 'info',
                timer: 2000,
                showConfirmButton: false
            });
        }

        function handleFloatingButton() {
            const productSection = document.getElementById('productSection');
            const floatingBtnDesktop = document.getElementById('floatingSubmitDesktop');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        floatingBtnDesktop.classList.add('show');
                    } else {
                        floatingBtnDesktop.classList.remove('show');
                    }
                });
            }, {
                threshold: 0.1
            });

            observer.observe(productSection);
        }

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            updateTotals();
            handleFloatingButton();
        });
    </script>
</body>
</html>
