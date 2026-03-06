<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->load->library('session');
        
        if (!$this->session->logged_in) {
            redirect('login');
        }
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('menu_generator_view');
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function save()
    {
        $id = $this->input->post('id');
        $data = array(
            'titulo' => $this->input->post('titulo'),
            'pie' => $this->input->post('pie'),
            'items' => $this->input->post('items'), // Expecting JSON string
            'config' => $this->input->post('config'), // Expecting JSON string
            'id_usuario' => $this->session->s_idusuario,
            'fecha_modificacion' => date('Y-m-d H:i:s')
        );

        if (!$id) {
            $data['fecha_creacion'] = date('Y-m-d H:i:s');
        }

        $result_id = $this->Menu_model->save_menu($data, $id);

        if ($result_id) {
            echo json_encode(array('success' => true, 'id' => $id ?: $result_id));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al guardar el menú'));
        }
    }

    public function list_available()
    {
        $menus = $this->Menu_model->get_menus();
        echo json_encode($menus);
    }

    public function get_detail($id)
    {
        $menu = $this->Menu_model->get_menu($id);
        if ($menu) {
            echo json_encode($menu);
        } else {
            echo json_encode(array('error' => 'Menú no encontrado'));
        }
    }

    public function delete($id)
    {
        $result = $this->Menu_model->delete_menu($id);
        echo json_encode(array('success' => $result));
    }
}
