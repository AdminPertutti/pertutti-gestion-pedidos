<style>
    /* Dark Mode Overrides for Backup View */
    body.dark-mode .box {
        background-color: #16213e !important;
        border-color: #30344c !important;
    }
    body.dark-mode .box-header {
        background-color: #0f3460 !important;
        border-bottom-color: #30344c !important;
    }
    body.dark-mode .box-title {
        color: #fff !important;
    }
    body.dark-mode .table {
        color: #c7c7c7 !important;
    }
    body.dark-mode .table thead tr {
        background-color: #0f3460 !important;
    }
    body.dark-mode .table thead th {
        color: #fff !important;
        border-color: #30344c !important;
    }
    body.dark-mode .table tbody td {
        border-color: #30344c !important;
    }
    body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #1f2a48 !important;
    }
    body.dark-mode .table-hover > tbody > tr:hover {
        background-color: #25335a !important;
    }
    body.dark-mode .modal-content {
        background-color: #16213e !important;
        border-color: #30344c !important;
    }
    body.dark-mode .modal-header {
        background-color: #0f3460 !important;
        border-bottom-color: #30344c !important;
    }
    body.dark-mode .modal-title {
        color: #fff !important;
    }
    body.dark-mode .modal-body {
        color: #c7c7c7 !important;
    }
    body.dark-mode .modal-footer {
        background-color: #16213e !important;
        border-top-color: #30344c !important;
    }
    body.dark-mode .alert-warning {
        background-color: #8B4513 !important;
        border-color: #A0522D !important;
        color: #fff !important;
    }
    body.dark-mode .alert-info {
        background-color: #0f3460 !important;
        border-color: #1e5a8e !important;
        color: #fff !important;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-database"></i> Backup de Base de Datos
            <small>Gestión de copias de seguridad</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Backup</li>
        </ol>
    </section>

    <section class="content">
        <!-- Mensajes de éxito/error -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-ban"></i> <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Información importante -->
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h4><i class="icon fa fa-info"></i> Información Importante</h4>
                    <ul>
                        <li><strong>Backup:</strong> Crea una copia completa de la base de datos (estructura y datos).</li>
                        <li><strong>Restaurar:</strong> Reemplaza completamente la base de datos actual con el backup seleccionado.</li>
                        <li><strong>Seguridad:</strong> Solo usuarios supervisores tienen acceso a esta funcionalidad.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Crear Nuevo Backup -->
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-plus-circle"></i> Crear Nuevo Backup</h3>
                    </div>
                    <div class="box-body">
                        <p>Crear una copia de seguridad completa de la base de datos actual.</p>
                        <p><strong>Base de datos:</strong> <?php echo $this->db->database; ?></p>
                        <p><strong>Fecha actual:</strong> <?php echo date('d/m/Y H:i:s'); ?></p>
                    </div>
                    <div class="box-footer">
                        <a href="<?php echo base_url('backup/crear_backup'); ?>" class="btn btn-primary btn-block" onclick="return confirm('¿Está seguro de crear un nuevo backup?');">
                            <i class="fa fa-save"></i> Crear Backup Ahora
                        </a>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-bar-chart"></i> Estadísticas</h3>
                    </div>
                    <div class="box-body">
                        <p><strong>Total de backups:</strong> <?php echo count($backups); ?></p>
                        <?php if (!empty($backups)): ?>
                            <?php 
                                $total_size = array_sum(array_column($backups, 'size'));
                                $size_mb = round($total_size / 1024 / 1024, 2);
                            ?>
                            <p><strong>Espacio total:</strong> <?php echo $size_mb; ?> MB</p>
                            <p><strong>Último backup:</strong><br><?php echo date('d/m/Y H:i', $backups[0]['timestamp']); ?></p>
                        <?php else: ?>
                            <p class="text-muted">No hay backups disponibles</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Lista de Backups -->
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-list"></i> Backups Disponibles</h3>
                    </div>
                    <div class="box-body">
                        <?php if (empty($backups)): ?>
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i> No hay backups disponibles. Cree uno nuevo para comenzar.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre del Archivo</th>
                                            <th>Fecha de Creación</th>
                                            <th>Tamaño</th>
                                            <th width="200px">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($backups as $backup): ?>
                                            <tr>
                                                <td>
                                                    <i class="fa fa-file-archive-o text-blue"></i> 
                                                    <?php echo $backup['filename']; ?>
                                                </td>
                                                <td><?php echo date('d/m/Y H:i:s', $backup['timestamp']); ?></td>
                                                <td><?php echo round($backup['size'] / 1024 / 1024, 2); ?> MB</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?php echo base_url('backup/descargar_backup/' . urlencode($backup['filename'])); ?>" 
                                                           class="btn btn-sm btn-info" 
                                                           title="Descargar">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-warning" 
                                                                onclick="confirmarRestaurar('<?php echo $backup['filename']; ?>')"
                                                                title="Restaurar">
                                                            <i class="fa fa-refresh"></i>
                                                        </button>
                                                        <a href="<?php echo base_url('backup/eliminar_backup/' . urlencode($backup['filename'])); ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('¿Está seguro de eliminar este backup?\n\nArchivo: <?php echo $backup['filename']; ?>');"
                                                           title="Eliminar">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal de Confirmación de Restauración -->
<div class="modal fade" id="modalRestaurar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirmar Restauración</h4>
            </div>
            <form action="<?php echo base_url('backup/restaurar_backup'); ?>" method="post" id="formRestaurar">
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h4><i class="fa fa-warning"></i> ¡ATENCIÓN!</h4>
                        <p>Esta acción reemplazará <strong>COMPLETAMENTE</strong> la base de datos actual con el backup seleccionado.</p>
                        <p><strong>Todos los cambios realizados después de la fecha del backup se perderán.</strong></p>
                    </div>
                    <p><strong>Archivo a restaurar:</strong></p>
                    <p id="nombreArchivoRestaurar" class="text-primary" style="font-size: 16px;"></p>
                    <input type="hidden" name="filename" id="filenameRestaurar">
                    
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="confirmarRestauracion" required>
                            Entiendo que esta acción no se puede deshacer y acepto continuar.
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning" id="btnConfirmarRestaurar" disabled>
                        <i class="fa fa-refresh"></i> Restaurar Base de Datos
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmarRestaurar(filename) {
    $('#nombreArchivoRestaurar').text(filename);
    $('#filenameRestaurar').val(filename);
    $('#confirmarRestauracion').prop('checked', false);
    $('#btnConfirmarRestaurar').prop('disabled', true);
    $('#modalRestaurar').modal('show');
}

// Habilitar botón de restaurar solo si se marca el checkbox
$('#confirmarRestauracion').on('change', function() {
    $('#btnConfirmarRestaurar').prop('disabled', !this.checked);
});

// Mostrar indicador de carga al restaurar
$('#formRestaurar').on('submit', function() {
    var btn = $('#btnConfirmarRestaurar');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Restaurando...');
});
</script>
