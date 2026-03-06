<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_menus()
    {
        $this->db->select('id, titulo, fecha_modificacion');
        $this->db->from('menus');
        $this->db->order_by('fecha_modificacion', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_menu($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('menus');
        return $query->row_array();
    }

    public function save_menu($data, $id = null)
    {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('menus', $data);
        }
        $this->db->insert('menus', $data);
        return $this->db->insert_id();
    }

    public function delete_menu($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('menus');
    }
}
