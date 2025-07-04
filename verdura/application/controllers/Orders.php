<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Order_model');
        $this->load->model('Product_model');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function create() {
        if ($this->input->post()) {
            $items_data = json_decode($this->input->post('items'), true);
            $items = array();
            
            foreach ($items_data as $item) {
                $items[] = array(
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                    'price' => $item['price']
                );
            }
            
            $order_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'user_name' => $this->session->userdata('user_name'),
                'total' => $this->input->post('total'),
                'supplier_email' => $this->input->post('supplier_email'),
                'notes' => $this->input->post('notes')
            );
            
            if ($this->Order_model->create_order($order_data, $items)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error al crear pedido'));
            }
            return;
        }
    }

    public function update_status() {
        if ($this->input->post()) {
            $order_id = $this->input->post('order_id');
            $status = $this->input->post('status');
            
            if ($this->Order_model->update_order_status($order_id, $status)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false));
            }
        }
    }
}
