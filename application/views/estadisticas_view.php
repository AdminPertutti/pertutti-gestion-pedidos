  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Estadisticas
        <small>Estadisticas de pedidos de Aderezo</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Estadisticas</li>
      </ol>
    </section>
        <section class="content">
              <div class="row">
                <div class="col-md-12">
                 <div class="box box-primary">
                   <div class="box-header with-border">
                     <h3 class="box-title">Kilos de aderezos enviados</h3>
                       <div class="box-body">
                 <section class="content">

            <canvas id="myChart"></canvas>

        </section>
        </div>
      </div>
    </div>
  </div>


    <div class="col-md-12">
     <div class="box box-primary">
       <div class="box-header with-border">
         <h3 class="box-title">Tus kilos consumidos</h3>
           </div>
       <div class="box-body">
         <section class="content">

     <canvas id="pieChart" style="height:250px"></canvas>

</section>
</div>
</div>
</div>

  </div>




               <div class="row">
                 <div class="col-xs-12">
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
