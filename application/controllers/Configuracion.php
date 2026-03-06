<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Configuracion_model');
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('s_nivel') != 1) {
            redirect('inicio');
        }

        $data = array(
            'sectores'  => $this->Configuracion_model->get_sectores(),
            'respuesta' => ''
        );

        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('configuracion_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }

    public function actualizar()
    {
        if ($this->session->userdata('s_nivel') != 1) {
            redirect('inicio');
        }

        $sectores = $this->Configuracion_model->get_sectores();
        $ok = true;
        foreach ($sectores as $sector) {
            $id   = $sector['idSector'];
            $ruta = $this->input->post('ruta_' . $id);
            if ($ruta !== false) {
                $resultado = $this->Configuracion_model->update_ruta_sector($id, $ruta);
                if (!$resultado) $ok = false;
            }
        }

        $respuesta = $ok
            ? '<script>
                const Toast = Swal.mixin({toast: true, position: "top-end", showConfirmButton: false, timer: 4000});
                Toast.fire({type: "success", title: "Configuración guardada correctamente"});
               </script>'
            : '<script>
                const Toast = Swal.mixin({toast: true, position: "top-end", showConfirmButton: false, timer: 4000});
                Toast.fire({type: "error", title: "Hubo un error al guardar"});
               </script>';

        $data = array(
            'sectores'  => $this->Configuracion_model->get_sectores(),
            'respuesta' => $respuesta
        );

        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('configuracion_view', $data);
        $this->load->view('close_section');
        $this->load->view('footer');
    }
}
