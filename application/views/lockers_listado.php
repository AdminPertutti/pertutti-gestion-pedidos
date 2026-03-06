<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listado de Lockers Asignados</title>
    <style>
        @media print { .no-print { display: none; } }
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        h2 { text-align: center; color: #333; }
        .header-info { text-align: center; margin-bottom: 20px; color: #666; }
        .btn-print {
            position: fixed; top: 20px; right: 20px;
            padding: 10px 20px; background: #f39c12; color: white;
            border: none; border-radius: 5px; cursor: pointer;
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">Imprimir Listado</button>
    
    <h2>Control de Lockers Asignados</h2>
    <div class="header-info">Fecha del reporte: <?php echo date('d/m/Y H:i'); ?></div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Locker</th>
                <th>Persona Asignada</th>
                <th style="width: 25%;">Firma / Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = 0;
            foreach ($lockers as $l): 
                if ($l['estado'] == 'asignado'):
                    $count++;
            ?>
            <tr>
                <td><strong># <?php echo $l['numero']; ?></strong></td>
                <td><?php echo $l['asignado_a']; ?></td>
                <td></td>
            </tr>
            <?php 
                endif;
            endforeach; 
            ?>
            <?php if ($count == 0): ?>
            <tr>
                <td colspan="3" style="text-align:center;">No hay lockers asignados actualmente.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 12px; color: #aaa; text-align: center;">
        SISTEMA DE GESTIÓN DE LOCKERS - PEDIDOS LOMAS
    </div>
</body>
</html>
