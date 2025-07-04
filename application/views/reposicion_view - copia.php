<?php
$ci = &get_instance();
$ci->load->model("reposicion_model");
echo $respuesta;
?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>Reposición <br>
        <small>Enviar reposición de productos a los sectores</small><br>
      </h1>
            <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Inicio</a></li>
            <li class="active">Reposición</li>
            </ol><br>
    <div class="col-md-12">
      <div class="box box-warning box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Las últimas reposiciones</h3>
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
                  <?php
                  foreach ($repo as $repos) {
                   ?>
                  <td><?php
                  $fecha_pedido = date_create($repos['fecha_repo']);
                  echo $fecha_pedido->format('d/m H:i:s'); ?></td>
                  <td><?php echo $repos['idRepo']; ?></td>
                  <td><?php
                  echo '<div class="dropdown show">
                  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink'.$repos['idRepo'].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Detalle
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$repos['idRepo'].'">';
                  //echo $repos['detalle'];
                  echo $ci->reposicion_model->detalle_reposicion($repos['detalle']);
                  echo '</div>
                  </div>';
                   ?></td>
                  <td>
                  <?php echo "<span class='badge bg-blue'>Impreso</span>";
                  ?>
                  </td>
                  <td><?php echo '<a rel="nofollow" href="#" onclick="reimprimir('.$repos['idRepo'].');return false;" id="'.$repos['idRepo'].'" class="glyphicon glyphicon-print" data-toggle="tooltip" title="Reimprimir!" ></span> </a>';
                  ?>
                </tr>

              <?php } ?>
              </table>
            </div>
          </div>
        </div>

<br>
<div class="col-md-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Productos a pedir Reposición</h3>
              <br>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo base_url()."reposicion/enviar";?>" name="repo" method="post">

              <!-- /.box-body -->
                <br>




          <?php foreach ($categorias as $categoria) { // Comienzo de las categorias !!! ?>
           <div class="box box-primary box-solid">
               <div class="box-header with-border">
              <h3 class="box-title"><?php echo $categoria['descripcion']; ?></h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
              <div class="box-body">
                <div class="row">
                    <?php foreach ($datos as $dato) { // Comienzo de los Artículos
                     // Cada boton de los artículos figura acá
                    if ($dato['idCategoria'] == $categoria['idCategoria']) {?>
                    <a rel="nofollow"  id="btnart" data-id="<?php echo $dato['idArt']; ?>" class="btn btn-app">
                    <span class="badge bg-green" id="item<?php echo $dato['idArt']; ?>"></span>
                    <i class="fa fa-barcode"></i> <?php echo $dato['nombre'] ?>
                    <input id="cant<?php echo $dato['idArt']; ?>" name="cant<?php echo $dato['idArt']; ?>" type="hidden" value=0>
                    <input id="sector<?php echo $dato['idArt']; ?>" name="sector<?php echo $dato['idArt']; ?>" type="hidden" value=<?php echo $dato['sector']; ?>>

                    </a>

                  <?php } } ?>



              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
          <div class="box-footer">
          </div>


        <?php } // Final de las $categorias ?>
        <?php foreach ($ultimo as $last) { ?>
        <input id="total" name="total" type="hidden" value=<?php echo $last['idArt']; ?>>
        <?php } ?>



                            <button type="reset" value="reset" class="btn btn-default">Cancelar</button>

                            <button type="button" onclick="confirmarepo()" id="enviar" class="btn btn-success pull-right" disabled>Enviar Reposición</button>
                          </form>
                          <br>
                        </div>
                    </div>
<BR>
