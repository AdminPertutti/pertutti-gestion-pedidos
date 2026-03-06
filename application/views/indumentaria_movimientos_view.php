<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Historial de Movimientos
            <small>Consultar entregas, devoluciones y bajas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?php echo base_url('indumentaria'); ?>">Indumentaria</a></li>
            <li class="active">Movimientos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-filter"></i> Filtros de Búsqueda</h3>
            </div>
            <form action="<?php echo base_url('indumentaria/movimientos'); ?>" method="get">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo de Movimiento</label>
                                <select name="tipo" class="form-control">
                                    <option value="">TODOS</option>
                                    <option value="ENTREGA" <?php echo ($filtros['tipo'] == 'ENTREGA') ? 'selected' : ''; ?>>ENTREGA</option>
                                    <option value="DEVOLUCION" <?php echo ($filtros['tipo'] == 'DEVOLUCION') ? 'selected' : ''; ?>>DEVOLUCIÓN</option>
                                    <option value="BAJA" <?php echo ($filtros['tipo'] == 'BAJA') ? 'selected' : ''; ?>>BAJA (Descarte)</option>
                                    <option value="INGRESO" <?php echo ($filtros['tipo'] == 'INGRESO') ? 'selected' : ''; ?>>INGRESO (Stock)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Empleado</label>
                                <select name="id_empleado" class="form-control select2">
                                    <option value="">TODOS</option>
                                    <?php foreach($empleados as $e): ?>
                                        <option value="<?php echo $e['id']; ?>" <?php echo ($filtros['id_empleado'] == $e['id']) ? 'selected' : ''; ?>><?php echo $e['nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Desde</label>
                                <input type="date" name="fecha_desde" class="form-control" value="<?php echo $filtros['fecha_desde']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Hasta</label>
                                <input type="date" name="fecha_hasta" class="form-control" value="<?php echo $filtros['fecha_hasta']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Filtrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Registros Hallados</h3>
                <div class="box-tools pull-right">
                    <a href="<?php echo base_url('indumentaria/reporte_movimientos?' . $_SERVER['QUERY_STRING']); ?>" target="_blank" class="btn btn-default btn-sm">
                        <i class="fa fa-print"></i> Imprimir listado actual
                    </a>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>Fecha/Hora Reg.</th>
                            <th>Fecha Entrega</th>
                            <th>Operación</th>
                            <th>Personal</th>
                            <th>Indumentaria</th>
                            <th>Cant.</th>
                            <th>Estado</th>
                            <th>Obs.</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($movimientos as $m): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($m['fecha'])); ?></td>
                            <td><b><?php echo $m['fecha_entrega'] ? date('d/m/Y', strtotime($m['fecha_entrega'])) : '-'; ?></b></td>
                            <td>
                                <?php 
                                    $label = 'label-info';
                                    if($m['tipo'] == 'DEVOLUCION') $label = 'label-success';
                                    if($m['tipo'] == 'BAJA') $label = 'label-danger';
                                    if($m['tipo'] == 'INGRESO') $label = 'label-warning';
                                ?>
                                <span class="label <?php echo $label; ?>"><?php echo $m['tipo']; ?></span>
                            </td>
                            <td><?php echo $m['empleado'] ? $m['empleado'] : 'DEPÓSITO'; ?></td>
                            <td><?php echo $m['articulo']; ?></td>
                            <td><?php echo $m['cantidad']; ?></td>
                            <td><?php echo $m['estado_prenda']; ?></td>
                            <td><small><?php echo $m['observaciones']; ?></small></td>
                            <td>
                                <a href="<?php echo base_url('indumentaria/deshacer_movimiento/' . $m['id']); ?>" class="btn btn-danger btn-xs" onclick="return confirm('¿Está seguro de deshacer este movimiento?')">
                                    <i class="fa fa-undo"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        if ($.fn.select2) {
            $('.select2').select2({ placeholder: "Seleccione..." });
        }
        if ($.fn.DataTable) {
            $('.datatable').DataTable({
                "order": [[0, "desc"]],
                "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" }
            });
        }
    });
</script>
