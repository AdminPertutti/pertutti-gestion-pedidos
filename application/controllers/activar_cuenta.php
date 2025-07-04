<?php

/**
 *
 */
class Activar_cuenta extends CI_Controller
{

  public function __construct()
  {
      parent::__construct();
      $this->load->model('mactivar');
      $this->load->library('session');
  }

  public function index()
  {
    $id = $this->input->get('id');
    $activate = $this->input->get('activate');
        if ($id != NULL | $activate != NULL) {
        //echo $activate;
        //echo $id;
        $act = $this->mactivar->activar($id, $activate);
        //echo $act;
      } else {
        $act = 0;
      }
    if ($act == 1) {
    $data['mensaje'] = '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Activación Correcta!</h4>
            Necesita loguearse para poder ingresar a la página
          </div>';
    $this->load->view('login_view', $data);
  } else {
    $data['error_msg'] = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
          Error al activar la cuenta
        </div>';
    $this->load->view('register_view', $data);
  }
  }


}
