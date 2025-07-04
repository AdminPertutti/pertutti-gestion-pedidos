

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">


      <h1>
        Pedido <br>
        <small>Pedidos pendientes de envío</small>
        <br>
      </h1>
            <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Enviar</li>
      </ol>

      <br>


      <div class="col-md-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Todos los pedidos procesados que faltan enviar</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="overlay">
                  <h1><div id="loading-img" style="vertical-align: middle">
                    <br><br><br><br><br>
                    Aguarde por favor...
                    <br>
                    Procesando !!!</div></h1>
              </div>
              <table class="table table-bordered table-responsive" width="100%">
                <tr>
                  <th style="width: 5px">[_]</th>
                  <th style="width: 10px">Num</th>
                  <th style="width: 80px">Cant</th>
                  <th>Pedido</th>
                  <th>Local</th>
                  </tr>

                  <?php
                  echo '<tr>';
                  foreach ($datos as $dato) {

                  if ($dato['procesado'] == 1 && $dato['enviado'] == 0){
                  echo '<td style="vertical-align: top">
                    <label><input type="checkbox" class="micheckbox" value="'.$dato['id_pedido'].'"></label>
                  </td>';
                  echo '<td>';
                  echo $dato['id_pedido'];
                   ?></td>
                  <td><input style="width: 25px" type="number" id="cantidad<?php echo $dato['id_pedido']; ?>" min="1" max="9" onchange="modificar(<?php echo $dato['id_pedido']; ?>,
                  <?php echo $dato['id_articulo']; ?>)" value="<?php echo $dato['cantidad']; ?>"></td>
                  <td><?php echo $dato['descripcion']; ?></td>
                  <td><?php echo $dato['local']; ?></td>
                  </tr>
                  <?php } } ?>
              </table>
              <BR>
              <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-success progress-bar-striped" id="cargando" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%" hidden>
                  <span class="sr-only">Modificando</span>
                </div>
              </div>
              <a  href="#" id="seleccionartodo" class="btn btn-app">
                <span class="badge bg-green">!</span>
                <i class="fa fa-check-square-o"></i> Seleccionar todo
              </a>
              <a href="#" id="botonenviar" onclick="enviar()" class="btn btn-app">
                <span class="badge bg-green">Enviar!</span>
                <i class="fa fa-truck"></i> Enviar Pedidos
              </a>
            </div>
            <!-- /.box-body -->

          </div>
          <BR>

          <div class="box box-warning box-solid" id="contenido" hidden>
            <div class="box-header with-border">
              <h3 class="box-title">Mensajes</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
          <!-- /.box -->
          <div>
             <ul id="posts">
             </ul>
          </div>
        </div>
        <br>
      </div>

        <!-- /.col -->



    </section>



<!-- Main content -->
