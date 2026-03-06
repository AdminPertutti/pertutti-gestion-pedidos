<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgLnNtVDtqJySyF1upbSlyvnjt9Vgs1LM&v=3.exp&libraries=places">
</script>
<link href="<?php echo base_url()."assets/";?>dist/css/estilo.css" type="text/css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Calcular costo de envío
        <small>Desde aquí puede calcular el costo de envío</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Delivery</li>
      </ol>
    </section>

    <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->

          <div class="row">
<div class="col-md-12">
 <div class="box box-warning">
   <div class="box-header with-border">
     <h3 class="box-title">Buscar dirección</h3>

   </div>
   <div class="box-body">

     <section class="content">

       <div id="mapCanvas"></div>
       <div id="directionsPanel">
       <div class="directionInputs">
       <form>
        <p>
       <div class="input-group input-group-sm">
       <input class="form-control" placeholder="Dirección de entrega"  type="text" size="30" value="" id="dirSource">
       <span class="input-group-btn">
       <button id="boton" type="button" class="btn btn-primary pull-left" value="Ver en el mapa" onclick="codeAddress()">
       Ver en el mapa</button> </span>
     </div>
   </p>

         <div id="mapa"></div><div id="mapa2"></div>
       </div>
         <BR>
           <?php
           foreach ($delivery as $key => $a) {
             echo "Dirección del local <BR><input class='form-control' type='text' size='30' id='direccion' value='". $a['Direccion']. "' readonly>";
             echo "</a3><BR> Valor por KM: $ <input class='form-control' type='text' size='5' id='precio' value='";
             echo $a['Precio'];
             echo "' readonly></a>";

           }
           ?>

         <div> <a3> COSTO DE ENVIO: $ <a3 id="costo"></a3> </a3>
       </div>

       <div> <a3> DISTANCIA EN KM : <a3 id="distancia"></a3> Km</a3>
       </div>

       <div> <a3> TIEMPO PARA LLEGAR A DESTINO :  <a3 id="tiempo"></a3> minutos </a3>
       </div>

       <BR>
       <button type="reset" id="reset" class="btn btn-warning pull-left">Buscar otra dirección</button>
       <button id="calcular" type="button" class="btn btn-success pull-right" value="Calcular Env&iacute;o">Calcular Env&iacute;o <i id="loading" class="fa fa-refresh fa-spin"></i> </button>
       </form>
       </div>
       <div class="overlay">

       </div>
       <script type="text/javascript" src="<?php echo base_url()."assets/";?>dist/js/mapa.js?v=<?php echo(rand()); ?>"></script>
</div></div>

               <div class="row">
                 <div class="col-xs-12">
