<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {


	public function __construct()
	{
			parent::__construct();
			$this->load->model('perfil_model');
			$this->load->library('session');
	}



	public function index()
	{
		if ($this->session->logged_in == TRUE) {
					$id = $this->session->s_idusuario;
					$consulta = $this->perfil_model->cargar_user($id);
					$data = array('mensaje' => '',
											'mail' => $consulta->usuario,
											'nombre_comp' => $consulta->Nombre_Completo,
											'telefono' => $consulta->telefono,
											'empresa' => $consulta->empresa
											);

					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('perfil_view', $data);
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

	public function check_clave() {
		$id = $this->input->post('id_usr');
		$pass = sha1($this->input->post('passwordact'));
		$consulta = $this->perfil_model->check_clave($id, $pass);

		if ($consulta == 1) {
			return TRUE;
		} else {
			$this->form_validation->set_message('check_clave', 'Clave actual incorrecta');
			return FALSE;
		}
	}
	public function modifica_clave()
	{

			//clave correcta
			$this->form_validation->set_rules('password1','Password','required|min_length[5]|max_length[12]|trim');
			$this->form_validation->set_rules('password2', 'Password Confirmation', 'required|trim|matches[password1]', 'No coinciden los passwords');
			$this->form_validation->set_rules('passwordact', 'Passwordact', 'callback_check_clave');

			$this->form_validation->set_message('matches', 'Las claves no coinciden');
			$this->form_validation->set_message('min_length', 'La clave debe tener 5 caracteres minimo');
			$this->form_validation->set_message('max_length', 'La clave debe tener 12 caracteres máximo');
			if($this->form_validation->run()==FALSE)
			{
					$this->index();

			} else {
				$id = $this->input->post('id_usr');
				$newpass = sha1($this->input->post('password2'));
				$consulta = $this->perfil_model->modifica_clave($id, $newpass);

				$data['mensaje'] = '<div class="alert alert-success alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-ban"></i> Alerta!</h4>
							Clave modificada, vuelva a ingresar a su cuenta.
						</div>';
				$this->load->view('login_view', $data);
			}





	}

	public function modificar() {

		$usu = $this->input->post('nombre_comp');
    $id = $this->input->post('id');
		$telefono = $this->input->post('telefono');

		$res = $this->perfil_model->modifica_user($usu, $id, $telefono);

		if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] > 0)
{

}
else
{
    // Verificamos si el tipo de archivo es un tipo de imagen permitido.
    // y que el tamaño del archivo no exceda los 16MB
    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
    $limite_kb = 16384;

    if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024)
    {

        // Archivo temporal
        $imagen_temporal = $_FILES['imagen']['tmp_name'];

        // Tipo de archivo
        $tipo = $_FILES['imagen']['type'];

        // Leemos el contenido del archivo temporal en binario.
        $fp = fopen($imagen_temporal, 'r+b');
        $data = fread($fp, filesize($imagen_temporal));
        fclose($fp);

        //Podríamos utilizar también la siguiente instrucción en lugar de las 3 anteriores.
        // $data=file_get_contents($imagen_temporal);

        // Escapamos los caracteres para que se puedan almacenar en la base de datos correctamente.
        $imagen = $data;
				$nombre = $usu;

        // Insertamos en la base de datos.
        $resultado = $this->perfil_model->subir_imagen($id, $imagen, $tipo, $nombre );
				if ($resultado)
				{
						$mensaje_error = "El archivo ha sido copiado exitosamente.";

				}
				else
				{
						$mensaje_error =  "Ocurrió algun error al copiar el archivo.";
				}
		}
		else
		{
				$mensaje_error =  "Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.";
		}

	}

		if ($res) {
					$id = $this->session->s_idusuario;
					$consulta = $this->perfil_model->cargar_user($id);
					$data = array('mensaje' => '<div class="alert alert-success alert-success">
		            <button type="button" class="close" data-dismiss="success" aria-hidden="true">&times;</button>
		            <h4><i class="icon fa fa-ban"></i> Perfecto!</h4>
		            Cambios Realizados !!
		          </div>',
											'mail' => $consulta->usuario,
											'nombre_comp' => $consulta->Nombre_Completo,
											'telefono' => $consulta->telefono,
											'empresa' => $consulta->empresa
											);
					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('perfil_view', $data);
					$this->load->view('close_section');
					$this->load->view('footer');


    } else {
      $data['mensaje'] = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
            Error al actualizar el usuario
          </div>';
      $this->load->view('login_view', $data);
    }

	}

	public function ver_imagen() {
		$id = $this->session->s_idusuario;
		$data = $this->perfil_model->cargar_imagen($id);
		echo $data;


	}

	public function imagen() {

		$usu = $this->input->post('nombre_comp');
    $id = $this->input->post('id');

    //$res = $this->perfil_model->modifica_user($usu, $id);

		if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] > 0)
{
    echo "Ha ocurrido un error.";
}
else
{
    // Verificamos si el tipo de archivo es un tipo de imagen permitido.
    // y que el tamaño del archivo no exceda los 16MB
    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
    $limite_kb = 16384;

    if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024)
    {

        // Archivo temporal
        $imagen_temporal = $_FILES['imagen']['tmp_name'];

        // Tipo de archivo
        $tipo = $_FILES['imagen']['type'];

        // Leemos el contenido del archivo temporal en binario.
        $fp = fopen($imagen_temporal, 'r+b');
        $data = fread($fp, filesize($imagen_temporal));
        fclose($fp);

        //Podríamos utilizar también la siguiente instrucción en lugar de las 3 anteriores.
        // $data=file_get_contents($imagen_temporal);

        // Escapamos los caracteres para que se puedan almacenar en la base de datos correctamente.
        $imagen = $data;
				$nombre = $usu;

        // Insertamos en la base de datos.
        $resultado = $this->perfil_model->subir_imagen($id, $imagen, $tipo, $nombre );

        if ($resultado)
        {
            echo "El archivo ha sido copiado exitosamente.";
						redirect('/perfil/');
        }
        else
        {
            echo "Ocurrió algun error al copiar el archivo.";
        }
    }
    else
    {
        echo "Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.";
    }

	}


	}

}
