<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->library('session');
        
        // Ensure user is logged in AND is admin (Level 1)
        if (!$this->session->logged_in || $this->session->s_nivel != 1) {
            redirect('inicio');
        }
    }

    public function index()
    {
        $data['usuarios'] = $this->Usuarios_model->get_usuarios();
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('usuarios_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function editar($idUsr)
    {
        $user = $this->Usuarios_model->get_usuario($idUsr);
        if (!$user) show_404();

        $data['u'] = $user;
        $data['permisos'] = json_decode($user['permisos'], true) ?: array();
        
        // Define available modules
        $data['modulos'] = array(
            'inicio' => 'Dashboard / Inicio',
            'verdura' => 'Pedido Verdura',
            'verdura_gestion' => 'Gestión Verdura',
            'proveedores' => 'Gestión de Proveedores',
            'lockers' => 'Lockers',
            'delivery' => 'Calcular Envío',
            'reposicion' => 'Reposición',
            'facturar' => 'Facturación',
            'procesar' => 'Procesar Manualmente',
            'articulos' => 'Artículos (Mercadería)',
            'categorias' => 'Categorías (Mercadería)',
            'usuarios' => 'Gestión de Usuarios',
            'registrarse' => 'Cargar Nuevo Local',
            'indumentaria' => 'Gestión de Indumentaria',
            'certificados' => 'Gestión de Certificados'
        );

        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('usuarios_perfil_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function guardar()
    {
        $idUsr = $this->input->post('idUsr');
        $permisos = $this->input->post('modulos'); // Array from checkboxes

        $data = array(
            'Nombre_Completo' => $this->input->post('nombre'),
            'usuario'         => $this->input->post('email'),
            'Nivel_acceso'    => $this->input->post('nivel'),
            'empresa'         => $this->input->post('empresa'),
            'permisos'        => $permisos ? json_encode($permisos) : NULL
        );

        // Cambiar contraseña solo si se completó el campo y coincide la confirmación
        $nueva = $this->input->post('nueva_password');
        $confirmar = $this->input->post('confirmar_password');
        if (!empty($nueva)) {
            if ($nueva === $confirmar) {
                $data['password'] = sha1($nueva);
            } else {
                $this->session->set_flashdata('error', 'Las contraseñas no coinciden. El resto de los datos sí fue guardado.');
                // Guardar igualmente sin contraseña
                $this->Usuarios_model->update_usuario($idUsr, $data);
                redirect('usuarios');
                return;
            }
        }

        if ($this->Usuarios_model->update_usuario($idUsr, $data)) {
            $this->session->set_flashdata('success', 'Usuario actualizado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar el usuario.');
        }

        redirect('usuarios');
    }

    public function eliminar($idUsr)
    {
        if ($idUsr == $this->session->s_idusuario) {
            $this->session->set_flashdata('error', 'No puedes eliminarte a ti mismo.');
        } else {
            $this->Usuarios_model->delete_usuario($idUsr);
            $this->session->set_flashdata('success', 'Usuario eliminado.');
        }
        redirect('usuarios');
    }
}
