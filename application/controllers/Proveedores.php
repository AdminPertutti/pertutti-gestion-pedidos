<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Proveedores_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Verificar que el usuario esté logueado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    /**
     * Página principal de gestión de proveedores
     */
    public function index()
    {
        $data['proveedores'] = $this->Proveedores_model->get_all_proveedores();
        $data['estadisticas'] = $this->Proveedores_model->get_estadisticas();
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('proveedores_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    /**
     * Guardar o actualizar proveedor
     */
    public function guardar_proveedor()
    {
        $id = $this->input->post('id');
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'telefono' => $this->input->post('telefono'),
            'email' => $this->input->post('email'),
            'whatsapp' => $this->input->post('whatsapp'),
            'notas' => $this->input->post('notas')
        );
        
        if ($id) {
            $this->Proveedores_model->update_proveedor($id, $data);
            $this->session->set_flashdata('success', 'Proveedor actualizado correctamente');
        } else {
            $this->Proveedores_model->add_proveedor($data);
            $this->session->set_flashdata('success', 'Proveedor agregado correctamente');
        }
        
        redirect('proveedores');
    }

    /**
     * Eliminar proveedor
     */
    public function eliminar_proveedor($id)
    {
        if ($this->Proveedores_model->delete_proveedor($id)) {
            $this->session->set_flashdata('success', 'Proveedor eliminado correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar el proveedor');
        }
        
        redirect('proveedores');
    }

    /**
     * Configurar días de pedido para un proveedor
     */
    public function configurar_dias($id)
    {
        $data['proveedor'] = $this->Proveedores_model->get_proveedor($id);
        
        if (!$data['proveedor']) {
            show_404();
            return;
        }
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('proveedores_dias_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    /**
     * Guardar configuración de días
     */
    public function guardar_dias()
    {
        $id_proveedor = $this->input->post('id_proveedor');
        $dias_seleccionados = $this->input->post('dias'); // Array de días seleccionados
        
        $dias_data = array();
        if ($dias_seleccionados) {
            foreach ($dias_seleccionados as $dia) {
                $hora = $this->input->post('hora_' . $dia);
                if ($hora) {
                    $dias_data[] = array(
                        'dia_semana' => $dia,
                        'hora_limite' => $hora
                    );
                }
            }
        }
        
        $this->Proveedores_model->save_dias_pedido($id_proveedor, $dias_data);
        $this->session->set_flashdata('success', 'Configuración de días guardada correctamente');
        
        redirect('proveedores');
    }

    /**
     * Formulario para hacer pedido a un proveedor
     */
    public function hacer_pedido($id)
    {
        $data['proveedor'] = $this->Proveedores_model->get_proveedor($id);
        
        if (!$data['proveedor']) {
            show_404();
            return;
        }
        
        $data['articulos'] = $this->Proveedores_model->get_articulos_proveedor($id);
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('proveedores_pedido_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    /**
     * Guardar pedido
     */
    public function guardar_pedido()
    {
        $id_proveedor = $this->input->post('id_proveedor');
        $detalle = $this->input->post('detalle');
        $enviar_whatsapp = $this->input->post('enviar_whatsapp') ? true : false;
        $enviar_email = $this->input->post('enviar_email') ? true : false;
        
        // Guardar el pedido
        if ($this->Proveedores_model->save_pedido($id_proveedor, $detalle, $enviar_whatsapp)) {
            $msg_success = 'Pedido guardado correctamente.';
            
            // Intentar enviar email si se solicitó
            if ($enviar_email) {
                 // Obtener datos del proveedor para el email
                $proveedor = $this->Proveedores_model->get_proveedor($id_proveedor);
                
                if ($proveedor && !empty($proveedor['email'])) {
                    $result = $this->_send_email($proveedor, $detalle);
                    if ($result['success']) {
                        $msg_success .= ' Email enviado correctamente.';
                    } else {
                        $this->session->set_flashdata('error', 'Pedido guardado, pero falló el envío del email: ' . (isset($result['response']['message']) ? $result['response']['message'] : 'Error desconocido'));
                        if (isset($result['response']['debug_log'])) {
                            $this->session->set_flashdata('error_modal', $result['response']['debug_log']);
                        }
                    }
                } else {
                    $this->session->set_flashdata('warning', 'Pedido guardado, pero el proveedor no tiene email configurado.');
                }
            }
            
            $this->session->set_flashdata('success', $msg_success);
        } else {
            $this->session->set_flashdata('error', 'Error al guardar el pedido');
        }
        
        redirect('proveedores/historial?proveedor=' . $id_proveedor);
    }
    
    /**
     * Función privada para enviar email usando PHPMailer
     */
    private function _send_email($proveedor, $detalle_texto)
    {
        $local_nombre = 'local lomas';

        $message = "<h2>Solicitud de Pedido - " . $local_nombre . "</h2><hr>";
        $message .= "<p>Hola <strong>" . $proveedor['nombre'] . "</strong>, le enviamos el siguiente pedido:</p>";
        
        // Convertir saltos de línea a <br>
        $detalle_html = nl2br(htmlspecialchars($detalle_texto));
        
        $message .= "<div style='background: #f9f9f9; padding: 15px; border: 1px solid #ddd; margin: 20px 0;'>";
        $message .= $detalle_html;
        $message .= "</div>";
        
        $message .= "<hr>";
        $message .= "<p>Gracias.<br>" . $local_nombre . "</p>";

        // Load PHPMailer via wrapper
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        try {
            $mail->setFrom($this->config->item('smtp_user'), 'Pedidos ' . $local_nombre);
            $mail->addAddress($proveedor['email']);
            $mail->addBCC('pertuttilomas@gmail.com'); // Copia oculta siempre
            
            $mail->Subject = 'Pedido de ' . $local_nombre . ' - ' . date('d/m/Y');
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message); // Plain text version

            if(!$mail->send()) {
                $debug_log = $this->phpmailer_lib->getDebugLog();
                return array(
                    'success' => false, 
                    'response' => array(
                        'message' => 'Mailer Error: ' . $mail->ErrorInfo,
                        'debug_log' => $debug_log
                    )
                );
            } else {
                return array('success' => true);
            }
        } catch (Exception $e) {
             return array(
                'success' => false, 
                'response' => array('message' => 'Exception: ' . $e->getMessage())
            );
        }
    }

    /**
     * Ver historial de pedidos
     */
    public function historial()
    {
        $id_proveedor = $this->input->get('proveedor');
        $data['pedidos'] = $this->Proveedores_model->get_pedidos_recientes(50, $id_proveedor);
        $data['proveedores'] = $this->Proveedores_model->get_all_proveedores();
        $data['proveedor_seleccionado'] = $id_proveedor;
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('proveedores_historial_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    /**
     * Obtener datos de proveedor en JSON (para edición)
     */
    public function get_proveedor_json($id)
    {
        $proveedor = $this->Proveedores_model->get_proveedor($id);
        header('Content-Type: application/json');
        echo json_encode($proveedor);
    }

    /**
     * Configurar artículos de pedido para un proveedor
     */
    public function configurar_articulos($id)
    {
        $data['proveedor'] = $this->Proveedores_model->get_proveedor($id);
        
        if (!$data['proveedor']) {
            show_404();
            return;
        }

        $data['articulos'] = $this->Proveedores_model->get_articulos_proveedor($id);
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('proveedores_articulos_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    /**
     * Guardar un artículo de proveedor
     */
    public function guardar_articulo()
    {
        $id_proveedor = $this->input->post('id_proveedor');
        $data = array(
            'id' => $this->input->post('id'),
            'id_proveedor' => $id_proveedor,
            'descripcion' => $this->input->post('descripcion'),
            'unidad_medida' => $this->input->post('unidad_medida'),
            'stock_completar' => $this->input->post('stock_completar')
        );
        
        if ($this->Proveedores_model->save_articulo($data)) {
            $this->session->set_flashdata('success', 'Artículo guardado correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al guardar el artículo');
        }
        
        redirect('proveedores/configurar_articulos/' . $id_proveedor);
    }

    /**
     * Eliminar un artículo de proveedor
     */
    public function eliminar_articulo($id)
    {
        $id_proveedor = $this->input->get('id_proveedor');
        if ($this->Proveedores_model->delete_articulo($id)) {
            $this->session->set_flashdata('success', 'Artículo eliminado correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar el artículo');
        }
        
        redirect('proveedores/configurar_articulos/' . $id_proveedor);
    }

    /**
     * Guardar un artículo vía AJAX y devolver JSON
     */
    public function ajax_guardar_articulo()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_proveedor = $this->input->post('id_proveedor');
        $data = array(
            'id_proveedor' => $id_proveedor,
            'descripcion' => $this->input->post('descripcion'),
            'unidad_medida' => $this->input->post('unidad_medida'),
            'stock_completar' => $this->input->post('stock_completar') ? $this->input->post('stock_completar') : 0
        );
        
        $id = $this->Proveedores_model->save_articulo($data);
        
        if ($id) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => true, 'id' => $id, 'data' => $data));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'message' => 'Error al guardar'));
        }
    }

    public function eliminar_pedido($id)
    {
        // Check permissions (only level 1)
        if ($this->session->userdata('s_nivel') != 1) {
            $this->session->set_flashdata('error', 'No tiene permisos para realizar esta acción.');
            redirect('inicio');
        }

        $this->Proveedores_model->delete_pedido($id);
        $this->session->set_flashdata('success', 'Pedido eliminado correctamente.');
        redirect('inicio');
    }

    public function omitir_recordatorio($id_proveedor)
    {
        $detalle = "Recordatorio Omitido: Stock Suficiente";
        $this->Proveedores_model->save_pedido($id_proveedor, $detalle);
        
        $this->session->set_flashdata('success', 'Recordatorio omitido por hoy.');
        redirect('inicio');
    }
}
