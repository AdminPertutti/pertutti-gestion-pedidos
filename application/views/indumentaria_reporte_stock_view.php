<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Stock de Indumentaria</title>
    <style>
        body { font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .footer { margin-top: 30px; font-size: 10px; text-align: right; border-top: 1px solid #ccc; padding-top: 5px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 20px; }
        }
    </style>
</head>
<body onload="window.print();">
    <div class="header">
        <h1>Reporte de Existencias - Indumentaria</h1>
        <p>Fecha de emisión: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="60%">Artículo</th>

                <th width="20%" class="text-center">Stock Actual</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($articulos as $a): ?>
            <tr>
                <td><?php echo $a['nombre']; ?></td>

                <td class="text-center text-bold"><?php echo $a['stock']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Gestión de Pedidos - Pertutti Lomas</p>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print();" style="padding: 10px 20px; cursor: pointer;">Imprimir Reporte</button>
        <button onclick="window.close();" style="padding: 10px 20px; cursor: pointer; margin-left:10px;">Cerrar Ventana</button>
    </div>
</body>
</html>
