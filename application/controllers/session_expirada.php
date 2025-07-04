<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_expirada extends CI_Controller {


	public function __construct()
	{
			parent::__construct();
			$this->load->model('enviar_model');
			$this->load->library('session');
	}



	public function index()
	{
	$SESSION = new SESSION_handler();
		if($SESSION->session_expired()) {
			echo "true";
		} else { echo "false";}
  }





}
