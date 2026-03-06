<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function login() {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            $user = $this->User_model->get_user_by_email($email);
            
            if ($user && $this->User_model->verify_password($password, $user->password)) {
                if ($user->status === 'approved' || $user->role === 'admin') {
                    $session_data = array(
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'user_email' => $user->email,
                        'user_role' => $user->role,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($session_data);
                    
                    echo json_encode(array('success' => true));
                    return;
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Usuario no aprobado'));
                    return;
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Credenciales incorrectas'));
                return;
            }
        }

        $this->load->view('auth/login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    public function register() {
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => $this->input->post('role', TRUE)
            );
            
            if ($this->User_model->create_user($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error al crear usuario'));
            }
            return;
        }
    }
}
