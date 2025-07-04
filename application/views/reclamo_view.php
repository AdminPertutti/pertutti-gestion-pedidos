
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Reclamo <br>
        <small>Desde aquí puede iniciar un reclamo </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Reclamo</li>
      </ol>
    </section>
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-exclamation-circle"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">!</span>
                  <span class="info-box-number">Iniciar Reclamo</span>
                </div>
              </div>
            </div>
          </div>
        <form enctype="multipart/form-data" action="<?php echo base_url()."reclamo/cargar";?>" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Asunto del reclamo </label>
              <input type="text" class="form-control"  name="asunto" placeholder="Asunto" value="">
            </div>
            <div class="form-group">
              <label for="inputTelefono">Detalle del reclamo</label>
              <textarea rows="4" class="form-control"  name="detalle" placeholder="Escriba el detalle del reclamo" value=""></textarea>
            </div>
            <div class="form-group">
              <label for="inputEmpresa">Local</label>
              <input type="text" class="form-control"  name="local" placeholder="Local" value="<?php echo $this->session->s_local; ?>" disabled>
            </div>
            <input type="hidden" name="id" value="<?php echo $this->session->s_idusuario;?>">
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Cargar Reclamo</button>
           <button type="button" class="btn btn-danger text-right" onclick="window.location='<?php echo base_url()."reclamo";?>'">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
</div>
