<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Res. 299/11 SRT - Constancia de Entrega</title>
    <style>
        @page { margin: 10mm; }
        body { font-family: Arial, sans-serif; font-size: 11px; margin: 0; padding: 0; color: #000; }
        .container { width: 100%; border: 1px solid #000; box-sizing: border-box; }
        .header-title { text-align: center; font-weight: bold; border-bottom: 2px solid #000; padding: 10px; font-size: 14px; text-decoration: underline; }
        
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { border: 1px solid #000; padding: 6px 8px; vertical-align: top; }
        .label { font-weight: bold; text-transform: uppercase; }
        
        .main-table { width: 100%; border-collapse: collapse; margin-top: -1px; }
        .main-table th, .main-table td { border: 1px solid #000; padding: 8px 4px; text-align: center; line-height: 1.2; }
        .main-table th { font-weight: bold; text-transform: uppercase; background-color: #f0f0f0; font-size: 10px; }
        .col-prod { width: 28%; }
        .col-model { width: 12%; }
        .col-marca { width: 12%; }
        .col-cert { width: 15%; }
        .col-cant { width: 7%; }
        .col-fecha { width: 11%; }
        .col-firma { width: 15%; }

        .row-empty td { height: 35px; }
        .footer-note { border: 1px solid #000; border-top: none; padding: 8px; font-weight: bold; text-transform: uppercase; height: 40px; }

        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 10px;">
        <button onclick="window.print()">Imprimir</button>
        <button onclick="window.history.back()">Volver</button>
    </div>

    <div class="container">
        <div class="header-title">
            CONSTANCIA DE ENTREGA DE ROPA DE TRABAJO Y ELEMENTOS DE PROTECCION PERSONAL (RES. 299 / 2011 SRT)
        </div>
        
        <table class="info-table">
            <tr>
                <td colspan="2"><span class="label">RAZON SOCIAL:</span> BAHIA ESPAÑA S.A.</td>
                <td colspan="2"><span class="label">CUIT:</span> 33-70779199-9</td>
            </tr>
            <tr>
                <td><span class="label">DIRECCIÓN:</span> ESPAÑA 299 - PERTUTTI LOMAS</td>
                <td><span class="label">LOCALIDAD:</span> LOMAS DE ZAMORA</td>
                <td><span class="label">CP:</span> 1832</td>
                <td><span class="label">PROVINCIA:</span> BUENOS AIRES</td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">NOMBRE Y APELLIDO:</span> <?php echo strtoupper($empleado->nombre); ?></td>
                <td colspan="2"><span class="label">DNI:</span> <?php echo $empleado->dni; ?></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">SECTOR / PUESTO:</span> </td>
                <td colspan="2"><span class="label">EPP:</span> ELEMENTOS VARIOS SEGÚN SE DETALLA EN COLUMNA DE PRODUCTO</td>
            </tr>
        </table>

        <table class="main-table">
            <thead>
                <tr>
                    <th class="col-prod">PRODUCTO</th>
                    <th class="col-model">TIPO/MODELO</th>
                    <th class="col-marca">MARCA</th>
                    <th class="col-cert">POSEE CERTIFICACION SI / NO</th>
                    <th class="col-cant">CANTIDAD</th>
                    <th class="col-fecha">FECHA DE ENTREGA</th>
                    <th class="col-firma">FIRMA</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = 0;
                foreach($movimientos as $m): 
                    $count++;
                ?>
                <tr>
                    <td style="text-align: left;"><?php echo strtoupper($m['articulo']); ?></td>
                    <td></td>
                    <td>GENERICA</td>
                    <td></td>
                    <td><?php echo $m['cantidad']; ?></td>
                    <td><?php echo $m['fecha_entrega'] ? date('d/m/Y', strtotime($m['fecha_entrega'])) : date('d/m/Y', strtotime($m['fecha'])); ?></td>
                    <td></td>
                </tr>
                <?php endforeach; ?>

                <?php 
                // Rellenar hasta 15 filas como en la imagen
                for($i = $count + 1; $i <= 15; $i++): ?>
                <tr class="row-empty">
                    <td><?php echo $i; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
        
        <div class="footer-note">
            INFORMACION ADICIONAL:
        </div>
    </div>

</body>
</html>
