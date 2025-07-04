<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {


	public function index()
	{
		$this->load->model('consulta');
		$this->load->model('pedidos_model');
		$this->load->library('session');

		if ($this->session->logedin == TRUE) {
			$fechaoriginal = $this->consulta->proximaentrega();
			$proximaentrega = date("d/m", strtotime($fechaoriginal));
					$datos = array(
												'users' => '0',
												'total' => '1234',
												'datos' => $this->pedidos_model->ultimospedidos(),
												'proximaentrega' => $proximaentrega,
												'total_kilos' => $this->consulta->totalkilos(),
												'graficar' => $this->consulta->graficarkilos(),
												'kilos' => $this->consulta->kilosporlocal($this->session->s_idusuario),
												'pedidos' => $this->pedidos_model->ultimospedidosparaver()
												);
					//var_dump($this->consulta->listadolecturas());
					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('principal' , $datos);
					$this->load->view('close_section');
					$this->load->view('footer');
				} else {
					redirect('login');

				}
	}


}
