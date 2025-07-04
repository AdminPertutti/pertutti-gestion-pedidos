

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Procesar Manualmente <br>
        <small>Listado de pedidos pendientes de procesar</small>
        <br>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Procesar</li>
      </ol>

      <br>

    </section>
    <section class="content">
      <div class="col-md-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Ultimos pedido procesado</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th>Local</th>
                  <th>Numero de pedido</th>
                  </tr>
                <tr>
                  <?php foreach ($procesado as $dato) {

                   ?>
                  <td><?php
                  echo $dato->local; ?></td>
                  <td><?php echo $dato->codigo; ?></td>
                </tr>
              <?php } ?>
              </table>
            </div>
            <div class="box-footer">
              <a href="/procesar/reimprimir_comandas" target="_parent"><button type="button" class="btn btn-success pull-right"> <i class="fa fa-fw fa-print"></i>  Reimprimir ultimos pedidos</button></a>
            </div>
          </div>
        </div>


  <div class="col-md-12">
      <div class="box box-warning box-solid">
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
              <th style="width: 20px">Local</th>
              <th style="width: 10px">#</th>
              <th>Descripción</th>
              <th style="width: 10px">_</th>
            </tr>
            <tr>
              <?php foreach ($pedidos as $dato) {

               ?>
              <td><?php
              $fecha_pedido = date_create($dato['fecha']);
              echo $fecha_pedido->format('d/m'); ?></td>
              <td><?php echo $dato['local']; ?></td>
              <td><?php echo $dato['cantidad']; ?></td>
              <td><?php echo $dato['descripcion']; ?></td>
              <td><?php if ($dato['procesado'] == 0) { echo '<a href="#" onclick="borrar('.$dato['cantidad'].',\''.$dato['descripcion'].'\','.$dato['id_pedido'].')" id="'.$dato['id_pedido'].'"class="btn btn-danger btn-xs" data-toggle="tooltip" title="Borrar!"><span class="glyphicon glyphicon-remove"></span> </a>'; }
              ?>
            </tr>
          <?php } ?>
          </table>
        </div>
        <div class="box-footer">
          <a href="/procesar/procesar_sinmail" target="_parent"><button type="button" class="btn btn-info"> <i class="fa fa-fw fa-print"></i> Procesar</button></a>
          <a href="/procesar/procesar_conmail" target="_parent"><button type="button" class="btn btn-warning pull-right"> <i class="fa fa-envelope"></i> Procesar/envía mails</button>
        </div>
      </div>
    </div>
</section>
