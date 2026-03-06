<style>
    /* Card Grid System */
    .products-grid {
        display: flex;
        flex-wrap: wrap;
        margin: -10px;
    }
    .product-card-wrapper {
        width: 33.33%;
        padding: 10px;
    }
    @media (max-width: 991px) {
        .product-card-wrapper { width: 50%; }
    }
    @media (max-width: 550px) {
        .product-card-wrapper { width: 100%; }
    }

    /* Card Styling - Light Mode */
    .product-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* Soft shadow like Rappi */
        padding: 15px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }
    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    }
    /* Highlight card when quantity > 0 */
    .product-card.active {
        border-color: #00a65a;
        background-color: #f9fff9;
    }

    /* Product Info */
    .product-title {
        font-size: 1.1em;
        font-weight: 700;
        margin-bottom: 5px;
        color: #333;
    }
    .product-meta {
        color: #777;
        font-size: 0.9em;
        margin-bottom: 15px;
    }
    
    /* Controls */
    .qty-controls {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f4f6f9;
        border-radius: 8px;
        padding: 5px;
    }
    .btn-qty-big {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        font-weight: bold;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-minus { background: #e0e0e0; color: #555; }
    .btn-minus:hover { background: #d0d0d0; }
    .btn-plus { background: #00a65a; color: white; }
    .btn-plus:hover { background: #008d4c; }

    .qty-display {
        font-size: 1.2em;
        font-weight: bold;
        width: 50px;
        text-align: center;
        background: transparent;
        border: none;
        padding: 0;
    }

    /* QUICK ADD BUTTONS */
    .quick-add {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 10px;
    }
    .btn-quick {
        font-size: 0.8em;
        padding: 2px 8px;
        border-radius: 12px;
        border: 1px solid #ddd;
        background: white;
        color: #666;
    }

    /* DARK MODE OVERRIDES */
    body.dark-mode .product-card {
        background-color: #1a1a2e; /* Dark card background */
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    body.dark-mode .product-card.active {
        border-color: #00a65a;
        background-color: #16213e; /* Slightly different active bg */
    }
    body.dark-mode .product-title { color: #fff; }
    body.dark-mode .product-meta { color: #aaa; }
    
    body.dark-mode .qty-controls { background: #0f3460; }
    body.dark-mode .qty-display { color: #fff; }
    
    body.dark-mode .btn-minus { background: #30344c; color: #fff; }
    body.dark-mode .btn-quick { 
        background: #16213e; 
        border-color: #30344c; 
        color: #bbb; 
    }
    
    /* Other overrides */
    body.dark-mode .box { background-color: #16213e !important; border-color: #30344c !important; }
    body.dark-mode .box-header { background-color: #0f3460 !important; border-bottom-color: #30344c !important; }
    body.dark-mode .box-title { color: #fff !important; }
    body.dark-mode textarea.form-control {
        background-color: #1a1a2e !important;
        border-color: #30344c !important;
        color: #fff !important;
    }
    body.dark-mode label { color: #c7c7c7 !important; }
    body.dark-mode .proveedor-info { background: #1a1a2e !important; border: 1px solid #30344c; }
    body.dark-mode .alert-info { background-color: #0f3460 !important; border-color: #1e5a8e !important; color: #fff !important; }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-shopping-cart"></i> Hacer Pedido
            <small><?php echo $proveedor['nombre']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?php echo base_url('proveedores'); ?>">Proveedores</a></li>
            <li class="active">Hacer Pedido</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-file-text"></i> Detalles del Pedido</h3>
                    </div>
                    <form action="<?php echo base_url('proveedores/guardar_pedido'); ?>" method="post" id="formPedido">
                        <input type="hidden" name="id_proveedor" value="<?php echo $proveedor['id']; ?>">
                        <input type="hidden" name="enviar_whatsapp" id="enviar_whatsapp" value="0">
                        <input type="hidden" name="enviar_email" id="enviar_email" value="0">
                        
                        <div class="box-body">
                            <!-- Información del Proveedor -->
                            <div class="proveedor-info">
                                <h4><i class="fa fa-truck"></i> <?php echo $proveedor['nombre']; ?></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php if ($proveedor['telefono']): ?>
                                            <p><i class="fa fa-phone"></i> <strong>Teléfono:</strong> <?php echo $proveedor['telefono']; ?></p>
                                        <?php endif; ?>
                                        <?php if ($proveedor['email']): ?>
                                            <p><i class="fa fa-envelope"></i> <strong>Email:</strong> <?php echo $proveedor['email']; ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php if ($proveedor['whatsapp']): ?>
                                            <p><i class="fa fa-whatsapp text-success"></i> <strong>WhatsApp:</strong> <?php echo $proveedor['whatsapp']; ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($articulos)): ?>
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-th-large"></i> Seleccionar Productos</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="$('#modalNuevoArticulo').modal('show')">
                                                <i class="fa fa-plus"></i> Nuevo Producto
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body" style="background: #f4f6f9;">
                                        <div class="products-grid">
                                            <?php foreach ($articulos as $art): ?>
                                                <div class="product-card-wrapper">
                                                    <div class="product-card" id="card_<?php echo $art['id']; ?>">
                                                        <div>
                                                            <div class="product-title"><?php echo $art['descripcion']; ?></div>
                                                            <div class="product-meta">
                                                                <?php echo $art['unidad_medida']; ?> 
                                                                <?php if($art['stock_completar'] > 0): ?>
                                                                    | Ideal: <strong><?php echo floatval($art['stock_completar']); ?></strong>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div>
                                                            <div class="qty-controls">
                                                                <button type="button" class="btn-qty-big btn-minus" onclick="adjustQty(this, -1)">-</button>
                                                                <input type="number" step="0.5" value="0" min="0" 
                                                                       class="qty-display qty-input" 
                                                                       id="input_<?php echo $art['id']; ?>"
                                                                       data-id="<?php echo $art['id']; ?>"
                                                                       data-descripcion="<?php echo $art['descripcion']; ?>" 
                                                                       data-unidad="<?php echo $art['unidad_medida']; ?>"
                                                                       onchange="highlightCard(this)">
                                                                <button type="button" class="btn-qty-big btn-plus" onclick="adjustQty(this, 1)">+</button>
                                                            </div>
                                                            
                                                            <div class="quick-add">
                                                                <button type="button" class="btn-quick" onclick="adjustQty(this, 5)">+5</button>
                                                                <button type="button" class="btn-quick" onclick="adjustQty(this, 10)">+10</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Campo oculto para el detalle final -->
                            <textarea name="detalle" id="detalle_pedido" style="display:none;"></textarea>
                        </div>
                        <div class="box-footer">
                            <a href="<?php echo base_url('proveedores'); ?>" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                            
                            <div class="pull-right">
                                <button type="button" class="btn btn-default" onclick="$('#modalComentarios').modal('show')">
                                    <i class="fa fa-comment"></i> Nota
                                </button>
                                <button type="button" class="btn btn-default" onclick="confirmarEnvio('guardar')">
                                    <i class="fa fa-save"></i> Solo Guardar
                                </button>
                                
                                <?php if ($proveedor['email']): ?>
                                    <button type="button" class="btn btn-info" onclick="confirmarEnvio('email')">
                                        <i class="fa fa-envelope"></i> Enviar por Email
                                    </button>
                                <?php endif; ?>

                                <?php if ($proveedor['whatsapp']): ?>
                                    <button type="button" class="btn btn-success" onclick="confirmarEnvio('whatsapp')" style="background-color: #25D366;">
                                        <i class="fa fa-whatsapp"></i> Enviar por WhatsApp
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Comentarios -->
<div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-comment-o"></i> Agregar Nota al Pedido</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Escriba aquí aclaraciones o productos fuera de lista:</label>
                    <textarea id="comentario_adicional" class="form-control" rows="5" placeholder="Ej: Traer 2 cajas de servilletas"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">
                    <i class="fa fa-check"></i> Listo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Articulo Ajax -->
<div class="modal fade" id="modalNuevoArticulo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Nuevo Artículo Rápido</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Descripción del Producto</label>
                    <input type="text" id="new_descripcion" class="form-control" placeholder="Ej: Tomate Perita">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Unidad de Medida</label>
                            <input type="text" id="new_unidad" class="form-control" placeholder="Ej: Kg, Cajón, Unidad">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stock Ideal (Opcional)</label>
                            <input type="number" id="new_stock" class="form-control" step="0.01">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarArticuloAjax()">
                    <i class="fa fa-save"></i> Guardar y Agregar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Pedido -->
<div class="modal fade" id="modalConfirmarPedido" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitle"><i class="fa fa-check-circle"></i> Confirmar Pedido</h4>
            </div>
            <div class="modal-body">
                <p>Por favor revise el detalle del pedido antes de enviarlo.</p>
                <div class="form-group">
                    <label>Detalle Final:</label>
                    <textarea id="detalle_final_modal" class="form-control" rows="10" readonly style="background: #f9f9f9; font-family: monospace; resize: vertical;"></textarea>
                </div>
                <div class="alert alert-warning" id="alert_metodo">
                    Se enviará este pedido.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar, volver a editar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarAccion" onclick="ejecutarAccion()">
                    <i class="fa fa-paper-plane"></i> Confirmar y Enviar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
var accionActual = '';

function adjustQty(btn, amount) {
    // Find input relative to the button (they are siblings in .qty-controls or via .product-card context)
    var card = $(btn).closest('.product-card');
    var input = card.find('.qty-input');
    
    var val = parseFloat(input.val()) || 0;
    val = Math.max(0, val + amount);
    
    input.val(val);
    highlightCard(input); // Trigger visual update
}

function highlightCard(input) {
    var val = parseFloat($(input).val()) || 0;
    var card = $(input).closest('.product-card');
    
    if (val > 0) {
        card.addClass('active');
    } else {
        card.removeClass('active');
    }
}

function calcularDetalleCompleto() {
    var detalle = '';
    
    // 1. Artículos de la lista
    $('.qty-input').each(function() {
        var descripcion = $(this).data('descripcion');
        var unidad = $(this).data('unidad');
        var qty = parseFloat($(this).val());
        
        if (!isNaN(qty) && qty > 0) {
            detalle += '- ' + qty + ' ' + unidad + ' de ' + descripcion + '\n';
        }
    });

    // 2. Comentario adicional (modal)
    var comentario = $('#comentario_adicional').val();
    if (comentario && comentario.trim()) {
        if (detalle) detalle += '\n--- NOTAS ---\n';
        detalle += comentario.trim();
    }
    
    return detalle;
}

function guardarArticuloAjax() {
    var desc = $('#new_descripcion').val();
    var uni = $('#new_unidad').val();
    var stock = $('#new_stock').val();
    
    if (!desc) { alert('Descripción requerida'); return; }
    
    $.ajax({
        url: '<?php echo base_url("proveedores/ajax_guardar_articulo"); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            id_proveedor: $('input[name="id_proveedor"]').val(),
            descripcion: desc,
            unidad_medida: uni,
            stock_completar: stock
        },
        success: function(resp) {
            if(resp.success) {
                // Agregar card al grid
                var html = `
                <div class="product-card-wrapper">
                    <div class="product-card" id="card_${resp.id}">
                        <div>
                            <div class="product-title">${resp.data.descripcion}</div>
                            <div class="product-meta">
                                ${resp.data.unidad_medida}
                                ${resp.data.stock_completar > 0 ? '| Ideal: <strong>' + parseFloat(resp.data.stock_completar) + '</strong>' : ''}
                            </div>
                        </div>
                        <div>
                            <div class="qty-controls">
                                <button type="button" class="btn-qty-big btn-minus" onclick="adjustQty(this, -1)">-</button>
                                <input type="number" step="0.5" value="0" min="0" 
                                       class="qty-display qty-input" 
                                       id="input_${resp.id}"
                                       data-id="${resp.id}"
                                       data-descripcion="${resp.data.descripcion}" 
                                       data-unidad="${resp.data.unidad_medida}"
                                       onchange="highlightCard(this)">
                                <button type="button" class="btn-qty-big btn-plus" onclick="adjustQty(this, 1)">+</button>
                            </div>
                            <div class="quick-add">
                                <button type="button" class="btn-quick" onclick="adjustQty(this, 5)">+5</button>
                                <button type="button" class="btn-quick" onclick="adjustQty(this, 10)">+10</button>
                            </div>
                        </div>
                    </div>
                </div>`;
                
                $('.products-grid').append(html);
                $('#modalNuevoArticulo').modal('hide');
                
                // Limpiar inputs
                $('#new_descripcion').val('');
                $('#new_unidad').val('');
                $('#new_stock').val('');
                
                // Scroll al nuevo elemento
                $('html, body').animate({
                    scrollTop: $("#card_" + resp.id).offset().top
                }, 1000);
            } else {
                alert('Error: ' + resp.message);
            }
        },
        error: function() {
            alert('Error de conexión al guardar artículo');
        }
    });
}

function confirmarEnvio(metodo) {
    accionActual = metodo;
    var detalle = calcularDetalleCompleto();
    
    if (!detalle.trim()) {
        alert('El pedido está vacío. Seleccione artículos o escriba un detalle.');
        return;
    }
    
    $('#detalle_final_modal').val(detalle);
    
    // Configurar modal según método
    var btn = $('#btnConfirmarAccion');
    var alertMsg = $('#alert_metodo');
    var title = $('#modalTitle');
    
    if (metodo === 'email') {
        title.html('<i class="fa fa-envelope"></i> Confirmar Envío por Email');
        btn.removeClass().addClass('btn btn-info').html('<i class="fa fa-envelope"></i> Enviar Email');
        alertMsg.removeClass().addClass('alert alert-info').html('<i class="fa fa-info-circle"></i> Se enviará un correo a <strong><?php echo $proveedor['email']; ?></strong>.');
    } else if (metodo === 'whatsapp') {
        title.html('<i class="fa fa-whatsapp"></i> Confirmar Envío por WhatsApp');
        btn.removeClass().addClass('btn btn-success').css('background-color', '#25D366').html('<i class="fa fa-whatsapp"></i> Enviar WhatsApp');
        alertMsg.removeClass().addClass('alert alert-success').html('<i class="fa fa-whatsapp"></i> Se guardará el pedido y se abrirá WhatsApp Web.');
    } else {
        title.html('<i class="fa fa-save"></i> Confirmar Guardado');
        btn.removeClass().addClass('btn btn-default').html('<i class="fa fa-save"></i> Guardar');
        alertMsg.removeClass().addClass('alert alert-warning').html('<i class="fa fa-warning"></i> Solo se guardará en el historial (no se envía).');
    }
    
    $('#modalConfirmarPedido').modal('show');
}

function ejecutarAccion() {
    // 1. Poner el detalle final calculado en el textarea del form (que es lo que se envía)
    $('#detalle_pedido').val($('#detalle_final_modal').val());
    
    // 2. Configurar flags
    $('#enviar_whatsapp').val('0');
    $('#enviar_email').val('0');
    
    if (accionActual === 'email') {
        $('#enviar_email').val('1');
        $('#formPedido').submit();
    } else if (accionActual === 'whatsapp') {
        enviarPorWhatsAppReal();
    } else {
        $('#formPedido').submit(); // Solo guardar
    }
    
    $('#modalConfirmarPedido').modal('hide');
}

function generarMensajeWhatsApp(detalle) {
    var proveedor = '<?php echo addslashes($proveedor['nombre']); ?>';
    var fecha = new Date().toLocaleDateString('es-AR', { 
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    var mensaje = 'Pedido de local lomas\n';
    mensaje += 'Fecha: ' + fecha + '\n';
    mensaje += '----------------------------\n';
    mensaje += detalle + '\n';
    mensaje += '----------------------------\n';
    mensaje += 'Enviado desde Sistema de Gestión';
    
    return mensaje;
}

function enviarPorWhatsAppReal() {
    var detalle = $('#detalle_pedido').val().trim();
    var whatsapp = '<?php echo $proveedor['whatsapp']; ?>';
    var mensaje = generarMensajeWhatsApp(detalle);
    var numero = whatsapp.replace(/[^0-9]/g, '');
    var url = 'https://wa.me/' + numero + '?text=' + encodeURIComponent(mensaje);
    
    $('#enviar_whatsapp').val('1');
    
    $.ajax({
        url: $('#formPedido').attr('action'),
        type: 'POST',
        data: $('#formPedido').serialize(),
        success: function() {
            window.open(url, '_blank');
            // Redirigir después de un momento
            setTimeout(function() {
                window.location.href = '<?php echo base_url('proveedores'); ?>';
            }, 1000);
        },
        error: function() {
            alert('Error al guardar el pedido');
            $('#enviar_whatsapp').val('0');
        }
    });
}
</script>
