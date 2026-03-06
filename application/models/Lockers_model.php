<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lockers_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all lockers from the database.
     */
    public function get_lockers()
    {
        $this->db->select('*');
        $this->db->from('lockers');
        $this->db->order_by('numero', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get a single locker by ID.
     */
    public function get_locker($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('lockers');
        return $query->row_array();
    }

    /**
     * Get a locker by token for public access.
     */
    public function get_locker_by_token($token)
    {
        $this->db->where('token', $token);
        $query = $this->db->get('lockers');
        return $query->row_array();
    }

    /**
     * Get the last locker number to continue sequence.
     */
    public function get_last_number()
    {
        $this->db->select('numero');
        $this->db->from('lockers');
        $this->db->order_by('numero', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->numero;
        }
        return '000';
    }

    /**
     * Create multiple lockers.
     */
    public function create_lockers($data)
    {
        return $this->db->insert_batch('lockers', $data);
    }

    /**
     * Update a locker.
     */
    public function update_locker($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('lockers', $data);
    }

    /**
     * Delete a locker.
     */
    public function delete_locker($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('lockers');
    }

    /**
     * Get summary counts for lockers.
     */
    public function get_summary()
    {
        $this->db->select('estado, COUNT(*) as cantidad');
        $this->db->from('lockers');
        $this->db->group_by('estado');
        $query = $this->db->get();
        
        $summary = array(
            'sin asignar' => 0,
            'asignado' => 0,
            'roto' => 0
        );
        
        foreach ($query->result() as $row) {
            $summary[$row->estado] = $row->cantidad;
        }
        
        return $summary;
    }
}
