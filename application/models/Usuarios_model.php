<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all users.
     */
    public function get_usuarios()
    {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->order_by('Nombre_Completo', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get a single user by idUsr.
     */
    public function get_usuario($idUsr)
    {
        $this->db->where('idUsr', $idUsr);
        $query = $this->db->get('usuarios');
        return $query->row_array();
    }

    /**
     * Update user details and permissions.
     */
    public function update_usuario($idUsr, $data)
    {
        $this->db->where('idUsr', $idUsr);
        return $this->db->update('usuarios', $data);
    }

    /**
     * Delete a user.
     */
    public function delete_usuario($idUsr)
    {
        $this->db->where('idUsr', $idUsr);
        return $this->db->delete('usuarios');
    }

    /**
     * Helper to check if user has access to a module.
     */
    public function has_permission($module)
    {
        $permisos_json = $this->session->userdata('s_permisos');
        if (!$permisos_json) {
            // If No permissions set, fallback to level if level is 1 (Admin sees everything by default)
            return ($this->session->userdata('s_nivel') == 1);
        }
        
        $permisos = json_decode($permisos_json, true);
        if (!is_array($permisos)) return ($this->session->userdata('s_nivel') == 1);
        
        return in_array($module, $permisos);
    }
}
