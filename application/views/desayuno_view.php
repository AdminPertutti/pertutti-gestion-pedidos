<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgLnNtVDtqJySyF1upbSlyvnjt9Vgs1LM&v=3.exp&libraries=places">
</script>
<link href="<?php echo base_url()."assets/";?>dist/css/desayuno.css" type="text/css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Desayuno</li>
      </ol>
    </section>
    <br>

    <!-- Main content -->
<section class="content">
<!-- Small boxes (Stat box) -->

<div class="row">
<div class="col-md-8">
 <div class="box box-success">
   <div class="box-header with-border">
     <h3 class="box-title">Venta de desayuno</h3>
   </div>
   <div class="box-body">

     <section class="content">
       <div class="form-group">
                  <h4>Elija el tipo de desayuno</h4>
                  <select id="producto" name="producto" onchange="mostrarElegido()" class="form-control">
                    <option selected="true" value="" disabled="disabled">Seleccione un desayuno</option>
                    <option value="2800">Desayuno Color</option>
                    <option value="3200">Desayuno Criollo</option>
                  </select>
                </div>
                <input id="aclaracion_desayuno" name="aclaracion_desayuno" placeholder="Aclaraciones sobre el desayuno" type="text" class="form-control">

       <h4>Datos de quién envía</h4>
        <form>

          <div class="form-group">
          <div class="input-group input-group-sm">
          <div class="input-group-addon">
          <i class="fa fa-phone"></i>
          </div>
          <input type="number" class="form-control" placeholder="Teléfono" data-inputmask='"mask": "(99) 9999-9999"' data-mask>
          </div>
        </div>
          <div class="input-group input-group-sm">
          <span class="input-group-addon">
          <i class="fa fa-user"></i></span>
          <input type="text" class="form-control" placeholder="Nombre"> </div>


      <div class="input-group input-group-sm">
      <span class="input-group-addon">
      <i class="fa fa-envelope"></i></span>
      <input type="email" class="form-control" placeholder="Email"> </div>

       <script type="text/javascript" src="<?php echo base_url()."assets/";?>dist/js/desayuno.js"></script>
       <br>
       <h4>Datos de quien recibe</h4>

          <div class="input-group input-group-sm">
          <span class="input-group-addon">
          <i class="fa fa-user"></i></span>
          <input type="text" class="form-control" placeholder="Nombre de quien Recibe">
         </div>
          <br>
       <div class="input-group input-group-sm">

       <input class="form-control" placeholder="Buscar dirección de entrega"  type="text" size="30" value="" id="dirSource">

       <span class="input-group-btn">
       <button id="boton" type="button" class="btn btn-primary pull-left" value="Ver en el mapa" onclick="codeAddress()">
       Ver en el mapa</button> </span>
       </div>
       <br>
       <div id="mapa"></div><div id="mapa2"></div>
       <br>
       <form class="form-horizontal">

  <div class="form-group">
    <label for="locality" class="control-label col-xs-3">Localidad</label>
    <div class="col-xs-9">
      <div class="input-group input-group-sm">
        <div class="input-group-addon">
          <i class="fa fa-circle-thin"></i>
        </div>


          <input id="localidad" name="localidad" placeholder="Localidad" type="text" required="required" class="form-control">
      </div>
    </div> </div>
    <div class="form-group">
    <label for="calle" class="control-label col-xs-3">Calle</label>
    <div class="col-xs-9">
      <div class="input-group input-group-sm">
        <div class="input-group-addon">
          <i class="fa fa-automobile"></i>
        </div>
        <input id="route" name="calle" placeholder="Calle" type="text" required="required" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="altura" class="control-label col-xs-3">Altura</label>
    <div class="col-xs-9">
      <div class="input-group input-group-sm">
        <div class="input-group-addon">
          <i class="fa fa-hashtag"></i>
        </div>
        <input id="street_number" name="altura" placeholder="Altura" type="text" required="required" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="detalle_direccion" class="control-label col-xs-3">Piso/Depto</label>
    <div class="col-xs-9">
      <div class="input-group input-group-sm">
        <div class="input-group-addon">
          <i class="fa fa-home"></i>
        </div>
        <input id="detalle_direccion" name="detalle_direccion" placeholder="Piso / Departamento / Casa" type="text" aria-describedby="detalle_direccionHelpBlock" required="required" class="form-control">
      </div>
      <span id="detalle_direccionHelpBlock" class="help-block">Ingrese el piso, el departamento o Casa</span>
    </div>
  </div>

  <div class="form-group input-group-sm">
    <label for="entrecalles" class="control-label col-xs-3">Entrecalles</label>
    <div class="col-xs-9">
      <input id="entrecalles" name="entrecalles" placeholder="Entrecalles" type="text" aria-describedby="entrecallesHelpBlock" required="required" class="form-control">
      <span id="entrecallesHelpBlock" class="help-block">Ingrese las entrecalles de la dirección</span>
    </div>
  </div>


  <div class="form-group">
    <label for="tarjeta" class="control-label col-xs-3">Tarjeta</label>
    <div class="col-xs-9">
      <textarea id="tarjeta" name="tarjeta" cols="40" rows="3" aria-describedby="tarjetaHelpBlock" class="form-control"></textarea>
      <span id="tarjetaHelpBlock" class="help-block">Ingrese el texto a incluir en la tarjeta</span>
    </div>
  </div>
    <br>
    <div class="form-group input-group-sm">
      <label for="observaciones" class="control-label col-xs-3">Observaciones</label>
      <div class="col-xs-9">
        <input id="observaciones" name="observaciones" placeholder="Observaciones o aclaraciones" type="text" class="form-control">
      </div>
  </div>
</form>



         <BR>
           <?php
           foreach ($delivery as $key => $a) {
             echo "<input class='form-control' type='hidden' size='30' id='direccion' value='". $a['Direccion']. "' readonly>";
             echo "</a3><input class='form-control' type='hidden' size='5' id='precio' value='";
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
       <input id="calcular" type="button" class="btn btn-success pull-right" value="Calcular Env&iacute;o"></p>
       </form>
     </section>
   </div> </div> </div>

     <div class="col-md-4">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Costo total</h3>
        </div>
        <div class="box-body">

          <section class="content">
            <form class="form-horizontal">
  <div class="form-group">
    <label for="precio_desayuno" class="control-label col-xs-5">Costo del desayuno</label>
    <div class="col-xs-7">
      <div class="input-group">
        <div class="input-group-addon">$</div>
        <input id="precio_desayuno" name="precio_desayuno" type="text" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="costo_adicionales" class="control-label col-xs-5">Costo de adicionales</label>
    <div class="col-xs-7">
      <div class="input-group">
        <div class="input-group-addon">$</div>
        <input id="costo_adicionales" name="costo_adicionales" type="text" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="costo_envio" class="control-label col-xs-5">Costo de envío</label>
    <div class="col-xs-7">
      <div class="input-group">
        <div class="input-group-addon">$</div>
        <input id="costo_envio" name="costo_envio" type="text" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-xs-5" for="costo_total">TOTAL</label>
    <div class="col-xs-7">
      <div class="input-group">
        <div class="input-group-addon">$</div>
        <input id="costo_total" name="costo_total" type="text" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-xs-offset-5 col-xs-7">
      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>
          </section>
        </div> </div> </div>
