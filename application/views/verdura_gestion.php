<?php
// Carga automática de header y menú ya que el controller lo hace, 
// así que este archivo solo debe contener el div.content-wrapper
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gestión de Verdura
            <small>Configuración de productos y proveedor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Gestión Verdura</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Configuración del Proveedor -->
            <div class="col-md-5">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-envelope"></i> Configuración del Proveedor</h3>
                    </div>
                    <div class="box-body">
                        <form action="<?php echo base_url('verdura/guardar_config'); ?>" method="post">
                            <div class="form-group">
                                <label>Nombre del Proveedor</label>
                                <input type="text" name="proveedor_nombre" class="form-control" value="<?php echo $proveedor_nombre; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Email del Proveedor</label>
                                <input type="email" name="proveedor_email" class="form-control" value="<?php echo $proveedor_email; ?>" required>
                            </div>
                            <hr>
                            <label><i class="fa fa-copy"></i> Copia de Pedido (BCC)</label>
                            <div class="form-group">
                                <label>Email para Copia</label>
                                <input type="email" name="copia_email" class="form-control" value="<?php echo $copia_email; ?>" placeholder="ej: central@mail.com">
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="enviar_copia" value="1" <?php echo ($enviar_copia == 1) ? 'checked' : ''; ?>>
                                        <strong>Enviar copia de pedidos a este mail</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-warning pull-right">
                                    <i class="fa fa-save"></i> Guardar Configuración
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Listado de Productos -->
            <div class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-list"></i> Artículos de Verdulería</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-success btn-sm" onclick="showAddModal()">
                                <i class="fa fa-plus"></i> Nuevo Producto
                            </button>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Unidad</th>
                                    <th>Est. Diario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $p): ?>
                                <tr>
                                    <td><strong><?php echo $p['nombre']; ?></strong></td>
                                    <td><?php echo $p['unidad']; ?></td>
                                    <td><?php echo floor($p['cantidad_estimada']); ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" onclick='editProduct(<?php echo json_encode($p); ?>)' title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-xs" onclick="deleteProduct(<?php echo $p['id']; ?>)" title="Eliminar">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Agregar/Editar Producto -->
<div id="productModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo base_url('verdura/guardar_producto'); ?>" method="post">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modalTitle">Nuevo Producto</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="prod_id">
                    <div class="form-group">
                        <label>Nombre del Producto</label>
                        <input type="text" name="nombre" id="prod_nombre" class="form-control" required placeholder="Ej: Tomate Redondo">
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Unidad</label>
                            <input type="text" name="unidad" id="prod_unidad" class="form-control" required placeholder="Ej: Kilos">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Cant. Estimada</label>
                            <input type="number" name="cantidad_estimada" id="prod_cantidad" class="form-control" step="0.01" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showAddModal() {
        $('#modalTitle').text('Nuevo Producto');
        $('#prod_id').val('');
        $('#prod_nombre').val('');
        $('#prod_unidad').val('');
        $('#prod_cantidad').val('0');
        $('#productModal').modal('show');
    }

    function editProduct(p) {
        $('#modalTitle').text('Editar Producto');
        $('#prod_id').val(p.id);
        $('#prod_nombre').val(p.nombre);
        $('#prod_unidad').val(p.unidad);
        $('#prod_cantidad').val(p.cantidad_estimada);
        $('#productModal').modal('show');
    }

    function deleteProduct(id) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción eliminará el producto del listado.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dd4b39",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                window.location.href = '<?php echo base_url('verdura/eliminar_producto/'); ?>' + id;
            }
        });
    }
</script>
