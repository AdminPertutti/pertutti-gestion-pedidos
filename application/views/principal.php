<?php
// $ci = &get_instance();
// $ci->load->model("pedidos_model");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Panel de control
        <small>Página principal de Pedidos Lomas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inicio</a></li>
        <li class="active">Principal</li>
      </ol>
    </section>
        <section class="content">
          <?php if (date('N') != 7 && (!isset($ha_pedido_hoy) || !$ha_pedido_hoy)): // Except Sundays and if not already ordered today ?>
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-leaf"></i> Recordatorio: Pedido de Verduras</h4>
                No olvides realizar el pedido de verduras para el día de mañana. 
                <a href="<?php echo base_url('verdura'); ?>" class="btn btn-xs btn-default" style="margin-left: 10px; color: #333 text-decoration: none;">Hacer Pedido Ahora</a>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <?php if (!empty($alertas_certificados)): ?>
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Alertas de Certificados</h4>
                Hay documentación vencida o próxima a vencer:
                <ul style="margin-top: 5px;">
                    <?php foreach ($alertas_certificados as $ac): ?>
                        <li>
                            <strong><?php echo $ac['tipo']; ?></strong>: 
                            <?php if ($ac['estado'] == 'VENCIDO'): ?>
                                <span style="color: #ffcccc; font-weight: bold;">VENCIÓ hace <?php echo abs($ac['dias_restantes']); ?> días</span>
                            <?php else: ?>
                                Vence en <?php echo $ac['dias_restantes']; ?> días
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?php echo base_url('certificados'); ?>" class="btn btn-outline btn-sm" style="margin-top: 5px; text-decoration: none;">Gestionar Certificados</a>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <?php if (!empty($proveedores_recordatorios)): ?>
          <div class="row">
            <?php foreach ($proveedores_recordatorios as $prov): ?>
            <div class="col-md-12">
              <div class="alert <?php echo $prov['atrasado'] ? 'alert-danger' : 'alert-warning'; ?> alert-dismissible" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4>
                  <i class="icon fa <?php echo $prov['atrasado'] ? 'fa-warning' : 'fa-truck'; ?>"></i> 
                  Recordatorio: <strong>Pedido a <?php echo $prov['nombre']; ?></strong>
                  <?php if ($prov['atrasado']): ?>
                    <span class="label label-default" style="margin-left: 10px; background: rgba(0,0,0,0.2);">¡ATRASADO!</span>
                  <?php endif; ?>
                </h4>
                <p style="font-size: 1.1em;">
                  Es momento de realizar el pedido a <strong><?php echo $prov['nombre']; ?></strong>. 
                  La hora límite de hoy era/es a las <strong><?php echo substr($prov['hora_limite'], 0, 5); ?> hs.</strong>
                </p>
                <div style="margin-top: 10px;">
                  <a href="<?php echo base_url('proveedores/hacer_pedido/' . $prov['id']); ?>" class="btn <?php echo $prov['atrasado'] ? 'btn-default' : 'btn-warning'; ?> btn-sm" style="font-weight: bold;">
                    <i class="fa fa-shopping-cart"></i> HACER EL PEDIDO AHORA
                  </a>
                  <?php if ($prov['whatsapp']): ?>
                  <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $prov['whatsapp']); ?>" target="_blank" class="btn btn-sm" style="background: #25D366; color: white; margin-left: 5px;">
                    <i class="fa fa-whatsapp"></i> Consultar WhatsApp
                  </a>
                  <?php endif; ?>
                  
                  <a href="<?php echo base_url('proveedores/omitir_recordatorio/' . $prov['id']); ?>" class="btn btn-default btn-sm pull-right" onclick="return confirm('¿Seguro que quiere omitir este recordatorio? Se marcará como que hoy NO se necesita pedir.');" title="Omitir por hoy">
                    <i class="fa fa-times"></i> Omitir
                  </a>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <!-- CUADROS DE ESTADO DE CERTIFICADOS -->
          <?php if (!empty($resumen_certificados)): ?>
          <div class="row">
            <div class="col-md-12">
              <h4 style="margin-bottom: 15px; font-weight: bold;"><i class="fa fa-file-text-o"></i> Estado de Certificados / Documentación</h4>
            </div>
          </div>
          <div class="row">
            <?php foreach ($resumen_certificados as $rc): 
                $icon = 'fa-file-text-o';
                if ($rc['color'] == 'green') $icon = 'fa-check-circle';
                if ($rc['color'] == 'red') $icon = 'fa-warning';
                if ($rc['color'] == 'yellow') $icon = 'fa-clock-o';
            ?>
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
              <div class="small-box bg-<?php echo $rc['color']; ?>" style="border-radius: 8px; overflow: hidden;">
                <div class="inner" style="padding: 10px;">
                  <h4 style="font-weight: bold; margin: 0; font-size: 1.1em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo $rc['nombre']; ?>">
                    <?php echo $rc['nombre']; ?>
                  </h4>
                  <p style="margin: 5px 0 0 0; font-size: 0.9em;">
                    Vence: <strong><?php echo $rc['fecha']; ?></strong><br>
                    <small style="text-transform: uppercase;"><?php echo $rc['texto']; ?></small>
                  </p>
                </div>
                <div class="icon" style="top: 5px; right: 5px; font-size: 45px; opacity: 0.2;">
                  <i class="fa <?php echo $icon; ?>"></i>
                </div>
                <a href="<?php echo base_url('certificados/gestion/' . $rc['id']); ?>" class="small-box-footer" style="padding: 3px 0;">
                  Gestionar <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3><?php
                    $lote=date("z")+1;
                    echo $lote;
                    ?></h3>
                    <p>Lote de hoy</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-calendar"></i>
                  </div>
                  <a class="small-box-footer">
                  <b> Fecha: <?php echo date('d-m-Y');?> </b>
                  </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $proximaentrega ?></h3>
                  <p>Pedir Reposición</p>
                </div>
                <div class="icon">
                  <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                </div>
                <a href="<?php echo base_url()."reposicion";?>" class="small-box-footer">Pedir Reposición <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $lockers_resumen['sin asignar']; ?></h3>
                  <p>Lockers Libres</p>
                </div>
                <div class="icon">
                  <i class="fa fa-th"></i>
                </div>
                <a href="<?php echo base_url('lockers'); ?>" class="small-box-footer">Gestionar Lockers <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $lockers_resumen['roto']; ?></h3>
                  <p>Lockers Rotos</p>
                </div>
                <div class="icon">
                  <i class="fa fa-wrench"></i>
                </div>
                <a href="<?php echo base_url('lockers'); ?>" class="small-box-footer">Ver Lockers <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>

