<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Configurar Permisos
            <small><?php echo $u['Nombre_Completo']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('usuarios'); ?>"><i class="fa fa-users"></i> Usuarios</a></li>
            <li class="active">Editar Permisos</li>
        </ol>
    </section>

    <section class="content">
        <form action="<?php echo base_url('usuarios/guardar'); ?>" method="post">
            <input type="hidden" name="idUsr" value="<?php echo $u['idUsr']; ?>">
            
            <div class="row">
                <!-- Datos del Usuario -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Datos Principales</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo $u['Nombre_Completo']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Email / Usuario</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $u['usuario']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Empresa / Local</label>
                                <input type="text" name="empresa" class="form-control" value="<?php echo $u['empresa']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Nivel de Acceso Base</label>
                                <select name="nivel" class="form-control">
                                    <option value="0" <?php echo ($u['Nivel_acceso'] == 0) ? 'selected' : ''; ?>>Usuario (Local)</option>
                                    <option value="1" <?php echo ($u['Nivel_acceso'] == 1) ? 'selected' : ''; ?>>Administrador</option>
                                </select>
                            </div>
                            <hr>
                            <p class="text-muted" style="font-size:0.9em;"><i class="fa fa-lock"></i> <strong>Cambiar contraseña</strong> &mdash; dejá en blanco para no cambiarla.</p>
                            <div class="form-group">
                                <label>Nueva Contraseña</label>
                                <input type="password" name="nueva_password" id="nueva_password" class="form-control" placeholder="Nueva contraseña (opcional)" autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label>Confirmar Contraseña</label>
                                <input type="password" name="confirmar_password" id="confirmar_password" class="form-control" placeholder="Repetir contraseña">
                                <span id="msg_pass" style="font-size:0.85em;"></span>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" id="btn_guardar" class="btn btn-primary btn-block">Guardar Cambios</button>
                            <a href="<?php echo base_url('usuarios'); ?>" class="btn btn-default btn-block">Cancelar</a>
                        </div>
                    </div>
                </div>

                <!-- Selección de Módulos -->
                <div class="col-md-8">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Permisos Granulares por Módulo</h3>
                            <button type="button" class="btn btn-xs btn-default pull-right" onclick="toggleAll()">Alternar Todos</button>
                        </div>
                        <div class="box-body">
                            <p class="text-muted"><i class="fa fa-info-circle"></i> Marque los módulos a los que este usuario podrá acceder manualmente.</p>
                            
                            <div class="row">
                                <?php foreach ($modulos as $key => $label): ?>
                                <div class="col-sm-6">
                                    <div class="checkbox">
                                        <label style="font-size: 1.1em;">
                                            <input type="checkbox" name="modulos[]" value="<?php echo $key; ?>" <?php echo in_array($key, $permisos) ? 'checked' : ''; ?> class="modulo-check">
                                            <strong><?php echo $label; ?></strong>
                                        </label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<script>
    function toggleAll() {
        var checks = document.getElementsByClassName('modulo-check');
        var firstVal = checks[0].checked;
        for (var i = 0; i < checks.length; i++) {
            checks[i].checked = !firstVal;
        }
    }

    // Validación de contraseña en tiempo real
    document.getElementById('confirmar_password').addEventListener('input', validarPass);
    document.getElementById('nueva_password').addEventListener('input', validarPass);

    function validarPass() {
        var p1 = document.getElementById('nueva_password').value;
        var p2 = document.getElementById('confirmar_password').value;
        var msg = document.getElementById('msg_pass');
        var btn = document.getElementById('btn_guardar');

        if (p1 === '' && p2 === '') {
            msg.innerHTML = '';
            btn.disabled = false;
            return;
        }
        if (p1 !== p2) {
            msg.innerHTML = '<span style="color:#dd4b39;"><i class="fa fa-times"></i> Las contraseñas no coinciden</span>';
            btn.disabled = true;
        } else if (p1.length < 4) {
            msg.innerHTML = '<span style="color:#f39c12;"><i class="fa fa-exclamation-triangle"></i> Mínimo 4 caracteres</span>';
            btn.disabled = true;
        } else {
            msg.innerHTML = '<span style="color:#00a65a;"><i class="fa fa-check"></i> Las contraseñas coinciden</span>';
            btn.disabled = false;
        }
    }
</script>

