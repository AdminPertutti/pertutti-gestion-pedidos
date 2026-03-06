<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reposicion_model extends CI_Model
{
  public function listacategorias()
  {
      $this->db->select('*');
      $this->db->from('categoria');
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
  }

  public function listasectores()
  {
      $this->db->select('*');
      $this->db->from('sector');
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
  }

  public function listareposicion()
  {
      $this->db->select('*');
      $this->db->from('reposicion');
      $this->db->limit(5);
      $this->db->order_by('idRepo', 'DESC');
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
  }

  public function prepara_reposicion($datos)
  {
    $comanda = "";
    $cant_sectores = $this->reposicion_model->cant_sectores();
    for ($i=1; $i <= $cant_sectores; $i++) {
    $datos_sec = "datos_sector" .$i;
    $$datos_sec = array_filter( $datos, function( $e ) use ($i) {
        return $e['sector'] == $i;
    });
    } //endfor

    for ($i=1; $i <= $cant_sectores; $i++) {
    $datos_sec = "datos_sector" .$i;
      foreach ($$datos_sec as $key)
      {
      $codigo = $key['codigo'];
      $detalle = $this->reposicion_model->articulo($codigo);
      $sector = $key['sector'];
      $cantidad = $key['cantidad'];
      $comanda .= "\n" .$cantidad ." x ";
      $comanda .= $detalle['nombre'];
      } //endfoeach
      if ($comanda != "") {
        $ruta_base = $this->reposicion_model->impresora($sector);

        // Si la ruta termina en \ o / es una carpeta: generar nombre único con timestamp
        if (substr($ruta_base, -1) === '\\' || substr($ruta_base, -1) === '/') {
          $nombre_archivo = "comanda_" . date("dmY_His") . ".txt";
          $impresora = rtrim($ruta_base, '\\/') . DIRECTORY_SEPARATOR . $nombre_archivo;
        } else {
          $impresora = $ruta_base; // Ruta completa con nombre de archivo explícito
        }

        try {
          $this->receiptprint->connect($impresora);
          $this->receiptprint->imprimir_comanda($comanda);
        } catch (Exception $e) {
          log_message('error', 'Error al generar comanda sector ' . $sector . ': ' . $e->getMessage() . ' | Ruta: ' . $impresora);
        }
      } //endif
      $comanda = ""; // pone la comanda en cero de vuelta
    } //endfor
  } //endfunction


      public function listaarticulos()
      {
      $this->db->select('*');
      $this->db->from('articulos');
      $this->db->order_by('categoria', 'ASC');
      $this->db->join('categoria','articulos.categoria = categoria.idCategoria');
      $this->db->where('activo', 1);
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
      }
      public function ultimoarticulo()
      {
      $this->db->select('*');
      $this->db->from('articulos');
      $this->db->limit(1);
      $this->db->order_by('idArt', 'DESC');
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
      }
      public function listadoarticulos()
      {
      $this->db->select('*');
      $this->db->from('articulos');
      $this->db->join('categoria','articulos.categoria = categoria.idCategoria');
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
      }


      public function articulo($id)
      {
      $this->db->select('*');
      $this->db->from('articulos');
      $this->db->where('idArt', $id);
      $this->db->order_by('categoria', 'ASC');
      $this->db->join('categoria','articulos.categoria = categoria.idCategoria');
      $query=$this->db->get();
      $data= $query->result_array();
      foreach ($data as $datos) {
        return $datos;
      }
      }
    public function impresora($id) // Devuelve el nombre de la impresora del sector
    {
    $this->db->select('impresora');
    $this->db->from('sector');
    $this->db->where('idSector', $id);
    $query=$this->db->get();
    $data= $query->result_array();
    foreach ($data as $datos) {
        return $datos['impresora'];
    }
  } //endfunction

      public function busca_reposicion($id)
      {
        $this->db->select('detalle');
        $this->db->from('reposicion');
        $this->db->where('idRepo', $id);
        $query=$this->db->get();
        $data= $query->result_array();
        foreach ($data as $datos) {
            return JSON_decode($datos['detalle'], true);
        }
      } //endfunction

      public function carga_reposicion($datos)
      {
        {
          date_default_timezone_set ('America/Argentina/Buenos_Aires');
          $datosJSON = json_encode($datos);
          $hoy = date("Y-m-d H:i:s");
          $data = array(
                'fecha_repo' => $hoy,
                'id_usuario' => $this->session->s_idusuario,
                'local' => $this->session->s_local,
                'detalle' => $datosJSON

        );
        $this->db->insert('reposicion', $data);
        $numero_repo = $this->db->insert_id();
        return $numero_repo;
        }
      }
      public function detalle_reposicion($datos)
      {
        //TODO: Separar los datos de las comandas por sectores automaticamente
        //TODO: Ver tabla de reposiciones con horario y poder reimprimir

        $comanda = "";
        $array = JSON_decode($datos, true);
        if (is_array($array)) {
            foreach ($array as $key)
            {
                $codigo = isset($key['codigo']) ? $key['codigo'] : 0;
                $detalle = $this->reposicion_model->articulo($codigo);
                $sector = isset($key['sector']) ? $key['sector'] : 0;
                $cantidad = isset($key['cantidad']) ? $key['cantidad'] : 0;
                
                // Si el articulo fue eliminado, $detalle puede ser null
                if ($detalle && is_array($detalle)) {
                    $nombre_articulo = isset($detalle['nombre']) ? $detalle['nombre'] : 'Desconocido';
                } else {
                    $nombre_articulo = 'Articulo #' . $codigo;
                }
                
                // Asegurar UTF-8 para evitar que json_encode() trunque la cadena
                $nombre_articulo = mb_convert_encoding($nombre_articulo, 'UTF-8', 'auto');
                
                $comanda .= "<br>" .$cantidad ." x " . $nombre_articulo;
            } //endfoeach
        }
        return $comanda;

      } //endfunction

      public function sectores()
      {
      $this->db->select('*');
      $this->db->from('sector');
      $query=$this->db->get();
      $data= $query->result_array();
      return $data;
      }

      public function cant_sectores()
      {
      $this->db->select('*');
      $this->db->from('sector');
      $query=$this->db->get();
      $data= $query->num_rows();
      return $data;
      }


}
