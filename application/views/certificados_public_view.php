<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Verificación de Certificado | Pertutti</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
  <style>
      body { background-color: #f4f6f9; }
      .verification-box { margin-top: 50px; text-align: center; }
      .status-box { padding: 20px; border-radius: 5px; margin-bottom: 20px; color: #fff; }
      .valid { background-color: #00a65a; }
      .expired { background-color: #dd4b39; }
      .warning { background-color: #f39c12; }
  </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 verification-box">
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-blue">
                    <h3 class="widget-user-username"><?php echo $tipo['nombre']; ?></h3>
                    <h5 class="widget-user-desc">Pertutti Lomas</h5>
                </div>
                <div class="box-footer no-padding">
                    <div style="padding: 20px;">
                        <?php if ($certificado): ?>
                            <?php 
                                $vencimiento = new DateTime($certificado['fecha_vencimiento']);
                                $hoy = new DateTime();
                                $interval = $hoy->diff($vencimiento);
                                $signo = $interval->format('%r');
                                
                                if ($signo == '-') {
                                    // Vencido
                                    echo '<div class="status-box expired"><h1><i class="fa fa-times-circle"></i> VENCIDO</h1><p>Fecha de Vencimiento: '.date('d/m/Y', strtotime($certificado['fecha_vencimiento'])).'</p></div>';
                                } else {
                                    // Vigente
                                    echo '<div class="status-box valid"><h1><i class="fa fa-check-circle"></i> VIGENTE</h1><p>Válido hasta: '.date('d/m/Y', strtotime($certificado['fecha_vencimiento'])).'</p></div>';
                                }
                            ?>
                            
                            <a href="<?php echo base_url('uploads/certificados/'.$certificado['archivo']); ?>" class="btn btn-primary btn-block btn-lg">
                                <i class="fa fa-file-pdf-o"></i> Ver Documento Oficial
                            </a>
                            <br>
                            <p class="text-muted">Cargado el: <?php echo date('d/m/Y', strtotime($certificado['fecha_carga'])); ?></p>
                            
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <h4><i class="icon fa fa-warning"></i> Sin Información</h4>
                                No hay certificados cargados actualmente para esta categoría.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <p class="text-muted" style="margin-top: 20px;">Sistema de Gestión - Pertutti Lomas</p>
        </div>
    </div>
</div>
</body>
</html>
