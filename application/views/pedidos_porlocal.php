<?php
$ci = &get_instance();
$ci->load->model("pedidos_model");
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pedido <br>
        <small>Cargarle un nuevo pedido a un local</small>
        <br>
      </h1>
            <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Pedido por local</li>
      </ol>

      <br>
      <div class="col-md-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Ultimos pedidos sin procesar</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">Dia</th>
                  <th style="width: 10px">#</th>
                  <th style="width: 15px">Local</th>
                  <th>Descripción</th>
                  <th>Estado</th>
                  <th style="width: 10px">_</th>
                </tr>
                <tr>
                  <?php
                  foreach ($pedidos as $repos) {
                   ?>
                  <td><?php
                  $fecha_pedido = date_create($repos['fecha']);
                  echo $fecha_pedido->format('d/m H:i:s'); ?></td>
                  <td><?php echo $repos['id']; ?></td>
                  <td><?php echo $repos['local']; ?></td>

                  <td><?php
                  echo '<div class="dropdown show">
                  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink'.$repos['id'].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Detalle
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$repos['id'].'">';
                  echo $ci->pedidos_model->detalle_pedidos($repos['json']);
                  echo '</div>
                  </div>';
                   ?></td>
                  <td>
                  <?php if ($repos['procesado'] == 0) {
                    echo "<span class='badge bg-yellow'>Pendiente</span>";
                  } elseif ($repos['procesado'] == 1 && $repos['enviado'] == 0){
                    echo "<span class='badge bg-blue'>Procesado</span>";
                  } elseif ($repos['enviado'] == 1 && $repos['facturado'] == 0) {
                    echo "<span class='badge bg-green'>Enviado</span>";
                  } elseif ($repos['facturado'] == 1){
                    echo "<span class='badge bg-red'>Facturado</span>";
                  } else {
                    echo "<span class='badge bg-red'>Error</span>";
                  }
                  ?>
                  </td>
                  <td><?php if ($repos['procesado'] == 0) { echo '<a href="#" onclick="borrar('.$repos['id'].',\''.$ci->pedidos_model->detalle_pedidos($repos['json']).'\','.$repos['id'].')" id="'.$repos['id'].'"class="btn btn-danger btn-xs" data-toggle="tooltip" title="Borrar!"><span class="glyphicon glyphicon-remove"></span> </a>'; }
                  ?>
                </tr>

              <?php } ?>
              </table>
            </div>
          </div>
        </div>

    </section>
    <section class="content">
      <div class="row">
      <div class="col-md-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Seleccionar el local al cual cargar el pedido</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo base_url()."pedidos/cargarporlocal";?>" name="pedido" method="post">
              <select class="form-control select2" name="idusuario">

                  <?php foreach ($datos as $dato) {
                    // code...
                   ?>
                  <option value="<?php echo $dato['idUsr']; ?>">
                  <?php echo $dato['empresa'] ?>
                  </option>

              <?php } ?>

            </select>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

    </section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-xs-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title">Productos a Encargar</h3>

        <br>

        <!-- /.box-header -->
              <div class="box-body">

                <div class="row">

                  <?php foreach ($articulos as $dato) { // Comienzo de los Artículos
                   // Cada boton de los artículos figura acá
                  ?>
                  <div class="col-lg-3 col-xs-6"><div class="small-box bg-primary">
                  <input type="hidden" id="ad<?php echo $dato['idArt']; ?>" name="ad<?php echo $dato['idArt']; ?>" value"0">
                  <div class="inner">
                  <p><?php echo $dato['nombre'] ?><br>_____</p></div>
                  <div class="icon"><i class="fa fa-shopping-bag" onclick="incrementar()"></i></div>
                  <div class="btn-group">
                    <button a rel="nofollow" id="btndesc" data-id="<?php echo $dato['idArt']; ?>" type="button" class="btn btn-default">-</button>
                    <button id="item<?php echo $dato['idArt']; ?>" type="button" class="btn btn-primary">0</button>
                    <button a rel="nofollow" id="btnart" data-id="<?php echo $dato['idArt']; ?>" type="button" class="btn btn-default">+</button>
                    <input id="cant<?php echo $dato['idArt']; ?>" name="cant<?php echo $dato['idArt']; ?>" type="hidden" value=0>
                  </div></div></div>

                <?php  } ?>

                <?php foreach ($ultimo as $last) { ?>
                <input id="total" name="total" type="hidden" value=<?php echo $last['idArt']; ?>>
                <?php } ?>
                                    <div class="row">
                <div class="form-group">
                  <label></label>
                  <input type="hidden" name="observacion" class="form-control" rows="3" placeholder="Ingrese alguna observacion sobre el pedido.."></textarea>
                  <?php foreach ($datos as $dato) { ?>
                  <input type="hidden" name="<?php echo $dato['idUsr']; ?>" value="<?php echo $dato['empresa'] ?>" />
                  <?php } ?>
                </div>

              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
            <div class="box-footer">
                            <button type="button" class="btn btn-default">Cancelar</button>

                            <button type="button" onclick="confirma()" id="enviar" class="btn btn-success pull-right" disabled>Enviar Pedido</button>
                          </div> </form>
