<style>
    /* Dark Mode Overrides for Proveedores View */
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
    body.dark-mode input.form-control,
    body.dark-mode textarea.form-control {
        background-color: #1a1a2e !important;
        border-color: #30344c !important;
        color: #fff !important;
    }
    body.dark-mode label {
        color: #c7c7c7 !important;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-truck"></i> Gestión de Proveedores
            <small>Administrar proveedores y pedidos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Proveedores</li>
        </ol>
    </section>

    <section class="content">
        <!-- Mensajes de éxito/error -->
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
            <!-- Estadísticas -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-truck"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Proveedores Activos</span>
                        <span class="info-box-number"><?php echo $estadisticas['total_proveedores']; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pedidos Hoy</span>
                        <span class="info-box-number"><?php echo $estadisticas['pedidos_hoy']; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pedidos Esta Semana</span>
                        <span class="info-box-number"><?php echo $estadisticas['pedidos_semana']; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-purple"><i class="fa fa-history"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Ver Historial</span>
                        <a href="<?php echo base_url('proveedores/historial'); ?>" class="btn btn-sm btn-default" style="margin-top: 5px;">
                            <i class="fa fa-list"></i> Historial
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-list"></i> Lista de Proveedores</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProveedor" onclick="nuevoProveedor()">
                                <i class="fa fa-plus"></i> Nuevo Proveedor
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php if (empty($proveedores)): ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> No hay proveedores registrados. Agregue uno nuevo para comenzar.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>WhatsApp</th>
                                            <th>Email</th>
                                            <th>Notas</th>
                                            <th width="250px">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($proveedores as $prov): ?>
                                            <tr>
                                                <td><strong><?php echo $prov['nombre']; ?></strong></td>
                                                <td><?php echo $prov['telefono'] ?: '-'; ?></td>
                                                <td>
                                                    <?php if ($prov['whatsapp']): ?>
                                                        <i class="fa fa-whatsapp text-success"></i> <?php echo $prov['whatsapp']; ?>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $prov['email'] ?: '-'; ?></td>
                                                <td><?php echo $prov['notas'] ? substr($prov['notas'], 0, 50) . '...' : '-'; ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-info" onclick="editarProveedor(<?php echo $prov['id']; ?>)" title="Editar">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <a href="<?php echo base_url('proveedores/configurar_articulos/' . $prov['id']); ?>" class="btn btn-sm btn-primary" title="Configurar Artículos">
                                                            <i class="fa fa-list"></i>
                                                        </a>
                                                        <a href="<?php echo base_url('proveedores/configurar_dias/' . $prov['id']); ?>" class="btn btn-sm btn-warning" title="Configurar Días">
                                                            <i class="fa fa-calendar"></i>
                                                        </a>
                                                        <a href="<?php echo base_url('proveedores/hacer_pedido/' . $prov['id']); ?>" class="btn btn-sm btn-success" title="Hacer Pedido">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </a>
                                                        <a href="<?php echo base_url('proveedores/eliminar_proveedor/' . $prov['id']); ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('¿Está seguro de eliminar este proveedor?');"
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
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Agregar/Editar Proveedor -->
<div class="modal fade" id="modalProveedor" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalProveedorTitle">Nuevo Proveedor</h4>
            </div>
            <form action="<?php echo base_url('proveedores/guardar_proveedor'); ?>" method="post" id="formProveedor">
                <input type="hidden" name="id" id="proveedor_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="proveedor_nombre" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" name="telefono" id="proveedor_telefono" class="form-control" placeholder="11-1234-5678">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>WhatsApp</label>
                                <input type="text" name="whatsapp" id="proveedor_whatsapp" class="form-control" placeholder="5491112345678">
                                <small class="text-muted">Formato: 549 + código de área + número</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="proveedor_email" class="form-control" placeholder="contacto@proveedor.com">
                    </div>
                    <div class="form-group">
                        <label>Notas</label>
                        <textarea name="notas" id="proveedor_notas" class="form-control" rows="3" placeholder="Información adicional sobre el proveedor..."></textarea>
                    </div>
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
function nuevoProveedor() {
    $('#modalProveedorTitle').text('Nuevo Proveedor');
    $('#formProveedor')[0].reset();
    $('#proveedor_id').val('');
}

function editarProveedor(id) {
    $('#modalProveedorTitle').text('Editar Proveedor');
    
    // Cargar datos del proveedor
    $.getJSON('<?php echo base_url("proveedores/get_proveedor_json/"); ?>' + id, function(data) {
        $('#proveedor_id').val(data.id);
        $('#proveedor_nombre').val(data.nombre);
        $('#proveedor_telefono').val(data.telefono);
        $('#proveedor_whatsapp').val(data.whatsapp);
        $('#proveedor_email').val(data.email);
        $('#proveedor_notas').val(data.notas);
        
        $('#modalProveedor').modal('show');
    });
}
</script>
