<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Reporte General de Indumentaria
            <small>Estado actual de asignaciones por empleado</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('indumentaria'); ?>"><i class="fa fa-shopping-bag"></i> Indumentaria</a></li>
            <li class="active">Reporte General</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary no-print">
            <div class="box-header with-border">
                <h3 class="box-title">Filtros</h3>
            </div>
            <div class="box-body">
                <form action="<?php echo base_url('indumentaria/reporte_general'); ?>" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Filtrar por Empleado</label>
                                <select name="id_empleado" class="form-control select2">
                                    <option value="">-- Todos los Empleados --</option>
                                    <?php foreach($empleados as $e): ?>
                                        <option value="<?php echo $e['id']; ?>" <?php echo ($filtros['id_empleado'] == $e['id']) ? 'selected' : ''; ?>>
                                            <?php echo $e['nombre']; ?> (DNI: <?php echo $e['dni']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" style="margin-top: 25px;">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-search"></i> Buscar
                            </button>
                        </div>
                        <div class="col-md-2" style="margin-top: 25px;">
                            <a href="<?php echo base_url('indumentaria/reporte_general'); ?>" class="btn btn-default btn-block">
                                <i class="fa fa-eraser"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Listado de Asignaciones</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-default btn-sm" onclick="window.print()">
                        <i class="fa fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped" id="tablaReporte">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Prenda / Artículo</th>
                            <th>Talle</th>
                            <th>Cantidad en Posesión</th>
                            <th>Última Entrega</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($asignaciones)): ?>
                            <?php foreach($asignaciones as $row): ?>
                                <tr>
                                    <td><strong><?php echo $row['empleado']; ?></strong></td>
                                    <td><?php echo $row['articulo']; ?></td>
                                    <td><?php echo $row['talle']; ?></td>
                                    <td>
                                        <span class="badge bg-green" style="font-size: 1.1em;"><?php echo $row['cantidad_actual']; ?></span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($row['ultima_fecha'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <p class="text-muted small">* La cantidad mostrada es el resultado de Entregas - Devoluciones - Bajas.</p>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    $('.select2').select2();
    
    $('#tablaReporte').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "pageLength": 50,
        "ordering": true,
        "searching": true,
        "stateSave": true,
        "responsive": true,
        "order": [[ 0, "asc" ]] // Ordenar por empleado por defecto
    });
});
</script>
