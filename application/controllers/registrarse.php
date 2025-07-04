<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrarse extends CI_Controller {


	public function index()
	{
		if ($this->session->logedin == TRUE && $this->session->s_nivel == 1) {
		$this->load->view('register_view');
		 }
	}


}
