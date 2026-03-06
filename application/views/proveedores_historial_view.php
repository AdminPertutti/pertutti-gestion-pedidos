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
    body.dark-mode .form-control {
        background-color: #1a1a2e !important;
        border-color: #30344c !important;
        color: #fff !important;
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
    body.dark-mode textarea {
        background-color: #1a1a2e !important;
        border-color: #30344c !important;
        color: #fff !important;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-history"></i> Historial de Pedidos
            <small>Registro de pedidos a proveedores</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?php echo base_url('proveedores'); ?>">Proveedores</a></li>
            <li class="active">Historial</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-list"></i> Pedidos Realizados</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url('proveedores'); ?>" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <!-- Filtro por proveedor -->
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-md-4">
                                <form method="get" action="<?php echo base_url('proveedores/historial'); ?>">
                                    <div class="input-group">
                                        <select name="proveedor" class="form-control">
                                            <option value="">Todos los proveedores</option>
                                            <?php foreach ($proveedores as $prov): ?>
                                                <option value="<?php echo $prov['id']; ?>" <?php echo ($proveedor_seleccionado == $prov['id']) ? 'selected' : ''; ?>>
                                                    <?php echo $prov['nombre']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-filter"></i> Filtrar
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <?php if (empty($pedidos)): ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> No hay pedidos registrados.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="150px">Fecha</th>
                                            <th>Proveedor</th>
                                            <th>Detalle</th>
                                            <th width="100px">WhatsApp</th>
                                            <th width="80px">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pedidos as $pedido): ?>
                                            <tr>
                                                <td><?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></td>
                                                <td><strong><?php echo $pedido['proveedor_nombre']; ?></strong></td>
                                                <td>
                                                    <?php 
                                                    $preview = substr($pedido['detalle'], 0, 100);
                                                    echo nl2br(htmlspecialchars($preview));
                                                    if (strlen($pedido['detalle']) > 100) {
                                                        echo '...';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($pedido['enviado_whatsapp']): ?>
                                                        <span class="label label-success">
                                                            <i class="fa fa-whatsapp"></i> Enviado
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="label label-default">No</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-info" 
                                                            onclick="verDetallePedido(<?php echo $pedido['id']; ?>, '<?php echo addslashes($pedido['proveedor_nombre']); ?>', '<?php echo addslashes($pedido['detalle']); ?>', '<?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?>')"
                                                            title="Ver Detalle">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
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

<!-- Modal para Ver Detalle -->
<div class="modal fade" id="modalDetallePedido" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa fa-file-text"></i> Detalle del Pedido
                </h4>
            </div>
            <div class="modal-body">
                <p><strong>Proveedor:</strong> <span id="modal_proveedor"></span></p>
                <p><strong>Fecha:</strong> <span id="modal_fecha"></span></p>
                <hr>
                <label>Detalle:</label>
                <textarea id="modal_detalle" class="form-control" rows="10" readonly style="font-family: monospace; resize: none;"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="copiarDetalle()">
                    <i class="fa fa-copy"></i> Copiar al Portapapeles
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function verDetallePedido(id, proveedor, detalle, fecha) {
    $('#modal_proveedor').text(proveedor);
    $('#modal_fecha').text(fecha);
    $('#modal_detalle').val(detalle);
    $('#modalDetallePedido').modal('show');
}

function copiarDetalle() {
    const copyText = document.getElementById("modal_detalle");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    
    // Feedback visual
    const btn = event.currentTarget;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-check"></i> ¡Copiado!';
    btn.className = 'btn btn-success';
    
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.className = 'btn btn-info';
    }, 2000);
}
</script>
