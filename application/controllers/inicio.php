<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {


	public function index()
	{
		$this->load->model('consulta');
		$this->load->model('pedidos_model');
		$this->load->library('session');

		if ($this->session->logged_in == TRUE) {
			$fechaoriginal = $this->consulta->proximaentrega();
					$proximaentrega = date("d/m", strtotime($fechaoriginal));
					$datos = array(
												'users' => '0',
												'total' => '1234',
												'proximaentrega' => $proximaentrega,
												'total_kilos' => $this->consulta->totalkilos(),
												'graficar' => $this->consulta->graficarkilos(),
												'kilos' => $this->consulta->kilosporlocal($this->session->s_idusuario),
												);

					// 1. Pedidos de Verdura
					$this->load->model('Verdura_model');
					$pedidos_verdura = $this->Verdura_model->get_all_orders(10);
					$lista_unificada = array();

					foreach ($pedidos_verdura as $pv) {
						$detalle = json_decode($pv['detalle'], true);
						$text = "Pedido de Verdura - " . $pv['local'] . "\n";
						$text .= "Fecha: " . date('d/m/Y H:i', strtotime($pv['fecha'])) . "\n";
						$text .= "----------------------------\n";
						if (is_array($detalle)) {
							foreach ($detalle as $item) {
								$text .= "- " . $item['nombre'] . ": " . $item['cantidad'] . " " . $item['unidad'] . "\n";
							}
						}
						
						$lista_unificada[] = array(
							'id' => $pv['id'],
							'tipo' => 'Verdura',
							'origen' => $pv['local'], // En verdura el origen es el local
							'fecha' => $pv['fecha'],
							'detalle_text' => $text,
							'link_reenviar' => base_url('verdura/reenviar/'.$pv['id'])
						);
					}

					// 2. Pedidos a Proveedores
					$this->load->model('Proveedores_model');
					$pedidos_proveedores = $this->Proveedores_model->get_pedidos_recientes(10);

					foreach ($pedidos_proveedores as $pp) {
						$lista_unificada[] = array(
							'id' => $pp['id'],
							'tipo' => 'Proveedor',
							'origen' => $pp['proveedor_nombre'],
							'fecha' => $pp['fecha'],
							'detalle_text' => $pp['detalle'], // Ya viene como texto simple
							'link_reenviar' => '#' // No implementado reenviar directo aún para proveedores
						);
					}

					// 3. Ordenar por fecha descendente
					usort($lista_unificada, function($a, $b) {
						return strtotime($b['fecha']) - strtotime($a['fecha']);
					});

					// 4. Limitar a los últimos 10
					$datos['ultimos_pedidos'] = array_slice($lista_unificada, 0, 10);
					
					// 5. Proveedores Activos (Para botones)
					$datos['proveedores_activos'] = $this->Proveedores_model->get_all_proveedores(true);
					
					
					$datos['ha_pedido_hoy'] = $this->Verdura_model->has_order_today();
 
					// Lockers
					$this->load->model('Lockers_model');
					$datos['lockers_resumen'] = $this->Lockers_model->get_summary();
					
					// Proveedores - Recordatorios
					$datos['proveedores_recordatorios'] = $this->Proveedores_model->get_proveedores_con_recordatorio();
					
                    // Certificados - Alertas
                    $this->load->model('Certificados_model');
                    $datos['alertas_certificados'] = $this->Certificados_model->get_vencimientos_proximos();

                    // Certificados - Resumen para Cuadros
                    $tipos_cert = $this->Certificados_model->get_tipos(TRUE);
                    $resumen_cert = array();
                    foreach ($tipos_cert as $t) {
                        $ultimo = $this->Certificados_model->get_ultimo_certificado($t['id']);
                        $estado = array(
                            'nombre' => $t['nombre'],
                            'id' => $t['id'],
                            'color' => 'gray',
                            'texto' => 'Sin Carga',
                            'fecha' => '-'
                        );

                        if ($ultimo && $ultimo['fecha_vencimiento'] && $ultimo['fecha_vencimiento'] != '0000-00-00') {
                            $vencimiento = new DateTime($ultimo['fecha_vencimiento']);
                            $hoy = new DateTime();
                            $dias_restantes = $hoy->diff($vencimiento)->format('%r%a');
                            $estado['fecha'] = date('d/m/Y', strtotime($ultimo['fecha_vencimiento']));

                            if ($dias_restantes < 0) {
                                $estado['color'] = 'red';
                                $estado['texto'] = 'VENCIDO';
                            } elseif ($t['requiere_aviso'] && $dias_restantes <= $t['dias_aviso']) {
                                $estado['color'] = 'yellow';
                                $estado['texto'] = 'POR VENCER';
                            } else {
                                $estado['color'] = 'green';
                                $estado['texto'] = 'VIGENTE';
                            }
                        }
                        $resumen_cert[] = $estado;
                    }
                    $datos['resumen_certificados'] = $resumen_cert;

					
					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('principal' , $datos);
					$this->load->view('close_section');
					$this->load->view('footer');
				} else {
					redirect('login');

				}
	}


}
