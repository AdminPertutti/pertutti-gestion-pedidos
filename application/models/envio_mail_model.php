<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Envio_mail_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }
    //realizamos la inserción de los datos y devolvemos el
    //resultado al controlador para envíar el correo si todo ha ido bien
    function new_user($nombre,$correo,$password,$local, $telefono, $nivel, $activate)
    {
        $data = array(
            'Nombre_Completo' => $nombre,
            'usuario' => $correo,
            'password' => $password,
            'telefono' => $telefono,
            'empresa' => $local,
            'Nivel_acceso' => $nivel,
            'activate' => $activate,
            'estado' => 0
        );
        return $this->db->insert('usuarios', $data);
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
