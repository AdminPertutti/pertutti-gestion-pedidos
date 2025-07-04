<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mactivar extends CI_Model
{
public function activar($id, $activate){


      $this->db->select('*');
      $this->db->from('usuarios');
      $this->db->where('usuario', $id);
      $this->db->where('activate', $activate);
      $resultado = $this->db->get();
      $row = $resultado->row();

      if ($resultado->num_rows() == 1){

      $data = array(
                    'estado' => 1,
                    'activate' => " "
              );
      $this->db->where('usuario', $id);
      $this->db->where('activate', $activate);
      $resultado = $this->db->update('usuarios', $data);


      if ($resultado == 1){
      return 1;

    } else { return 0; }

  } else { return 0; }
      }

}
