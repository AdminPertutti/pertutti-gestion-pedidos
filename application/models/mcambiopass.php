<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcambiopass extends CI_Model
{
    public function cambiar_pass($id2, $activate2, $pass)
        {
            $data = array(
                                'estado' => 1,
                                'activate' => " ",
                                'password' => $pass
                          );
                  $this->db->where('usuario', $id2);
                  $this->db->where('activate', $activate2);
                  $resultado = $this->db->update('usuarios', $data);
                  // ACTUALIZA EL PASSWORD Y BORRA LA CLAVE DE ACTIVATE PARA QUE
                  // NO SE PUEDA UTILIZAR OTRA VEZ.
                  if ($resultado == 1){
                  return 1;

                } else { return 0; }



        }

        public function verifica_cuenta($id, $activate)
        {
           $this->db->select('*');
           $this->db->from('usuarios');
           $this->db->where('activate', $activate);
           $this->db->where('usuario', $id);
           $query = $this->db->get();

           if($query->num_rows() > 0 )
           {
               return 1;
           } else { return 0;}

        }
}
