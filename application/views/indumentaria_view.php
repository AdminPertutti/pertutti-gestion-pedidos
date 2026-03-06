<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    .select2-container .select2-selection--single { height: 34px !important; border: 1px solid #d2d6de !important; border-radius: 0 !important; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 32px !important; padding-left: 0 !important; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 32px !important; }

    /* Dark Mode Overrides for Select2 */
    body.dark-mode .select2-container--default .select2-selection--single {
        background-color: #16213e !important;
        border-color: #30344c !important;
        color: #fff !important;
    }
    body.dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #fff !important;
    }
    body.dark-mode .select2-dropdown {
        background-color: #16213e !important;
        border-color: #30344c !important;
        color: #fff !important;
    }
    body.dark-mode .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #1a1a2e !important;
        border-color: #30344c !important;
        color: #fff !important;
    }
    body.dark-mode .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #0f3460 !important;
    }
    body.dark-mode .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #0f3460 !important;
        color: #fff !important;
    }
    body.dark-mode .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #888 !important;
    }

    /* Broad input overrides for Dark Mode */
    body.dark-mode input.form-control,
    body.dark-mode select.form-control,
    body.dark-mode textarea.form-control {
        background-color: #1a1a2e !important;
        border-color: #30344c !important;
        color: #fff !important;
    }
    body.dark-mode .input-group-addon {
        background-color: #16213e !important;
        border-color: #30344c !important;
        color: #c7c7c7 !important;
    }

    /* Container and Label overrides for Dark Mode */
    body.dark-mode .form-group[style*="background: #f4f4f4"],
    body.dark-mode .row[style*="background: #fff"],
    body.dark-mode .row[style*="background:#fff"] {
        background-color: #1a1a2e !important;
        border-color: #30344c !important;
    }
    body.dark-mode label,
    body.dark-mode h1,
    body.dark-mode h2,
    body.dark-mode h3,
    body.dark-mode h4,
    body.dark-mode h5,
    body.dark-mode h6,
    body.dark-mode .box-title {
        color: #fff !important;
    }
    body.dark-mode .table thead tr[style*="background: #eee"],
    body.dark-mode .table thead tr[style*="background:#eee"] {
        background-color: #0f3460 !important;
    }
    body.dark-mode .table thead tr th {
        color: #fff !important;
    }
    body.dark-mode hr {
        border-top-color: #30344c !important;
    }

    /* Tabs and Table overrides for Employee History in Dark Mode */
    body.dark-mode .nav-tabs-custom {
        background-color: #16213e !important;
        box-shadow: none !important;
    }
    body.dark-mode .nav-tabs-custom > .nav-tabs {
        border-bottom-color: #30344c !important;
    }
    body.dark-mode .nav-tabs-custom > .nav-tabs > li > a {
        color: #c7c7c7 !important;
    }
    body.dark-mode .nav-tabs-custom > .nav-tabs > li.active > a {
        background-color: #16213e !important;
        color: #fff !important;
        border-left-color: #30344c !important;
        border-right-color: #30344c !important;
    }
    body.dark-mode .nav-tabs-custom > .tab-content {
        background-color: #16213e !important;
        color: #c7c7c7 !important;
    }
    body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #1f2a48 !important;
    }
    body.dark-mode .table-hover > tbody > tr:hover {
        background-color: #25335a !important;
    }
    body.dark-mode .text-muted {
        color: #888 !important;
    }
    body.dark-mode .label-default {
        background-color: #30344c !important;
        color: #fff !important;
    }
    body.dark-mode .select2-container--default .select2-selection--single {
        background-color: #1a1a2e !important;
        border-color: #30344c !important;
    }
    body.dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #fff !important;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Gestión de Indumentaria
            <small>Control de stock y entregas a empleados</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Indumentaria</li>
        </ol>
    </section>

    <section class="content">
        <!-- Botones de Acceso Rápido (Dashboard Style) -->
        <div class="row">
            <div class="col-lg-4 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>Stock</h3>
                        <p>Administrar Depósito</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-archive"></i>
                    </div>
                    <a href="<?php echo base_url('indumentaria/deposito'); ?>" class="small-box-footer">Entrar al Depósito <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>Personal</h3>
                        <p>Administrar Empleados</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="<?php echo base_url('indumentaria/empleados'); ?>" class="small-box-footer">Gestión de Empleados <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>Historial</h3>
                        <p>Reportes y Auditoría</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-history"></i>
                    </div>
                    <a href="<?php echo base_url('indumentaria/movimientos'); ?>" class="small-box-footer">Ver Movimientos <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>Reporte</h3>
                        <p>Sin Uniforme Asignado</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <a href="<?php echo base_url('indumentaria/empleados_sin_uniforme'); ?>" class="small-box-footer">Ver Empleados Sin Uniforme <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>General</h3>
                        <p>Reporte de Asignaciones</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list-alt"></i>
                    </div>
                    <a href="<?php echo base_url('indumentaria/reporte_general'); ?>" class="small-box-footer">Ver Qué Tiene Cada Uno <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Columna de Movimientos (Acción Principal) -->
            <div class="col-md-8">
                <form action="<?php echo base_url('indumentaria/registrar_entrega_batch'); ?>" method="post" id="formEntregaMultiple">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-exchange"></i> Registrar Entrega de Indumentaria</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="background: #f4f4f4; padding: 10px; border-left: 5px solid #3c8dbc;">
                                        <label><i class="fa fa-user"></i> 1. Seleccione el Empleado</label>
                                        <select name="id_empleado" id="id_empleado_select" class="form-control select2" required style="width: 100%;">
                                            <option value="">Escriba nombre o DNI...</option>
                                            <?php foreach($empleados as $e): ?>
                                                <option value="<?php echo $e['id']; ?>"><?php echo $e['dni']; ?> - <?php echo $e['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><i class="fa fa-calendar"></i> 2. Fecha de Entrega Física</label>
                                        <input type="date" name="fecha_entrega" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            <label>3. Agregue las prendas a entregar</label>
                            <div class="row" id="selector_prendas" style="background: #fff; border: 1px solid #ddd; padding: 15px; margin: 0 5px 15px 5px; border-radius: 5px;">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Artículo</label>
                                        <select id="sel_articulo" class="form-control select2" style="width: 100%;">
                                            <option value="">Seleccione un artículo...</option>
                                            <?php foreach($articulos as $a): ?>
                                                <option value="<?php echo $a['id']; ?>" data-nombre="<?php echo $a['nombre']; ?>" data-stock="<?php echo $a['stock']; ?>">
                                                    <?php echo $a['nombre']; ?> - Stock: <?php echo $a['stock']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Cant.</label>
                                        <input type="number" id="sel_cantidad" class="form-control" value="1" min="1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <select id="sel_estado" class="form-control">
                                            <option value="NUEVO">NUEVA</option>
                                            <option value="USADO">USADA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-success btn-block" onclick="agregarArticuloALista()"><i class="fa fa-plus"></i> Añadir</button>
                                </div>
                            </div>

                            <!-- Tabla de Lista Temporal -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="tabla_entrega_multiple">
                                    <thead>
                                        <tr style="background: #eee;">
                                            <th>Artículo</th>
                                            <th>Cantidad</th>
                                            <th>Estado</th>
                                            <th width="50px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="lista_prendas_cuerpo">
                                        <tr id="fila_vacia">
                                            <td colspan="4" class="text-center text-muted">No hay prendas en la lista de entrega</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            <i class="text-muted small">* Al confirmar, se actualizará el stock y se abrirá el remito para imprimir.</i>
                            <button type="submit" id="btn_confirmar_entrega" class="btn btn-primary pull-right" disabled><i class="fa fa-print"></i> Confirmar Entrega e Imprimir</button>
                        </div>
                    </div>
                </form>

                <!-- Box para Devoluciones y Bajas (Individual) -->
                <form action="<?php echo base_url('indumentaria/registrar_movimiento'); ?>" method="post">
                    <div class="box box-warning collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-undo"></i> Registrar Devolución o Baja Individual</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Empleado</label>
                                        <select name="id_empleado" class="form-control select2" required style="width: 100%;">
                                            <option value="">Escriba nombre o DNI...</option>
                                            <?php foreach($empleados as $e): ?>
                                                <option value="<?php echo $e['id']; ?>"><?php echo $e['dni']; ?> - <?php echo $e['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Artículo</label>
                                        <select name="id_articulo" class="form-control select2" required style="width: 100%;">
                                            <option value="">Seleccione...</option>
                                            <?php foreach($articulos as $a): ?>
                                                <option value="<?php echo $a['id']; ?>"><?php echo $a['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Fecha de Entrega</label>
                                        <input type="date" name="fecha_entrega" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select name="tipo" class="form-control">
                                            <option value="DEVOLUCION">DEVOLUCIÓN</option>
                                            <option value="BAJA">BAJA (Descarte)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="number" name="cantidad" class="form-control" value="1" min="1">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <select name="estado_prenda" class="form-control">
                                            <option value="USADO">USADO (Buen estado)</option>
                                            <option value="MALO">MAL ESTADO / ROTA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning pull-right">Registrar Movimiento</button>
                        </div>
                    </div>
                </form>

                <!-- Resumen de Movimientos Recientes -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-history"></i> Consulta por Empleado</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10">
                                <select id="select_consulta_empleado" class="form-control select2" style="width: 100%;">
                                    <option value="">Seleccione para ver historial...</option>
                                    <?php foreach($empleados as $e): ?>
                                        <option value="<?php echo $e['id']; ?>"><?php echo $e['nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-info btn-block" onclick="consultarEmpleado()"><i class="fa fa-search"></i> Ver</button>
                            </div>
                        </div>
                        <div id="resultado_consulta" style="margin-top: 20px; display:none;">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab">Historial</a></li>
                                    <li><a href="#tab_2" data-toggle="tab">Lo que posee</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <table class="table table-striped" id="tabla_historial">
                                            <thead>
                                                <tr>
                                                    <th>Fecha Reg.</th>
                                                    <th>Fecha Entrega</th>
                                                    <th>Tipo</th>
                                                    <th>Artículo</th>
                                                    <th>Cant.</th>
                                                    <th>Estado</th>
                                                    <th width="50px">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div class="text-right">
                                            <a href="#" id="btn_imprimir_comanda" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Imprimir Comanda de Entrega</a>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_2">
                                        <table class="table table-bordered" id="tabla_posesion">
                                            <thead>
                                                <tr>
                                                    <th>Artículo</th>
                                                    <th>Cant. Actual</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna de Configuración (ABMs) -->
            <div class="col-md-4">
                <!-- Gestión de Stock -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-tag"></i> Stock de Indumentaria</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modalArticulo"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Artículo</th>
                                <th>Stock</th>
                            </tr>
                            <?php foreach($articulos as $a): ?>
                            <tr>
                                <td><?php echo $a['nombre']; ?></td>
                                <td>
                                    <?php if($a['stock'] <= 5): ?>
                                        <span class="text-red" style="font-weight:bold;"><?php echo $a['stock']; ?></span>
                                    <?php else: ?>
                                        <?php echo $a['stock']; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>

                <!-- Gestión de Empleados -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-users"></i> Empleados</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modalEmpleado"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>DNI</th>
                                <th>Nombre</th>
                            </tr>
                            <?php foreach($empleados as $e): ?>
                            <tr>
                                <td><?php echo $e['dni']; ?></td>
                                <td><?php echo $e['nombre']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modales -->
<div class="modal fade" id="modalEmpleado" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Nuevo Empleado</h4>
            </div>
            <form action="<?php echo base_url('indumentaria/guardar_empleado'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>DNI</label>
                        <input type="text" name="dni" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalArticulo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Nuevo Artículo / Cargar Stock</h4>
            </div>
            <form action="<?php echo base_url('indumentaria/guardar_articulo'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre del Artículo</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Pantalón de Trabajo" required>
                    </div>

                    <div class="form-group">
                        <label>Stock Inicial / Actualizar</label>
                        <input type="number" name="stock" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function consultarEmpleado() {
        var id = $('#select_consulta_empleado').val();
        if (!id) return;

        $('#resultado_consulta').show();
        $('#btn_imprimir_comanda').attr('href', '<?php echo base_url("indumentaria/comanda/"); ?>' + id);

        // Mostrar mensaje de carga
        var loadingHtml = '<tr><td colspan="7" class="text-center"><i class="fa fa-spinner fa-spin"></i> Cargando datos...</td></tr>';
        $('#tabla_historial tbody').html(loadingHtml);
        $('#tabla_posesion tbody').html('<tr><td colspan="2" class="text-center"><i class="fa fa-spinner fa-spin"></i> Cargando datos...</td></tr>');

        // Cargar Historial
        $.getJSON('<?php echo base_url("indumentaria/get_movimientos_empleado_json/"); ?>' + id, function(data) {
            var html = '';
            if (data.length === 0) {
                html = '<tr><td colspan="7" class="text-center text-muted">No hay movimientos registrados para este empleado</td></tr>';
            } else {
                $.each(data, function(i, item) {
                    var label = 'label-info';
                    if (item.tipo == 'DEVOLUCION') label = 'label-success';
                    if (item.tipo == 'BAJA') label = 'label-danger';

                    html += '<tr>';
                    html += '<td>' + item.fecha + '</td>';
                    html += '<td><b>' + (item.fecha_entrega ? item.fecha_entrega : '-') + '</b></td>';
                    html += '<td><span class="label ' + label + '">' + item.tipo + '</span></td>';
                    html += '<td>' + item.articulo + '</td>';
                    html += '<td>' + item.cantidad + '</td>';
                    html += '<td>' + item.estado_prenda + '</td>';
                    html += '<td>';
                    html += '<a href="<?php echo base_url("indumentaria/deshacer_movimiento/"); ?>' + item.id + '" class="btn btn-xs btn-danger" onclick="return confirm(\'¿Está seguro de deshacer este movimiento? Se restablecerá el stock.\')">';
                    html += '<i class="fa fa-undo"></i></a>';
                    html += '</td>';
                    html += '</tr>';
                });
            }
            $('#tabla_historial tbody').html(html);
        }).fail(function() {
            $('#tabla_historial tbody').html('<tr><td colspan="7" class="text-center text-danger">Error al cargar los datos</td></tr>');
        });

        // Cargar Resumen (Lo que tiene)
        $.getJSON('<?php echo base_url("indumentaria/get_resumen_empleado_json/"); ?>' + id, function(data) {
            var html = '';
            if (data.length === 0) {
                html = '<tr><td colspan="2" class="text-center text-muted">Este empleado no posee indumentaria actualmente</td></tr>';
            } else {
                $.each(data, function(i, item) {
                    html += '<tr>';
                    html += '<td>' + item.nombre + '</td>';
                    html += '<td>' + item.cantidad_actual + '</td>';
                    html += '</tr>';
                });
            }
            $('#tabla_posesion tbody').html(html);
        }).fail(function() {
            $('#tabla_posesion tbody').html('<tr><td colspan="2" class="text-center text-danger">Error al cargar los datos</td></tr>');
        });
    }

    var itemsEntrega = [];

    function agregarArticuloALista() {
        var id = $('#sel_articulo').val();
        var nombre = $('#sel_articulo option:selected').data('nombre');
        var cantidad = $('#sel_cantidad').val();
        var estado = $('#sel_estado').val();

        if (!id || cantidad < 1) {
            alert('Seleccione un artículo y cantidad válida');
            return;
        }

        // Agregar al array
        var index = itemsEntrega.length;
        itemsEntrega.push({
            id_articulo: id,
            cantidad: cantidad,
            estado: estado
        });

        // Actualizar Tabla
        $('#fila_vacia').hide();
        var html = '<tr id="fila_item_' + index + '">';
        html += '<td>' + nombre + '</td>';
        html += '<td>' + cantidad + '</td>';
        html += '<td>' + estado + '</td>';
        html += '<td>';
        html += '<input type="hidden" name="prendas[' + index + '][id_articulo]" value="' + id + '">';
        html += '<input type="hidden" name="prendas[' + index + '][cantidad]" value="' + cantidad + '">';
        html += '<input type="hidden" name="prendas[' + index + '][estado]" value="' + estado + '">';
        html += '<button type="button" class="btn btn-xs btn-danger" onclick="quitarDeLista(' + index + ')"><i class="fa fa-times"></i></button>';
        html += '</td>';
        html += '</tr>';

        $('#lista_prendas_cuerpo').append(html);
        $('#btn_confirmar_entrega').prop('disabled', false);

        // Limpiar selectores
        $('#sel_articulo').val('').trigger('change');
        $('#sel_cantidad').val(1);
    }

    function quitarDeLista(index) {
        $('#fila_item_' + index).remove();
        // Nota: en producción real borraríamos del array, pero como enviamos por campos hidden en el form, con remover el HTML alcanza.
        if ($('#lista_prendas_cuerpo tr:not(#fila_vacia)').length == 0) {
            $('#fila_vacia').show();
            $('#btn_confirmar_entrega').prop('disabled', true);
        }
    }

    $(document).ready(function() {
        // Inicializar select2 con buscador habilitado
        if ($.fn.select2) {
            $('.select2').select2({
                placeholder: 'Escriba para buscar...',
                allowClear: true,
                language: {
                    noResults: function() { return "No se encontraron resultados"; }
                }
            });
        }
    });

    // Manejar el envío del formulario de entrega múltiple vía AJAX
    $('#formEntregaMultiple').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var id_empleado = $('#id_empleado_select').val();
        
        // Bloquear botón para evitar doble envío
        var btn = $('#btn_confirmar_entrega');
        var originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Procesando...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function() {
                // Abrir comanda en nueva pestaña
                var win = window.open('<?php echo base_url("indumentaria/comanda/"); ?>' + id_empleado + '?print=true', '_blank');
                if (win) {
                    win.focus();
                } else {
                    alert('Por favor habilite las ventanas emergentes para ver la comanda.');
                }
                // Recargar página actual para limpiar formulario y actualizar stock/historial
                location.reload();
            },
            error: function() {
                alert('Error crítico al procesar la entrega. Por favor verifique los datos.');
                btn.prop('disabled', false).html(originalText);
            }
        });
    });
</script>
