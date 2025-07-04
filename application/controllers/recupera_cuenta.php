<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Recupera_cuenta extends CI_Controller
{

  public function __construct()
  {
      parent::__construct();
      $this->load->model('mcambiopass');
  }

  public function index()
{
        $id = $this->input->get('id');
        $activate = $this->input->get('activate');

        $check = $this->mcambiopass->verifica_cuenta($id, $activate);
        if ($check == 1)
          {
          $data['id'] = $id;
          $data['activate'] = $activate;
          $this->load->view('cambio_pass_view', $data);
          } else {
                  $data['mensaje'] = '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
                  Error al modificar la clave
                  </div>';
                  $this->load->view('login_view', $data);
                  }
}

public function cambiar_clave()
{

  if(isset($_POST['actualizar']) and $_POST['actualizar'] == 'si')
  {
      //SI EXISTE EL CAMPO OCULTO LLAMADO GRABAR CREAMOS LAS VALIDACIONES
      $this->form_validation->set_rules('pass','Password','required|min_length[5]|max_length[12]|trim');
      $this->form_validation->set_rules('pass2', 'Password Confirmation', 'required|trim|matches[pass]', 'No coinciden los passwords');
    //	$this->form_validation->set_rules('pass2','Password2','required|trim|xss_clean|md5');
      //SI HAY ALGÚNA REGLA DE LAS ANTERIORES QUE NO SE CUMPLE MOSTRAMOS EL MENSAJE
      //EL COMODÍN %s SUSTITUYE LOS NOMBRES QUE LE HEMOS DADO ANTERIORMENTE, EJEMPLO,
      //SI EL NOMBRE ESTÁ VACÍO NOS DIRÍA, EL NOMBRE ES REQUERIDO, EL COMODÍN %s
      //SERÁ SUSTITUIDO POR EL NOMBRE DEL CAMPO
      $this->form_validation->set_message('matches', 'Las claves no coinciden');
      $this->form_validation->set_message('min_length', 'La clave debe tener 5 caracteres minimo');
      $this->form_validation->set_message('max_length', 'La clave debe tener 12 caracteres máximo');
      //SI ALGO NO HA IDO BIEN NOS DEVOLVERÁ AL INDEX MOSTRANDO LOS ERRORES
          if($this->form_validation->run()==FALSE)
          {
          $this->index();

          }else{
          //EN CASO CONTRARIO PROCESAMOS LOS DATOS
          $password = sha1($this->input->post('pass'));
          $id2 = $this->input->post('id');
          $activate2 = $this->input->post('activate');
          $cambio = $this->mcambiopass->cambiar_pass($id2, $activate2, $password);
              if ($cambio == 1) {
                  $data['mensaje'] = '<div class="alert alert-success alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-check"></i> Clave modificada!</h4>
                          Necesita loguearse para poder ingresar a la página
                        </div>';
                  $this->load->view('login_view', $data);
              } else {
                        $data['mensaje'] = '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
                        Error al modificar la clave
                        </div>';
                        $this->load->view('login_view', $data);
                      }
          }

  } else {
          $data['mensaje'] = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
          Error al modificar la clave
          </div>';
          $this->load->view('login_view', $data);
          }

  }


}
