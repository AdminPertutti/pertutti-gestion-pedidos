<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Desayuno_model extends CI_Model
{

    function datosdelivery($id)
    {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('idUsr', $id);
        $query=$this->db->get();
    		$data= $query->result_array();
        return $data;
    }

}
