<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Depósito de Indumentaria
            <small>Administración de stock e ingresos masivos</small>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalNuevoArticulo" style="margin-left: 10px;">
                <i class="fa fa-plus"></i> Nuevo Artículo
            </button>
            <a href="<?php echo base_url('indumentaria/reporte_stock'); ?>" target="_blank" class="btn btn-default btn-sm" style="margin-left: 10px;">
                <i class="fa fa-print"></i> Imprimir Reporte de Stock
            </a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?php echo base_url('indumentaria'); ?>">Indumentaria</a></li>
            <li class="active">Depósito</li>
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

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error</h4>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Gestión de Stock -->
            <div class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-archive"></i> Existencias en Depósito</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <tr>
                                    <th>Artículo</th>
                                    <th>Stock Actual</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($articulos as $a): ?>
                                <tr>
                                    <td><?php echo $a['nombre']; ?></td>
                                    <td style="font-weight: bold; font-size: 1.1em;">
                                        <?php if($a['stock'] <= 5): ?>
                                            <span class="text-red"><?php echo $a['stock']; ?></span>
                                        <?php else: ?>
                                            <?php echo $a['stock']; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-success" onclick="openIngresoModal(<?php echo $a['id']; ?>, '<?php echo $a['nombre']; ?>')">
                                            <i class="fa fa-plus"></i> Ingreso
                                        </button>
                                        <a href="<?php echo base_url('indumentaria/eliminar_articulo/' . $a['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('¿Está seguro de eliminar esta prenda del depósito? Se borrará permanentemente.')">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Importación CSV -->
            <div class="col-md-5">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-file-excel-o"></i> Importar desde CSV</h3>
                    </div>
                    <form action="<?php echo base_url('indumentaria/importar_csv'); ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="well well-sm">
                                <strong>Formato del Archivo:</strong><br>
                                El CSV debe tener 2 columnas sin cabecera (o ignorará la primera fila):<br>
                                <code>Nombre, Cantidad</code><br>
                                <small>Ej: Pantalón, 50</small>
                            </div>
                            <div class="form-group">
                                <label for="archivo_csv">Seleccionar Archivo .csv</label>
                                <input type="file" name="archivo_csv" id="archivo_csv" accept=".csv" required>
                                <p class="help-block">Suba el archivo de stock recibido para actualizar existencias de forma rápida.</p>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-upload"></i> Procesar Importación</button>
                        </div>
                    </form>
                </div>

                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-info"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Ayuda</span>
                        <span class="info-box-number">Ingreso Manual</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description">
                            También puede registrar ingresos prenda por prenda usando el botón verde de la tabla.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if($this->session->userdata('perfil') === 'admin'): ?>
<section class="content" style="min-height: auto; padding-top: 0;">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-warning"></i> Zona de Peligro: Reinicio del Sistema</h3>
                </div>
                <div class="box-body">
                    <p>Esta acción eliminará <strong>TODOS</strong> los datos del módulo de indumentaria: empleados, catálogo de artículos, stock y todo el historial de movimientos.</p>
                    <p class="text-red"><strong>¡Atención! Ésta acción es irreversible y se recomienda solo después de finalizar las pruebas.</strong></p>
                    <a href="<?php echo base_url('indumentaria/reset_total'); ?>" 
                       class="btn btn-danger" 
                       onclick="return confirm('¿ESTÁ ABSOLUTAMENTE SEGURO? Se borrarán todos los empleados, artículos y movimientos. Esta acción no se puede deshacer.');">
                       <i class="fa fa-trash"></i> Poner Sistema en Cero (RESET TOTAL)
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Modal Nuevo Artículo -->
<div class="modal fade" id="modalNuevoArticulo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title">Registrar Nuevo Artículo en Catálogo</h4>
            </div>
            <form action="<?php echo base_url('indumentaria/guardar_articulo'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre del Artículo</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Pantalón de Trabajo" required>
                    </div>

                    <div class="form-group">
                        <label>Stock Inicial</label>
                        <input type="number" name="stock" class="form-control" value="0" required>
                        <p class="help-block">Cantidad inicial disponible en depósito.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Artículo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ingreso Manual -->
<div class="modal fade" id="modalIngresoManual" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <h4 class="modal-title">Registrar Ingreso de Stock</h4>
            </div>
            <form action="<?php echo base_url('indumentaria/registrar_movimiento'); ?>" method="post">
                <input type="hidden" name="id_articulo" id="m_id_articulo">
                <input type="hidden" name="id_empleado" value="0"> <!-- 0 para ingresos de depósito -->
                <input type="hidden" name="tipo" value="INGRESO">
                
                <div class="modal-body">
                    <div class="form-group">
                        <label>Artículo seleccionado:</label>
                        <p id="m_nombre_articulo" class="form-control-static" style="font-weight:bold;"></p>
                    </div>
                    <div class="form-group">
                        <label>Cantidad recibida:</label>
                        <input type="number" name="cantidad" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="form-group">
                        <label>Estado al recibir:</label>
                        <select name="estado_prenda" class="form-control">
                            <option value="NUEVO">NUEVO (Directo de proveedor)</option>
                            <option value="USADO">USADO (Reacondicionado)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Observaciones (Ej: Nro de Remito):</label>
                        <textarea name="observaciones" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Ingreso</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openIngresoModal(id, nombre) {
        $('#m_id_articulo').val(id);
        $('#m_nombre_articulo').text(nombre);
        $('#modalIngresoManual').modal('show');
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
