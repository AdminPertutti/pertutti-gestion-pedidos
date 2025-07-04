<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_products() {
        return $this->db->get('products')->result();
    }

    public function get_product_by_id($id) {
        return $this->db->get_where('products', array('id' => $id))->row();
    }

    public function create_product($data) {
        return $this->db->insert('products', $data);
    }

    public function update_product($id, $data) {
        return $this->db->update('products', $data, array('id' => $id));
    }

    public function delete_product($id) {
        return $this->db->delete('products', array('id' => $id));
    }

    public function get_categories() {
        $this->db->select('category');
        $this->db->distinct();
        return $this->db->get('products')->result();
    }

    public function search_products($search = '', $category = '') {
        if (!empty($search)) {
            $this->db->like('name', $search);
        }
        if (!empty($category) && $category !== 'all') {
            $this->db->where('category', $category);
        }
        return $this->db->get('products')->result();
    }
}
