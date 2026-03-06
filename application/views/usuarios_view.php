<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Gestión de Usuarios
            <small>Administrar accesos y niveles</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Usuarios</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Listado de Usuarios</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url('registrarse'); ?>" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Nuevo Usuario
                            </a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-hover" id="tablausuarios">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email / Usuario</th>
                                    <th>Local / Empresa</th>
                                    <th>Nivel</th>
                                    <th>Permisos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $u): ?>
                                <tr>
                                    <td><strong><?php echo $u['Nombre_Completo']; ?></strong></td>
                                    <td><?php echo $u['usuario']; ?></td>
                                    <td><?php echo $u['empresa']; ?></td>
                                    <td>
                                        <?php if ($u['Nivel_acceso'] == 1): ?>
                                            <span class="label label-danger">ADMIN</span>
                                        <?php else: ?>
                                            <span class="label label-primary">LOCAL</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $p = json_decode($u['permisos'], true);
                                            if (is_array($p)) {
                                                echo count($p) . " módulos";
                                            } else {
                                                echo ($u['Nivel_acceso'] == 1) ? "<span class='text-muted'>Full Access</span>" : "<span class='text-warning'>Sin configurar</span>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('usuarios/editar/'.$u['idUsr']); ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-key"></i> Permisos
                                        </a>
                                        <button class="btn btn-danger btn-xs" onclick="deleteUser(<?php echo $u['idUsr']; ?>)">
                                            <i class="fa fa-trash"></i>
                                        </button>
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

<script>
    $(document).ready(function() {
        $('#tablausuarios').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        });

        <?php if($this->session->flashdata('success')): ?>
            Swal.fire('¡Éxito!', '<?php echo $this->session->flashdata('success'); ?>', 'success');
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            Swal.fire('Error', '<?php echo $this->session->flashdata('error'); ?>', 'error');
        <?php endif; ?>
    });

    function deleteUser(id) {
        Swal.fire({
            title: "¿Eliminar usuario?",
            text: "Esta acción es irreversible.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dd4b39",
            confirmButtonText: "Sí, eliminar"
        }).then((result) => {
            if (result.value) {
                window.location.href = '<?php echo base_url('usuarios/eliminar/'); ?>' + id;
            }
        });
    }
</script>
