<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Obtener todos los proveedores
     */
    public function get_all_proveedores($activos_only = true)
    {
        if ($activos_only) {
            $this->db->where('activo', 1);
        }
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get('proveedores');
        return $query->result_array();
    }

    /**
     * Obtener un proveedor por ID con sus días de pedido
     */
    public function get_proveedor($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('proveedores');
        $proveedor = $query->row_array();
        
        if ($proveedor) {
            $proveedor['dias_pedido'] = $this->get_dias_pedido($id);
        }
        
        return $proveedor;
    }

    /**
     * Agregar nuevo proveedor
     */
    public function add_proveedor($data)
    {
        return $this->db->insert('proveedores', $data);
    }

    /**
     * Actualizar proveedor
     */
    public function update_proveedor($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('proveedores', $data);
    }

    /**
     * Eliminar proveedor (soft delete)
     */
    public function delete_proveedor($id)
    {
        return $this->update_proveedor($id, array('activo' => 0));
    }

    /**
     * Obtener días de pedido de un proveedor
     */
    public function get_dias_pedido($id_proveedor)
    {
        $this->db->where('id_proveedor', $id_proveedor);
        $this->db->order_by('dia_semana', 'ASC');
        $query = $this->db->get('proveedores_dias_pedido');
        return $query->result_array();
    }

    /**
     * Guardar días de pedido para un proveedor
     * $dias = array de arrays con 'dia_semana' y 'hora_limite'
     */
    public function save_dias_pedido($id_proveedor, $dias)
    {
        // Eliminar días existentes
        $this->db->where('id_proveedor', $id_proveedor);
        $this->db->delete('proveedores_dias_pedido');
        
        // Insertar nuevos días
        if (!empty($dias)) {
            foreach ($dias as $dia) {
                $data = array(
                    'id_proveedor' => $id_proveedor,
                    'dia_semana' => $dia['dia_semana'],
                    'hora_limite' => $dia['hora_limite']
                );
                $this->db->insert('proveedores_dias_pedido', $data);
            }
        }
        
        return true;
    }

    /**
     * Obtener proveedores que tienen recordatorio para hoy
     */
    public function get_proveedores_con_recordatorio()
    {
        $dia_actual = date('w'); // 0 (Domingo) a 6 (Sábado)
        $hora_actual = date('H:i:s');
        
        $this->db->select('p.*, pd.hora_limite, pd.dia_semana');
        $this->db->from('proveedores p');
        $this->db->join('proveedores_dias_pedido pd', 'p.id = pd.id_proveedor');
        $this->db->where('p.activo', 1);
        $this->db->where('pd.dia_semana', $dia_actual);
        // Quitamos la restricción de hora para que aparezca todo el día si no se hizo
        // $this->db->where('pd.hora_limite >', $hora_actual); 
        
        $query = $this->db->get();
        $proveedores = $query->result_array();
        
        // Verificar si ya se hizo pedido hoy
        $resultado = array();
        foreach ($proveedores as $prov) {
            if (!$this->has_pedido_today($prov['id'])) {
                // Agregar flag si ya pasó la hora límite
                $prov['atrasado'] = ($hora_actual > $prov['hora_limite']);
                $resultado[] = $prov;
            }
        }
        
        return $resultado;
    }

    /**
     * Verificar si ya se hizo pedido hoy a un proveedor
     */
    public function has_pedido_today($id_proveedor)
    {
        $hoy = date('Y-m-d');
        $this->db->where('id_proveedor', $id_proveedor);
        $this->db->where('DATE(fecha)', $hoy);
        $query = $this->db->get('proveedores_pedidos');
        return $query->num_rows() > 0;
    }

    /**
     * Guardar un pedido
     */
    public function save_pedido($id_proveedor, $detalle, $enviado_whatsapp = false)
    {
        $data = array(
            'id_proveedor' => $id_proveedor,
            'fecha' => date('Y-m-d H:i:s'),
            'detalle' => $detalle,
            'enviado_whatsapp' => $enviado_whatsapp ? 1 : 0,
            'id_usuario' => $this->session->userdata('s_idusuario')
        );
        
        return $this->db->insert('proveedores_pedidos', $data);
    }

    /**
     * Obtener pedidos recientes
     */
    public function get_pedidos_recientes($limit = 20, $id_proveedor = null)
    {
        $this->db->select('pp.*, p.nombre as proveedor_nombre');
        $this->db->from('proveedores_pedidos pp');
        $this->db->join('proveedores p', 'pp.id_proveedor = p.id');
        
        if ($id_proveedor) {
            $this->db->where('pp.id_proveedor', $id_proveedor);
        }
        
        $this->db->order_by('pp.fecha', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Obtener estadísticas
     */
    public function get_estadisticas()
    {
        $stats = array();
        
        // Total proveedores activos
        $this->db->where('activo', 1);
        $stats['total_proveedores'] = $this->db->count_all_results('proveedores');
        
        // Pedidos esta semana
        $inicio_semana = date('Y-m-d', strtotime('monday this week'));
        $this->db->where('fecha >=', $inicio_semana);
        $stats['pedidos_semana'] = $this->db->count_all_results('proveedores_pedidos');
        
        // Pedidos hoy
        $hoy = date('Y-m-d');
        $this->db->where('DATE(fecha)', $hoy);
        $stats['pedidos_hoy'] = $this->db->count_all_results('proveedores_pedidos');
        
        return $stats;
    }

    /**
     * Obtener artículos de un proveedor
     */
    public function get_articulos_proveedor($id_proveedor)
    {
        $this->db->where('id_proveedor', $id_proveedor);
        $this->db->where('activo', 1);
        $this->db->order_by('descripcion', 'ASC');
        $query = $this->db->get('proveedores_articulos');
        return $query->result_array();
    }

    /**
     * Guardar un artículo (Insertar o Actualizar)
     */
    public function save_articulo($data)
    {
        if (isset($data['id']) && !empty($data['id'])) {
            $this->db->where('id', $data['id']);
            return $this->db->update('proveedores_articulos', $data);
        } else {
            $this->db->insert('proveedores_articulos', $data);
            return $this->db->insert_id();
        }
    }

    /**
     * Eliminar un artículo (borrado lógico)
     */
    public function delete_articulo($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('proveedores_articulos', array('activo' => 0));
    }

    /**
     * Obtener nombre del día en español
     */
    public function get_nombre_dia($dia_numero)
    {
        $dias = array(
            0 => 'Domingo',
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado'
        );
        
        return isset($dias[$dia_numero]) ? $dias[$dia_numero] : '';
    }

    /**
     * Eliminar un pedido
     */
    public function delete_pedido($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('proveedores_pedidos');
    }
}
