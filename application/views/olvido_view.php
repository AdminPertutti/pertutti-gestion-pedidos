<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pedidos lomas | Recupero de contraseña</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>dist/css/skins/_all-skins.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Pedidos</b>LOMAS
  </div>
  <div class="login-box-body">
    <b><p class="login-box-msg">Recuperar Contraseña</p></b>
        <?php echo $mensaje; ?>

    <form action="<?php echo base_url()."olvido_mail/recuperar_pass";?>" method="post">
      <div class="form-group has-feedback">
        <input name="recusuario" type="email" class="form-control" placeholder="Email" value="<?php echo set_value('recusuario') ?>" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span> <?php echo form_error('recusuario'); ?>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Recuperar </button>
        </div>
      </div>
    </form>
    <a href="<?php echo base_url();?>login">Ingresar</a><br>
  </div>
</div>
<script src="<?php echo base_url()."assets/";?>bower_components/jquery/dist/jquery.min.js"></script>


</body>
</html>
