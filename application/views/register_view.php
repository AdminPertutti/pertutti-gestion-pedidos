
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Pedidos lomas | Pedidoslomas.ddns.net</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="<?php echo base_url()."login/";?>"><b>Pedidos</b>LOMAS</a>
  </div>
<fieldset>
  <div class="register-box-body">
    <h4><b><p class="login-box-msg">Crear usuario nuevo</p></b></h4>
    <?php
    if (isset($error_msg)) {
    echo $error_msg;
    } ?>
    <?php echo form_open("".base_url()."envio_mail/nuevo_usuario") ?>
  
      <div class="form-group has-feedback">
        <input type="hidden" name="grabar" value="si"/>

        <input type="text" class="form-control" placeholder="Nombre Completo" value="<?php echo set_value('nom') ?>" name="nom" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span> <?php echo form_error('nom'); ?>
      </div>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" value="<?php echo set_value('mail') ?>" name="mail" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span> <?php echo form_error('mail'); ?>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Telefono" value="<?php echo set_value('telefono') ?>" name="telefono" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span> <?php echo form_error('mail'); ?>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Clave" name="pass" value="<?php echo set_value('pass') ?>" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span> <?php echo form_error('pass'); ?>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Reingresar clave"   value="<?php echo set_value('pass2') ?>" name="pass2" required>
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span> <?php echo form_error('pass2'); ?>
      </div>

        <div class="form-group has-feedback">


          <input type="text" class="form-control" placeholder="Local" value="<?php echo set_value('local') ?>" name="local" required>
          <span class="glyphicon glyphicon-home form-control-feedback"></span> <?php echo form_error('local'); ?>
        </div>
        <div class="form-group has-feedback">

          <label for="nivel">Nivel de acceso:</label>
          <select class="form-control" id="nivel" name="nivel" >
          <option value="0">Usuario</option>
          <option value="1">Administrador</option>
          </select>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>

        <!-- /.col -->
        <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn btn-success btn-block btn-flat"> Registrarse  </button>
        </div>
      </div>
    </form>
    <BR>
    <a href="<?php echo base_url();?>login" class="text-center">Ya estoy registrado</a>
  </div>
</div>
<?php echo form_close() ?> </fieldset>
<script src="<?php echo base_url()."assets/";?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url()."assets/";?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()."assets/";?>dist/js/adminlte.min.js"></script>

</body>
</html>
