<?php
$ci = &get_instance();
$ci->load->model("pedidos_model");
?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Pedido <br>
        <small>Realizar un nuevo Pedido</small>
        <br>
      </h1>
            <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Pedidos</li>
      </ol>

      <br>
      <?php  if ($pedido_ok !=0) {
        echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Pedido cargado!</h4>
              Se ha cargado su pedido numero ' .$pedido_ok.'</div>';
      }
      ?>
      <?php  if ($pendiente == true) {
        echo '<div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
              Tiene pedidos pendientes sin procesar. <br> Tenerlo en cuenta antes de realizar un pedido nuevo.
            </div>';
      }
      ?>
      <div class="col-md-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Tus últimos pedidos</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">Dia</th>
                  <th style="width: 10px">#</th>
                  <th>Descripción</th>
                  <th>Estado</th>
                  <th style="width: 10px">_</th>
                </tr>
                <tr>
                  <?php foreach ($pedidos as $dato) {
                     ?>
                  <td><?php
                  $fecha_pedido = date_create($dato['fecha']);
                  echo $fecha_pedido->format('d/m'); ?></td>
                  <td><?php echo $dato['id']; ?></td>
                  <td>  <?php   echo '<div class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink'.$dato['id'].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Detalle
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$dato['id'].'">';
                                    echo $ci->pedidos_model->detalle_pedidos($dato['json']);
                                    echo '</div>
                                    </div>'; ?>
                  </td>
                  <td>
                  <?php if ($dato['procesado'] == 0) {
                    echo "<span class='badge bg-yellow'>Pendiente</span>";
                  } elseif ($dato['procesado'] == 1 && $dato['enviado'] == 0){
                    echo "<span class='badge bg-blue'>Procesado</span>";
                  } elseif ($dato['enviado'] == 1 && $dato['facturado'] == 0) {
                    echo "<span class='badge bg-green'>Enviado</span>";
                  } elseif ($dato['facturado'] == 1){
                    echo "<span class='badge bg-red'>Facturado</span>";
                  } else {
                    echo "<span class='badge bg-red'>Error</span>";
                  }

                  ?>


                  </td>
                  <td><?php if ($dato['procesado'] == 0) { echo '<a href="#" onclick="borrar('.$dato['id'].',\''.$ci->pedidos_model->detalle_pedidos($dato['json']).'\','.$dato['id'].')" id="'.$dato['id'].'"class="btn btn-danger btn-xs" data-toggle="tooltip" title="Borrar!"><span class="glyphicon glyphicon-remove"></span> </a>'; }
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
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title">Productos a Encargar</h3>

        <br>
              <div id="pedir" class="box-body">

                <div class="row">
                  <form action="<?php echo base_url()."pedidos/cargar";?>" name="pedido" method="post">

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
                </div>
              </div>
            </div>
          </div>
            <div class="box-footer">
                            <button type="button" class="btn btn-default">Cancelar</button>
                            <button type="button" onclick="confirma()" id="enviar" class="btn btn-success pull-right" disabled>Enviar Pedido</button>
                          </div> </form>
