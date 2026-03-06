<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verdura extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Verdura_model');
        $this->load->library('session');
        $this->load->config('verdura');
        
        // Ensure user is logged in
        if (!$this->session->logged_in) {
            redirect('login');
        }
    }

    public function index()
    {
        $pedidos = $this->Verdura_model->get_all_orders(0); // Fetch all
        foreach ($pedidos as &$p) {
            $detalle = json_decode($p['detalle'], true);
            $p['detalle_html'] = "<ul>";
            $text = "Pedido de Verdura - " . $p['local'] . "\n";
            $text .= "Fecha: " . date('d/m/Y H:i', strtotime($p['fecha'])) . "\n";
            $text .= "----------------------------\n";
            foreach ($detalle as $item) {
                $p['detalle_html'] .= "<li>" . $item['nombre'] . ": " . $item['cantidad'] . " " . $item['unidad'] . "</li>";
                $text .= "- " . $item['nombre'] . ": " . $item['cantidad'] . " " . $item['unidad'] . "\n";
            }
            $p['detalle_html'] .= "</ul>";
            $p['detalle_text'] = $text;
        }

        $data = array(
            'productos' => $this->Verdura_model->get_products(),
            'pedidos' => $pedidos,
            'respuesta' => ''
        );

        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('verdura_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function gestion()
    {
        $data = array(
            'productos' => $this->Verdura_model->get_products(),
            'proveedor_email' => $this->Verdura_model->get_config('proveedor_email', $this->config->item('verdura_proveedor_email')),
            'proveedor_nombre' => $this->Verdura_model->get_config('proveedor_nombre', $this->config->item('verdura_proveedor_nombre')),
            'copia_email' => $this->Verdura_model->get_config('copia_email', 'pertuttilomas@gmail.com'),
            'enviar_copia' => $this->Verdura_model->get_config('enviar_copia', 0),
            'respuesta' => ''
        );

        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('verdura_gestion', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function guardar_producto()
    {
        $id = $this->input->post('id');
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'unidad' => $this->input->post('unidad'),
            'cantidad_estimada' => $this->input->post('cantidad_estimada')
        );

        if ($this->Verdura_model->save_product($data, $id)) {
            $this->session->set_flashdata('success', 'Producto guardado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al guardar el producto.');
        }
        redirect('verdura/gestion');
    }

    public function eliminar_producto($id)
    {
        if ($this->Verdura_model->delete_product($id)) {
            $this->session->set_flashdata('success', 'Producto eliminado.');
        } else {
            $this->session->set_flashdata('error', 'No se pudo eliminar el producto.');
        }
        redirect('verdura/gestion');
    }

    public function guardar_config()
    {
        $email = $this->input->post('proveedor_email');
        $nombre = $this->input->post('proveedor_nombre');
        $copia = $this->input->post('copia_email');
        $enviar_copia = $this->input->post('enviar_copia') ? 1 : 0;

        $this->Verdura_model->save_config('proveedor_email', $email);
        $this->Verdura_model->save_config('proveedor_nombre', $nombre);
        $this->Verdura_model->save_config('copia_email', $copia);
        $this->Verdura_model->save_config('enviar_copia', $enviar_copia);

        $this->session->set_flashdata('success', 'Configuración actualizada.');
        redirect('verdura/gestion');
    }

    public function enviar()
    {
        $productos = $this->Verdura_model->get_products();
        $orden_items = array();
        $total_enviado = false;

        foreach ($productos as $p) {
            $input_name = 'prod_' . $p['id'];
            $cantidad = $this->input->post($input_name);
            
            if ($cantidad > 0) {
                $orden_items[] = array(
                    'id' => $p['id'],
                    'nombre' => $p['nombre'],
                    'cantidad' => $cantidad,
                    'unidad' => $p['unidad']
                );
                $total_enviado = true;
            }
        }

        if ($total_enviado) {
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $order_data = array(
                'id_usuario' => $this->session->s_idusuario,
                'local' => $this->session->s_local,
                'fecha' => date("Y-m-d H:i:s"),
                'detalle' => json_encode($orden_items)
            );

            $order_id = $this->Verdura_model->save_order($order_data);

            if ($order_id) {
                $result = $this->_send_email($orden_items);
                if ($result['success']) {
                    $this->session->set_flashdata('success', '¡Pedido de verdura enviado correctamente!');
                } else {
                    $error_msg = 'El pedido se guardó pero el mail falló.';
                    if (isset($result['response']['message'])) {
                        $error_msg .= ' Error: ' . $result['response']['message'];
                    }
                    $this->session->set_flashdata('error', $error_msg);
                    
                    // Pass debug log to modal if available
                    if (isset($result['response']['debug_log'])) {
                        $this->session->set_flashdata('error_modal', $result['response']['debug_log']);
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Error al guardar el pedido.');
            }
        } else {
            $this->session->set_flashdata('warning', 'No se seleccionaron productos.');
        }

        redirect('verdura');
    }

    public function reenviar($id)
    {
        $pedido = $this->Verdura_model->get_order($id);
        if ($pedido) {
            $items = json_decode($pedido['detalle'], true);
            $result = $this->_send_email($items);
            
            if ($result['success']) {
                $this->session->set_flashdata('success', 'Pedido reenviado correctamente por email.');
            } else {
                $error_msg = 'Error al reenviar el email.';
                if (isset($result['response']['message'])) {
                     $error_msg .= ' Error: ' . $result['response']['message'];
                }
                $this->session->set_flashdata('error', $error_msg);
                
                // Pass debug log to modal if available
                if (isset($result['response']['debug_log'])) {
                    $this->session->set_flashdata('error_modal', $result['response']['debug_log']);
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Pedido no encontrado.');
        }
        redirect('verdura');
    }

    private function _send_email($items)
    {
        $email_to = $this->Verdura_model->get_config('proveedor_email', $this->config->item('verdura_proveedor_email'));
        $proveedor_nombre = $this->Verdura_model->get_config('proveedor_nombre', $this->config->item('verdura_proveedor_nombre'));
        $copia_email = $this->Verdura_model->get_config('copia_email', 'pertuttilomas@gmail.com');
        $enviar_copia = $this->Verdura_model->get_config('enviar_copia', 0);
        $local_nombre = 'local lomas';

        $message = "<h2>Pedido de Verdura - " . $local_nombre . "</h2><hr>";
        $message .= "<p>Hola " . $proveedor_nombre . ", adjuntamos el pedido del día:</p>";
        $message .= "<ul>";
        
        foreach ($items as $item) {
            $message .= "<li><strong>" . $item['nombre'] . ":</strong> " . $item['cantidad'] . " " . $item['unidad'] . "</li>";
        }
        
        $message .= "</ul><br><hr>";
        $message .= "<p>Gracias.</p>";

        // Load PHPMailer via wrapper
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        try {
            $mail->setFrom($this->config->item('smtp_user'), 'Pedidos ' . $local_nombre);
            $mail->addAddress($email_to);
            
            if ($enviar_copia == 1 && !empty($copia_email)) {
                $mail->addBCC($copia_email);
            }
            
            $mail->Subject = 'Nuevo Pedido de Verdura - ' . $local_nombre;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message); // Plain text version

            if(!$mail->send()) {
                // Get full SMTP debug log
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

    public function eliminar($id)
    {
        // Check permissions (only level 1)
        if ($this->session->userdata('s_nivel') != 1) {
            $this->session->set_flashdata('error', 'No tiene permisos para realizar esta acción.');
            redirect('inicio');
        }

        $this->Verdura_model->delete_order($id);
        $this->session->set_flashdata('success', 'Pedido de verdura eliminado correctamente.');
        redirect('inicio');
    }
}
