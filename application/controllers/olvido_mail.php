<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Olvido_mail extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('olvido_mail_model');
        $this->load->library('encrypt');
    }

    function index()
    {
        $data['mensaje'] = '';
        $this->load->view('olvido_view', $data);
    }
    function recuperar_pass()
    {
      function genera_random($longitud){
      $exp_reg="[^A-Z0-9]";
      return substr(preg_replace($exp_reg, "", md5(rand())) .
         preg_replace($exp_reg, "", md5(rand())) .
         preg_replace($exp_reg, "", md5(rand())),
         0, $longitud);
      }
        if(isset($_POST['recusuario']))
        {
            //SI EXISTE EL CAMPO OCULTO LLAMADO GRABAR CREAMOS LAS VALIDACIONES
            $this->form_validation->set_rules('recusuario','Email','required|valid_email|trim');
            //SI HAY ALGÚNA REGLA DE LAS ANTERIORES QUE NO SE CUMPLE MOSTRAMOS EL MENSAJE
            //EL COMODÍN %s SUSTITUYE LOS NOMBRES QUE LE HEMOS DADO ANTERIORMENTE, EJEMPLO,
            //SI EL NOMBRE ESTÁ VACÍO NOS DIRÍA, EL NOMBRE ES REQUERIDO, EL COMODÍN %s
            //SERÁ SUSTITUIDO POR EL NOMBRE DEL CAMPO
            $this->form_validation->set_message('valid_email', 'El %s no es válido');
						//SI ALGO NO HA IDO BIEN NOS DEVOLVERÁ AL INDEX MOSTRANDO LOS ERRORES
            if($this->form_validation->run()==FALSE)
            {
                $this->index();

            }else{
                //EN CASO CONTRARIO PROCESAMOS LOS DATOS

                //agregamos la variable $activate que es un numero aleatorio de
                //20 digitos crado con la funcion genera_random de mas arriba
                $activate = genera_random(20);
                $correo = $this->input->post('recusuario');
                //ENVÍAMOS LOS DATOS AL MODELO CON LA SIGUIENTE LÍNEA
                if ($this->olvido_mail_model->check_user($correo) == 1) {
                $insert = $this->olvido_mail_model->new_pass($correo,$activate);
                //si el modelo nos responde afirmando que todo ha ido bien, envíamos un correo
                //al usuario y lo redirigimos al index, en verdad deberíamos redirigirlo al home de
                //nuestra web para que puediera iniciar sesión
                $this->email->from('Soporte', 'pedidoslomasddns@gmail.com');
                $this->email->to($correo);
                //super importante, para poder envíar html en nuestros correos debemos ir a la carpeta
                //system/libraries/Email.php y en la línea 42 modificar el valor, en vez de text debemos poner html
                $this->email->subject('Recuperar clave de Pedidos Lomas');
                $this->email->message('<h2>Se envia un link para recuperar clave de Pedidos Lomas</h2><hr><br><br>
                Tu nombre de usuario es: ' . $correo . '.<br> Presioná sobre el link para activar tu cuenta.
                <BR> <BR> <B>Link de activación http://pedidoslomas.ddns.net/recupera_cuenta?id=' . $correo .
                '&activate=' . $activate . '</B>');
                $this->email->send();
								$data['mensaje'] = '<div class="alert alert-success alert-dismissible">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												<h4><i class="icon fa fa-check"></i> Reenvio de clave correcto!</h4>
												Ingrese al link enviado por mail para cambiar la clave.
											</div>';
								$this->load->view('login_view', $data);
              } else {
                $data['mensaje'] = '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
                    Cuenta inexistente - Reintente por favor
                    </div>';
                $this->load->view('olvido_view', $data);
              }
            }
        }
    }
}
