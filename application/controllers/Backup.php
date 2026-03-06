<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('file');
        
        // Verificar que el usuario esté logueado y sea supervisor (nivel 1)
        if (!$this->session->userdata('logged_in') || $this->session->userdata('s_nivel') != 1) {
            redirect('login');
        }
    }

    /**
     * Página principal de gestión de backups
     */
    public function index()
    {
        $data['backups'] = $this->listar_backups();
        
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('backup_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    /**
     * Crear un nuevo backup de la base de datos
     */
    public function crear_backup()
    {
        // Configuración de la base de datos
        $db_host = $this->db->hostname;
        $db_user = $this->db->username;
        $db_pass = $this->db->password;
        $db_name = $this->db->database;
        
        // Nombre del archivo con fecha y hora
        $fecha = date('Y-m-d_His');
        $filename = $db_name . '_backup_' . $fecha . '.sql';
        $backup_path = FCPATH . 'backups' . DIRECTORY_SEPARATOR . $filename;
        
        // Ruta de mysqldump (ajustar según instalación de Bitnami)
        $mysqldump_path = 'C:\\Bitnami\\wampstack-7.1.29-0\\mysql\\bin\\mysqldump.exe';
        
        // Comando mysqldump
        $command = sprintf(
            '"%s" --user=%s --password=%s --host=%s --routines --triggers --single-transaction %s > "%s" 2>&1',
            $mysqldump_path,
            $db_user,
            $db_pass,
            $db_host,
            $db_name,
            $backup_path
        );
        
        // Ejecutar comando
        exec($command, $output, $return_var);
        
        if ($return_var === 0 && file_exists($backup_path)) {
            $this->session->set_flashdata('success', 'Backup creado exitosamente: ' . $filename);
        } else {
            $error_msg = 'Error al crear el backup.';
            if (!empty($output)) {
                $error_msg .= ' Detalles: ' . implode(' ', $output);
            }
            $this->session->set_flashdata('error', $error_msg);
        }
        
        redirect('backup');
    }

    /**
     * Listar todos los archivos de backup disponibles
     */
    private function listar_backups()
    {
        $backup_dir = FCPATH . 'backups' . DIRECTORY_SEPARATOR;
        $backups = array();
        
        if (is_dir($backup_dir)) {
            $files = scandir($backup_dir);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                    $filepath = $backup_dir . $file;
                    $backups[] = array(
                        'filename' => $file,
                        'size' => filesize($filepath),
                        'date' => date('Y-m-d H:i:s', filemtime($filepath)),
                        'timestamp' => filemtime($filepath)
                    );
                }
            }
            
            // Ordenar por fecha descendente (más reciente primero)
            usort($backups, function($a, $b) {
                return $b['timestamp'] - $a['timestamp'];
            });
        }
        
        return $backups;
    }

    /**
     * Descargar un archivo de backup
     */
    public function descargar_backup($filename)
    {
        // Validar nombre de archivo para prevenir directory traversal
        $filename = basename($filename);
        $filepath = FCPATH . 'backups' . DIRECTORY_SEPARATOR . $filename;
        
        if (!file_exists($filepath) || pathinfo($filename, PATHINFO_EXTENSION) !== 'sql') {
            show_404();
            return;
        }
        
        $this->load->helper('download');
        force_download($filepath, NULL);
    }

    /**
     * Restaurar base de datos desde un backup
     */
    public function restaurar_backup()
    {
        $filename = $this->input->post('filename');
        
        if (!$filename) {
            $this->session->set_flashdata('error', 'No se especificó un archivo de backup.');
            redirect('backup');
            return;
        }
        
        // Validar nombre de archivo
        $filename = basename($filename);
        $filepath = FCPATH . 'backups' . DIRECTORY_SEPARATOR . $filename;
        
        if (!file_exists($filepath) || pathinfo($filename, PATHINFO_EXTENSION) !== 'sql') {
            $this->session->set_flashdata('error', 'Archivo de backup no válido.');
            redirect('backup');
            return;
        }
        
        // Configuración de la base de datos
        $db_host = $this->db->hostname;
        $db_user = $this->db->username;
        $db_pass = $this->db->password;
        $db_name = $this->db->database;
        
        // Ruta de mysql (ajustar según instalación de Bitnami)
        $mysql_path = 'C:\\Bitnami\\wampstack-7.1.29-0\\mysql\\bin\\mysql.exe';
        
        // Comando mysql para restaurar
        $command = sprintf(
            '"%s" --user=%s --password=%s --host=%s %s < "%s" 2>&1',
            $mysql_path,
            $db_user,
            $db_pass,
            $db_host,
            $db_name,
            $filepath
        );
        
        // Ejecutar comando
        exec($command, $output, $return_var);
        
        if ($return_var === 0) {
            $this->session->set_flashdata('success', 'Base de datos restaurada exitosamente desde: ' . $filename);
        } else {
            $error_msg = 'Error al restaurar la base de datos.';
            if (!empty($output)) {
                $error_msg .= ' Detalles: ' . implode(' ', $output);
            }
            $this->session->set_flashdata('error', $error_msg);
        }
        
        redirect('backup');
    }

    /**
     * Eliminar un archivo de backup
     */
    public function eliminar_backup($filename)
    {
        // Validar nombre de archivo
        $filename = basename($filename);
        $filepath = FCPATH . 'backups' . DIRECTORY_SEPARATOR . $filename;
        
        if (!file_exists($filepath) || pathinfo($filename, PATHINFO_EXTENSION) !== 'sql') {
            $this->session->set_flashdata('error', 'Archivo de backup no válido.');
            redirect('backup');
            return;
        }
        
        if (unlink($filepath)) {
            $this->session->set_flashdata('success', 'Backup eliminado: ' . $filename);
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar el backup.');
        }
        
        redirect('backup');
    }
}
