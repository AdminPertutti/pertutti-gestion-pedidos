<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadisticas extends CI_Controller {


	public function index()
	{
		$this->load->model('estadisticas_model');
		$this->load->library('session');

		if ($this->session->logedin == TRUE) {
					$datos = array(
												'total_kilos' => $this->estadisticas_model->totalkilos(),
												'graficar' => $this->estadisticas_model->graficarkilos(),
												'kilos' => $this->estadisticas_model->kilosporlocal($this->session->s_idusuario)
												);
					//var_dump($this->consulta->listadolecturas());
					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('estadisticas_view' , $datos);
					$this->load->view('close_section');
					$this->load->view('footer');
				} else {
					redirect('login');

				}
	}

	public function comparativa()
	{
		if ($this->session->logedin == TRUE) {
					$datos = array(
												'total_kilos' => $this->estadisticas_model->totalkilos(),
												'graficar' => $this->estadisticas_model->graficarkilos(),
												'kilos' => $this->estadisticas_model->kilosporlocal($this->session->s_idusuario)
												);
					//var_dump($this->consulta->listadolecturas());
					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('estadisticas_view' , $datos);
					$this->load->view('close_section');
					$this->load->view('footer');
				} else {
					redirect('login');

				}

	}


}
