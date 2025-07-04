
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Perfil <br>
        <small>Modificar los datos del usuario</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Perfil</li>
      </ol>
    </section>
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                <i class="fa fa-user-circle fa-6" aria-hidden="true"></i>
              </div>
              <h3 class="widget-user-username"><?php echo $nombre_comp;?></h3>
              <h5 class="widget-user-desc"><?php echo $this->session->s_usuario;?></h5>
            </div>
          </div>
        </div>
        <?php echo $mensaje;?>
        <form enctype="multipart/form-data" action="<?php echo base_url()."perfil/modificar";?>" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Nombre Completo</label>
              <input type="text" class="form-control"  name="nombre_comp" placeholder="Nombre completo" value="<?php echo $nombre_comp;?>">
            </div>
            <div class="form-group">
              <label for="inputTelefono">Telefono</label>
              <input type="phone" class="form-control"  name="telefono" placeholder="Teléfono" value="<?php echo $telefono;?>">
            </div>
            <div class="form-group">
              <label for="inputEmpresa">Local</label>
              <input type="phone" class="form-control"  name="empresa" placeholder="Empresa" value="<?php echo $empresa;?>" disabled>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" name="email" placeholder="Entrar email" value="<?php echo $mail;?>" disabled>
            </div>
            <input type="hidden" name="id" value="<?php echo $this->session->s_idusuario;?>">
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Modificar</button>
           <button type="button" class="btn btn-danger text-right" onclick="window.location='<?php echo base_url()."perfil";?>'">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-6">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Cambio de clave</h3>
                </div>
                <form class="form-horizontal" action="<?php echo base_url()."perfil/modifica_clave";?>" method="post">
                    <div class="box-body">
                  <label for="exampleInputPasswordact">Clave actual</label>
                  <input type="password" class="form-control" name="passwordact" value="<?php echo set_value('passwordact'); ?>" placeholder="Clave" required> <?php echo form_error('passwordact'); ?>

                 <label for="exampleInputPassword1">Modificar Clave</label>
                 <input type="password" class="form-control" name="password1" value="<?php echo set_value('password1'); ?>" placeholder="Clave" required> <?php echo form_error('password1'); ?>


                 <label for="exampleInputPassword2">Vuelva a escribir la clave</label>
                 <input type="password" class="form-control" name="password2" value="<?php echo set_value('password2'); ?>" placeholder="Reescriba la clave" required> <?php echo form_error('password2'); ?>
                 <input type="hidden" name="id_usr" value="<?php echo $this->session->s_idusuario;?>">
               </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Modificar</button>
        </form>
      </div>
    </div>
  </div>
</div>
       </div>
