<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Administración de Empleados
            <small>Gestión de personal para indumentaria</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?php echo base_url('indumentaria'); ?>">Indumentaria</a></li>
            <li class="active">Empleados</li>
        </ol>
    </section>

    <section class="content">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> ¡Éxito!</h4>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Listado de Empleados -->
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-users"></i> Listado de Personal</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEmpleado">
                                <i class="fa fa-user-plus"></i> Nuevo Empleado
                            </button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <tr>
                                    <th>DNI</th>
                                    <th>Nombre Completo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($empleados as $e): ?>
                                <tr>
                                    <td><?php echo $e['dni']; ?></td>
                                    <td><?php echo $e['nombre']; ?></td>
                                    <td>
                                        <?php if($e['activo']): ?>
                                            <span class="label label-success">Activo</span>
                                        <?php else: ?>
                                            <span class="label label-danger">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-default" onclick="editarEmpleado(<?php echo $e['id']; ?>, '<?php echo $e['dni']; ?>', '<?php echo $e['nombre']; ?>')">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <?php if($e['activo']): ?>
                                        <button class="btn btn-xs btn-danger" onclick="abrirLiquidacion(<?php echo $e['id']; ?>, '<?php echo $e['nombre']; ?>')" title="Dar de baja">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Importación CSV de Empleados -->
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-file-excel-o"></i> Importar Empleados</h3>
                    </div>
                    <form action="<?php echo base_url('indumentaria/importar_empleados_csv'); ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="well well-sm">
                                <strong>Formato del Archivo:</strong><br>
                                CSV con 2 columnas:<br>
                                <code>DNI, Nombre Completo</code><br>
                                <small>Ej: 20123456, Juan Perez</small>
                            </div>
                            <div class="form-group">
                                <label for="archivo_csv">Seleccionar Archivo .csv</label>
                                <input type="file" name="archivo_csv" id="archivo_csv" accept=".csv" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-upload"></i> Carga Masiva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Liquidación / Baja -->
<div class="modal fade" id="modalLiquidacion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title">Liquidación de Indumentaria por Baja</h4>
            </div>
            <form action="<?php echo base_url('indumentaria/baja_empleado_procesar'); ?>" method="post">
                <input type="hidden" name="id_empleado" id="liq_id_empleado">
                <div class="modal-body">
                    <p>Está por dar de baja al empleado: <strong id="liq_nombre_empleado"></strong></p>
                    <p>Por favor, indique el destino de la ropa que tiene en su poder antes de confirmar:</p>
                    
                    <div id="contenedor_liquidacion">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Prenda / Talle</th>
                                    <th>Cant.</th>
                                    <th width="50%">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tabla_liquidacion_cuerpo">
                                <!-- Se carga vía AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Confirmar Baja y Procesar Devoluciones</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Empleado -->
<div class="modal fade" id="modalEmpleado" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Nuevo Empleado</h4>
            </div>
            <form action="<?php echo base_url('indumentaria/guardar_empleado'); ?>" method="post">
                <input type="hidden" name="id" id="emp_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>DNI</label>
                        <input type="text" name="dni" id="emp_dni" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre" id="emp_nombre" class="form-control" required>
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
    function editarEmpleado(id, dni, nombre) {
        $('#emp_id').val(id);
        $('#emp_dni').val(dni);
        $('#emp_nombre').val(nombre);
        $('#modal_title').text('Editar Empleado');
        $('#modalEmpleado').modal('show');
    }

    function abrirLiquidacion(id, nombre) {
        $('#liq_id_empleado').val(id);
        $('#liq_nombre_empleado').text(nombre);
        $('#tabla_liquidacion_cuerpo').html('<tr><td colspan="3" class="text-center"><i class="fa fa-refresh fa-spin"></i> Cargando indumentaria...</td></tr>');
        $('#modalLiquidacion').modal('show');

        // Buscar prendas del empleado
        $.getJSON('<?php echo base_url("indumentaria/get_resumen_empleado_json/"); ?>' + id, function(data) {
            var html = '';
            if (data.length == 0) {
                html = '<tr><td colspan="3" class="text-center text-muted">El empleado no tiene prendas pendientes de devolución.</td></tr>';
            } else {
                $.each(data, function(i, item) {
                    html += '<tr>';
                    html += '<td>' + item.nombre + ' (T: ' + item.talle + ')</td>';
                    html += '<td>' + item.cantidad_actual + '</td>';
                    html += '<td>';
                    html += '<input type="hidden" name="prendas[' + i + '][id_articulo]" value="' + item.id_articulo + '">';
                    html += '<input type="hidden" name="prendas[' + i + '][cantidad]" value="' + item.cantidad_actual + '">';
                    html += '<div class="radio-group">';
                    html += '<label style="margin-right:15px; cursor:pointer;"><input type="radio" name="prendas[' + i + '][accion]" value="DEVOLUCION" checked> Devolver al Stock (Buen estado)</label>';
                    html += '<label style="cursor:pointer; color:#dd4b39;"><input type="radio" name="prendas[' + i + '][accion]" value="BAJA"> Marcar como Rota / Mal estado</label>';
                    html += '</div>';
                    html += '</td>';
                    html += '</tr>';
                });
            }
            $('#tabla_liquidacion_cuerpo').html(html);
        });
    }

    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('.datatable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                }
            });
        }
    });
</script>
