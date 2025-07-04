

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Facturación <br>
        <small>Listado de facturación a locales</small>
        <br>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Facturacion</li>
      </ol>

      <br>
      <div class="row"> <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow"> <div class="inner">
            <h3>Simular</h3>
            <p>Facturacion</p>
      </div>  <div class="icon">  <i class="fa fa-file"></i>
      </div>  <a href="<?php echo base_url()."facturar/simular";?>" class="small-box-footer">
            Realizar simulación<i class="fa fa-arrow-circle-right"></i>
          </a> </div> </div>

          <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green"> <div class="inner">
                <h3>Facturar</h3>
                <p>Todos los locales</p>
          </div>  <div class="icon">  <i class="fa fa-file-text"></i>
          </div>  <a href="<?php echo base_url()."facturar/facturar";?>" class="small-box-footer">
                Realizar facturacion<i class="fa fa-arrow-circle-right"></i>
              </a> </div> </div>

              </div>
    </section>


<!-- Main content -->
<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-xs-12">
      <!-- general form elements -->
      <div class="box box-success">
        <div class="box-header with-border">
        <h3 class="box-title">Listado de Facturación a Locales</h3>


                    <!-- /.box-header -->
              <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th style="width:5px">#</th>
                    <th>Local</th>
                    <th style="width:10px">Fecha</th>
                    <th>Importe</th>
                    <th>PDF</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($datos as $dato) {
                     ?>

                    <td><?php echo $dato->idFact; ?> </td>
                    <td><?php echo $dato->nombre_local; ?></td>
                    <td><?php
                    $fecha_ = date_create($dato->fecha_facturacion);
                    echo $fecha_->format('d/m'); ?>
                   </td>
                    <td><?php echo "$ "; echo $dato->total_produccion+$dato->total_logistica;?>


                    </td>
                    <td>  <a href="<?php echo base_url().$dato->pdf; ?>" target="_blank" class="btn btn-success" role="button" aria-disabled="true">PDF</a>
                          </td>
                  </tr>
                <?php } ?>

                  </tr>

                  </tfoot>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
