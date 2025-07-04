<?php
$ci = &get_instance();
$ci->load->model("pedidos_model");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Panel de control
        <small>Página principal de Pedidos Lomas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Principal</li>
      </ol>
    </section>
        <section class="content">
          <div class="row">
            <div class="col-lg-3 col-xs-6">

              <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3><?php
                    $lote=date("z")+1;
                    echo $lote;
                    ?></h3>

                    <p>Lote de hoy<?php //echo date('d/m/Y');?></p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-calendar"></i>
                  </div>
                  <a class="small-box-footer">
                  <b> Fecha: <?php echo date('d-m-Y');?> </b>
                  </a>
                </div>

            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $proximaentrega ?></h3>
                  <p>Próxima entrega</p>
                </div>
                <div class="icon">
                  <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                </div>
                <a href="<?php echo base_url()."diasdeentrega";?>" class="small-box-footer">Ver días de entrega <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>Nuevo</h3>
                  <p>Pedido</p>
                </div>
                <div class="icon">
                  <i class="fa fa-shopping-bag"></i>
                </div>
                <a href="<?php echo base_url()."pedidos";?>" class="small-box-footer">Hacer Pedido <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>

          <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
                <div class="inner">
                  <h3>Iniciar</h3>
                    <p>Reclamo</p>
                </div>
                <div class="icon">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                </div>
                <a href="<?php echo base_url()."reclamo";?>" class="small-box-footer">Hacer reclamo <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>

<div class="row">
    <div class="col-md-12">
            <!-- Box Comment -->
            <div class="box box-success">
              <div class="box-header with-border">
                <div class="user-block">
                  <img class="img-circle"> <i class"fa-check-circle"></i>
                  <span class="username"><a href="#">Hernan Quatraro.</a></span>
                  <span class="description">Nuevas funciones - 02-09-2020</span>
                </div>
                <!-- /.user-block -->
                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- post text -->
                <p>- Se agrega funcion para calcular el costo de
                envío. El algoritmo toma en cuenta 2km de distancia
              hasta el punto de destino, como máximo para cobrar $50.
              Después de ese punto, cobra $100 hasta los 4km.
              Después ya calcula de acuerdo al precio por kilometro de
              la remiseria de su zona, redondeando siempre para arriba.</p>

                <p>- También figura en la página principal el numero de Lote
                que coresponde al día actual. Y desde el menú lateral se
              puede buscar la fecha que corresponde a un lote ingresado.</p>
              </div>
              <!-- /.box-body -->
              <div class="box-footer box-comments">
                <div class="box-comment">
                  <!-- User image -->
                  <div class="comment-text">

                  </div>
                  <!-- /.comment-text -->
                </div>
                <!-- /.box-comment -->

                <!-- /.box-comment -->
              </div>
              <!-- /.box-footer -->

              <!-- /.box-footer -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->


              <div class="row">
                <div class="col-md-6">
                 <div class="box box-primary">
                   <div class="box-header with-border">
                     <h3 class="box-title">Kilos de aderezos enviados</h3>
                       <div class="box-body">
                 <section class="content">

            <canvas id="myChart"></canvas>


        </div>
      </div>
    </div>
  </div>


    <div class="col-md-6">
     <div class="box box-primary">
       <div class="box-header with-border">
         <h3 class="box-title">Tus kilos consumidos</h3>
           </div>
       <div class="box-body">
         <section class="content">

     <canvas id="pieChart" style="height:250px"></canvas>


</div>
</div>
</div>

  </div>


          <div class="row">

<div class="col-md-12">
 <div class="box box-success">
   <div class="box-header with-border">
     <h3 class="box-title">Últimos Pedidos</h3>

   </div>
   <div class="box-body">
     <section class="content">
               <div class="box-body">
                 <table class="table table-bordered" id="example1">
                   <tr>
                     <th>Dia</th>
                     <th style="width: 10px">#</th>
                     <th style="width: 15px">Local</th>
                     <th>Descripción</th>
                     <th>Estado</th>
                     </tr>
                   <tr>
                     <?php
                     foreach ($pedidos as $repos) {

                      $fecha_pedido = date_create($repos['fecha']);
                      ?>
                     <td><?php
                     echo $fecha_pedido->format('d/m H:i:s'); ?></td>
                     <td><?php echo $repos['id']; ?></td>
                     <td><?php echo $repos['local']; ?></td>

                     <td><?php
                     echo '<div class="dropdown show">
                     <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink'.$repos['id'].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Detalle
                     </a>
                     <div class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$repos['id'].'">';
                     echo $ci->pedidos_model->detalle_pedidos($repos['json']);
                     echo '</div>
                     </div>';
                      ?></td>
                     <td>
                     <?php if ($repos['procesado'] == 0) {
                       echo "<span class='badge bg-yellow'>Pendiente</span>";
                     } elseif ($repos['procesado'] == 1 && $repos['enviado'] == 0){
                       echo "<span class='badge bg-blue'>Procesado</span>";
                     } elseif ($repos['enviado'] == 1 && $repos['facturado'] == 0) {
                       echo "<span class='badge bg-green'>Enviado</span>";
                     } elseif ($repos['facturado'] == 1){
                       echo "<span class='badge bg-red'>Facturado</span>";
                     } else {
                       echo "<span class='badge bg-red'>Error</span>";
                     }
                     ?>
                     </td>
                       </tr>

                 <?php } ?>
                 </table>
                 </div>
               </div>
       </div> </div>
</div>

</div>

<script>
$(function() {
var config1 = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						<?php echo $total_kilos ?>,
					  <?php echo $kilos ?>
					],
				backgroundColor: ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],
        borderColor: ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"],
        borderWidth: 1,
				label: 'Dataset 1'
				}],
				labels: [
					'Total de kilos',
					'Tus kilos'

				]
			},
			options: {
				responsive: true,
        	legend: {
					position: 'left',
				},
				title: {
					display: false,
					text: 'Kilos de Adeerzo enviado'
				},
				animation: {
				  duration: 1000,
          animationSteps       : 100,
          animateScale         : false,
          animationEasing      : 'easeOutBounce'
				}
			}}

      <?php
      $total = count($graficar);
      echo "var etiquetas = [";
      foreach ($graficar as $value) {
      $total--;
      echo "'" . $value['local'] . "'";
      if ($total != 0) echo ",";
       }  // Termina el foreach
      echo "];";

      echo " var datos = [";
      $total = count($graficar);
      foreach ($graficar as $value) {
        $total--;
      echo $value['kilos'];
      if ($total != 0) echo ",";
       }  // Termina el foreach
      echo "];";
      ?>

		  var config = {
      type: 'bar',
      data: {
          labels: etiquetas,
             datasets: [{
              data: datos,
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  "rgba(75, 192, 192, 0.2)",
                  "rgba(54, 0, 235, 0.2)",
                  "rgba(153, 102, 255, 0.2)",
                  "rgba(201, 203, 207, 0.2)"

              ],

              borderWidth: 2
          }]
      }, 
      options: {
        legend: false,
        beginAtZero: true,
        animateRotate        : true,
        animationSteps       : 150000,
        maintainAspectRatio  : true,
        animationEasing      : 'easeOutBounce'
      }
    }

var ctx1 = document.getElementById('pieChart').getContext('2d');
var ctx = document.getElementById('myChart').getContext('2d');

var myChart = new Chart(ctx, config);
window.myDoughnut = new Chart(ctx1, config1);
});
</script>
