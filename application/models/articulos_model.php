<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Articulos_model extends CI_Model
{
  public function borrararticulo($id) {
    $this->db->where('idArt', $id);
    $this->db->delete('articulos');


  }
  public function agrega_articulo($id,$nombre,$descripcion,$categoria,$sector,$activado) {
    if ($this->session->logged_in == TRUE) {
      $data = array(
                  'nombre' => $nombre,
                  'descripcion' => $descripcion,
                  'importe_envio' => 0,
                  'importe_produccion' => 0,
                  'categoria' => $categoria,
                  'sector' => $sector,
                  'activo' => $activado
    );

   if ($this->db->insert('articulos', $data)) { return 1;
   } else {return 0;}
  }
}

public function agregar_categoria($nombre) {
  if ($this->session->logged_in == TRUE) {
    $data = array(
                'descripcion' => $nombre
  );

 if ($this->db->insert('categoria', $data)) { return 1;
 } else {return 0;}
}
}

  public function modifica_articulo($id,$nombre,$descripcion,$categoria,$sector,$activado) {
    if ($this->session->logged_in == TRUE) {
      $data = array(
                  'nombre' => $nombre,
                  'descripcion' => $descripcion,
                  'importe_envio' => 0,
                  'importe_produccion' => 0,
                  'categoria' => $categoria,
                  'sector' => $sector,
                  'activo' => $activado
    );
    $this->db->where("idArt", $id);
   if ($this->db->update('articulos', $data)) { return 1;
   } else {return 0;}
  }
  }
  public function editar_articulo($id)
   {
     $this->db->select('*');
     $this->db->from('articulos');
     $this->db->where('idArt', $id);
     $query=$this->db->get();
     $data= $query->result_array();
     foreach ($data as $datos) {
         return $datos;
     }

    }
  public function activar($id) {
    $this->db->where('idArt', $id);
    $this->db->set('activo', 1);
    $resultado = $this->db->update('articulos');
    }

    public function desactivar($id) {
      $this->db->where('idArt', $id);
      $this->db->set('activo', 0);
      $resultado = $this->db->update('articulos');
      }

}
