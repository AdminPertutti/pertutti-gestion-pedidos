<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mprocesar extends CI_Model
{

  public function articulo($id)
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


public function pedidossinprocesar()
{
  $this->db->select('*');
  $this->db->from('pedidos');
  $this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
  $this->db->join('articulos','detalle_pedido.id_articulo = articulos.idArt');
  $this->db->join('usuarios','pedidos.id_usuario = usuarios.idUsr');
  $this->db->order_by('pedidos.id','DESC');
  $this->db->where('procesado', 0);
  $query=$this->db->get();
  $data= $query->result_array();
  return $data;
}

public function detalle_pedido($datos) // nueva funcion para procesar las comandas de los nuevos productos
{
  //TODO: Separar los datos de las comandas por sectores automaticamente
  //TODO: Ver tabla de reposiciones con horario y poder reimprimir

  $comanda = "";
  $array = JSON_decode($datos, true);
  foreach ($array as $key)
    {
    $codigo = $key['codigo'];
    if( $codigo > 2 ) { // Para que no vuelva a procesar los aderezos solo lo que viene después
    $detalle = $this->mprocesar->articulo($codigo);
    $cantidad = $key['cantidad'];
    $comanda .= "\n" .$cantidad ." x ";
    $comanda .= $detalle['nombre'];
    } // end if
    } //endfoeach
    if ($codigo >2) {
      return $comanda;
    } else {
      return 0;
    }

} //endfunction


public function procesar($mail) {
  $this->db->select('*');
  $this->db->from('pedidos');
  $this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
  $this->db->join('articulos','detalle_pedido.id_articulo = articulos.idArt');
  $this->db->join('usuarios','pedidos.id_usuario = usuarios.idUsr');
  $this->db->order_by('pedidos.id','DESC');
  $this->db->where('procesado', 0);
  $query=$this->db->get();
  $data= $query->result_array();

  $this->db->select('*');
  $this->db->from('pedidos');
  $this->db->join('usuarios','pedidos.id_usuario = usuarios.idUsr');
  $this->db->where('procesado', 0);
  $query2=$this->db->get();
  $data2 = $query2->result();
  $suma_kilos = 0;
  $remito = "";
            foreach ($query2->result() as $resulta) {
              $pedido = $resulta->id;
              $this->db->select('*');
              $this->db->from('detalle_pedido');
              $this->db->where('id_pedido', $pedido);
              $query3=$this->db->get();
              $data3 = $query3->result();
              $remito .= "Numero de  pedido ";
              $remito .= $pedido . "\n";
              $detalle_pedido_mail = "";
              $detalle_remito = "";

                  foreach ($data3 as $columna) {
                    $cantidad = $columna->cantidad;
                    if ($cantidad != 0) {
                    $desc = $columna->descripcion;
                    $detalle_pedido_mail .= $cantidad . " bolsas de " . $desc . " <BR>";
                    $detalle_remito .= $cantidad . " bolsas de " . $desc . "\n";
                  }
                    }

                    // VERIFICAR FUNCIONAMIENTO
                    // agregar impresion de comandas de productos adicionales
                    $datos_pedido = $resulta->json;
                    $comanda = $this->detalle_pedido($datos_pedido);
                    if ($comanda != 0) {
                    $comanda1 = "LOCAL:  " .$resulta->local;
                    $comanda1 .= $comanda;
                     // falta configurar para la impresión


                    $numero = date("dmyhis");
                    $filename = "c:\imprimir/local/"."imprimir".strval($numero).".txt";
                    $this->receiptprint->connect($filename); //Conectando a la impresora
                    $this->receiptprint->imprimir_pedido($comanda1); //Llama a la función para imprimir imprimir_remito

                    $remito .= "\n**** PEDIDO ESPECIAL ****";
                    $remito .= "\n";
                    $remito .= " \n";
                    $remito .= $comanda;
                    $remito .= " \n";
                    $remito .= "------------------ \n";
                    sleep(2); //Pausa de 2 segundos
                    }
                    // VERIFICAR FUNCIONAMENTO



                  $remito .= "LOCAL:  " .$resulta->local;
                  $remito .= "\n";
                  $remito .= " \n";
                  $remito .= $detalle_remito;
                  $remito .= " \n";
                  $remito .= "------------------ \n";
                  echo "<br> Detalle <br>";
                  echo $detalle_pedido_mail;
                  if ($mail) $this->mail_pedidoprocesado($resulta->usuario, $resulta->empresa, $detalle_pedido_mail); // Envia mail al local del procesado del pedido
            }

  if ($query->num_rows() > 0) {
    foreach ($query->result() as $row)
    {
          $cantidad = $row->cantidad;
          $kilos = $row->kilos;
          $total_kilos = $cantidad * $kilos;
          $usuario = $row->id_usuario;
          $local = $row->empresa;
          // Aca abrir impresora
          $numero = date("dmyhis");
          $filename = "c:\imprimir/local/"."imprimir".strval($numero).".txt";
          $this->receiptprint->connect($filename); //Conectando a la impresora
          $this->receiptprint->abrir_conexion();
              for ($i=0; $i < $cantidad; $i++)
              {
              $cant = $i + 1;
              $texto1 = "BOLSA ".$cant." DE ".$cantidad;
              $texto2 = $row->descripcion; //descripcion del artículo
            $this->receiptprint->imprimir_etiquetas($local, $texto1, $texto2); //Llama a la función para imprimir imprimir_etiquetas

            echo $local;
            echo "<br>";
            echo $texto1;
            echo "<br>";
            echo $texto2;
            echo "<br>";

              }
              // Aca cerrar y grabar el archivo
              $this->receiptprint->cerrar_conexion();
              sleep(5);

              $suma_kilos = $suma_kilos + $total_kilos;
      }



  } else  {

    echo "<br> Sin pedidos para procesar ... :) <BR>";

    return false;
  }


  // SE AGREGA ACA PARA PROCESAR LOS OTROS PRODUCTOS NUEVOS



  // **************** FIN MODIFICACIÓN //

                    echo "<BR> TOTAL GENERAL DE KILOS ". $suma_kilos;  // Este total hay que pasarlo por mail a Wanted para producción

                    //$correo_wanted = "gutierrezmarioantonio3@gmail.com"; // Ver para tomar este mail desde la base de datos
                    //if ($mail) $this->mail_a_wanted($correo_wanted, $suma_kilos);
                    $correo_hernan = "hernanquatraro@gmail.com";
                    if ($mail) $this->mail_a_wanted($correo_hernan, $suma_kilos);
                    $correo_juan = "wantedlomas@gmail.com";
                    if ($mail) $this->mail_a_wanted($correo_juan, $suma_kilos);

                    echo "*******   REMITO   ****** <BR>";
                    $remito .= "TOTAL DE KILOS: ";
                    $remito .= $suma_kilos;
                    $remito .= "\n";
                    $remito .= " \n";


                    foreach ($query2->result() as $resulta)
                        {  //carga el detalle de los pedidos que se procesaron
                        $pedido = $resulta->id;
                        $local = $resulta->local;
                        $array[] = array(  // Va cargando los datos de los productos seleccionados en un array
                													'codigo' => $pedido,
                													'local' => $local
                			 										);
                        }
                   $numero_carga = $this->carga_produccion($suma_kilos, $array); // Carga los kilos de producción en la base de datos.



                    sleep(1);
                    $numero = date("dmyhis");
                    $filename = "c:\imprimir/local/"."imprimir".strval($numero).".txt";
                    $this->receiptprint->connect($filename); //Conectando a la impresora
                    $this->receiptprint->imprimir_remito($remito); //Llama a la función para imprimir imprimir_remito
                    sleep(5); //Pausa de 2 segundos
                    $numero = date("dmyhis");
                    $filename = "c:\imprimir/local/"."imprimir".strval($numero).".txt";
                    $this->receiptprint->connect($filename); //Conectando a la impresora
                    $this->receiptprint->imprimir_remito($remito); //Llama a la función para imprimir imprimir_remito
                    $remitomail = str_replace("\n", "<BR>", $remito);
                    $correo_panaderia = "lasegundasanmartin@pertuttiresto.com.ar";
                    if ($mail) $this->mail_remito($correo_hernan, $remitomail); //Enviar remito por mail
                    $this->procesa_pedidos(); // Procesar pedidos y marcarlos como procesados (agregar fecha de procesado)


                    echo $remitomail;
                    // OK: enviar mails a los locales que hicieron pedidos para confirmar que se están produciendo los aderezos

}
public function procesa_pedidos()
{
      date_default_timezone_set ('America/Argentina/Buenos_Aires');
      $hoy = date("y/m/d h:m:s");
      $this->db->set('procesado', 1);
      $this->db->set('fechaprocesado', $hoy);
      $this->db->where('procesado', 0);
      $this->db->update('pedidos');

}
public function ultimo_procesado()
{
$row = $this->db->select("*")->limit(1)->order_by('idProduccion',"DESC")->get("produccion")->row();
return JSON_decode($row->observaciones);
}

public function prepara_reimpresion()
{
//falta armar esta funcion
$row = $this->db->select("*")->limit(1)->order_by('idProduccion',"DESC")->get("produccion")->row();
$procesado = JSON_decode($row->observaciones);
  foreach ($procesado as $dato)
  {
   $id = $dato->codigo;
   $this->db->set('procesado', 0);
   $this->db->where('id', $id);
   $this->db->update('pedidos');
  }
}

public function carga_produccion($total_kilos, $array) {
  date_default_timezone_set ('America/Argentina/Buenos_Aires');
  $hoy = date("y/m/d h:m:s");
  $datosJSON = json_encode($array);
  $data = array(
      'kilos' => $total_kilos,
      'fecha' => $hoy,
      'observaciones' => $datosJSON
      );
  $this->db->insert('produccion', $data);
  $numero_carga = $this->db->insert_id();
  return $numero_carga;

}


    public function mail_pedidoprocesado($correo, $local, $descripcion) { //Para enviar mail a local por pedidos procesados
      $this->email->from('pedidoslomasddns@gmail.com', 'pedidoslomasddns@gmail.com');
      $this->email->to($correo);
      $this->email->subject('Pedido en producción');
      $this->email->message('<h2>' . $local . ', se procesó su pedido y se envía a producción</h2><hr><br><br>
      Tu pedido es el siguiente: <br> <BR>' . $descripcion .'
      <BR> <BR> <br> <hr> <B>Gracias por realizar su pedido.</B>
      <br> http://pedidoslomas.ddns.net <br>');
      echo '<br> Enviando mail a ' . $correo;
      // $this->email->send();
      if ($this->email->send()) {
    echo 'El correo ha sido enviado';
    } else {
    echo $this->email->print_debugger();
    }
    }

    public function mail_remito($correo, $remito) { //Para enviar mail a local por pedidos procesados
      $this->email->from('pedidoslomasddns@gmail.com', 'pedidoslomasddns@gmail.com');
      $this->email->to($correo);
      $this->email->subject('Aderezos en producción');
      $this->email->message('<h2> Se procesaron los pedidos y se envían a producción</h2><hr><br><br>
      El detalle de los pedidos de los locales es el siguiente: <br> <BR>' . $remito .'
      <BR> <BR> <br> <hr> <B>Con el camion de la tarde se enviarán estos productos para su distribución.</B>
      <br> http://pedidoslomas.ddns.net <br>');
      echo '<br> Enviando mail a ' . $correo;
      if ($this->email->send()) {
    echo 'El correo ha sido enviado';
    } else {
    echo $this->email->print_debugger();
    }
    }

    public function mail_a_wanted($correo, $total_kilos) { // Para enviar mail a producción con el total de kilos
      $this->email->from('pedidoslomasddns@gmail.com', 'pedidoslomasddns@gmail.com');
      $this->email->to($correo);
      $this->email->subject('Orden de producción');
      $this->email->message('<h2>Se procesaron los pedidos, se envía orden de producción</h2><hr><br><br>
      Se requiere en total : <br> <BR>' . $total_kilos .' kilos de aderezo caesar
      <BR> <BR> <br> <hr> <B>Por favor avisar cuando se termine la producción para realizar el embolsado.</B>
      <br> Gracias !!!!!!
      <br> http://pedidoslomas.ddns.net <br>');
      echo '<br> Enviando mail a ' . $correo;
      if ($this->email->send()) {
    echo 'El correo ha sido enviado';
    } else {
    echo $this->email->print_debugger();
    }
    }
}
