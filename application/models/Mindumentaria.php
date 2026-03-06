<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mindumentaria extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // --- Empleados ---
    public function get_empleados($solo_activos = TRUE) {
        if ($solo_activos) {
            $this->db->where('activo', 1);
        }
        $query = $this->db->get('indumentaria_empleados');
        return $query->result_array();
    }

    public function add_empleado($data) {
        return $this->db->insert('indumentaria_empleados', $data);
    }

    public function update_empleado($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('indumentaria_empleados', $data);
    }

    // --- Catálogo / Stock ---
    public function get_articulos($solo_activos = TRUE) {
        if ($solo_activos) {
            $this->db->where('activo', 1);
        }
        $query = $this->db->get('indumentaria_catalogo');
        return $query->result_array();
    }

    public function add_articulo($data) {
        return $this->db->insert('indumentaria_catalogo', $data);
    }

    public function update_articulo($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('indumentaria_catalogo', $data);
    }

    public function eliminar_articulo($id) {
        // Podríamos hacer un delete lógico (activo = 0) o físico. 
        // Dado el sistema, vamos a hacer un delete lógico o simplemente borrarlo si no tiene movimientos.
        // Pero para simplificar, lo borramos.
        $this->db->where('id', $id);
        return $this->db->delete('indumentaria_catalogo');
    }

    // --- Movimientos ---
    public function registrar_movimiento($id_empleado, $id_articulo, $tipo, $cantidad, $estado_prenda = 'NUEVO', $observaciones = '', $fecha_entrega = NULL) {
        $this->db->trans_start();

        // 1. Insertar el movimiento
        $data_movimiento = array(
            'id_empleado' => $id_empleado,
            'id_articulo' => $id_articulo,
            'tipo' => $tipo,
            'cantidad' => $cantidad,
            'estado_prenda' => $estado_prenda,
            'observaciones' => $observaciones,
            'fecha' => date('Y-m-d H:i:s'),
            'fecha_entrega' => $fecha_entrega ? $fecha_entrega : date('Y-m-d')
        );
        $this->db->insert('indumentaria_movimientos', $data_movimiento);

        // 2. Ajustar el stock
        $this->db->where('id', $id_articulo);
        if ($tipo == 'ENTREGA') {
            $this->db->set('stock', 'stock - ' . (int)$cantidad, FALSE);
        } elseif ($tipo == 'DEVOLUCION') {
            // Solo sumamos al stock si la prenda se entrega en buen estado (NUEVO o USADO)
            if ($estado_prenda != 'MALO') {
                $this->db->set('stock', 'stock + ' . (int)$cantidad, FALSE);
            }
        } elseif ($tipo == 'BAJA') {
            $this->db->set('stock', 'stock - ' . (int)$cantidad, FALSE);
        } elseif ($tipo == 'INGRESO') {
            $this->db->set('stock', 'stock + ' . (int)$cantidad, FALSE);
        }
        $this->db->update('indumentaria_catalogo');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_movimientos_empleado($id_empleado) {
        $this->db->select('m.*, c.nombre as articulo');
        $this->db->from('indumentaria_movimientos m');
        $this->db->join('indumentaria_catalogo c', 'm.id_articulo = c.id');
        $this->db->where('m.id_empleado', $id_empleado);
        $this->db->order_by('m.fecha', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_resumen_prenda_empleado($id_empleado) {
        $this->db->select('c.nombre, m.id_articulo, SUM(CASE WHEN m.tipo="ENTREGA" THEN m.cantidad ELSE -m.cantidad END) as cantidad_actual');
        $this->db->from('indumentaria_movimientos m');
        $this->db->join('indumentaria_catalogo c', 'm.id_articulo = c.id');
        $this->db->where('m.id_empleado', $id_empleado);
        $this->db->group_by('m.id_articulo');
        $this->db->having('cantidad_actual >', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    // --- Importación y Depósito ---
    public function upsert_empleado_por_dni($dni, $nombre) {
        $this->db->where('dni', $dni);
        $query = $this->db->get('indumentaria_empleados');
        
        if ($query->num_rows() > 0) {
            $emp = $query->row();
            $this->db->where('id', $emp->id);
            $this->db->update('indumentaria_empleados', array('nombre' => $nombre, 'activo' => 1));
            return $emp->id;
        } else {
            $data = array(
                'dni' => $dni,
                'nombre' => $nombre,
                'activo' => 1
            );
            $this->db->insert('indumentaria_empleados', $data);
            return $this->db->insert_id();
        }
    }

    public function get_movimientos_busqueda($filtros = array()) {
        $this->db->select('m.*, c.nombre as articulo, e.nombre as empleado');
        $this->db->from('indumentaria_movimientos m');
        $this->db->join('indumentaria_catalogo c', 'm.id_articulo = c.id');
        $this->db->join('indumentaria_empleados e', 'm.id_empleado = e.id', 'left');

        if (!empty($filtros['tipo'])) {
            $this->db->where('m.tipo', $filtros['tipo']);
        }
        if (!empty($filtros['id_empleado'])) {
            $this->db->where('m.id_empleado', $filtros['id_empleado']);
        }
        if (!empty($filtros['fecha_desde'])) {
            $this->db->where('DATE(m.fecha) >=', $filtros['fecha_desde']);
        }
        if (!empty($filtros['fecha_hasta'])) {
            $this->db->where('DATE(m.fecha) <=', $filtros['fecha_hasta']);
        }

        $this->db->order_by('m.fecha', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function reset_total_tablas() {
        $this->db->trans_start();
        $this->db->truncate('indumentaria_movimientos');
        $this->db->truncate('indumentaria_catalogo');
        $this->db->truncate('indumentaria_empleados');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function upsert_articulo_por_nombre($nombre, $talle, $cantidad_ingreso) {
        $this->db->where('nombre', $nombre);
        $query = $this->db->get('indumentaria_catalogo');
        
        if ($query->num_rows() > 0) {
            $art = $query->row();
            $this->db->where('id', $art->id);
            $this->db->set('stock', 'stock + ' . (int)$cantidad_ingreso, FALSE);
            $this->db->update('indumentaria_catalogo');
            return $art->id;
        } else {
            $data = array(
                'nombre' => $nombre,
                'talle' => $talle,
                'stock' => $cantidad_ingreso
            );
            $this->db->insert('indumentaria_catalogo', $data);
            return $this->db->insert_id();
        }
    }

    public function get_empleados_sin_uniforme() {
        // Obtener empleados activos que no tienen uniformes asignados
        // Un empleado no tiene uniforme si:
        // 1. No tiene ningún movimiento de tipo ENTREGA, o
        // 2. El balance neto de sus uniformes es 0 (entregas - devoluciones - bajas = 0)
        
        $sql = "SELECT e.id, e.dni, e.nombre 
                FROM indumentaria_empleados e
                WHERE e.activo = 1
                AND e.id NOT IN (
                    SELECT m.id_empleado
                    FROM indumentaria_movimientos m
                    WHERE m.id_empleado IS NOT NULL
                    GROUP BY m.id_empleado
                    HAVING SUM(CASE 
                        WHEN m.tipo = 'ENTREGA' THEN m.cantidad 
                        WHEN m.tipo IN ('DEVOLUCION', 'BAJA') THEN -m.cantidad 
                        ELSE 0 
                    END) > 0
                )
                ORDER BY e.nombre ASC";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function deshacer_movimiento($id_movimiento) {
        $this->db->where('id', $id_movimiento);
        $mov = $this->db->get('indumentaria_movimientos')->row();
        
        if (!$mov) return FALSE;

        $this->db->trans_start();

        // Reversar el stock
        $this->db->where('id', $mov->id_articulo);
        if ($mov->tipo == 'ENTREGA' || $mov->tipo == 'BAJA') {
            $this->db->set('stock', 'stock + ' . (int)$mov->cantidad, FALSE);
        } elseif ($mov->tipo == 'DEVOLUCION') {
            if ($mov->estado_prenda != 'MALO') {
                $this->db->set('stock', 'stock - ' . (int)$mov->cantidad, FALSE);
            }
        } elseif ($mov->tipo == 'INGRESO') {
            $this->db->set('stock', 'stock - ' . (int)$mov->cantidad, FALSE);
        }
        $this->db->update('indumentaria_catalogo');

        // Eliminar el registro
        $this->db->where('id', $id_movimiento);
        $this->db->delete('indumentaria_movimientos');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_stock_empleados_general($filtros = array()) {
        $this->db->select('e.nombre as empleado, c.nombre as articulo, c.talle, 
                           SUM(CASE WHEN m.tipo="ENTREGA" THEN m.cantidad 
                                    WHEN m.tipo="DEVOLUCION" OR m.tipo="BAJA" THEN -m.cantidad 
                                    ELSE 0 END) as cantidad_actual,
                           MAX(m.fecha) as ultima_fecha');
        $this->db->from('indumentaria_movimientos m');
        $this->db->join('indumentaria_empleados e', 'm.id_empleado = e.id');
        $this->db->join('indumentaria_catalogo c', 'm.id_articulo = c.id');
        
        $this->db->where('e.activo', 1); // Solo empleados activos

        if (!empty($filtros['id_empleado'])) {
            $this->db->where('m.id_empleado', $filtros['id_empleado']);
        }

        $this->db->group_by(array('m.id_empleado', 'm.id_articulo'));
        $this->db->having('cantidad_actual >', 0);
        $this->db->order_by('e.nombre', 'ASC');
        $this->db->order_by('c.nombre', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
}
