<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Gestión de Certificados
            <small>Control de vencimientos y documentación legal</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Certificados</li>
        </ol>
    </section>

    <section class="content">
        <!-- Alertas de Vencimiento -->
        <?php if (!empty($alertas)): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-warning"></i> Alertas de Vencimiento</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Certificado</th>
                                    <th>Vence el</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($alertas as $a): ?>
                                <tr>
                                    <td><?php echo $a['tipo']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($a['fecha_vencimiento'])); ?></td>
                                    <td>
                                        <?php if($a['estado'] == 'VENCIDO'): ?>
                                            <span class="label label-danger">VENCIDO (hace <?php echo abs($a['dias_restantes']); ?> días)</span>
                                        <?php else: ?>
                                            <span class="label label-warning">Vence en <?php echo $a['dias_restantes']; ?> días</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('certificados/gestion/'.$a['id_tipo']); ?>" class="btn btn-xs btn-primary">Renovar</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tipos de Certificados</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalNuevoTipo">
                                <i class="fa fa-plus"></i> Nuevo Tipo
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <?php foreach ($tipos as $t): 
                                $bg_class = 'bg-aqua';
                                if($t['estado_color'] == 'green') $bg_class = 'bg-green';
                                if($t['estado_color'] == 'yellow') $bg_class = 'bg-yellow';
                                if($t['estado_color'] == 'red') $bg_class = 'bg-red';
                            ?>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon <?php echo $bg_class; ?>"><i class="fa fa-file-text-o"></i></span>
                                    <div class="info-box-content" style="color: #333;">
                                        <div class="pull-right">
                                            <?php if($this->session->userdata('s_nivel') == 1): ?>
                                                <button type="button" class="btn btn-box-tool" title="Editar" onclick='editarTipo(<?php echo json_encode($t); ?>)'>
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <span class="info-box-text"><?php echo $t['nombre']; ?></span>
                                        <span class="info-box-number" style="font-weight: normal; font-size: 14px;">
                                            <?php echo $t['estado_texto']; ?>
                                        </span>
                                        <span class="progress-description text-muted small" style="color: #777;">
                                            <?php if($t['requiere_aviso']): ?>
                                                Avisa <?php echo $t['dias_aviso']; ?> días antes
                                            <?php else: ?>
                                                Sin aviso
                                            <?php endif; ?>
                                        </span>
                                        
                                        <div style="margin-top: 5px;">
                                            <a href="<?php echo base_url('certificados/gestion/'.$t['id']); ?>" class="btn btn-default btn-xs"><i class="fa fa-upload"></i> Gestionar</a>
                                            <a href="<?php echo base_url('certificados/imprimir_qr/'.$t['id']); ?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-qrcode"></i> QR</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Nuevo Tipo -->
<div class="modal fade" id="modalNuevoTipo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color: #333;" id="modalCertTitulo">Crear Nuevo Tipo de Certificado</h4>
            </div>
            <form action="<?php echo base_url('certificados/guardar_tipo'); ?>" method="post" id="formCertificado">
                <input type="hidden" name="id" id="id_tipo_edit" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label style="color: #333;">Nombre del Certificado</label>
                        <input type="text" name="nombre" id="nombre_tipo" class="form-control" placeholder="Ej: Control de Plagas" required>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox">
                            <label style="color: #333;">
                                <input type="checkbox" name="requiere_aviso" id="chk_aviso" value="1" checked onchange="toggleDiasAviso()">
                                <strong>Activar alerta de vencimiento</strong>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="group_dias_aviso">
                        <label style="color: #333;">Días de aviso previo</label>
                        <input type="number" name="dias_aviso" id="dias_aviso_input" class="form-control" value="15">
                        <p class="help-block" style="color: #666;">El sistema avisará cuando falten estos días para el vencimiento.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleDiasAviso() {
    var chk = document.getElementById('chk_aviso');
    var group = document.getElementById('group_dias_aviso');
    if (chk.checked) {
        group.style.display = 'block';
    } else {
        group.style.display = 'none';
        group.querySelector('input').value = 0;
    }
}

function editarTipo(data) {
    $('#modalCertTitulo').text('Editar Tipo de Certificado');
    $('#id_tipo_edit').val(data.id);
    $('#nombre_tipo').val(data.nombre);
    
    // Checkbox and Number
    var chk = document.getElementById('chk_aviso');
    if (data.requiere_aviso == 1) {
        chk.checked = true;
        $('#dias_aviso_input').val(data.dias_aviso);
    } else {
        chk.checked = false;
        $('#dias_aviso_input').val(data.dias_aviso); // Mantener valor aunque oculto
    }
    toggleDiasAviso();
    
    $('#modalNuevoTipo').modal('show');
}

// Resetear modal al abrir para 'Nuevo'
$('#modalNuevoTipo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    if (button.hasClass('btn-success')) { // Es el botón "Nuevo Tipo"
        $('#modalCertTitulo').text('Crear Nuevo Tipo de Certificado');
        $('#formCertificado')[0].reset();
        $('#id_tipo_edit').val('');
        $('#chk_aviso').prop('checked', true);
        toggleDiasAviso();
    }
});
</script>