<div class="row">
    <div class="col-md-12">
            <!-- Box Comment -->
            <div class="box box-success">
              <div class="box-header with-border">
                <div class="user-block">
                  <img class="img-circle"> <i class"fa-check-circle"></i>
                  <span class="username"><a href="#">Hernan Quatraro.</a></span>
                  <span class="description">Nuevas funciones - 05-02-2026</span>
                </div>
                <!-- /.user-block -->
                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- post text -->
                <!-- post text -->
                <p><strong>Actualización Febrero 2026:</strong></p>
                <ul>
                    <li><i class="fa fa-truck"></i> <strong>Gestión de Proveedores:</strong> Ahora puedes cargar pedidos a cualquier proveedor.</li>
                    <li><i class="fa fa-shopping-cart"></i> <strong>Pedido Rápido:</strong> Nueva interfaz estilo App para cargar pedidos más rápido.</li>
                    <li><i class="fa fa-whatsapp"></i> <strong>Envío Directo:</strong> Envía los pedidos por WhatsApp o Email automáticamente.</li>
                    <li><i class="fa fa-bell"></i> <strong>Recordatorios:</strong> Avisos en pantalla si olvidas hacer un pedido.</li>
                </ul>

                <p>- Se actualizan problemas y estetica.</p>
              </div>
              <!-- /.box-body -->
              <div class="box-footer box-comments">
                <div class="box-comment">
                  <!-- User image -->
                  <div class="comment-text">

                  </div>
                  <!-- /.comment-text -->
                </div>
                <!-- /.box-comment -->

                <!-- /.box-comment -->
              </div>
              <!-- /.box-footer -->

              <!-- /.box-footer -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->





