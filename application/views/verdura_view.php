<?php
// Carga automática de header y menú ya que el controller lo hace
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pedido de Verdura
            <small>Selecciona las cantidades para el pedido de hoy</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Pedido Verdura</li>
        </ol>
    </section>

    <section class="content">
        <form action="<?php echo base_url('verdura/enviar'); ?>" method="post" id="verduraForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-leaf"></i> Productos disponibles</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <?php foreach ($productos as $p): ?>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="info-box" id="box_<?php echo $p['id']; ?>" style="border: 1px solid #ddd; transition: all 0.3s ease; background: rgba(0,0,0,0.05);">
                                            <span class="info-box-icon bg-gray"><i class="fa fa-leaf"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text" style="font-weight: bold; font-size: 1.1em; color: inherit;"><?php echo $p['nombre']; ?></span>
                                                <div class="input-group" style="margin-top: 5px;">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default btn-flat" onclick="changeQty(<?php echo $p['id']; ?>, -1)"><i class="fa fa-minus"></i></button>
                                                    </span>
                                                    <input type="number" 
                                                           name="prod_<?php echo $p['id']; ?>" 
                                                           id="qty_<?php echo $p['id']; ?>" 
                                                           class="form-control text-center" 
                                                           value="0" 
                                                           min="0"
                                                           onchange="updateBox(<?php echo $p['id']; ?>)"
                                                           style="font-weight: bold; font-size: 1.2em; background: white; color: black;">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default btn-flat" onclick="changeQty(<?php echo $p['id']; ?>, 1)"><i class="fa fa-plus"></i></button>
                                                    </span>
                                                </div>
                                                <div style="margin-top: 3px; display: flex; justify-content: space-between; align-items: center;">
                                                    <small class="text-primary" style="font-weight: 600;">
                                                        Sugerido: <?php echo floor($p['cantidad_estimada']); ?> <?php echo $p['unidad']; ?>
                                                    </small>
                                                    <small class="text-muted"><?php echo $p['unidad']; ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-paper-plane"></i> ENVIAR PEDIDO
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-history"></i> Historial de Pedidos</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Local</th>
                                    <th>Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count = 0;
                                foreach ($pedidos as $ped): 
                                    $count++;
                                    $fecha = date_create($ped['fecha']);
                                    $hidden_class = ($count > 10) ? 'history-hidden hidden' : '';
                                ?>
                                <tr class="<?php echo $hidden_class; ?>">
                                    <td><?php echo $fecha->format('d/m/Y H:i'); ?></td>
                                    <td><?php echo $ped['local']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-default btn-xs" onclick="verDetalle(`<?php echo $ped['detalle_text']; ?>`)">
                                            Ver Detalle
                                        </button>
                                        <button type="button" class="btn btn-info btn-xs" onclick="resendOrder(<?php echo $ped['id']; ?>)" title="Reenviar Pedido">
                                            <i class="fa fa-envelope"></i> Reenviar
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (count($pedidos) > 10): ?>
                    <div class="box-footer text-center">
                        <button type="button" class="btn btn-default btn-sm" id="btnVerMas" onclick="showAllHistory()">
                            <i class="fa fa-plus"></i> Ver más
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal de Confirmación y Reducción de Email -->
<div class="modal fade" id="modalConfirmarPedido" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-envelope"></i> Revisar Pedido de Verdura</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Aquí tienes la redacción del pedido. Puedes copiarla al portapapeles o enviarla directamente.
                        </div>
                        <div class="form-group">
                            <label>Cuerpo del Mensaje:</label>
                            <textarea id="emailDraft" class="form-control" rows="12" style="font-family: monospace; font-size: 1.1em; resize: none;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <div>
                    <button type="button" class="btn btn-info" onclick="copyToClipboard()"><i class="fa fa-copy"></i> Copiar al Portapapeles</button>
                    <button type="button" class="btn btn-success" onclick="confirmAndSend()"><i class="fa fa-paper-plane"></i> CONFIRMAR Y ENVIAR</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeQty(id, delta) {
        const input = $('#qty_' + id);
        let val = parseInt(input.val()) || 0;
        val = Math.max(0, val + delta);
        input.val(val);
        updateBox(id);
    }

    function updateBox(id) {
        const input = $('#qty_' + id);
        const box = $('#box_' + id);
        if (parseInt(input.val()) > 0) {
            box.css('border-color', '#00a65a');
            box.find('.info-box-icon').removeClass('bg-gray').addClass('bg-green');
        } else {
            box.css('border-color', '#ddd');
            box.find('.info-box-icon').removeClass('bg-green').addClass('bg-gray');
        }
    }

    // Initialize boxes
    $(document).ready(function() {
        <?php foreach ($productos as $p): ?>
            updateBox(<?php echo $p['id']; ?>);
        <?php endforeach; ?>

        $('#verduraForm').on('submit', function(e) {
            e.preventDefault();
            prepareDraft();
        });
    });

    function prepareDraft() {
        let draft = "Pedido de Verdura - <?php echo $this->session->s_local; ?>\n";
        draft += "------------------------------------------\n";
        let hasItems = false;
        
        <?php foreach ($productos as $p): ?>
            let qty_<?php echo $p['id']; ?> = $('#qty_<?php echo $p['id']; ?>').val();
            if (qty_<?php echo $p['id']; ?> > 0) {
                draft += "- <?php echo $p['nombre']; ?>: " + qty_<?php echo $p['id']; ?> + " <?php echo $p['unidad']; ?>\n";
                hasItems = true;
            }
        <?php endforeach; ?>

        if (!hasItems) {
            Swal.fire('Atención', 'No has seleccionado ningún producto.', 'warning');
            return;
        }

        $('#emailDraft').val(draft);
        $('#modalConfirmarPedido').modal('show');
    }

    function copyToClipboard() {
        const textArea = document.getElementById("emailDraft");
        textArea.select();
        document.execCommand("copy");
        
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '¡Copiado al portapapeles!',
            showConfirmButton: false,
            timer: 2000
        });
    }

    function confirmAndSend() {
        document.getElementById('verduraForm').submit();
    }

    function showAllHistory() {
        $('.history-hidden').removeClass('hidden');
        $('#btnVerMas').hide();
    }

    function resendOrder(id) {
        Swal.fire({
            title: "¿Reenviar el pedido?",
            text: "Se enviará nuevamente el email al proveedor.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#31708f",
            confirmButtonText: "Sí, reenviar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                window.location.href = '<?php echo base_url('verdura/reenviar/'); ?>' + id;
            }
        });
    }

    function verDetalle(texto) {
        $('#detalleTextoSimple').val(texto);
        $('#modalDetallePedidoVerdura').modal('show');
    }

    function copiarDetalle() {
        const copyText = document.getElementById("detalleTextoSimple");
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

<!-- Modal para Detalle de Pedido (Historial) -->
<div class="modal fade" id="modalDetallePedidoVerdura" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-list"></i> Detalle del Pedido</h4>
            </div>
            <div class="modal-body">
                <textarea id="detalleTextoSimple" class="form-control" rows="10" readonly style="font-family: monospace; resize: none; background: #f9f9f9;"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="copiarDetalle()"><i class="fa fa-copy"></i> Copiar al Portapapeles</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Debug de Email -->
<?php if($this->session->flashdata('error_modal')): ?>
<div class="modal fade" id="modalDebugEmail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-bug"></i> Error al Enviar Email - Log de Depuración</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle"></i> El correo no pudo enviarse. A continuación se muestra la respuesta del servidor:
                </div>
                <pre style="max-height: 400px; overflow-y: auto; background: #222; color: #0f0; padding: 10px; font-family: monospace; font-size: 0.9em;"><?php echo $this->session->flashdata('error_modal'); ?></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#modalDebugEmail').modal('show');
    });
</script>
<?php endif; ?>
