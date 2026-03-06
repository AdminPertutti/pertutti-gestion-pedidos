<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Empleados Sin Uniforme Asignado
            <small>Listado de personal sin indumentaria</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?php echo base_url('indumentaria'); ?>">Indumentaria</a></li>
            <li class="active">Sin Uniforme</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-exclamation-triangle"></i> Empleados Sin Uniforme</h3>
                <div class="box-tools pull-right">
                    <a href="<?php echo base_url('indumentaria/reporte_empleados_sin_uniforme'); ?>" target="_blank" class="btn btn-default btn-sm">
                        <i class="fa fa-print"></i> Imprimir Reporte
                    </a>
                </div>
            </div>
            <div class="box-body">
                <?php if (empty($empleados)): ?>
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i> ¡Excelente! Todos los empleados activos tienen uniformes asignados.
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fa fa-info-circle"></i> Se encontraron <strong><?php echo count($empleados); ?></strong> empleado(s) sin uniforme asignado.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <tr>
                                    <th>DNI</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($empleados as $emp): ?>
                                <tr>
                                    <td><?php echo $emp['dni']; ?></td>
                                    <td><?php echo $emp['nombre']; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('indumentaria#emp-' . $emp['id']); ?>" class="btn btn-primary btn-xs" title="Asignar uniforme">
                                            <i class="fa fa-plus"></i> Asignar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('.datatable').DataTable({
                "order": [[1, "asc"]],
                "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" }
            });
        }
    });
</script>
