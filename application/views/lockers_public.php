<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Locker <?php echo $locker['numero']; ?></title>
    <!-- Use AdminLTE/Bootstrap CSS for consistency, or standard Bootstrap for public -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body { background-color: #f4f7f6; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
        .card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; max-width: 400px; width: 90%; }
        .number { font-size: 80px; font-weight: bold; color: #3c8dbc; line-height: 1; margin-bottom: 20px; }
        .status { font-size: 24px; padding: 10px 20px; border-radius: 50px; display: inline-block; margin-bottom: 20px; text-transform: uppercase; font-weight: bold; }
        .status-sin-asignar { background: #e0e0e0; color: #666; }
        .status-asignado { background: #dff0d8; color: #3c763d; }
        .status-roto { background: #f2dede; color: #a94442; }
        .assigned-to { font-size: 20px; color: #333; }
        .logo { margin-bottom: 30px; font-weight: bold; font-size: 24px; color: #333; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">SISTEMA LOCKERS</div>
        <div class="number"><?php echo $locker['numero']; ?></div>
        
        <?php 
            $status_class = 'status-sin-asignar';
            $status_text = 'Sin Asignar';
            if ($locker['estado'] == 'asignado') { $status_class = 'status-asignado'; $status_text = 'Asignado'; }
            if ($locker['estado'] == 'roto') { $status_class = 'status-roto'; $status_text = 'Fuera de Servicio'; }
        ?>
        
        <div class="status <?php echo $status_class; ?>">
            <?php echo $status_text; ?>
        </div>

        <?php if ($locker['estado'] == 'asignado' && $locker['asignado_a']): ?>
            <div class="assigned-to">
                <small style="color:#888; display:block">Asignado a:</small>
                <strong><?php echo $locker['asignado_a']; ?></strong>
            </div>
        <?php endif; ?>
        
        <?php if ($locker['estado'] == 'roto'): ?>
            <div class="assigned-to" style="color:#a94442">
                <p>Este locker se encuentra en mantenimiento.</p>
            </div>
        <?php endif; ?>

        <div style="margin-top:40px; font-size: 12px; color: #aaa;">
            © <?php echo date('Y'); ?> Pedidos Lomas
        </div>
    </div>
</body>
</html>
