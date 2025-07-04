

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
        <li class="active">Envios</li>
      </ol>

      <br>


      <div class="col-md-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Tus pedidos procesados que faltan enviar</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">Dia</th>
                  <th style="width: 10px">#</th>
                  <th>Descripción</th>

                </tr>
                <tr>
                  <?php foreach ($datos as $dato) {
                    // code...
                   ?>
                  <?php
                  if ($dato['procesado'] == 1 && $dato['enviado'] == 0){
                  echo "<td>";
                  $fecha_pedido = date_create($dato['fecha']);
                  echo $fecha_pedido->format('d/m'); ?></td>
                  <td><?php echo $dato['cantidad']; ?></td>
                  <td><?php echo $dato['descripcion']; ?></td>

                  </tr>
              <?php } } ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

    </section>


<!-- Main content -->
