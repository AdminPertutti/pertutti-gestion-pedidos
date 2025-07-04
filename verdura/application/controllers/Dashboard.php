<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $data['user'] = (object) array(
            'id' => $this->session->userdata('user_id'),
            'name' => $this->session->userdata('user_name'),
            'email' => $this->session->userdata('user_email'),
            'role' => $this->session->userdata('user_role')
        );
        
        $data['products'] = $this->Product_model->get_all_products();
        $data['categories'] = $this->Product_model->get_categories();
        
        if ($data['user']->role === 'admin') {
            $data['orders'] = $this->Order_model->get_all_orders();
        } else {
            $data['orders'] = $this->Order_model->get_orders_by_user($data['user']->id);
        }
        
        $data['stats'] = $this->Order_model->get_order_stats(
            $data['user']->role === 'admin' ? null : $data['user']->id
        );
        
        $this->load->view('dashboard', $data);
    }
}
