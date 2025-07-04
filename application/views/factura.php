<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Factura PedidosLomas</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/";?>dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> Pertutti lomas  / Facturación a Locales.
          <BR>
          <small class="pull-right">
          </small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-6 invoice-col">
        De
        <address>
          <strong>Pertutti lomas</strong>
          Lomas de zamora<br>
          Tel: 4392-4343<br>
          Email: pertuttilomas@gmail.com
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-6 invoice-col">
        A
        <address>
          <?php //Aca se cargan los datos del local !!!! ?>
          <strong><?php
          echo $localfacturado;
          ?>
        </strong>
          <?php echo $nombre; ?><br>
          Telefono: <?php echo $telefono; ?><br>
          Email: <?php echo $mail; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Facturación del mes de : </b><br>
        <br>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>

            <th>Pedido</th>
            <th>Fecha</th>
            <th>Cant</th>
            <th>Descripcion</th>
            <th>Costo</th>
            <th>Logistica</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $total = 0;
            $totallogistica = 0;
            foreach ($factura as $key)
            {
            echo "<tr>";

            echo "<td> $key->id_pedido </td>";
            echo "<td>";
            $fecha_ = date_create($key->fecha);
            echo $fecha_->format('d/m');
            echo "</td>";
            echo "
            <td>   $key->cantidad </td>
            <td> $key->descripcion </td>
            <td>$";
            // Precio
            $subtotal = $key->importe_produccion * $key->cantidad;
            $total += $subtotal;
            echo $subtotal;
            echo "</td>";

            $subtotallogistica = $key->importe_envio * $key->cantidad;
            $totallogistica += $subtotallogistica;
            echo "<td>$$subtotallogistica</td>
            </tr>";
            }
          ?>

          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-12">

        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          Facturación realizada desde el sistema pedidoslomas.ddns.net
        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">---------------------------------------------------</p>

        <div class="table-responsive well-sm">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal Costo:</th>
              <td>$<?php echo $total ?></td>
            </tr>
            <tr>
              <th>Logistica:</th>
              <td>$<?php echo $totallogistica ?></td>
            </tr>
            <tr>
              <th>Total:</th>
              <td><strong>$<?php echo $total+$totallogistica ?></strong></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
