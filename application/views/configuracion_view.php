<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Configuración
      <small>Rutas de archivos para generación de comandas por sector</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('inicio'); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Configuración</li>
    </ol>
  </section>

  <section class="content">
    <?php echo $respuesta; ?>

    <div class="row">
      <div class="col-md-10 col-md-offset-1">

        <!-- Información de ayuda -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-info-circle"></i> Información</h3>
          </div>
          <div class="box-body">
            <p>Acá podés configurar la <strong>ruta completa del archivo</strong> donde se graba la comanda de cada sector cuando se envía una reposición.</p>
            <p>La ruta debe ser una ruta de Windows con doble barra invertida o barra normal, por ejemplo:</p>
            <ul>
              <li><code>C:\imprimir\cocina\comanda.txt</code></li>
              <li><code>C:/imprimir/barra/comanda.txt</code></li>
            </ul>
            <p class="text-muted"><i class="fa fa-exclamation-triangle"></i> Si la ruta termina en carpeta (sin nombre de archivo), el sistema agregará un nombre automático con fecha y hora.</p>
          </div>
        </div>

        <!-- Formulario de sectores -->
        <form action="<?php echo base_url('configuracion/actualizar'); ?>" method="post">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-folder-open"></i> Rutas de archivos por sector</h3>
            </div>
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width: 60px;">#</th>
                    <th style="width: 200px;">Sector</th>
                    <th>Ruta del archivo de comanda</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($sectores)): ?>
                    <?php foreach ($sectores as $sector): ?>
                    <tr>
                      <td class="text-center"><strong><?php echo $sector['idSector']; ?></strong></td>
                      <td>
                        <i class="fa fa-print text-muted"></i>
                        <?php echo htmlspecialchars($sector['descripcion']); ?>
                      </td>
                      <td>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-folder"></i></span>
                          <input type="text"
                                 class="form-control"
                                 id="ruta_<?php echo $sector['idSector']; ?>"
                                 name="ruta_<?php echo $sector['idSector']; ?>"
                                 value="<?php echo htmlspecialchars($sector['impresora']); ?>"
                                 placeholder="Ej: C:\imprimir\<?php echo strtolower($sector['descripcion']); ?>\comanda.txt">
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="3" class="text-center text-muted">
                        <i class="fa fa-exclamation-circle"></i> No hay sectores configurados en la base de datos.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa fa-save"></i> Guardar configuración
              </button>
              <a href="<?php echo base_url('inicio'); ?>" class="btn btn-default btn-lg pull-right">
                <i class="fa fa-arrow-left"></i> Volver al inicio
              </a>
            </div>
          </div>
        </form>

      </div>
    </div>
  </section>
</div>
