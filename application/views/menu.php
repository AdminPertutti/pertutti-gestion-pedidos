<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU PRINCIPAL</li>
        <form action="" method="get" class="sidebar-form">
        <div class="input-group">
          <input id="buscarlote" type="number" name="lote" class="form-control" placeholder="Buscar por lote..." min="1" max="366">
          <span class="input-group-btn">
                <button name="buscar" id="buscar-btn" class="btn btn-flat" disabled>
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
        </form>
        <br>
        <table class="table text-center">
               <tr>
                 <th>
        <button type="button" id="lote" class="btn btn-block btn-default btn-sm" style="display: none;"> 15-07-1977</button>
      </th>
    </table>
        <li>
          <a href="<?php echo base_url()."inicio/";?>">
            <i class="fa fa-dashboard"></i> <span>Inicio</span>
            </a>
        </li>
        <?php //Aca se agregan al menú las opciones para los administradores
        echo '<li>
          <a href="';
          echo base_url();
          echo 'pedidos">';
          echo '<i class="fa fa-shopping-bag"></i> <span>Pedidos</span>
            <span class="pull-right-container">

            </span>
          </a>
        </li>';

       if ($this->session->s_nivel == 0) {
        echo '<li>
          <a href="';
          echo base_url().'envios';
          echo '"><i class="fa fa-shopping-cart"></i> <span>Envíos Pendientes</span>
            <span class="pull-right-container">';

              if ($this->session->s_pendientes > 0) {
              echo '<small class="label pull-right bg-red">';
              echo $this->session->s_pendientes;
              echo '</small>';
             }
             echo '  </span>
             </a>
           </li>';
           }

       ?>
       <li>
         <a href="<?php echo base_url()."reclamo/";?>">
           <i class="fa fa-exclamation-circle"></i> <span>Reclamos</span>
           </a>
       </li>
        <?php //Aca se agregan al menú las opciones para los administradores
        if ($this->session->s_nivel == 1) {
          echo '<li> <a href="';
          echo base_url();
          echo 'enviar">
            <i class="fa fa-truck"></i> <span>Enviar Mercaderia</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>'; }

        echo '<li> <a href="';
        echo base_url();
        echo 'delivery">
          <i class="fa fa-motorcycle"></i> <span>Calcular envío</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>';

        if ($this->session->s_nivel == 1) {
        echo '<li> <a href="';
        echo base_url();
        echo 'registrarse">
          <i class="fa fa-home"></i> <span>Cargar nuevo local</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>';

  echo '<li class="treeview">
  <a href="#">
    <i class="fa fa-laptop"></i>
    <span>Mercaderia</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="';
    echo base_url();
    echo 'articulos"><i class="fa fa-circle-o"></i> Articulos</a></li>
    <li><a href="';
    echo base_url();
    echo 'categorias"><i class="fa fa-circle-o"></i> Categorias</a></li>
  </ul>
</li>';
}
         ?>
         <?php //Aca se agregan al menú las opciones para los administradores
         if ($this->session->s_nivel == 1) {
           echo '<li> <a href="';
           echo base_url();
           echo 'reposicion">
             <i class="fa fa-edit"></i> <span>Reposición</span>
             <span class="pull-right-container">
             </span>
           </a>
         </li>';
           echo '<li> <a href="';
           echo base_url();
           echo 'facturar">
             <i class="fa fa-file-text"></i> <span>Facturación</span>
             <span class="pull-right-container">
             </span>
           </a>
         </li>';
           echo '<li> <a href="';
           echo base_url();
           echo 'procesar">
             <i class="fa fa-desktop"></i> <span>Procesar Manualmente</span>
             <span class="pull-right-container">
             </span>
           </a>
         </li>';

         }
          ?>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
<script type="text/javascript" src="<?php echo base_url()."assets/";?>dist/js/menu.js"></script>
