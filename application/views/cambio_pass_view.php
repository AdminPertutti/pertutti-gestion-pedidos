<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pedidos lomas | Cambio de clave</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Pedidos</b>LOMAS
  </div>
  <div class="login-box-body">
    <b><p class="login-box-msg">Cambio de contraseña</p></b>
        <?php echo form_open("".base_url()."recupera_cuenta/cambiar_clave") ?>
        <div class="form-group has-feedback">
          <input type="hidden" name="actualizar" value="si"/>

        <div class="form-group has-feedback">
          <input type="hidden" name="id" value="<?php echo $id;?>"/>
          <input type="hidden" name="activate" value="<?php echo $activate;?>"/>
          <input type="password" class="form-control" placeholder="Clave" name="pass" value="<?php echo set_value('pass') ?>" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span> <?php echo form_error('pass'); ?>
        </div>
        <div class="form-group has-feedback">

          <input type="password" class="form-control" placeholder="Reingresar clave"   value="<?php echo set_value('pass2') ?>" name="pass2" required>
          <span class="glyphicon glyphicon-log-in form-control-feedback"></span> <?php echo form_error('pass2'); ?>
        </div>
        <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Cambiar </button>
        </div>
      </div>
    </div>
    </form>
</div>
</div>
<script src="<?php echo base_url()."assets/";?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url()."assets/";?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url()."assets/";?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
