<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Certificados_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // --- Parte Privada (Gestión) ---

    public function index() {
        if ($this->session->logged_in != TRUE) redirect('login'); // Seguridad básica

        $tipos = $this->Certificados_model->get_tipos(FALSE); // Traer todos (inc inactivos)
        
        // Calcular estado para cada tipo
        foreach ($tipos as &$t) {
            $ultimo = $this->Certificados_model->get_ultimo_certificado($t['id']);
            $t['estado_color'] = 'gray'; // Por defecto (sin carga)
            $t['estado_texto'] = 'Sin Carga';
            
            if ($ultimo && $ultimo['fecha_vencimiento'] && $ultimo['fecha_vencimiento'] != '0000-00-00') {
                $vencimiento = new DateTime($ultimo['fecha_vencimiento']);
                $hoy = new DateTime();
                $dias_restantes = $hoy->diff($vencimiento)->format('%r%a'); // %r pone signo negativo si ya pasó

                if ($dias_restantes < 0) {
                    $t['estado_color'] = 'red';
                    $t['estado_texto'] = 'VENCIDO';
                } elseif ($t['requiere_aviso'] && $dias_restantes <= $t['dias_aviso']) {
                    $t['estado_color'] = 'yellow';
                    $t['estado_texto'] = 'POR VENCER';
                } else {
                    $t['estado_color'] = 'green';
                    $t['estado_texto'] = 'VIGENTE';
                }
            }
        }
        $data['tipos'] = $tipos;
        $data['alertas'] = $this->Certificados_model->get_vencimientos_proximos();

        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('certificados_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function eliminar_certificado($id) {
        if ($this->session->logged_in != TRUE) redirect('login');
        
        // Seguridad: Solo Nivel 1
        if ($this->session->userdata('s_nivel') != 1) {
            show_error('No tiene permisos para realizar esta acción', 403);
            return;
        }

        $cert = $this->Certificados_model->get_certificado($id);
        if ($cert) {
            // Borrar archivo físico
            $path = './uploads/certificados/' . $cert['archivo'];
            if (file_exists($path)) {
                unlink($path);
            }
            
            // Borrar de DB
            $this->Certificados_model->delete_certificado($id);
            $this->session->set_flashdata('success', 'Certificado eliminado correctamente');
            redirect('certificados/gestion/' . $cert['id_tipo']);
        } else {
            show_error('Certificado no encontrado', 404);
        }
    }

    public function gestion($id_tipo) {
        if ($this->session->logged_in != TRUE) redirect('login');

        $data['tipo'] = $this->Certificados_model->get_tipo($id_tipo);
        if (!$data['tipo']) redirect('certificados');

        $data['historial'] = $this->Certificados_model->get_historial($id_tipo);
        $data['ultimo'] = $this->Certificados_model->get_ultimo_certificado($id_tipo);

        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('certificados_gestion_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function guardar_tipo() {
        if ($this->session->logged_in != TRUE) redirect('login');

        $nombre = $this->input->post('nombre');
        $dias = $this->input->post('dias_aviso');
        $requiere_aviso = $this->input->post('requiere_aviso') ? 1 : 0;
        $id = $this->input->post('id');

        $data = array(
            'nombre' => $nombre,
            'dias_aviso' => $dias,
            'requiere_aviso' => $requiere_aviso,
            'activo' => 1
        );

        if ($id) {
            $this->Certificados_model->update_tipo($id, $data);
        } else {
            $this->Certificados_model->add_tipo($data);
        }
        redirect('certificados');
    }

    public function subir_certificado() {
        if ($this->session->logged_in != TRUE) redirect('login');

        $id_tipo = $this->input->post('id_tipo');
        $fecha_vencimiento = $this->input->post('fecha_vencimiento');
        $observaciones = $this->input->post('observaciones');

        // Configurar Upload
        $config['upload_path']   = './uploads/certificados/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size']      = 5120; // 5MB
        $config['file_name']     = 'cert_' . $id_tipo . '_' . date('YmdHis');

        // Crear carpeta si no existe
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('archivo')) {
            $error = $this->upload->display_errors('', '');
            $this->session->set_flashdata('error', 'Error al subir archivo: ' . $error);
        } else {
            $upload_data = $this->upload->data();
            
            $data = array(
                'id_tipo' => $id_tipo,
                'archivo' => $upload_data['file_name'],
                'fecha_vencimiento' => $fecha_vencimiento,
                'fecha_carga' => date('Y-m-d H:i:s'),
                'observaciones' => $observaciones,
                'id_usuario' => 0 // Podríamos poner el ID del usuario logueado
            );

            if ($this->Certificados_model->add_certificado($data)) {
                $this->session->set_flashdata('success', 'Certificado cargado correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al guardar en base de datos');
            }
        }
        redirect('certificados/gestion/' . $id_tipo);
    }

    // --- Parte Pública (QR) ---

    public function publico($id_tipo) {
        // Esta vista es pública, no requiere login
        $data['tipo'] = $this->Certificados_model->get_tipo($id_tipo);
        
        if (!$data['tipo'] || $data['tipo']['activo'] == 0) {
            show_error('Certificado no encontrado o inactivo', 404);
            return;
        }

        $data['certificado'] = $this->Certificados_model->get_ultimo_certificado($id_tipo);
        
        $this->load->view('certificados_public_view', $data);
    }
    
    public function imprimir_qr($id_tipo) {
       // Solo accesible si estás logueado
       if ($this->session->logged_in != TRUE) redirect('login');
       
       $data['tipo'] = $this->Certificados_model->get_tipo($id_tipo);
       if (!$data['tipo']) redirect('certificados');
       
       $this->load->view('certificados_qr_print_view', $data);
    }

    public function descargar($file) {
        // Método seguro para descargar/ver el archivo
        // Idealmente verificar si es público o si el usuario tiene permiso, 
        // pero dado que es para QR público, permitimos acceso.
        $path = './uploads/certificados/' . $file;
        if (file_exists($path)) {
            $this->load->helper('download');
            $data = file_get_contents($path);
            force_download($file, $data);
        } else {
            show_404();
        }
    }
}
