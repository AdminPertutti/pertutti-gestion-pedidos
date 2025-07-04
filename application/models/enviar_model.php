<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Enviar_model extends CI_Model
{
  public function borrarpedido($id) {
    if ($this->session->logedin == TRUE) {
    $this->db->where('id', $id);
    $this->db->delete('pedidos');
    $this->db->where('id_pedido', $id);
    $this->db->delete('detalle_pedido');

  }
  }
  public function ultimospedidosporempresa()
  {
  		$id = $this->session->s_idusuario;
  		$this->db->select('*');
  		$this->db->from('pedidos');
      $this->db->limit(5);
  		$this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
  		$this->db->where('id_usuario',$id);
      $this->db->order_by('pedidos.id','DESC');
  		$query=$this->db->get();
  		$data= $query->result_array();
  		//var_dump($data);
      return $data;
  }

  public function ultimospedidos()
  {
  		$id = $this->session->s_idusuario;
  		$this->db->select('*');
  		$this->db->from('pedidos');
      $this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
  		$this->db->order_by('pedidos.id','DESC');
  		$query=$this->db->get();
  		$data= $query->result_array();
  		return $data;
  }
public function checkpendientes(){
  $id = $this->session->s_idusuario;
  $this->db->select('*');
  $this->db->from('pedidos');
  $this->db->limit(10);
  $this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
  $this->db->order_by('pedidos.id','DESC');
  $this->db->where('id_usuario',$id);
  $this->db->where('procesado', 0);
  $query=$this->db->get();
  $data= $query->result_array();
  //var_dump($data);
  if ($query->num_rows() > 0) {
  return true;
  } else {
  return false;
  }
}
public function totalpendientes(){
  $id = $this->session->s_idusuario;
  $this->db->select('*');
  $this->db->from('pedidos');
  $this->db->limit(10);
  $this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
  $this->db->order_by('pedidos.id','DESC');
  $this->db->where('id_usuario',$id);
  $this->db->where('procesado', 0);
  $query=$this->db->get();
  $data= $query->result_array();
  //var_dump($data);
  if ($query->num_rows() > 0) {
  return $query->num_rows();
  } else {
  return 0;
  }
}

public function cargarpedido($cantidad1, $cantidad2, $observaciones)
  {
    if ($this->session->logedin == TRUE) {
    date_default_timezone_set ('America/Argentina/Buenos_Aires');
    $hoy = date("y/m/d h:m:s");
    $data = array(
                  'id_usuario' => $this->session->s_idusuario,
                  'fecha' => $hoy,
                  'local' => $this->session->s_local,
                  'procesado' => 0,
                  'enviado' => 0,
                  'facturado' => 0,
                  'observaciones' => $observaciones
    );


    $this->db->insert('pedidos', $data);
    $numero_pedido = $this->db->insert_id();



    if ($cantidad1 != 0) {
    $data = array(
                  'id_pedido' => $numero_pedido,
                  'cantidad' => $cantidad1,
                  'id_articulo' => 1,
                  'descripcion' => "Aderezo 4KG"
    );
    $this->db->insert('detalle_pedido', $data);
    }
    if ($cantidad2 != 0) {
    $data = array(
                  'id_pedido' => $numero_pedido,
                  'cantidad' => $cantidad2,
                  'id_articulo' => 2,
                  'descripcion' => "Aderezo 2KG"
    );
    $this->db->insert('detalle_pedido', $data);
    }
    return $numero_pedido;
    }
  }
}
