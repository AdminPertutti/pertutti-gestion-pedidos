<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Envio_mail extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('envio_mail_model');
        $this->load->library('encrypt');
    }

    function index()
    {
				$this->load->view('register_view');
    }
    function nuevo_usuario()
    {
      function genera_random($longitud){
      $exp_reg="[^A-Z0-9]";
      return substr(preg_replace($exp_reg, "", md5(rand())) .
         preg_replace($exp_reg, "", md5(rand())) .
         preg_replace($exp_reg, "", md5(rand())),
         0, $longitud);
      }
        if(isset($_POST['grabar']) and $_POST['grabar'] == 'si')
        {
            //SI EXISTE EL CAMPO OCULTO LLAMADO GRABAR CREAMOS LAS VALIDACIONES
            $this->form_validation->set_rules('nom','Username','required|trim|alpha_numeric_spaces');
            $this->form_validation->set_rules('local','Local','required|trim|alpha_numeric_spaces');
            $this->form_validation->set_rules('mail','Email','required|valid_email|trim');
            $this->form_validation->set_rules('telefono','telefono','required|trim');
            $this->form_validation->set_rules('pass','Password','required|min_length[5]|max_length[12]|trim');
						$this->form_validation->set_rules('pass2', 'Password Confirmation', 'required|trim|matches[pass]', 'No coinciden los passwords');
					//	$this->form_validation->set_rules('pass2','Password2','required|trim|xss_clean|md5');
            //SI HAY ALGÚNA REGLA DE LAS ANTERIORES QUE NO SE CUMPLE MOSTRAMOS EL MENSAJE
            //EL COMODÍN %s SUSTITUYE LOS NOMBRES QUE LE HEMOS DADO ANTERIORMENTE, EJEMPLO,
            //SI EL NOMBRE ESTÁ VACÍO NOS DIRÍA, EL NOMBRE ES REQUERIDO, EL COMODÍN %s
            //SERÁ SUSTITUIDO POR EL NOMBRE DEL CAMPO
            $this->form_validation->set_message('required', 'El %s es requerido');
            $this->form_validation->set_message('valid_email', 'El %s no es válido');
						$this->form_validation->set_message('matches', 'Las claves no coinciden');
						$this->form_validation->set_message('min_length', 'La clave debe tener 5 caracteres minimo');
						$this->form_validation->set_message('max_length', 'La clave debe tener 12 caracteres máximo');
            $this->form_validation->set_message('alpha_numeric_spaces', 'El nombre de usuario solo puede tener letras y números');
            //SI ALGO NO HA IDO BIEN NOS DEVOLVERÁ AL INDEX MOSTRANDO LOS ERRORES
            if($this->form_validation->run()==FALSE)
            {
                $this->index();

            }else{
                //EN CASO CONTRARIO PROCESAMOS LOS DATOS

                //agregamos la variable $activate que es un numero aleatorio de
                //20 digitos crado con la funcion genera_random de mas arriba

                $activate = genera_random(20);
                $nombre = $this->input->post('nom');
                $correo = $this->input->post('mail');
                $local = $this->input->post('local');
                $password = sha1($this->input->post('pass'));
                $nivel = $this->input->post('nivel');
                $telefono = $this->input->post('telefono');
                //ENVÍAMOS LOS DATOS AL MODELO CON LA SIGUIENTE LÍNEA
                if ($this->envio_mail_model->check_user($correo) == 0) {
                $insert = $this->envio_mail_model->new_user($nombre,$correo,$password, $local, $telefono, $nivel, $activate);
                //si el modelo nos responde afirmando que todo ha ido bien, envíamos un correo
                //al usuario y lo redirigimos al index, en verdad deberíamos redirigirlo al home de
                //nuestra web para que puediera iniciar sesión
                $this->email->from('pedidoslomasddns@gmail.com', 'pedidoslomasddns@gmail.com');
                $this->email->to($correo);
                //super importante, para poder envíar html en nuestros correos debemos ir a la carpeta
                //system/libraries/Email.php y en la línea 42 modificar el valor, en vez de text debemos poner html
                $this->email->subject('Registro en Pedidos Lomas');
                $this->email->message('<h2>' . $nombre . ' gracias por registrarte en Pedidos Lomas</h2><hr><br><br>
                Tu nombre de usuario es: ' . $correo . '.<br> Presioná sobre el link para activar tu cuenta.
                <BR> <BR> <B>Link de activación http://pedidoslomas.ddns.net/activar_cuenta?id=' . $correo .
                '&activate=' . $activate . '</B>');
                $this->email->send();
								$data['mensaje'] = '<div class="alert alert-success alert-dismissible">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												<h4><i class="icon fa fa-check"></i> Registro Correcto!</h4>
												Necesita activar la cuenta para poder ingresar a la página
											</div>';
								$this->load->view('login_view', $data);
              } else {
                $data['error_msg'] = '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
                      Ya se encuentra registrado ese mail
                    </div>';
                $this->load->view('register_view', $data);
              }
            }
        }
    }
}