<div class="col-md-12">
    <!-- Quick Action Buttons -->
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bolt"></i> Accesos Rápidos</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                    <a href="<?php echo base_url('verdura'); ?>" class="btn btn-app btn-block" style="height: auto; padding: 20px; font-size: 16px; background-color: #00a65a; color: white;">
                        <i class="fa fa-leaf" style="font-size: 30px; display: block; margin-bottom: 5px;"></i>
                        Pedir Verdura
                    </a>
                </div>
                
                <?php if(isset($proveedores_activos)): ?>
                    <?php foreach($proveedores_activos as $prov): ?>
                        <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                            <a href="<?php echo base_url('proveedores/hacer_pedido/'.$prov['id']); ?>" class="btn btn-app btn-block" style="height: auto; padding: 20px; font-size: 16px; background-color: #f39c12; color: white;">
                                <i class="fa fa-truck" style="font-size: 30px; display: block; margin-bottom: 5px;"></i>
                                Pedir a <?php echo $prov['nombre']; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Unified Orders Table -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Últimos Pedidos (General)</h3>
        </div>
        <div class="box-body">
            <section class="content">
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th style="width: 100px">Tipo</th>
                                <th>Origen/Proveedor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($ultimos_pedidos) && !empty($ultimos_pedidos)): ?>
                                <?php foreach ($ultimos_pedidos as $pedido): 
                                    $fecha_p = date_create($pedido['fecha']);
                                    $label_class = ($pedido['tipo'] == 'Verdura') ? 'label-success' : 'label-warning';
                                ?>
                                <tr>
                                    <td><?php echo $fecha_p->format('d/m/Y H:i'); ?></td>
                                    <td><span class="label <?php echo $label_class; ?>"><?php echo $pedido['tipo']; ?></span></td>
                                    <td><?php echo $pedido['origen']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-default btn-xs" onclick="verDetalle(`<?php echo htmlspecialchars($pedido['detalle_text']); ?>`)">
                                            <i class="fa fa-eye"></i> Ver Detalle
                                        </button>
                                        <?php if($pedido['tipo'] == 'Verdura'): ?>
                                            <a href="<?php echo $pedido['link_reenviar']; ?>" class="btn btn-info btn-xs" title="Reenviar">
                                                <i class="fa fa-envelope"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if($this->session->userdata('s_nivel') == 1): ?>
                                            <?php 
                                            $link_borrar = ($pedido['tipo'] == 'Verdura') 
                                                ? base_url('verdura/eliminar/'.$pedido['id']) 
                                                : base_url('proveedores/eliminar_pedido/'.$pedido['id']);
                                            ?>
                                            <a href="<?php echo $link_borrar; ?>" class="btn btn-danger btn-xs" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este pedido? Esta acción no se puede deshacer.');">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay pedidos recientes.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>

</div>


<!-- Modal para Detalle de Pedido -->
<div class="modal fade" id="modalDetallePedido" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-list"></i> Detalle del Pedido</h4>
            </div>
            <div class="modal-body">
                <textarea id="detalleTexto" class="form-control" rows="10" readonly style="font-family: monospace; resize: none; background: #f9f9f9;"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="copiarDetalle()"><i class="fa fa-copy"></i> Copiar al Portapapeles</button>
            </div>
        </div>
    </div>
</div>

<script>
function verDetalle(texto) {
    $('#detalleTexto').val(texto);
    $('#modalDetallePedido').modal('show');
}

function copiarDetalle() {
    const copyText = document.getElementById("detalleTexto");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    
    // Feedback visual
    const btn = event.currentTarget;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-check"></i> ¡Copiado!';
    btn.className = 'btn btn-success';
    
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.className = 'btn btn-info';
    }, 2000);
}
</script>
