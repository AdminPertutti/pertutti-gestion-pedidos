<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->model('Product_model');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        if ($this->session->userdata('user_role') !== 'admin') {
            show_404();
        }
    }

    public function index() {
        $data['users'] = $this->User_model->get_all_users();
        $data['products'] = $this->Product_model->get_all_products();
        $this->load->view('admin/index', $data);
    }

    public function create_user() {
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => $this->input->post('role')
            );
            
            if ($this->User_model->create_user($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error al crear usuario'));
            }
            return;
        }
    }

    public function delete_user($id) {
        if ($id == $this->session->userdata('user_id')) {
            echo json_encode(array('success' => false, 'message' => 'No puedes eliminarte a ti mismo'));
            return;
        }
        
        if ($this->User_model->delete_user($id)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al eliminar usuario'));
        }
    }
}
