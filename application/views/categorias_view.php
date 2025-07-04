

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Artículos <br>
        <small>Listado de Categorias a la venta</small>
        <br>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Categorias</li>
      </ol>

      <br>
      <div class="row">
      <div class="col-lg-12 col-xs-12">
      <button class="btn btn-warning" data-toggle="modal" data-target="#modalAgregarCategoria"><i class="fa  fa-navicon"></i> <BR>Agregar Categoria</button>
      </div>
          </div>
    </section>


<!-- Main content -->
<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-xs-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title">Listado de Categorias</h3>


                    <!-- /.box-header -->
              <div class="box-body">
                <table id="categorias" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($categorias as $dato) { // Comienzo de los Artículos
                    ?>
                  <tr>
                    <td><?php echo $dato['idCategoria'] ?></td>
                    <td><?php echo $dato['descripcion'] ?></td>
                    <td>
                    <?php echo '<a href="#" onclick="edita_cat('.$dato['idCategoria'].');return false;" id="editar'.$dato['idCategoria'].'" class="fa fa-edit" data-toggle="tooltip" title="Editar"></span> </a>'; ?>
                    </td>
                  </tr> <?php } //fin del foreach ?>

                  </tfoot>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- Main content -->


                  <!-- MODAL PARA CREAR CATEGORIA -->
                  <div id="modalAgregarCategoria" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <div class="modal-content">

                        <form role="form" action="<?php echo base_url()."categorias/agregar_categoria";?>" method="post">
                        <!-- general form elements -->
                            <div class="modal-header" style="background:#3c8dbc; color:white">
                              <h4 class="modal-title">Nueva Categoria</h4>
                            </div>
                          <!-- /.box-header -->
                          <!-- form start -->
                          <?php //echo $mensaje;?>
                             <div class="modal-body">

                                <div class="form-group">
                                <label for="Nombrearticulo">Nombre</label>
                                <input type="text" class="form-control"  name="nombre_cat" placeholder="Nombre de la Categoria" required>
                              </div>
                              <div class="form-group">
                                            </div>
                            <!-- /.box-body -->

                            <div class="modal-footer">
                              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                              <button type="submit" class="btn btn-primary">Agregar Categoria</button>


                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                        <!-- /.box -->

                <!-- MODAL PARA EDITAR CATEGORIAS-->
                <div id="modalModificarCategoria" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <div class="modal-content">

                      <form role="form" action="<?php echo base_url()."categorias/modificar_categoria";?>" method="post">
                      <!-- general form elements -->
                          <div class="modal-header" style="background:#3c8dbc; color:white">
                            <h4 class="modal-title">Modificar Categoria</h4>
                          </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <?php //echo $mensaje;?>
                           <div class="modal-body">

                              <div class="form-group">
                              <label for="Nombrearticulo">Nombre</label>
                              <input type="text" id="CategoriaNombre" class="form-control"  name="nombre_cat" placeholder="Nombre de la Categoria" required>
                            </div>
                            <input type="hidden" name="id" value="" id="idCategoria">
                            <div class="form-group">
                                          </div>
                          <!-- /.box-body -->

                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                            <button type="submit" class="btn btn-primary">Modificar Categoria</button>


                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                      <!-- /.box -->


<script src="<?php echo base_url()."assets/";?>dist/js/categorias.js?v=<?php echo(rand()); ?>"></script>
