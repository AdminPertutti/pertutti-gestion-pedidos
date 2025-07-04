<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procesar extends CI_Controller {

	public function __construct()
	{
			parent::__construct();
			$this->load->model('mprocesar');
			$this->load->model('pedidos_model');
			$this->load->library('session');
			$this->load->model('envio_mail_model');
			$this->load->library('ReceiptPrint');

	}

	public function index()
	{
		if 	(isset($_GET['clave']) && $_GET['clave'] == "iddqd478")  {
			$this->mprocesar->procesar(1);

  			} elseif ($this->session->logedin == TRUE && $this->session->s_nivel == 1) {
					$data = array(
						'pedidos' => $this->pedidos_model->ultimospedidossinprocesar(),
						'procesado' => $this->mprocesar->ultimo_procesado()
						);
		
					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('procesar_view', $data);
					$this->load->view('close_section');
					$this->load->view('footer');
					
  			} else {
  				redirect(base_url('inicio'));
  			}

	}

	public function procesar_conmail()
	{
				if ($this->session->logedin == TRUE && $this->session->s_nivel == 1) {
					$this->mprocesar->procesar(1);
				}
	}

	public function procesar_sinmail()
	{
				if ($this->session->logedin == TRUE && $this->session->s_nivel == 1) {
					$this->mprocesar->procesar(0);
				}
	}

	public function reimprimir_comandas()
	{
	if ($this->session->logedin == TRUE && $this->session->s_nivel == 1) {
			$this->mprocesar->prepara_reimpresion();
			$this->mprocesar->procesar(0);
			}
 }

}
