<style>
    /* Dark Mode Overrides */
    body.dark-mode .box {
        background-color: #16213e !important;
        border-color: #30344c !important;
    }
    body.dark-mode .box-header {
        background-color: #0f3460 !important;
        border-bottom-color: #30344c !important;
    }
    body.dark-mode .box-title {
        color: #fff !important;
    }
    body.dark-mode input.form-control {
        background-color: #1a1a2e !important;
        border-color: #30344c !important;
        color: #fff !important;
    }
    body.dark-mode label {
        color: #c7c7c7 !important;
    }
    body.dark-mode .table {
        color: #c7c7c7 !important;
    }
    body.dark-mode .table thead tr {
        background-color: #0f3460 !important;
    }
    body.dark-mode .table thead th {
        color: #fff !important;
        border-color: #30344c !important;
    }
    body.dark-mode .table tbody td {
        border-color: #30344c !important;
    }
    body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #1f2a48 !important;
    }
    body.dark-mode .table-hover > tbody > tr:hover {
        background-color: #25335a !important;
    }
    body.dark-mode .modal-content {
        background-color: #16213e !important;
        border-color: #30344c !important;
    }
    body.dark-mode .modal-header {
        background-color: #0f3460 !important;
        border-bottom-color: #30344c !important;
    }
    body.dark-mode .modal-title {
        color: #fff !important;
    }
    body.dark-mode .modal-body {
        color: #c7c7c7 !important;
    }
    body.dark-mode .modal-footer {
        background-color: #16213e !important;
        border-top-color: #30344c !important;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-list"></i> Artículos Predefinidos
            <small><?php echo $proveedor['nombre']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?php echo base_url('proveedores'); ?>">Proveedores</a></li>
            <li class="active">Configurar Artículos</li>
        </ol>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-ban"></i> <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-shopping-basket"></i> Lista de Artículos para Pedido Rápido</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalArticulo" onclick="nuevoArticulo()">
                                <i class="fa fa-plus"></i> Agregar Artículo
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Configure aquí los artículos que suele pedir a este proveedor. 
                            Indique la <strong>cantidad ideal de stock</strong> que debe tener en depósito. 
                            Al hacer el pedido, el sistema le ayudará a calcular cuánto falta para llegar a ese ideal.
                        </div>

                        <?php if (empty($articulos)): ?>
                            <div class="text-center" style="padding: 20px;">
                                <p class="text-muted"><i class="fa fa-folder-open-o fa-3x"></i><br>No hay artículos configurados para este proveedor.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Descripción</th>
                                            <th class="text-center">Unidad de Medida</th>
                                            <th class="text-center">Stock Ideal</th>
                                            <th width="120px" class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($articulos as $art): ?>
                                            <tr>
                                                <td><?php echo $art['descripcion']; ?></td>
                                                <td class="text-center"><?php echo $art['unidad_medida']; ?></td>
                                                <td class="text-center"><strong><?php echo number_format($art['stock_completar'], 2); ?></strong></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-xs btn-info" 
                                                                onclick='editarArticulo(<?php echo json_encode($art); ?>)' 
                                                                title="Editar">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <a href="<?php echo base_url('proveedores/eliminar_articulo/' . $art['id'] . '?id_proveedor=' . $proveedor['id']); ?>" 
                                                           class="btn btn-xs btn-danger" 
                                                           onclick="return confirm('¿Está seguro de eliminar este artículo?');"
                                                           title="Eliminar">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="box-footer">
                        <a href="<?php echo base_url('proveedores'); ?>" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Volver a Proveedores
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Agregar/Editar Artículo -->
<div class="modal fade" id="modalArticulo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalArticuloTitle">Nuevo Artículo</h4>
            </div>
            <form action="<?php echo base_url('proveedores/guardar_articulo'); ?>" method="post" id="formArticulo">
                <input type="hidden" name="id" id="articulo_id">
                <input type="hidden" name="id_proveedor" value="<?php echo $proveedor['id']; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Descripción del Artículo <span class="text-danger">*</span></label>
                        <input type="text" name="descripcion" id="articulo_descripcion" class="form-control" required placeholder="Ej: Tomate Redondo, Papines, etc.">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unidad de Medida <span class="text-danger">*</span></label>
                                <input type="text" name="unidad_medida" id="articulo_unidad_medida" class="form-control" required placeholder="Ej: kg, unidades, cajón">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock Ideal <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="stock_completar" id="articulo_stock_completar" class="form-control" required placeholder="Ej: 10.00">
                            </div>
                        </div>
                    </div>
                    <p class="text-muted"><small>El stock ideal es informativo para saber cuánto se suele tener en depósito.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function nuevoArticulo() {
    $('#modalArticuloTitle').text('Nuevo Artículo');
    $('#formArticulo')[0].reset();
    $('#articulo_id').val('');
}

function editarArticulo(art) {
    $('#modalArticuloTitle').text('Editar Artículo');
    $('#articulo_id').val(art.id);
    $('#articulo_descripcion').val(art.descripcion);
    $('#articulo_unidad_medida').val(art.unidad_medida);
    $('#articulo_stock_completar').val(art.stock_completar);
    $('#modalArticulo').modal('show');
}
</script>
