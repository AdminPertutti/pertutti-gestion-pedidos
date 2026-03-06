<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Gestión de Lockers
            <small>Administración y asignación</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Lockers</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Listado de Lockers</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCrear">
                                <i class="fa fa-plus"></i> Crear Lockers
                            </button>
                            <a href="<?php echo base_url('lockers/listado'); ?>" class="btn btn-warning btn-sm" target="_blank">
                                <i class="fa fa-list"></i> Listado Asig.
                            </a>
                            <a href="<?php echo base_url('lockers/etiquetas'); ?>" class="btn btn-info btn-sm" target="_blank">
                                <i class="fa fa-print"></i> Imprimir Etiquetas
                            </a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-hover" id="tablalockers">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Estado</th>
                                    <th>Asignado a</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lockers as $l): 
                                    $label_class = 'label-default';
                                    if ($l['estado'] == 'asignado') $label_class = 'label-success';
                                    if ($l['estado'] == 'roto') $label_class = 'label-danger';
                                ?>
                                <tr>
                                    <td><span class="badge bg-blue" style="font-size: 1.2em;"><?php echo $l['numero']; ?></span></td>
                                    <td><span class="label <?php echo $label_class; ?>" style="font-size: 0.9em; text-transform: uppercase;"><?php echo $l['estado']; ?></span></td>
                                    <td><strong><?php echo $l['asignado_a'] ? $l['asignado_a'] : '-'; ?></strong></td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" onclick='editLocker(<?php echo json_encode($l); ?>)' title="Editar/Asignar">
                                            <i class="fa fa-edit"></i> Editar
                                        </button>
                                        <button class="btn btn-danger btn-xs" onclick="deleteLocker(<?php echo $l['id']; ?>)" title="Eliminar">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <a href="<?php echo base_url('lockers/ver/'.$l['token']); ?>" target="_blank" class="btn btn-default btn-xs" title="Ver Link Público">
                                            <i class="fa fa-external-link"></i> Link
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Crear -->
<div id="modalCrear" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="<?php echo base_url('lockers/crear'); ?>" method="post">
                <div class="modal-header" style="background:#00a65a; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Crear Nuevos Lockers</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cantidad a crear</label>
                        <input type="number" name="cantidad" class="form-control" value="1" min="1" max="50" required>
                        <p class="help-block">Se numerarán automáticamente a partir del último.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div id="modalEditar" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo base_url('lockers/guardar'); ?>" method="post">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Locker <span id="label_numero"></span></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" id="edit_estado" class="form-control" onchange="toggleAsignado()">
                            <option value="sin asignar">Sin asignar</option>
                            <option value="asignado">Asignado</option>
                            <option value="roto">Roto</option>
                        </select>
                    </div>
                    <div class="form-group" id="group_asignado" style="display:none;">
                        <label>Asignado a (Nombre)</label>
                        <input type="text" name="asignado_a" id="edit_asignado" class="form-control" placeholder="Nombre de la persona">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tablalockers').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "order": [[ 0, "asc" ]],
            "pageLength": 25
        });

        <?php if($this->session->flashdata('success')): ?>
            Swal.fire('¡Éxito!', '<?php echo $this->session->flashdata('success'); ?>', 'success');
        <?php endif; ?>
    });

    function toggleAsignado() {
        if ($('#edit_estado').val() == 'asignado') {
            $('#group_asignado').show();
        } else {
            $('#group_asignado').hide();
        }
    }

    function editLocker(l) {
        $('#edit_id').val(l.id);
        $('#label_numero').text(l.numero);
        $('#edit_estado').val(l.estado);
        $('#edit_asignado').val(l.asignado_a);
        toggleAsignado();
        $('#modalEditar').modal('show');
    }

    function deleteLocker(id) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dd4b39",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                window.location.href = '<?php echo base_url('lockers/eliminar/'); ?>' + id;
            }
        });
    }
</script>
