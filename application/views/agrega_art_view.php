

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Artículos <br>
        <small>Agregar Articulos a la venta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Articulos</li>
      </ol>
    </section>


<!-- Main content -->
<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title">Artículo Nuevo</h3>
            </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?php //echo $mensaje;?>

        <form enctype="multipart/form-data" action="<?php echo base_url()."articulos/agregar";?>" method="get">
          <div class="box-body">
            <div class="form-group">
              <label for="Nombrearticulo">Nombre</label>
              <input type="text" class="form-control"  name="nombre_art" placeholder="Nombre artículo" required>
            </div>
            <div class="form-group">
              <label for="Descripción">Descripción</label>
              <input type="text" class="form-control"  name="descripcion" placeholder="Descripción" required>
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
              <select class="form-control select2" name="categoria">

                  <option value=1>Activado</option>
                  <option value=0>Desactivado</option>


            </select>
            </div>

            <input type="hidden" name="id" value="<?php echo $this->session->s_idusuario;?>">

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Agregar Articulo</button>

           <button type="button" class="btn btn-danger text-right" onclick="window.location='<?php echo base_url()."articulos";?>'">Cancelar</button>
          </div>
        </form>
      </div>
      <!-- /.box -->
<button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">Agregar categoría</button>
<!-- /.modal -->

       </div>


       <!--=====================================
       MODAL AGREGAR CATEGORÍA
       ======================================-->

       <div id="modalAgregarCategoria" class="modal fade" role="dialog">

         <div class="modal-dialog">

           <div class="modal-content">

             <form role="form" method="post">

               <!--=====================================
               CABEZA DEL MODAL
               ======================================-->

               <div class="modal-header" style="background:#3c8dbc; color:white">

                 <button type="button" class="close" data-dismiss="modal">&times;</button>

                 <h4 class="modal-title">Agregar categoría</h4>

               </div>

               <!--=====================================
               CUERPO DEL MODAL
               ======================================-->

               <div class="modal-body">

                 <div class="box-body">

                   <!-- ENTRADA PARA EL NOMBRE -->

                   <div class="form-group">

                     <div class="input-group">

                       <span class="input-group-addon"><i class="fa fa-th"></i></span>

                       <input type="text" class="form-control input-lg" name="nuevaCategoria" placeholder="Ingresar categoría" required>

                     </div>

                   </div>

                 </div>

               </div>

               <!--=====================================
               PIE DEL MODAL
               ======================================-->

               <div class="modal-footer">

                 <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                 <button type="submit" class="btn btn-primary">Guardar categoría</button>

               </div>

             </form>

</div>

</div>


             </div>

           <!-- /.modal-dialog -->
         </div>
