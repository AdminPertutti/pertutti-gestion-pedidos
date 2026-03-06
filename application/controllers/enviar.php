<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enviar extends CI_Controller {


	public function __construct()
	{
			parent::__construct();
			$this->load->model('enviar_model');
			$this->load->library('session');
	}



	public function index()
	{
		if ($this->session->logged_in == TRUE && $this->session->s_nivel == 1) {
				  $data = array(
							'pendiente' => $this->enviar_model->checkpendientes(),
						'datos' => $this->enviar_model->ultimospedidos(),
						'pedido_ok' => 0
						);

					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('enviar_view', $data);
					$this->load->view('close_section');
					$this->load->view('footer');

	} else {

		$this->load->view('header');
	
		$this->load->view('sinpermiso');
		$this->load->view('close_section');
		$this->load->view('footer');
	}

	}
public function borrar()
{
	$id_pedido = $this->input->post('id_pedido');
	$this->enviar_model->borrarpedido($id_pedido);
}


public function cargar(){
	$cantidad1 = $this->input->post('ad1');
	$cantidad2 = $this->input->post('ad2');
	$observaciones = $this->input->post('observacion');


		if ($cantidad1 != 0 OR $cantidad2 != 0) {
		$numero_pedido = $this->enviar_model->cargarpedido($cantidad1, $cantidad2, $observaciones);
		$data = array(
			'pendiente' => 0,
			'datos' => $this->enviar_model->ultimospedidosporempresa(),
			'pedido_ok' => $numero_pedido
			);

		$this->load->view('header');
		$this->load->view('menu');
		$this->load->view('enviar_view', $data);
		$this->load->view('close_section');
		$this->load->view('footer');
	} else {

		$this->index();

	}

}





}
