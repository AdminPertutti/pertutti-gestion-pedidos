<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Settings_model');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $data['settings'] = $this->Settings_model->get_all_settings();
        $this->load->view('settings/index', $data);
    }

    public function save() {
        if ($this->input->post()) {
            $company_name = $this->input->post('company_name');
            $supplier_email = $this->input->post('supplier_email');
            $currency = $this->input->post('currency');
            
            $this->Settings_model->set_setting('company_name', $company_name);
            $this->Settings_model->set_setting('default_supplier_email', $supplier_email);
            $this->Settings_model->set_setting('currency', $currency);
            
            echo json_encode(array('success' => true, 'message' => 'Configuración guardada'));
            return;
        }
    }
}
