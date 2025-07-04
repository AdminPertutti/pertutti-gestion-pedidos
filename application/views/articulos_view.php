

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Artículos <br>
        <small>Listado de artículos a la venta</small>
        <br>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Articulos</li>
      </ol>

      <br>
      <div class="row">
      <div class="col-lg-12 col-xs-12">
      <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarArticulo"><i class="fa fa-shopping-basket"></i> <BR>Agregar Artículo</button>
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
        <h3 class="box-title">Listado de Articulos</h3>


                    <!-- /.box-header -->
              <div class="box-body">
                <table id="articulos" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Sector</th>
                    <th>____</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($datos as $dato) { // Comienzo de los Artículos
                    ?>
                  <tr>
                    <td><?php echo $dato['nombre'] ?></td>
                    <td><?php echo $dato['descripcion'] ?></td>
                    <td><?php
                    $indice = $dato['sector'] - 1;
                    echo $sectores[$indice]['descripcion']?></td>
                    <td>
                    <?php
                    if ($dato['activo'] == 1) {
                    echo '<a href="#" onclick="desactiva('.$dato['idArt'].');return false;" id="desactiva'.$dato['idArt'].'" class="fa fa-check-circle" data-toggle="tooltip" title="Desctivar"></span> </a>';
                  } else { echo '<a href="#" onclick="activa('.$dato['idArt'].');return false;" id="activa'.$dato['idArt'].'" class="fa fa-circle" data-toggle="tooltip" title="Activar"></span> </a>'; }
                    ?>
                    <?php echo '<a href="#" onclick="edita_art('.$dato['idArt'].');return false;" id="editar'.$dato['idArt'].'" class="fa fa-edit" data-toggle="tooltip" title="Editar"></span> </a>'; ?>
                    <?php echo '<a href="#" onclick="borra_art('.$dato['idArt'].');return false;" id="'.$dato['idArt'].'" class="fa fa-trash" data-toggle="tooltip" title="Borrar!"></span> </a>'; ?>
                    </td>
                  </tr> <?php } //fin del foreach ?>

                  </tfoot>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- Main content -->

                <div id="modalAgregarArticulo" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <div class="modal-content">

                      <form role="form" action="<?php echo base_url()."articulos/agregar";?>" method="post">
                      <!-- general form elements -->
                          <div class="modal-header" style="background:#3c8dbc; color:white">
                            <h4 class="modal-title">Artículo Nuevo</h4>
                          </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <?php //echo $mensaje;?>
                           <div class="modal-body">
                              <div class="form-group">
                              <label for="Nombrearticulo">Nombre</label>
                              <input type="text" class="form-control"  name="nombre_art" placeholder="Nombre artículo" required>
                            </div>
                            <div class="form-group">
                              <label for="Descripción">Descripción</label>
                              <input type="text" class="form-control"  name="descripcion" placeholder="Descripción">
                            </div>
                            <div class="form-group">
                              <label for="precioproduccion">Categoría del articulo</label>
                              <select class="form-control select2" name="categoria">

                                  <?php foreach ($categorias as $dato) {
                                    // code...
                                   ?>
                                  <option value="<?php echo $dato['idCategoria']; ?>">
                                  <?php echo $dato['descripcion'] ?>
                                  </option>
                                  <?php } ?>
                            </select>

                            </div>

                            <div class="form-group">
                              <label for="preciodistribucion">Sector desde donde se despacha</label>
                              <select class="form-control select2" name="sectores">

                                  <?php foreach ($sectores as $dato) {
                                    // code...
                                   ?>
                                  <option value="<?php echo $dato['idSector']; ?>">
                                  <?php echo $dato['descripcion'] ?>
                                  </option>

                              <?php } ?>

                            </select>
                            </div>
                            <div class="form-group">
                              <label for="activado">Activado</label>
                              <select class="form-control select2" name="activado">

                                  <option value=1>Activado</option>
                                  <option value=0>Desactivado</option>


                            </select>
                            </div>

                            <input type="hidden" name="id" value="<?php echo $this->session->s_idusuario;?>">

                          </div>
                          <!-- /.box-body -->

                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                            <button type="submit" class="btn btn-primary">Agregar Articulo</button>


                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- MODAL PARA CREAR CATEGORIA -->
                  <div id="modalAgregarCategoria" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <div class="modal-content">

                        <form role="form" action="<?php echo base_url()."articulos/agregar_categoria";?>" method="post">
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

                <!-- MODAL PARA EDITAR ARTICULOS-->
                <div id="modalEditarArticulo" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <div class="modal-content">

                      <form role="form" action="<?php echo base_url()."articulos/editar_art";?>" method="POST">
                      <!-- general form elements -->
                          <div class="modal-header" style="background:#3c8dbc; color:white">
                            <h4 class="modal-title">Artículo Nuevo</h4>
                          </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <?php //echo $mensaje;?>
                           <div class="modal-body">
                              <div class="form-group">
                              <label for="Nombrearticulo">Nombre</label>
                              <input type="text" class="form-control"  name="nombre_art" placeholder="Nombre artículo" id="ArticuloNombre" required>
                            </div>
                            <div class="form-group">
                              <label for="Descripción">Descripción</label>
                              <input type="text" class="form-control"  name="descripcion" placeholder="Descripción">
                            </div>
                            <div class="form-group">
                              <label for="precioproduccion">Categoría del articulo</label>
                              <select class="form-control select2" name="categoria" id="SelectCategoria">

                                  <?php foreach ($categorias as $dato) {
                                    // code...
                                   ?>
                                  <option value="<?php echo $dato['idCategoria']; ?>">
                                  <?php echo $dato['descripcion'] ?>
                                  </option>
                                  <?php } ?>
                            </select>

                            </div>

                            <div class="form-group">
                              <label for="preciodistribucion">Sector desde donde se despacha</label>
                              <select class="form-control select2" name="sectores" id="SelectSector">

                                  <?php foreach ($sectores as $dato) {
                                    // code...
                                   ?>
                                  <option value="<?php echo $dato['idSector']; ?>">
                                  <?php echo $dato['descripcion'] ?>
                                  </option>

                              <?php } ?>

                            </select>
                            </div>
                            <div class="form-group">
                              <label for="activado">Activado</label>
                              <select class="form-control select2" name="activado" id="SelectActivado">

                                  <option value=1>Activado</option>
                                  <option value=0>Desactivado</option>


                            </select>
                            </div>

                            <input type="hidden" name="id" value="" id="idArt">

                          </div>
                          <!-- /.box-body -->

                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                            <button type="submit" class="btn btn-primary">Modificar Articulo</button>


                          </div>
                        </form>
                      </div>
                    </div>
                  </div>


<script src="<?php echo base_url()."assets/";?>dist/js/articulos.js?v=<?php echo(rand()); ?>"></script>
