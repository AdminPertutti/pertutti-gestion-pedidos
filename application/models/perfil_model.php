<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Perfil_model extends CI_Model
{

    //realizamos la inserción de los datos y devolvemos el
    //resultado al controlador para envíar el correo si todo ha ido bien
    function modifica_user($nombre, $id, $telefono)
    {
        $data = array(
            'Nombre_Completo' => $nombre,
            'telefono' => $telefono

            );
        $this->db->where('idUsr', $id);
        $query = $this->db->update('usuarios', $data);

        return $query;
    }

  function check_clave($id, $pass)
    {
      $this->db->select('*');
      $this->db->from('usuarios');
      $this->db->where('idUsr', $id);
      $this->db->where('password', $pass);
      //$this->db->where('estado', 1);
      $resultado = $this->db->get();
      $row = $resultado->row();
      if ($resultado->num_rows() == 1){
        return 1; //Ok
      } else {
        return 2; // Error
      }
    }

    function modifica_clave($id, $newpass)
    {
        $data = array(
            'password' => $newpass
            );
        $this->db->where('idUsr', $id);
        $query = $this->db->update('usuarios', $data);

        return $query;
    }


    function cargar_user($id)
    {

        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('idUsr', $id);
        $query = $this->db->get();
        return $query->row();


    }

}
