<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reclamo_model extends CI_Model
{

    function carga_reclamo($local, $id, $asunto, $descripcion)
    {
        $data = array(
            'local' => $local,
            'idusuario' => $id,
            'asunto' => $asunto,
            'descripcion' => $descripcion

            );
        $this->db->insert('reclamos', $data);
        $mail = 'hernanquatraro@gmail.com';
        $this->mail_reclamo($mail, $local, $asunto, $descripcion);

       //return $query;
    }

    function ver_reclamos()
    {
      	$id = $this->session->s_idusuario;
        $this->db->select('*');
        $this->db->from('reclamos');
        $this->db->where('idusuario', $id);
        $query=$this->db->get();
        $data=$query->result_array();
        return $data;
    }

    public function mail_reclamo($correo, $local, $asunto, $descripcion) {
      $this->email->from('pedidoslomasddns@gmail.com', 'pedidoslomasddns@gmail.com');
      $this->email->to($correo);
      $this->email->subject($asunto);
      $this->email->message('<h2> El local de ' . $local . ', ingresó un reclamo.</h2><hr><br><br>
      El reclamo es el siguiente: <br> <BR>' . $descripcion .'
      <BR> <BR> <br> <hr> <B>Solucionar a la brevedad.</B>
      <br> http://pedidoslomas.ddns.net <br>');
      $this->email->send();
    }

}
