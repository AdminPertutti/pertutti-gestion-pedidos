

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reclamos <br>
        <small>Listado de reclamos</small>
        <br>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Reclamos</li>
      </ol>

      <br>
      <div class="row">
      <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
          <div class="inner">
            <h3>Nuevo</h3>

            <p>Reclamo</p>
          </div>
          <div class="icon">
            <i class="fa fa-exclamation-circle"></i>
          </div>
          <a href="<?php echo base_url()."reclamo/nuevoreclamo";?>" class="small-box-footer">
            Ingresar Reclamo<i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
          </div>
    </section>


<!-- Main content -->
<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-xs-12">
      <!-- general form elements -->
      <div class="box box-danger">
        <div class="box-header with-border">
        <h3 class="box-title">Listado de Reclamos</h3>


                    <!-- /.box-header -->
              <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th style="width:10px">Asunto</th>
                    <th>Descripción</th>
                    <th style="width:5px">Fecha</th>
                    <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($datos as $dato) {
                     ?>

                    <td><?php echo $dato['asunto']; ?> </td>
                    <td><?php echo $dato['descripcion']; ?></td>
                    <td><?php
                    $fecha_ = date_create($dato['fecha']);
                    echo $fecha_->format('d/m'); ?>
                   </td>
                    <td><?php if ($dato['resuelto'] == 0) {
                      echo "<span class='badge bg-yellow'>Pendiente</span>";
                    } elseif ($dato['resuelto'] == 1){
                      echo "<button class='btn btn-primary badge bg-green' data-toggle='modal' data-target='#exampleModal". $dato['idRec'] ."'>Resuelto</button>";
                      ?>


<!-- Modal -->
<div class="modal fade" id="exampleModal<?php echo $dato['idRec']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Resolución de la queja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php echo $dato['resolucion']; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
                    <?php } else {
                      echo "<span class='badge bg-red'>Error</span>";
                    }
                    ?></td>
                  </tr>
                <?php } ?>

                  </tr>

                  </tfoot>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
