<?php

class Estadisticas_model extends CI_Model
{
   public function usuarios(){
     $usuarios = $this->db->get('usuarios');
     //si existe más de una fila
     if($usuarios->num_rows() > 0)
       {
        return $usuarios->result();
        }

    }
    public function locales() {

      $this->db->select('idUsr, empresa');
      $this->db->from('usuarios');
      $this->db->where('Nivel_acceso', 0);
      $query=$this->db->get();
      $data= $query->result();
      return $data;
    }

    public function kilosporlocal($id)
    {
        $this->db->select('*');
        $this->db->from('pedidos');
        $this->db->join('detalle_pedido','pedidos.id = detalle_pedido.id_pedido');
        $this->db->join('articulos', 'detalle_pedido.id_articulo = articulos.idArt');
        $this->db->where('id_usuario', $id);
        $query=$this->db->get();
        $data= $query->result();
        $kilos=0;
        foreach ($data as $value) {
        $suma = $value->cantidad * $value->kilos;
           $kilos += $suma;
        }

        return $kilos;

    }

    public function graficarkilos()
    {
        $locales = $this->locales();

        foreach ($locales as $local) {
          $id = $local->idUsr;
          $array[] = array(  // Va cargando los datos de los productos seleccionados en un array
  													'idLocal' => $id,
  													'local' => $local->empresa,
  													'kilos' => $this->kilosporlocal($id)
  			 										);

        }

        return $array;

    }

    public function totalkilos()
    {
      $this->db->select('SUM(kilos)');
      $this->db->from('produccion');
      $lecturas = $this->db->get();
      $datos = $lecturas->result_array();
      foreach ($datos as $key) {
      $data = $key['SUM(kilos)'];
      }

      return $data;
    }

     public function totallecturas()
     {
       $total = $this->db->count_all('mqtt');
       return $total;
     }

     public function proximaentrega()
     {
       $numerodia = date('w');
       switch ($numerodia) {
         case '6':
           // sabado, próximo pedido lunes
           $fecha_actual = date("d-m-Y");
           $proximaentrega = date("d-m-Y",strtotime($fecha_actual."+ 2 days"));
           //$this->proximaentrega($proximaentrega); // Falta crear la función
           break;

           case '0':
           // domingo, próximo pedido lunes
           $fecha_actual = date("d-m-Y");
           $proximaentrega = date("d-m-Y",strtotime($fecha_actual."+ 1 days"));
           //$this->proximaentrega($proximaentrega); // Falta crear la función
           break;
           case '5':
           // viernes, próximo pedido lunes
           $fecha_actual = date("d-m-Y");
           $proximaentrega = date("d-m-Y",strtotime($fecha_actual."+ 3 days"));
           //$this->proximaentrega($proximaentrega); // Falta crear la función
           break;
           case '1':
           // lunes, próximo pedido miercoles
           $fecha_actual = date("d-m-Y");
           $proximaentrega = date("d-m-Y",strtotime($fecha_actual."+ 2 days"));
           //$this->proximaentrega($proximaentrega); // Falta crear la función
           break;
           case '2':
           // martes, próximo pedido miercoles
           $fecha_actual = date("d-m-Y");
           $proximaentrega = date("d-m-Y",strtotime($fecha_actual."+ 1 days"));
           //$this->proximaentrega($proximaentrega); // Falta crear la función
           break;
           case '3':
           // miercoles, próximo pedido viernes
           $fecha_actual = date("d-m-Y");
           $proximaentrega = date("d-m-Y",strtotime($fecha_actual."+ 2 days"));
           //$this->proximaentrega($proximaentrega); // Falta crear la función
           break;
           case '4':
           // jueves, próximo pedido viernes
           $fecha_actual = date("d-m-Y");
           $proximaentrega = date("d-m-Y",strtotime($fecha_actual."+ 1 days"));
           //$this->proximaentrega($proximaentrega); // Falta crear la función
           break;

       }

       return $proximaentrega;

     }

}
