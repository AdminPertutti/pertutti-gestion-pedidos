<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class desayuno extends CI_Controller {


	public function index()
	{
		$this->load->model('consulta');
		$this->load->model('desayuno_model');
		$this->load->model('delivery_model');
		$this->load->library('session');

		if ($this->session->logged_in == TRUE) {
					$data = array(
					'delivery' => $this->delivery_model->datosdelivery($this->session->s_idusuario)
					);

					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('desayuno_view' , $data);
					$this->load->view('close_section');
					$this->load->view('footer');
				} else {
					$data['mensaje'] = '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
                Necesita loguearse para poder ingresar
              </div>';
					$this->load->view('login_view', $data);
				}
	}


}
