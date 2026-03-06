<?php

class Mlogin extends CI_Model
{
 public function ingresar($usu, $pass){
      $this->db->select('*');
      $this->db->from('usuarios');
      $this->db->where('usuario', $usu);
      $this->db->where('password', $pass);
      //$this->db->where('estado', 1);
      $resultado = $this->db->get();
      $row = $resultado->row();
      if ($resultado->num_rows() == 1){
        if ($row->estado == 1) {
        $r = $resultado->row();

        date_default_timezone_set ('America/Argentina/Buenos_Aires');
        $hoy = date("y/m/d h:m:s");
        //var_dump($r);
        $data = array(
                        'ultimo_login' => $hoy
                      );
        $this->db->where('usuario', $usu);
        $this->db->where('password', $pass);
        $this->db->update('usuarios', $data);

        // agregar el ingreso al Registro

        $data = array(
                      'id_usuario' => $row->idUsr,
                      'fecha' => $hoy,
                      'usuario' => $usu,
                      'observaciones' => "login"
        );
        $this->db->insert('registro_usuarios', $data);
        $id = $row->id;
        $this->db->select('*');
        $this->db->from('pedidos');
        $this->db->limit(10);
        $this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
        $this->db->order_by('pedidos.id','DESC');
        $this->db->where('id_usuario',$id);
        $this->db->where('procesado', 0);
        $query=$this->db->get();
        $datos= $query->result_array();
        $pendientes = $query->num_rows();
        //var_dump($data);
        $s_usuario = array(
          's_idusuario' => $r->idUsr,
          's_nombre' => $r->Nombre_Completo,
          's_usuario' => $r->usuario,
          's_id' => $r->id,
          's_local' => $r->empresa,
          's_pendientes' => $pendientes,
          's_nivel' => $r->Nivel_acceso,
          's_permisos' => $r->permisos,
          'logged_in' => TRUE
        );
          //var_dump($s_usuario);

          $this->session->set_userdata($s_usuario);
      return 1;
    } else { return 2; }

  } else {  //Eror al ingresar

    date_default_timezone_set ('America/Argentina/Buenos_Aires');
    $hoy = date("y/m/d h:m:s");
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = array(
                  'id_usuario' => '0',
                  'fecha' => $hoy,
                  'usuario' => $usu,
                  'observaciones' => $ip
    );
    $this->db->insert('registro_usuarios', $data);

      return 0;


    }
      }
      public function Salir()
      {
        if ($this->session->logged_in == TRUE) {
        date_default_timezone_set ('America/Argentina/Buenos_Aires');
        $hoy = date("y/m/d h:m:s");
        $data = array(
                      'id_usuario' => $this->session->s_idusuario,
                      'fecha' => $hoy,
                      'usuario' => $this->session->s_usuario,
                      'observaciones' => "logout"
        );
        $this->db->insert('registro_usuarios', $data);

      }
    }
}
