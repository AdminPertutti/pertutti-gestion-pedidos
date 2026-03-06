<!DOCTYPE html>
<html lang="es-ES">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema de pedidos | Pertutti Lomas</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/";?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/";?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="<?php echo base_url()."assets/";?>dist/css/custom.css">
    <style type="text/css">
    .overlay {
        background: #e9e9e9;
        display: none;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        opacity: 0.5;
        text-align: center;

    }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo base_url()."assets/";?>bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script>
    $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="<?php echo base_url()."assets/";?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="<?php echo base_url()."assets/";?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()."assets/";?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url()."assets/";?>bower_components/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url()."assets/";?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url()."assets/";?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url()."assets/";?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="<?php echo base_url()."assets/";?>dist/js/adminlte.min.js"></script>
    <script src="<?php echo base_url()."assets/";?>dist/js/sweetalert2.all.js"></script>
    <script src="<?php echo base_url()."assets/";?>dist/js/pedidos.js?v=<?php echo(rand()); ?>"></script>
    <script src="<?php echo base_url()."assets/";?>plugins/input-mask/jquery.inputmask.js"></script>
    <script>
    function toggleDarkMode() {
        $('body').toggleClass('dark-mode');
        var isDark = $('body').hasClass('dark-mode');
        
        // Update Icon
        if (isDark) {
            $('#darkModeIcon').removeClass('fa-moon-o').addClass('fa-sun-o');
            localStorage.setItem('theme', 'dark');
        } else {
            $('#darkModeIcon').removeClass('fa-sun-o').addClass('fa-moon-o');
            localStorage.setItem('theme', 'light');
        }
    }

    // Apply theme on load
    $(document).ready(function() {
        if (localStorage.getItem('theme') === 'dark') {
            $('body').addClass('dark-mode');
            $('#darkModeIcon').removeClass('fa-moon-o').addClass('fa-sun-o');
        }
    });
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="" class="logo">
      <span class="logo-mini"><b>P</b>L</span>
      <span class="logo-lg"><b>Pedidos</b>LOMAS</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="<?php echo base_url()."assets/";?>#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Cambiar Navegación</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Dark Mode Toggle -->
          <li>
            <a href="#" onclick="toggleDarkMode(); return false;" title="Modo Oscuro">
              <i class="fa fa-moon-o" id="darkModeIcon"></i>
            </a>
          </li>
          <li class="dropdown user user-menu">
            <a href="<?php echo base_url()."assets/";?>#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user-circle fa-3" aria-hidden="true"></i>
              <span class="hidden-xs"><?php echo $this->session->s_nombre;?> </span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <i class="fa fa-user-circle fa-3" aria-hidden="true"></i>
                <p>
                  <?php echo $this->session->s_nombre;?>
                  <small><?php echo $this->session->s_usuario;?></small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url()."perfil";?>" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url()."login/logout";?>" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
      </div>
    </nav>
      </header>
