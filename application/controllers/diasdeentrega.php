<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class diasdeentrega extends CI_Controller {


	public function index()
	{
		$this->load->model('consulta');

		if ($this->session->logedin == TRUE) {

					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('diasdeentrega');
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
