<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indumentaria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mindumentaria');
        $this->load->library('session');
        if ($this->session->logged_in != TRUE) {
            redirect('login');
        }
    }

    public function index() {
        $data['empleados'] = $this->Mindumentaria->get_empleados();
        $data['articulos'] = $this->Mindumentaria->get_articulos();
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('indumentaria_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function deposito() {
        $data['articulos'] = $this->Mindumentaria->get_articulos();
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('indumentaria_deposito_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function reporte_stock() {
        $data['articulos'] = $this->Mindumentaria->get_articulos();
        $this->load->view('indumentaria_reporte_stock_view', $data);
    }

    public function movimientos() {
        $data['filtros'] = array(
            'tipo' => $this->input->get('tipo'),
            'id_empleado' => $this->input->get('id_empleado'),
            'fecha_desde' => $this->input->get('fecha_desde'),
            'fecha_hasta' => $this->input->get('fecha_hasta')
        );

        $data['movimientos'] = $this->Mindumentaria->get_movimientos_busqueda($data['filtros']);
        $data['empleados'] = $this->Mindumentaria->get_empleados(FALSE);

        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('indumentaria_movimientos_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function reporte_movimientos() {
        $filtros = array(
            'tipo' => $this->input->get('tipo'),
            'id_empleado' => $this->input->get('id_empleado'),
            'fecha_desde' => $this->input->get('fecha_desde'),
            'fecha_hasta' => $this->input->get('fecha_hasta')
        );

        $data['titulo'] = "Reporte de " . ($filtros['tipo'] ? ucfirst(strtolower($filtros['tipo'])) : "Movimientos");
        $data['movimientos'] = $this->Mindumentaria->get_movimientos_busqueda($filtros);
        $this->load->view('indumentaria_reporte_movimientos_view', $data);
    }

    public function empleados() {
        $data['empleados'] = $this->Mindumentaria->get_empleados(FALSE); // Incluir inactivos
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('indumentaria_empleados_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function verificar_dni_ajax() {
        $dni = $this->input->post('dni');
        $this->db->where('dni', $dni);
        $query = $this->db->get('indumentaria_empleados');
        if ($query->num_rows() > 0) {
            $emp = $query->row();
            echo json_encode(array('existe' => true, 'nombre' => $emp->nombre));
        } else {
            echo json_encode(array('existe' => false));
        }
    }

    // --- Acciones de Empleados ---
    public function guardar_empleado() {
        $id = $this->input->post('id');
        $data = array(
            'dni' => $this->input->post('dni'),
            'nombre' => $this->input->post('nombre')
        );

        if ($id) {
            $this->Mindumentaria->update_empleado($id, $data);
        } else {
            $this->Mindumentaria->add_empleado($data);
        }
        redirect('indumentaria');
    }

    // --- Acciones de Catálogo ---
    public function guardar_articulo() {
        $id = $this->input->post('id');
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'stock' => $this->input->post('stock')
        );

        if ($id) {
            $this->Mindumentaria->update_articulo($id, $data);
        } else {
            $this->Mindumentaria->add_articulo($data);
        }
        redirect('indumentaria/deposito');
    }

    public function eliminar_articulo($id) {
        if ($this->Mindumentaria->eliminar_articulo($id)) {
            $this->session->set_flashdata('success', 'Artículo eliminado correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar el artículo. Es posible que tenga movimientos asociados.');
        }
        redirect('indumentaria/deposito');
    }

    // --- Movimientos ---
    public function registrar_movimiento() {
        $id_empleado = $this->input->post('id_empleado');
        $id_articulo = $this->input->post('id_articulo');
        $tipo = $this->input->post('tipo');
        $cantidad = $this->input->post('cantidad');
        $estado = $this->input->post('estado_prenda');
        $obs = $this->input->post('observaciones');
        $fecha_entrega = $this->input->post('fecha_entrega');

        if ($this->Mindumentaria->registrar_movimiento($id_empleado, $id_articulo, $tipo, $cantidad, $estado, $obs, $fecha_entrega)) {
            $this->session->set_flashdata('success', 'Movimiento registrado correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al registrar el movimiento');
        }
        redirect('indumentaria');
    }

    public function deshacer_movimiento($id_movimiento) {
        if ($this->Mindumentaria->deshacer_movimiento($id_movimiento)) {
            $this->session->set_flashdata('success', 'Movimiento deshecho correctamente. El stock ha sido restablecido.');
        } else {
            $this->session->set_flashdata('error', 'Error al intentar deshacer el movimiento');
        }
        redirect('indumentaria');
    }

    public function registrar_entrega_batch() {
        $id_empleado = $this->input->post('id_empleado');
        $fecha_entrega = $this->input->post('fecha_entrega');
        $prendas = $this->input->post('prendas'); // Array de {id_articulo, cantidad, estado}

        if (!$id_empleado || empty($prendas)) {
            $this->session->set_flashdata('error', 'Datos insuficientes para la entrega');
            redirect('indumentaria');
        }

        $exito = true;
        foreach ($prendas as $p) {
            if (!$this->Mindumentaria->registrar_movimiento($id_empleado, $p['id_articulo'], 'ENTREGA', $p['cantidad'], $p['estado'], 'Entrega múltiple', $fecha_entrega)) {
                $exito = false;
            }
        }

        if ($exito) {
            $this->session->set_flashdata('success', 'Entrega registrada correctamente');
            // Redirigir a la comanda con flag de impresión
            redirect('indumentaria/comanda/' . $id_empleado . '?print=true');
        } else {
            $this->session->set_flashdata('error', 'Hubo errores al procesar algunos artículos');
            redirect('indumentaria');
        }
    }

    // --- Reportes / JSON ---
    public function get_movimientos_empleado_json($id_empleado) {
        $movimientos = $this->Mindumentaria->get_movimientos_empleado($id_empleado);
        echo json_encode($movimientos);
    }

    public function get_resumen_empleado_json($id_empleado) {
        $resumen = $this->Mindumentaria->get_resumen_prenda_empleado($id_empleado);
        echo json_encode($resumen);
    }

    public function comanda($id_empleado) {
        // Generar un reporte simple para imprimir (Comanda de entrega)
        $this->db->where('id', $id_empleado);
        $data['empleado'] = $this->db->get('indumentaria_empleados')->row();
        $data['movimientos'] = $this->Mindumentaria->get_movimientos_empleado($id_empleado); // Podríamos filtrar por fecha hoy
        
        $this->load->view('indumentaria_comanda_view', $data);
    }

    public function empleados_sin_uniforme() {
        $data['empleados'] = $this->Mindumentaria->get_empleados_sin_uniforme();
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('indumentaria_empleados_sin_uniforme_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function reporte_empleados_sin_uniforme() {
        $data['empleados'] = $this->Mindumentaria->get_empleados_sin_uniforme();
        $this->load->view('indumentaria_reporte_empleados_sin_uniforme_view', $data);
    }

    // --- Importación CSV ---
    public function importar_csv() {
        if (!isset($_FILES['archivo_csv']) || $_FILES['archivo_csv']['error'] != UPLOAD_ERR_OK) {
            $this->session->set_flashdata('error', 'Error al subir el archivo');
            redirect('indumentaria/deposito');
        }

        $file = $_FILES['archivo_csv']['tmp_name'];
        $handle = fopen($file, "r");
        
        $hubo_error = false;
        $i = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $i++;
            if ($i == 1) continue; // Saltar cabecera (Asumimos: Nombre, Talle, Cantidad)
            
            if (count($data) >= 2) {
                $nombre = trim($data[0]);
                $cantidad = (int)trim($data[1]);
                
                if (!empty($nombre)) {
                    $id_articulo = $this->Mindumentaria->upsert_articulo_por_nombre($nombre, '', $cantidad);
                    if ($id_articulo) {
                        // Registrar el ingreso en movimientos (opcional: usar id_usuario 0 o sistema)
                        $this->Mindumentaria->registrar_movimiento(0, $id_articulo, 'INGRESO', $cantidad, 'NUEVO', 'Carga masiva CSV');
                    } else {
                        $hubo_error = true;
                    }
                }
            }
        }
        fclose($handle);

        if ($hubo_error) {
            $this->session->set_flashdata('error', 'La importación terminó con algunos errores');
        } else {
            $this->session->set_flashdata('success', 'Importación realizada con éxito');
        }
        
        redirect('indumentaria/deposito');
    }

    public function baja_empleado_procesar() {
        $id_empleado = $this->input->post('id_empleado');
        $prendas = $this->input->post('prendas'); // Array de {id_articulo, cantidad, accion}

        if ($prendas && is_array($prendas)) {
            foreach ($prendas as $p) {
                $accion = $p['accion']; // 'DEVOLUCION' o 'BAJA'
                $estado = ($accion == 'DEVOLUCION') ? 'USADO' : 'MALO';
                $obs = 'Liquidación por baja de empleado';

                $this->Mindumentaria->registrar_movimiento($id_empleado, $p['id_articulo'], $accion, $p['cantidad'], $estado, $obs);
            }
        }

        // Desactivar empleado
        $this->Mindumentaria->update_empleado($id_empleado, array('activo' => 0));

        $this->session->set_flashdata('success', 'Empleado dado de baja y stock actualizado correctamente');
        redirect('indumentaria/empleados');
    }

    public function reset_total() {
        // Solo administradores pueden resetear el sistema
        if ($this->session->userdata('perfil') !== 'admin') {
            $this->session->set_flashdata('error', 'No tiene permisos para realizar esta acción');
            redirect('indumentaria');
        }

        if ($this->Mindumentaria->reset_total_tablas()) {
            $this->session->set_flashdata('success', 'Sistema reiniciado correctamente. El inventario está en cero.');
        } else {
            $this->session->set_flashdata('error', 'Error al intentar reiniciar el sistema');
        }
        redirect('indumentaria/deposito');
    }

    public function importar_empleados_csv() {
        if (!isset($_FILES['archivo_csv']) || $_FILES['archivo_csv']['error'] != UPLOAD_ERR_OK) {
            $this->session->set_flashdata('error', 'Error al subir el archivo');
            redirect('indumentaria/empleados');
        }

        $file = $_FILES['archivo_csv']['tmp_name'];
        $handle = fopen($file, "r");
        
        $hubo_error = false;
        $i = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $i++;
            if ($i == 1) continue; // Saltar cabecera (Asumimos: DNI, Nombre)
            
            if (count($data) >= 2) {
                $dni = trim($data[0]);
                $nombre = trim($data[1]);
                
                if (!empty($dni) && !empty($nombre)) {
                    if (!$this->Mindumentaria->upsert_empleado_por_dni($dni, $nombre)) {
                        $hubo_error = true;
                    }
                }
            }
        }
        fclose($handle);

        if ($hubo_error) {
            $this->session->set_flashdata('error', 'La importación de empleados terminó con algunos errores');
        } else {
            $this->session->set_flashdata('success', 'Importación de empleados realizada con éxito');
        }
        
        redirect('indumentaria/empleados');
    }

    public function reporte_general() {
        $filtros = array(
            'id_empleado' => $this->input->get('id_empleado')
        );

        $data['filtros'] = $filtros;
        $data['asignaciones'] = $this->Mindumentaria->get_stock_empleados_general($filtros);
        $data['empleados'] = $this->Mindumentaria->get_empleados(TRUE); // Solo activos para el filtro

        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('indumentaria_reporte_general_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }
}
