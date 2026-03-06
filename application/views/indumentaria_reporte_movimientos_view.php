<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
    <style>
        body { font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f4f4f4; }
        .label { padding: 2px 5px; border-radius: 3px; font-weight: bold; font-size: 9px; }
        .footer { margin-top: 30px; font-size: 9px; text-align: right; border-top: 1px solid #ccc; padding-top: 5px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print();">
    <div class="header">
        <h1><?php echo $titulo; ?></h1>
        <p>Generado el: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha Reg.</th>
                <th>Fecha Entrega</th>
                <th>Operación</th>
                <th>Empleado</th>
                <th>Artículo</th>
                <th>Cant.</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($movimientos as $m): ?>
            <tr>
                <td><?php echo date('d/m/Y H:i', strtotime($m['fecha'])); ?></td>
                <td><strong><?php echo $m['fecha_entrega'] ? date('d/m/Y', strtotime($m['fecha_entrega'])) : '-'; ?></strong></td>
                <td><strong><?php echo $m['tipo']; ?></strong></td>
                <td><?php echo $m['empleado'] ? $m['empleado'] : 'DEPÓSITO'; ?></td>
                <td><?php echo $m['articulo']; ?></td>
                <td><?php echo $m['cantidad']; ?></td>
                <td><?php echo $m['estado_prenda']; ?></td>
                <td><?php echo $m['observaciones']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Gestión de Pedidos - Pertutti Lomas</p>
    </div>
</body>
</html>
