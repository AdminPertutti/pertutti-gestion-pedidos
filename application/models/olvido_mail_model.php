<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Olvido_mail_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }
    //realizamos la inserción de los datos y devolvemos el
    //resultado al controlador para envíar el correo si todo ha ido bien
    function new_pass($correo,$activate)
    {
      $this->db->select('*');
      $this->db->from('usuarios');
      $this->db->where('usuario', $correo);
      $resultado = $this->db->get();
      $row = $resultado->row();

      if ($resultado->num_rows() == 1){

          $data = array(
                    'activate' => $activate
                    );
            $this->db->where('usuario', $correo);
            $resultado = $this->db->update('usuarios', $data);
            if ($resultado == 1){
            return 1;

          } else { return 0; }

        } else { return 0; }

      }
      function check_user($correo)
      {

          $this->db->select('correo');
          $this->db->from('usuarios');
          $this->db->where('usuario', $correo);
          $query = $this->db->get();
          if($query->num_rows() > 0 )
          {
              return 1;
          } else { return 0;}
      }
}
