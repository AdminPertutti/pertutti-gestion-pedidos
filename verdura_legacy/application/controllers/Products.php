<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Product_model');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        if ($this->session->userdata('user_role') !== 'admin') {
            show_404();
        }
    }

    public function create() {
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'unit' => $this->input->post('unit'),
                'category' => $this->input->post('category'),
                'price' => $this->input->post('price') ?: 0,
                'qty_dom_mie' => $this->input->post('qty_dom_mie') ?: 0,
                'qty_jue' => $this->input->post('qty_jue') ?: 0,
                'qty_vie' => $this->input->post('qty_vie') ?: 0,
                'created_by' => $this->session->userdata('user_id')
            );
            
            if ($this->Product_model->create_product($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error al crear producto'));
            }
            return;
        }
    }

    public function edit($id) {
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'unit' => $this->input->post('unit'),
                'category' => $this->input->post('category'),
                'price' => $this->input->post('price') ?: 0,
                'qty_dom_mie' => $this->input->post('qty_dom_mie') ?: 0,
                'qty_jue' => $this->input->post('qty_jue') ?: 0,
                'qty_vie' => $this->input->post('qty_vie') ?: 0
            );
            
            if ($this->Product_model->update_product($id, $data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error al actualizar producto'));
            }
            return;
        }
        
        $product = $this->Product_model->get_product_by_id($id);
        echo json_encode($product);
    }

    public function delete($id) {
        if ($this->Product_model->delete_product($id)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al eliminar producto'));
        }
    }

    public function bulk_upload() {
        if ($this->input->post()) {
            $csv_data = $this->input->post('csv_data');
            $lines = explode("\n", trim($csv_data));
            
            if (count($lines) < 2) {
                echo json_encode(array('success' => false, 'message' => 'Datos CSV inválidos'));
                return;
            }
            
            $headers = str_getcsv($lines[0]);
            $products = array();
            
            for ($i = 1; $i < count($lines); $i++) {
                $values = str_getcsv($lines[$i]);
                if (count($values) === count($headers)) {
                    $product = array();
                    foreach ($headers as $index => $header) {
                        $product[$header] = $values[$index];
                    }
                    
                    $products[] = array(
                        'name' => $product['name'] ?? '',
                        'unit' => $product['unit'] ?? '',
                        'category' => $product['category'] ?? '',
                        'price' => $product['price'] ?? 0,
                        'qty_dom_mie' => $product['qty_dom_mie'] ?? 0,
                        'qty_jue' => $product['qty_jue'] ?? 0,
                        'qty_vie' => $product['qty_vie'] ?? 0,
                        'created_by' => $this->session->userdata('user_id')
                    );
                }
            }
            
            $success_count = 0;
            foreach ($products as $product) {
                if ($this->Product_model->create_product($product)) {
                    $success_count++;
                }
            }
            
            echo json_encode(array(
                'success' => true, 
                'message' => "Se crearon $success_count productos exitosamente"
            ));
            return;
        }
    }
}
