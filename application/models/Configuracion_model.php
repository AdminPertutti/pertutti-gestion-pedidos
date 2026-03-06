<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracion_model extends CI_Model
{
    public function get_sectores()
    {
        $this->db->select('*');
        $this->db->from('sector');
        $this->db->order_by('idSector', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_ruta_sector($id, $ruta)
    {
        $this->db->set('impresora', $ruta);
        $this->db->where('idSector', $id);
        return $this->db->update('sector');
    }
}
