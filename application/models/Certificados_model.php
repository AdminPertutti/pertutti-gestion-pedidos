<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->check_database();
    }

    private function check_database() {
        // Tabla de Tipos de Certificado
        if (!$this->db->table_exists('certificados_tipos')) {
            $this->db->query("CREATE TABLE `certificados_tipos` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `nombre` varchar(100) NOT NULL,
                `descripcion` text,
                `dias_aviso` int(11) DEFAULT '15',
                `activo` tinyint(1) DEFAULT '1',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            
            // Insertar tipos por defecto
            $this->db->query("INSERT INTO `certificados_tipos` (`nombre`, `dias_aviso`) VALUES 
                ('Fumigación', 7),
                ('Limpieza de Tanques', 15),
                ('Análisis de Agua', 15),
                ('Bromatología', 30);");
        }

        // Tabla de Archivos/Cargas
        if (!$this->db->table_exists('certificados_uploads')) {
            $this->db->query("CREATE TABLE `certificados_uploads` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `id_tipo` int(11) NOT NULL,
                `archivo` varchar(255) NOT NULL,
                `fecha_vencimiento` date NOT NULL,
                `fecha_carga` datetime NOT NULL,
                `observaciones` text,
                `id_usuario` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `id_tipo` (`id_tipo`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }
        // Actualización: Agregar columna requiere_aviso si no existe
        if (!$this->db->field_exists('requiere_aviso', 'certificados_tipos')) {
            $this->db->query("ALTER TABLE `certificados_tipos` ADD COLUMN `requiere_aviso` tinyint(1) DEFAULT '1' AFTER `descripcion`;");
        }
    }

    // --- Tipos ---
    public function get_tipos($solo_activos = TRUE) {
        if ($solo_activos) {
            $this->db->where('activo', 1);
        }
        return $this->db->get('certificados_tipos')->result_array();
    }

    public function get_tipo($id) {
        $this->db->where('id', $id);
        return $this->db->get('certificados_tipos')->row_array();
    }

    public function add_tipo($data) {
        return $this->db->insert('certificados_tipos', $data);
    }

    public function update_tipo($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('certificados_tipos', $data);
    }

    // --- Certificados ---
    public function get_ultimo_certificado($id_tipo) {
        $this->db->where('id_tipo', $id_tipo);
        $this->db->order_by('fecha_vencimiento', 'DESC');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        return $this->db->get('certificados_uploads')->row_array();
    }

    public function get_historial($id_tipo) {
        $this->db->where('id_tipo', $id_tipo);
        $this->db->order_by('fecha_vencimiento', 'DESC');
        return $this->db->get('certificados_uploads')->result_array();
    }

    public function add_certificado($data) {
        return $this->db->insert('certificados_uploads', $data);
    }

    public function delete_certificado($id) {
        $this->db->where('id', $id);
        return $this->db->delete('certificados_uploads');
    }

    public function get_certificado($id) {
        $this->db->where('id', $id);
        return $this->db->get('certificados_uploads')->row_array();
    }

    // --- Alertas ---
    public function get_vencimientos_proximos() {
        // Obtener solo tipos activos y que REQUIERAN AVISO
        $this->db->where('activo', 1);
        $this->db->where('requiere_aviso', 1);
        $tipos = $this->db->get('certificados_tipos')->result_array();
        
        $alertas = array();

        foreach ($tipos as $t) {
            $ultimo = $this->get_ultimo_certificado($t['id']);
            if ($ultimo) {
                // Verificar si fecha_vencimiento es válida (no nula o 0000)
                if ($ultimo['fecha_vencimiento'] && $ultimo['fecha_vencimiento'] != '0000-00-00') {
                    $vencimiento = new DateTime($ultimo['fecha_vencimiento']);
                    $hoy = new DateTime();
                    $dias_restantes = $hoy->diff($vencimiento)->format('%r%a'); 

                    if ($dias_restantes <= $t['dias_aviso']) {
                        $estado = ($dias_restantes < 0) ? 'VENCIDO' : 'POR VENCER';
                        $alertas[] = array(
                            'tipo' => $t['nombre'],
                            'fecha_vencimiento' => $ultimo['fecha_vencimiento'],
                            'dias_restantes' => $dias_restantes,
                            'estado' => $estado,
                            'id_tipo' => $t['id']
                        );
                    }
                }
            }
        }
        return $alertas;
    }
}
