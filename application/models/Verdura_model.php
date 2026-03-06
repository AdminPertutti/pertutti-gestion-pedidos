<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verdura_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all vegetable products from the database.
     */
    public function get_products()
    {
        $this->db->select('*');
        $this->db->from('verdura_productos');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get a single vegetable product.
     */
    public function get_product($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('verdura_productos');
        return $query->row_array();
    }

    /**
     * Add or update a vegetable product.
     */
    public function save_product($data, $id = null)
    {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('verdura_productos', $data);
        }
        return $this->db->insert('verdura_productos', $data);
    }

    /**
     * Delete a vegetable product.
     */
    public function delete_product($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('verdura_productos');
    }

    /**
     * Save a new vegetable order and return the insertion ID.
     */
    public function save_order($data)
    {
        if ($this->db->insert('verdura_pedidos', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Get a single vegetable order.
     */
    public function get_order($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('verdura_pedidos');
        return $query->row_array();
    }

    /**
     * Get all vegetable orders with parsed details.
     */
    public function get_all_orders($limit = 15)
    {
        $this->db->select('*');
        $this->db->from('verdura_pedidos');
        $this->db->order_by('fecha', 'DESC');
        if ($limit) $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get configuration value by key.
     */
    public function get_config($clave, $default = '')
    {
        $this->db->where('clave', $clave);
        $query = $this->db->get('verdura_config');
        if ($query->num_rows() > 0) {
            return $query->row()->valor;
        }
        return $default;
    }

    /**
     * Save configuration value.
     */
    public function save_config($clave, $valor)
    {
        $data = array('clave' => $clave, 'valor' => $valor);
        $this->db->where('clave', $clave);
        $query = $this->db->get('verdura_config');
        if ($query->num_rows() > 0) {
            $this->db->where('clave', $clave);
            return $this->db->update('verdura_config', array('valor' => $valor));
        }
        return $this->db->insert('verdura_config', $data);
    }

    /**
     * Check if there is an order for the current day.
     */
    public function has_order_today()
    {
        $this->db->where('DATE(fecha)', date('Y-m-d'));
        $query = $this->db->get('verdura_pedidos');
        return ($query->num_rows() > 0);
    }

    /**
     * Delete a vegetable order.
     */
    public function delete_order($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('verdura_pedidos');
    }
}
