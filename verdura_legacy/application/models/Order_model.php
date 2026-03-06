<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_order($order_data, $items) {
        $this->db->trans_start();
        
        // Insertar pedido
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();
        
        // Insertar items del pedido
        foreach ($items as $item) {
            $item['order_id'] = $order_id;
            $this->db->insert('order_items', $item);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_orders_by_user($user_id) {
        $this->db->select('o.*, GROUP_CONCAT(CONCAT(oi.product_name, ":", oi.quantity, " ", oi.unit) SEPARATOR "|") as items');
        $this->db->from('orders o');
        $this->db->join('order_items oi', 'o.id = oi.order_id');
        $this->db->where('o.user_id', $user_id);
        $this->db->group_by('o.id');
        $this->db->order_by('o.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_orders() {
        $this->db->select('o.*, GROUP_CONCAT(CONCAT(oi.product_name, ":", oi.quantity, " ", oi.unit) SEPARATOR "|") as items');
        $this->db->from('orders o');
        $this->db->join('order_items oi', 'o.id = oi.order_id');
        $this->db->group_by('o.id');
        $this->db->order_by('o.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function update_order_status($order_id, $status) {
        return $this->db->update('orders', array('status' => $status), array('id' => $order_id));
    }

    public function get_order_with_items($order_id) {
        $order = $this->db->get_where('orders', array('id' => $order_id))->row();
        if ($order) {
            $items = $this->db->get_where('order_items', array('order_id' => $order_id))->result();
            $order->items = $items;
        }
        return $order;
    }

    public function get_order_stats($user_id = null) {
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $total = $this->db->count_all_results('orders');
        
        $this->db->reset_query();
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->where('MONTH(created_at)', date('n'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $this_month = $this->db->count_all_results('orders');
        
        return array('total' => $total, 'this_month' => $this_month);
    }
}
