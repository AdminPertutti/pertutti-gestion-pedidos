<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pedidos_model extends CI_Model
{
  public function borrarpedido($id) {
    $this->db->where('id', $id);
    $this->db->delete('pedidos');
    $this->db->where('id_pedido', $id);
    $this->db->delete('detalle_pedido');


  }
  public function modificar($id_pedido, $id_articulo, $cantidad) {
    $this->db->where('id_pedido', $id_pedido);
    $this->db->where('id_articulo', $id_articulo);
    $resultado = $this->db->update('detalle_pedido', array('cantidad' => $cantidad));
    echo $resultado;

  }
  public function enviarpedido($id_pedido) {
    date_default_timezone_set ('America/Argentina/Buenos_Aires');
    $hoy = date("Y-m-d H:i:s");
    $data = array(
        'enviado' => 1,
        'fechaenviado' => $hoy
    );
    $this->db->where('id', $id_pedido);
    $this->db->update('pedidos', $data);

    //Ver que local hizo el pedido para enviar mails
    $this->db->select('*');
    $this->db->from('pedidos');
    $this->db->where('id', $id_pedido);
    $query=$this->db->get();
    $data=$query->result();
    // 
    foreach ($data as $columna1) {
    $local = $columna1->id_usuario;
    }

    $this->db->select('*');
    $this->db->from('usuarios');
    $this->db->where('idUsr', $local);
    $query2=$this->db->get();
    $data2= $query2->result();
    // 
    foreach ($data2 as $columna2) {
      $correo = $columna2->usuario;
      $nombre = $columna2->empresa;
    }



    $this->pedidoenviado_mail($correo, $nombre);

  }


  public function listaarticulos()
  {
  $this->db->select('*');
  $this->db->from('articulos');
  $this->db->where('categoria', 0);
  $query=$this->db->get();
  $data= $query->result_array();
  return $data;
  } //endfunction
  public function ultimoarticulo()
  {
  $this->db->select('*');
  $this->db->from('articulos');
  $this->db->limit(1);
  $this->db->order_by('idArt', 'DESC');
  $query=$this->db->get();
  $data= $query->result_array();
  return $data;
} //endfunction

  public function pedidoenviado_mail($correo, $nombre)
  {

        $this->email->from('Pedidos', 'pedidoslomasddns@gmail.com');
        $this->email->to($correo);
        $this->email->subject('Envío de pedido');
        $this->email->message('<h2>' . $nombre . ', se ha enviado su pedido. </h2><hr><br><br>
        Debería estar recibiendolo en el transcurso del día de mañana.
        <BR> <BR>
        <BR> <BR> <br> <hr> <B>Gracias por realizar su pedido.</B>
        <br> http://pedidoslomas.ddns.net <br>');

        $this->email->send();

  }

  public function ultimospedidosporempresa()
  {
      $id = $this->session->s_idusuario;
      $this->db->select('*');
      $this->db->from('pedidos');
      $this->db->limit(5);
      //$this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
      $this->db->where('id_usuario',$id);
      $this->db->order_by('pedidos.id','DESC');
      $query=$this->db->get();
      $data= $query->result_array();
      //
      return $data;
  }

  public function ultimospedidossinprocesar()
  {
      $this->db->select('*');
      $this->db->from('pedidos');
      $this->db->limit(10);
      //$this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
      $this->db->where('procesado', 0);
      $this->db->order_by('pedidos.id','DESC');
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
  }

  public function ultimospedidosparaver()
  {
      $this->db->select('*');
      $this->db->from('pedidos');
      $this->db->limit(15);
      //$this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
      $this->db->order_by('pedidos.id','DESC');
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
  }

  public function ultimospedidossinprocesarporid()
  {
      $id = $this->session->s_idusuario;
      $this->db->select('*');
      $this->db->from('pedidos');
      $this->db->limit(5);
      $this->db->where('procesado', 0);
      $this->db->where('id_usuario', $id);
      $this->db->order_by('pedidos.id','DESC');
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
  }

  public function ultimospedidos()
  {
  		$id = $this->session->s_idusuario;
  		$this->db->select('*');
  		$this->db->from('pedidos');
      $this->db->limit(10);
  		$this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
  		$this->db->order_by('pedidos.id','DESC');
  		$query=$this->db->get();
  		$data= $query->result_array();
  		//
      return $data;
  }

  public function listalocales()
  {
  		$this->db->select('idUsr, empresa, Nivel_acceso');
  		$this->db->from('usuarios');
      $this->db->where('Nivel_acceso', 0);
      $this->db->where('estado', 1);
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

public function cargarpedido($cantidad1, $cantidad2, $detalle)
  {
    if ($this->session->logged_in == TRUE) {
    date_default_timezone_set ('America/Argentina/Buenos_Aires');
    $hoy = date("Y-m-d H:i:s");
    $datosJSON = json_encode($detalle);
    $data = array(
                  'id_usuario' => $this->session->s_idusuario,
                  'fecha' => $hoy,
                  'local' => $this->session->s_local,
                  'procesado' => 0,
                  'enviado' => 0,
                  'facturado' => 0,
                  'json' => $datosJSON
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
  } else  return false;
    }

    public function listadetallepedidos()
    {
        $this->db->select('*');
        $this->db->from('reposicion');
        $this->db->limit(5);
        $this->db->order_by('idRepo', 'DESC');
        $query=$this->db->get();
        $data= $query->result_array();
        return $data;
    }

    public function articulo($id)
    {
    $this->db->select('*');
    $this->db->from('articulos');
    $this->db->where('idArt', $id);
  //  $this->db->order_by('categoria', 'ASC');
    $query=$this->db->get();
    $data= $query->result_array();
    foreach ($data as $datos) {
      return $datos;
    }
  }


    public function detalle_pedidos($datos)
    {
      //TODO: Separar los datos de las comandas por sectores automaticamente
      //TODO: Ver tabla de reposiciones con horario y poder reimprimir

      $comanda = "";
      $array = JSON_decode($datos, true);
      foreach ($array as $key)
        {
        $codigo = $key['codigo'];
        $detalle = $this->pedidos_model->articulo($codigo);
        $cantidad = $key['cantidad'];
        $comanda .= "<br>" .$cantidad ." x ";
        $comanda .= $detalle['nombre'];
        } //endfoeach
        return $comanda;

    } //endfunction

    public function cargapedidolocal($cantidad1, $cantidad2, $observaciones, $local, $idusuario)
      {
        if ($this->session->logged_in == TRUE) {
        date_default_timezone_set ('America/Argentina/Buenos_Aires');
        $hoy = date("Y-m-d H:i:s");
        $datosJSON = json_encode($observaciones);
        $data = array(
                      'id_usuario' => $idusuario,
                      'fecha' => $hoy,
                      'local' => $local,
                      'procesado' => 0,
                      'enviado' => 0,
                      'facturado' => 0,
                      'Json' => $datosJSON
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
        if ($cantidad2 == 0 && $cantidad2 == 0) {
        $data = array(
                      'id_pedido' => $numero_pedido,
                      'cantidad' => 0,
                      'id_articulo' => 1,
                      'descripcion' => "Aderezo 4KG"
        );
        $this->db->insert('detalle_pedido', $data);
      }

        return $numero_pedido;
      } else  return false;
        }
}
