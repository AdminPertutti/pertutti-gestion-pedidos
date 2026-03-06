<style>
    /* Dark Mode Overrides */
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
    body.dark-mode input.form-control {
        background-color: #1a1a2e !important;
        border-color: #30344c !important;
        color: #fff !important;
    }
    body.dark-mode label {
        color: #c7c7c7 !important;
    }
    body.dark-mode .checkbox label {
        color: #c7c7c7 !important;
    }
    .dia-config {
        padding: 15px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #f9f9f9;
    }
    body.dark-mode .dia-config {
        background: #1a1a2e !important;
        border-color: #30344c !important;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-calendar"></i> Configurar Días de Pedido
            <small><?php echo $proveedor['nombre']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?php echo base_url('proveedores'); ?>">Proveedores</a></li>
            <li class="active">Configurar Días</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-calendar-check-o"></i> Seleccione los días y horarios de pedido</h3>
                    </div>
                    <form action="<?php echo base_url('proveedores/guardar_dias'); ?>" method="post">
                        <input type="hidden" name="id_proveedor" value="<?php echo $proveedor['id']; ?>">
                        <div class="box-body">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> Seleccione los días en que se puede hacer pedido a este proveedor y la hora límite para cada día.
                            </div>

                            <?php
                            $dias_semana = array(
                                1 => 'Lunes',
                                2 => 'Martes',
                                3 => 'Miércoles',
                                4 => 'Jueves',
                                5 => 'Viernes',
                                6 => 'Sábado',
                                0 => 'Domingo'
                            );
                            
                            // Crear array de días configurados
                            $dias_configurados = array();
                            foreach ($proveedor['dias_pedido'] as $dia) {
                                $dias_configurados[$dia['dia_semana']] = $dia['hora_limite'];
                            }
                            ?>

                            <?php foreach ($dias_semana as $num => $nombre): ?>
                                <div class="dia-config">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" 
                                                           name="dias[]" 
                                                           value="<?php echo $num; ?>" 
                                                           id="dia_<?php echo $num; ?>"
                                                           <?php echo isset($dias_configurados[$num]) ? 'checked' : ''; ?>
                                                           onchange="toggleHora(<?php echo $num; ?>)">
                                                    <strong><?php echo $nombre; ?></strong>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label>Hora límite:</label>
                                                <input type="time" 
                                                       name="hora_<?php echo $num; ?>" 
                                                       id="hora_<?php echo $num; ?>" 
                                                       class="form-control"
                                                       value="<?php echo isset($dias_configurados[$num]) ? substr($dias_configurados[$num], 0, 5) : '12:00'; ?>"
                                                       <?php echo !isset($dias_configurados[$num]) ? 'disabled' : ''; ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="box-footer">
                            <a href="<?php echo base_url('proveedores'); ?>" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-warning pull-right">
                                <i class="fa fa-save"></i> Guardar Configuración
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function toggleHora(dia) {
    var checkbox = $('#dia_' + dia);
    var horaInput = $('#hora_' + dia);
    
    if (checkbox.is(':checked')) {
        horaInput.prop('disabled', false);
    } else {
        horaInput.prop('disabled', true);
    }
}
</script>
