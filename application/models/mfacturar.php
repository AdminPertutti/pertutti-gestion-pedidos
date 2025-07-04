<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mfacturar extends CI_Model
{
public function checkip(){

         $ip="mi.ip.";
         $new_ip=$this->mprocesar->get_client_ip();
         if ($new_ip==$ip){
           return true;
         } else {
           return false;
         }


  }

public function localesafacturar() {

  $this->db->select('idUsr, empresa, Nombre_Completo, telefono, usuario');
  $this->db->distinct();
  $this->db->from('pedidos');
  $this->db->join('usuarios','pedidos.id_usuario = usuarios.idUsr', 'left');
  $this->db->where('facturado', 0);
  $this->db->where('enviado', 1);
  $this->db->where('Nivel_acceso', 0);
  $query=$this->db->get();
  $data= $query->result();
  return $data;

}

public function pedidosporempresa($id)
{
    $this->db->select('*');
    $this->db->from('pedidos');
    //$this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
    //$this->db->join('articulos', 'detalle_pedido.id_articulo = articulos.idArt');
    $this->db->where('id_usuario', $id);
    $this->db->where('enviado', 1);
    $this->db->where('facturado', 0);
    $this->db->where('json is NOT NULL', NULL, FALSE);
    //$this->db->order_by('pedidos.id','DESC');
    $query=$this->db->get();
    $data= $query->result();
    return $data;
}

public function articulo($argumento, $id)
{
$this->db->select($argumento);
$this->db->from('articulos');
$this->db->where('idArt', $id);
$this->db->order_by('categoria', 'ASC');
//$this->db->join('categoria','articulos.categoria = categoria.idCategoria');
$query=$this->db->get();
$data= $query->row();
return $data->$argumento;

} //endfunction



public function facturasrealizadas()
{
    $this->db->select('*');
    $this->db->from('facturacion');
    $query=$this->db->get();
    $data= $query->result();
    return $data;
}

public function factura_pedidos($datos, $empresa, $id)
{
  $total = 0;
  $totallogistica = 0;

  foreach ($datos as $key)
  {
  $subtotal = $key->importe_produccion * $key->cantidad;
  $total += $subtotal;
  $subtotallogistica = $key->importe_envio * $key->cantidad;
  $totallogistica += $subtotallogistica;

 // ***************************************************** //
 // Aca se procesa cada uno de los pedidos y se los marca como facturados
$this->factura_pedido_porid($key->id_pedido);


  }
// $total de facturación !!

  // FALTA TERMINAR ESTA FUNCION
  //var_dump($datos);
  $datosJSON = json_encode($datos);
  $numero_factura = $this->carga_facturacion($id, $empresa, $datosJSON, $total, $totallogistica);
  return $numero_factura;

}

public function factura_pedidos_new($datos, $empresa, $id)
{
  $total = 0;
  $totallogistica = 0;

  foreach ($datos as $key)
  {
  $subtotal = $key->importe_produccion * $key->cantidad;
  $total += $subtotal;
  $subtotallogistica = $key->importe_envio * $key->cantidad;
  $totallogistica += $subtotallogistica;

 // ***************************************************** //
 // Aca se procesa cada uno de los pedidos y se los marca como facturados
$this->factura_pedido_porid($key->id_pedido);


  }
// $total de facturación !!

  // FALTA TERMINAR ESTA FUNCION
  //var_dump($datos);
  $datosJSON = json_encode($datos);
  $numero_factura = $this->carga_facturacion($id, $empresa, $datosJSON, $total, $totallogistica);
  return $numero_factura;

}

public function carga_facturacion($id, $empresa, $datos, $total, $totallogistica)
{
  date_default_timezone_set ('America/Argentina/Buenos_Aires');
  $hoy = date("y/m/d h:m:s");
  $data = array(
        'fecha_facturacion' => $hoy,
        'id_local' => $id,
        'nombre_local' => $empresa,
        'detalle' => $datos,
        'pdf' => "",
        'total_produccion' => $total,
        'total_logistica' => $totallogistica
);
$this->db->insert('facturacion', $data);
$numero_factura = $this->db->insert_id();
return $numero_factura;
}

public function actualiza_pdf($id, $pdf)
{
  $this->db->set('pdf', $pdf);
  $this->db->where('idFact', $id);
  $this->db->update('facturacion');
}

public function factura_pedido_porid($id_pedido){
  date_default_timezone_set ('America/Argentina/Buenos_Aires');
  $hoy = date("y/m/d h:m:s");
  $this->db->set('facturado', 1);
  $this->db->set('fechafacturado', $hoy);
  $this->db->where('id', $id_pedido);
  $this->db->update('pedidos');
}
public function get_client_ip() {
  if (isset($_SERVER["HTTP_CLIENT_IP"])){

      return $_SERVER["HTTP_CLIENT_IP"];

  }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){

      return $_SERVER["HTTP_X_FORWARDED_FOR"];

  }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){

      return $_SERVER["HTTP_X_FORWARDED"];

  }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){

      return $_SERVER["HTTP_FORWARDED_FOR"];

  }elseif (isset($_SERVER["HTTP_FORWARDED"])){

      return $_SERVER["HTTP_FORWARDED"];

  }else{

      return $_SERVER["REMOTE_ADDR"];

  }
    }


    public function mail_pedidofacturado($correo, $local, $descripcion) {
      $this->email->from('Pedidos Lomas', 'pedidoslomas.ddns.com');
      $this->email->to($correo);
      //super importante, para poder envíar html en nuestros correos debemos ir a la carpeta
      //system/libraries/Email.php y en la línea 42 modificar el valor, en vez de text debemos poner html
      $this->email->subject('Pedido en producción');
      $this->email->message('<h2>' . $local . ', se procesó su pedido y se envía a producción</h2><hr><br><br>
      Tu pedido es el siguiente: <br> <BR>' . $descripcion .'
      <BR> <BR> <br> <hr> <B>Gracias por realizar su pedido.</B>
      <br> http://pedidoslomas.ddns.net <br>');
      echo '<br> Enviando mail a ' . $correo;
      $this->email->send();
    }

    public function mail_a_wanted($correo, $total_kilos) {
      $this->email->from('Pedidos Lomas', 'pedidoslomas.ddns.com');
      $this->email->to($correo);
      //super importante, para poder envíar html en nuestros correos debemos ir a la carpeta
      //system/libraries/Email.php y en la línea 42 modificar el valor, en vez de text debemos poner html
      $this->email->subject('Orden de producción');
      $this->email->message('<h2>Se procesaron los pedidos, se envía orden de producción</h2><hr><br><br>
      Se requiere en total : <br> <BR>' . $total_kilos .' kilos de aderezo caesar
      <BR> <BR> <br> <hr> <B>Por favor avisar cuando se termine la producción para realizar el embolsado.</B>
      <br> Gracias !!!!!!
      <br> http://pedidoslomas.ddns.net <br>');
      echo '<br> Enviando mail a ' . $correo;
      $this->email->send();
    }
}
