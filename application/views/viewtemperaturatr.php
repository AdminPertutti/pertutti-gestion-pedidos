<?php
echo  '  <section class="content">
        <div class="row">

      ';

foreach ($ultimatemp as $ultimatemp):

echo '      <div class="col-md-6 col-sm-6 col-xs-12">

            <div class="info-box bg-green">';

            if ($ultimatemp->ultima_temp > 6) {
          echo  '<span class="info-box-icon"><i class="fa fa-thermometer-full"></i></span>';
        } elseif ($ultimatemp->ultima_temp < 7 && $ultimatemp->ultima_temp > 0) {
          echo  '<span class="info-box-icon"><i class="fa fa-thermometer-half"></i></span>';
        } elseif ($ultimatemp->ultima_temp < 0) {
          echo  '<span class="info-box-icon"><i class="fa fa-thermometer-empty"></i></span>';
        }
            echo '<div class="info-box-content">
              <span class="info-box-text">'.$ultimatemp->nombre_placa.'</span>  <!-- Aca php con nombre de sensor -->
              <span class="info-box-number">'.$ultimatemp->ultima_temp.'</span> <!-- Aca php con temperatura sensor -->

              <div class="progress">
                <div class="progress-bar" style="width: ';
                $valor_temp = floatval($ultimatemp->ultima_temp);
                $temp = ($valor_temp +18) / 36 * 100;
                echo $temp;
                echo '%"></div>
              </div>
                  <span class="progress-description">
                    Temperatura
                  </span>
                  </div>
                </div>
                </div>
                ';
				endforeach;


echo '</section>';



?>
