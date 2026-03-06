<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reclamo extends CI_Controller {


	public function __construct()
	{
			parent::__construct();
			$this->load->model('reclamo_model');
			$this->load->library('session');
	}



	public function index()
	{
		if ($this->session->logged_in == TRUE) {

					$id = $this->session->s_idusuario;
		    	$data = array(
												'datos' => $this->reclamo_model->ver_reclamos()
											);
					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('verreclamos_view', $data);
					$this->load->view('close_section');
					$this->load->view('footer');

	} else {

				redirect('login');
			}

	}

	public function nuevoreclamo() {
		if ($this->session->logged_in == TRUE) {

					$id = $this->session->s_idusuario;
		    	$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('reclamo_view');
					$this->load->view('close_section');
					$this->load->view('footer');

	} else {

				redirect('login');
			}


	}

	public function cargar() {
				 $local = $this->session->s_local;
				 $id = $this->session->s_idusuario;
				 $asunto = $this->input->post('asunto');
				 $descripcion = $this->input->post('detalle');
				 $this->reclamo_model->carga_reclamo($local, $id, $asunto, $descripcion);
				 redirect('reclamo');

	}

}
