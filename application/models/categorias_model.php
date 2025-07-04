<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categorias_model extends CI_Model
{
  public function borrararticulo($id) {
    $this->db->where('idArt', $id);
    $this->db->delete('articulos');


  }
  public function listacategorias()
  {
      $this->db->select('*');
      $this->db->from('categoria');
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
  }


public function agregar_categoria($nombre) {
  if ($this->session->logedin == TRUE) {
    $data = array(
                'descripcion' => $nombre
  );

 if ($this->db->insert('categoria', $data)) { return 1;
 } else {return 0;}
}
}

  public function modifica_categoria($id,$nombre) {
    if ($this->session->logedin == TRUE) {
      $data = array(
                  'descripcion' => $nombre
    );
    $this->db->where("idCategoria", $id);
   if ($this->db->update('categoria', $data)) { return 1;
   } else {return 0;}
  }
  }
  public function editar_categoria($id)
   {
     $this->db->select('*');
     $this->db->from('categoria');
     $this->db->where('idCategoria', $id);
     $query=$this->db->get();
     $data= $query->result_array();
     foreach ($data as $datos) {
         return $datos;
     }

    }


}
