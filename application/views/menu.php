<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU PRINCIPAL</li>
            
            <form action="" method="get" class="sidebar-form">
                <div class="input-group">
                    <input id="buscarlote" type="number" name="lote" class="form-control" placeholder="Buscar por lote..." min="1" max="366">
                    <span class="input-group-btn">
                        <button name="buscar" id="buscar-btn" class="btn btn-flat" disabled>
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <br>
            
            <table class="table text-center">
                <tr>
                    <th>
                        <button type="button" id="lote" class="btn btn-block btn-default btn-sm" style="display: none;"> 15-07-1977</button>
                    </th>
                </tr>
            </table>

            <!-- SECCIÓN GENERAL -->
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> <span>Inicio</span></a></li>

            <?php 
                $permisos_json = $this->session->userdata('s_permisos');
                $permisos = json_decode($permisos_json, true) ?: array();
                $is_admin = ($this->session->userdata('s_nivel') == 1);
                
                function hasPerm($mod, $permisos, $is_admin) {
                    return $is_admin || in_array($mod, $permisos);
                }
            ?>

            <!-- SECCIÓN VERDURAS -->
            <?php if (hasPerm('verdura', $permisos, $is_admin)): ?>
            <li><a href="<?php echo base_url('verdura'); ?>"><i class="fa fa-leaf"></i> <span>Pedido Verdura</span></a></li>
            <?php endif; ?>

            <?php if (hasPerm('verdura_gestion', $permisos, $is_admin)): ?>
            <li><a href="<?php echo base_url('verdura/gestion'); ?>"><i class="fa fa-cog"></i> <span>Gestión Verdura</span></a></li>
            <?php endif; ?>

            <!-- SECCIÓN LOCKERS -->
            <?php if (hasPerm('lockers', $permisos, $is_admin)): ?>
            <li><a href="<?php echo base_url('lockers'); ?>"><i class="fa fa-th"></i> <span>Lockers</span></a></li>
            <?php endif; ?>

            <!-- SECCIÓN UTILIDADES -->
            <?php if (hasPerm('delivery', $permisos, $is_admin)): ?>
            <li><a href="<?php echo base_url('delivery'); ?>"><i class="fa fa-motorcycle"></i> <span>Calcular envío</span></a></li>
            <?php endif; ?>

            <?php if (hasPerm('indumentaria', $permisos, $is_admin)): ?>
            <li><a href="<?php echo base_url('indumentaria'); ?>"><i class="fa fa-shopping-bag"></i> <span>Indumentaria</span></a></li>
            <?php endif; ?>

            <!-- SECCIÓN CERTIFICADOS -->
            <?php if (hasPerm('certificados', $permisos, $is_admin)): ?>
            <li><a href="<?php echo base_url('certificados'); ?>"><i class="fa fa-file-text-o"></i> <span>Certificados</span></a></li>
            <?php endif; ?>

            <!-- SECCIÓN MENU GENERATOR -->
            <li><a href="<?php echo base_url('menu'); ?>"><i class="fa fa-cutlery"></i> <span>Generador de Menú</span></a></li>

            <!-- SECCIÓN ADMINISTRACIÓN -->
            <?php if ($is_admin || !empty(array_intersect(['registrarse', 'articulos', 'categorias', 'reposicion', 'facturar', 'procesar', 'usuarios'], $permisos))): ?>
                <li class="header">SISTEMA</li>
                
                <?php if (hasPerm('usuarios', $permisos, $is_admin)): ?>
                <li><a href="<?php echo base_url('usuarios'); ?>"><i class="fa fa-users"></i> <span>Gestión Usuarios</span></a></li>
                <?php endif; ?>

                <?php if ($is_admin): ?>
                <li><a href="<?php echo base_url('backup'); ?>"><i class="fa fa-database"></i> <span>Backup Base de Datos</span></a></li>
                <li><a href="<?php echo base_url('configuracion'); ?>"><i class="fa fa-cogs"></i> <span>Configuración Comandas</span></a></li>
                <?php endif; ?>

                <?php if (hasPerm('proveedores', $permisos, $is_admin)): ?>
                <li><a href="<?php echo base_url('proveedores'); ?>"><i class="fa fa-truck"></i> <span>Proveedores</span></a></li>
                <?php endif; ?>

                <?php if (hasPerm('registrarse', $permisos, $is_admin)): ?>
                <li><a href="<?php echo base_url('registrarse'); ?>"><i class="fa fa-home"></i> <span>Cargar nuevo local</span></a></li>
                <?php endif; ?>

                <?php if (hasPerm('articulos', $permisos, $is_admin) || hasPerm('categorias', $permisos, $is_admin)): ?>
                <li class="treeview">
                    <a href="#"><i class="fa fa-laptop"></i> <span>Mercaderia</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                        <?php if (hasPerm('articulos', $permisos, $is_admin)): ?><li><a href="<?php echo base_url('articulos'); ?>"><i class="fa fa-circle-o"></i> Articulos</a></li><?php endif; ?>
                        <?php if (hasPerm('categorias', $permisos, $is_admin)): ?><li><a href="<?php echo base_url('categorias'); ?>"><i class="fa fa-circle-o"></i> Categorias</a></li><?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (hasPerm('reposicion', $permisos, $is_admin)): ?>
                <li><a href="<?php echo base_url('reposicion'); ?>"><i class="fa fa-edit"></i> <span>Reposición</span></a></li>
                <?php endif; ?>
                
                <?php if (hasPerm('facturar', $permisos, $is_admin)): ?>
                <li><a href="<?php echo base_url('facturar'); ?>"><i class="fa fa-file-text"></i> <span>Facturación</span></a></li>
                <?php endif; ?>
                
                <?php if (hasPerm('procesar', $permisos, $is_admin)): ?>
                <li><a href="<?php echo base_url('procesar'); ?>"><i class="fa fa-desktop"></i> <span>Procesar Manualmente</span></a></li>
                <?php endif; ?>
            <?php endif; ?>

        </ul>
    </section>
</aside>

<script type="text/javascript" src="<?php echo base_url('assets/dist/js/menu.js'); ?>"></script>
