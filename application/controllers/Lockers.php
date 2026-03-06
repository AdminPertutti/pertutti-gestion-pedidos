<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lockers extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Lockers_model');
        $this->load->library('session');
    }

    /**
     * Private management dashboard.
     */
    public function index()
    {
        if (!$this->session->logged_in) {
            redirect('login');
        }

        $data = array(
            'lockers' => $this->Lockers_model->get_lockers()
        );

        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('lockers_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    /**
     * Create lockers in bulk.
     */
    public function crear()
    {
        if (!$this->session->logged_in) redirect('login');
        
        $cantidad = (int) $this->input->post('cantidad');
        if ($cantidad <= 0) $cantidad = 1;

        $last_num = $this->Lockers_model->get_last_number();
        $current_num = (int)$last_num;

        $data_batch = array();
        for ($i = 1; $i <= $cantidad; $i++) {
            $num = $current_num + $i;
            $numero_str = str_pad($num, 3, "0", STR_PAD_LEFT);
            $token = md5(uniqid($numero_str, true));
            
            $data_batch[] = array(
                'numero' => $numero_str,
                'estado' => 'sin asignar',
                'token' => $token
            );
        }

        if (!empty($data_batch)) {
            $this->Lockers_model->create_lockers($data_batch);
            $this->session->set_flashdata('success', $cantidad . ' lockers creados correctamente.');
        }

        redirect('lockers');
    }

    /**
     * Handle update/assignment.
     */
    public function guardar()
    {
        if (!$this->session->logged_in) redirect('login');

        $id = $this->input->post('id');
        $data = array(
            'estado' => $this->input->post('estado'),
            'asignado_a' => $this->input->post('asignado_a')
        );

        if ($data['estado'] != 'asignado') {
            $data['asignado_a'] = NULL;
        }

        if ($this->Lockers_model->update_locker($id, $data)) {
            $this->session->set_flashdata('success', 'Locker actualizado.');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar locker.');
        }

        redirect('lockers');
    }

    /**
     * Delete a locker.
     */
    public function eliminar($id)
    {
        if (!$this->session->logged_in) redirect('login');

        if ($this->Lockers_model->delete_locker($id)) {
            $this->session->set_flashdata('success', 'Locker eliminado.');
        }
        redirect('lockers');
    }

    /**
     * Public status page (No-Auth).
     */
    public function ver($token = null)
    {
        if (!$token) show_404();

        $locker = $this->Lockers_model->get_locker_by_token($token);
        if (!$locker) show_404();

        $data['locker'] = $locker;
        $this->load->view('lockers_public', $data);
    }

    /**
     * Labels for printing.
     */
    public function etiquetas()
    {
        if (!$this->session->logged_in) redirect('login');

        $data['lockers'] = $this->Lockers_model->get_lockers();
        $this->load->view('lockers_etiquetas', $data);
    }

    /**
     * Print-friendly list of assignments.
     */
    public function listado()
    {
        if (!$this->session->logged_in) redirect('login');

        $this->db->where('estado', 'asignado');
        $data['lockers'] = $this->Lockers_model->get_lockers();
        $this->load->view('lockers_listado', $data);
    }
}
