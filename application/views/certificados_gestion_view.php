<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Gestión: <?php echo $tipo['nombre']; ?>
            <small>Historial y cargas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('indumentaria'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?php echo base_url('certificados'); ?>">Certificados</a></li>
            <li class="active">Gestión</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- Columna Izquierda: Estado Actual y Nueva Carga -->
            <div class="col-md-4">
                
                <!-- Estado del Último -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Estado Actual</h3>
                    </div>
                    <div class="box-body" style="color: #333;">
                        <?php if ($ultimo): ?>
                            <?php 
                                $vencimiento = new DateTime($ultimo['fecha_vencimiento']);
                                $hoy = new DateTime();
                                $interval = $hoy->diff($vencimiento);
                                $signo = $interval->format('%r');
                                $dias = $interval->days;
                                
                                if ($signo == '-' && $dias > 0) {
                                    echo '<div class="alert alert-danger"><h4><i class="icon fa fa-ban"></i> VENCIDO</h4>El certificado venció el '.date('d/m/Y', strtotime($ultimo['fecha_vencimiento'])).'</div>';
                                } elseif ($tipo['requiere_aviso'] && $dias <= $tipo['dias_aviso']) {
                                    echo '<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> POR VENCER</h4>Vence en '.$dias.' días ('.date('d/m/Y', strtotime($ultimo['fecha_vencimiento'])).')</div>';
                                } else {
                                    echo '<div class="alert alert-success"><h4><i class="icon fa fa-check"></i> VIGENTE</h4>Vence el '.date('d/m/Y', strtotime($ultimo['fecha_vencimiento'])).'</div>';
                                }
                            ?>
                            <p><strong>Archivo:</strong> <a href="<?php echo base_url('uploads/certificados/'.$ultimo['archivo']); ?>" target="_blank">Ver Documento</a></p>
                            <p><strong>Cargado el:</strong> <?php echo date('d/m/Y', strtotime($ultimo['fecha_carga'])); ?></p>
                        <?php else: ?>
                            <div class="alert alert-info">No hay certificados cargados para este tipo.</div>
                        <?php endif; ?>
                    </div>
                    <div class="box-footer text-center">
                         <a href="<?php echo base_url('certificados/imprimir_qr/'.$tipo['id']); ?>" target="_blank" class="btn btn-default btn-block"><i class="fa fa-qrcode"></i> Imprimir QR Público</a>
                    </div>
                </div>

                <!-- Formulario de Carga -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cargar Nuevo Certificado</h3>
                    </div>
                    <form action="<?php echo base_url('certificados/subir_certificado'); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_tipo" value="<?php echo $tipo['id']; ?>">
                        <div class="box-body" style="color: #333;">
                            <div class="form-group">
                                <label>Fecha de Vencimiento</label>
                                <input type="date" name="fecha_vencimiento" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Archivo (PDF o Imagen)</label>
                                <input type="file" name="archivo" class="form-control" required accept=".pdf, .jpg, .jpeg, .png">
                            </div>
                            <div class="form-group">
                                <label>Observaciones (Opcional)</label>
                                <textarea name="observaciones" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success btn-block">Subir y Renovar</button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Columna Derecha: Historial -->
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Historial de Cargas</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha Carga</th>
                                    <th>Vencimiento</th>
                                    <th>Archivo</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($historial): ?>
                                    <?php foreach($historial as $h): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y', strtotime($h['fecha_carga'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($h['fecha_vencimiento'])); ?></td>
                                        <td>
                                            <a href="<?php echo base_url('uploads/certificados/'.$h['archivo']); ?>" target="_blank" class="btn btn-xs btn-default">
                                                <i class="fa fa-download"></i> Ver
                                            </a>
                                            <?php if($this->session->userdata('s_nivel') == 1): ?>
                                                <a href="<?php echo base_url('certificados/eliminar_certificado/'.$h['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('¿Está seguro de eliminar este certificado? Esta acción no se puede deshacer.');" title="Eliminar">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $h['observaciones']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center">Sin historial</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
