<!DOCTYPE html>
<html>
<head>
    <title>Reporte - Empleados Sin Uniforme</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .info-seccion { margin-bottom: 20px; }
        .tabla { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .tabla th, .tabla td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .tabla th { background-color: #f2f2f2; font-weight: bold; }
        .tabla tr:nth-child(even) { background-color: #f9f9f9; }
        .resumen { background-color: #fff3cd; padding: 10px; border-left: 4px solid #ffc107; margin-bottom: 20px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="background: #f0f0f0; padding: 10px; text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()">Imprimir Reporte</button>
        <button onclick="window.history.back()">Volver</button>
    </div>

    <div class="header">
        <h2>REPORTE DE EMPLEADOS SIN UNIFORME ASIGNADO</h2>
        <p>Fecha de Generación: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <?php if (empty($empleados)): ?>
        <div class="resumen" style="background-color: #d4edda; border-left-color: #28a745;">
            <strong>✓ Estado Óptimo:</strong> Todos los empleados activos tienen uniformes asignados.
        </div>
    <?php else: ?>
        <div class="resumen">
            <strong>⚠ Atención:</strong> Se encontraron <?php echo count($empleados); ?> empleado(s) sin uniforme asignado.
        </div>

        <h3>Listado de Empleados</h3>
        <table class="tabla">
            <thead>
                <tr>
                    <th style="width: 10%;">#</th>
                    <th style="width: 30%;">DNI</th>
                    <th style="width: 60%;">Nombre del Empleado</th>
                </tr>
            </thead>
            <tbody>
                <?php $contador = 1; ?>
                <?php foreach($empleados as $emp): ?>
                <tr>
                    <td><?php echo $contador++; ?></td>
                    <td><?php echo $emp['dni']; ?></td>
                    <td><?php echo $emp['nombre']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="info-seccion">
            <p><strong>Total de empleados sin uniforme:</strong> <?php echo count($empleados); ?></p>
            <p><strong>Nota:</strong> Este reporte incluye únicamente empleados activos que no tienen uniformes asignados o cuyo balance neto de uniformes es cero.</p>
        </div>
    <?php endif; ?>

</body>
</html>
