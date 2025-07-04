<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Login extends CI_Controller
{

  public function __construct()
  {
      parent::__construct();
      $this->load->model('mlogin');
      $this->load->library('session');
  }

  public function index()
  {
    $sistema = $this->check_os();
    if ($sistema != "MAC") {
    $data['mensaje'] = "";
    $this->load->view('login_view', $data);
  } else {
    $data['mensaje'] = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> No funciona con MAC!</h4>
          Esta página por el momento no funciona correctamente en IPAD / IPHONE, se está trabajando para solucionarlo
        </div>';

    $this->load->view('login_view', $data);
  }

  }

  public function check_os() {
    $os=array("WIN","MAC","LINUX");
    // obtenemos el sistema operativo
	foreach($os as $val)
	{
		if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
			$info = $val;
	}

	// devolvemos el array de valores
	return $info;
  }
  public function logout()
  {
    $this->mlogin->salir();
    $this->session->sess_destroy();
    $data['mensaje'] = "";
    redirect(base_url('login'));

  }
  public function ingresar() {
    $usu = $this->input->post('txtusuario');
    $pass = sha1($this->input->post('txtclave'));
    $res = $this->mlogin->ingresar($usu, $pass);

    if ($res == 1) {
      redirect(base_url('inicio')); //si está todo ok redirecciono a tiemporeal

    } elseif ($res ==2) {
      $data['mensaje'] = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
            Usuario no activado, verifique su mail para activarlo.
          </div>';
      $this->load->view('login_view', $data);

    } else {
      $data['mensaje'] = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
            Usuario o Clave incorrecta
          </div>';
      $this->load->view('login_view', $data);
    }
  }
}


 ?>
