<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Envios extends CI_Controller {


	public function __construct()
	{
			parent::__construct();
			$this->load->model('envios_model');
			$this->load->library('session');
	}



	public function index()
	{
		if ($this->session->logged_in == TRUE) {
				  $data = array(
							'pendiente' => $this->envios_model->checkpendientes(),
						'datos' => $this->envios_model->ultimospedidosporempresa(),
						'pedido_ok' => 0
						);

					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('envios_view', $data);
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
public function borrar()
{
	$id_pedido = $this->input->post('id_pedido');
	$this->envios_model->borrarpedido($id_pedido);
}


public function cargar(){
	$cantidad1 = $this->input->post('ad1');
	$cantidad2 = $this->input->post('ad2');
	$observaciones = $this->input->post('observacion');


		if ($cantidad1 != 0 OR $cantidad2 != 0) {
		$numero_pedido = $this->envios_model->cargarpedido($cantidad1, $cantidad2, $observaciones);
		$data = array(
			'pendiente' => 0,
			'datos' => $this->envios_model->ultimospedidosporempresa(),
			'pedido_ok' => $numero_pedido
			);

		$this->load->view('header');
		$this->load->view('menu');
		$this->load->view('envios_view', $data);
		$this->load->view('close_section');
		$this->load->view('footer');
	} else {

		$this->index();

	}

}





}
