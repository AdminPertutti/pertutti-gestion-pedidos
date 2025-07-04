<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reposicion extends CI_Controller {

public function __construct()
	{
			parent::__construct();
			$this->load->model('reposicion_model');
			$this->load->library('session');
			$this->load->library('ReceiptPrint');
	}

	public function index()
	{
		if ($this->session->logedin == TRUE) {
							  $data = array(
								'categorias' => $this->reposicion_model->listacategorias(),
				  			'datos' => $this->reposicion_model->listaarticulos(),
								'repo' => $this->reposicion_model->listareposicion(),
								'ultimo' => $this->reposicion_model->ultimoarticulo(),
								'respuesta' => '');
							$this->load->view('header');
							$this->load->view('menu');
							$this->load->view('reposicion_view', $data);
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

	public function index2($resultado)
	{
		if ($resultado == 1) {
			$respuesta = '<script>if (window.history.replaceState) { // verificamos disponibilidad
     window.history.replaceState(null, null, window.location.href);
		 const Toast = Swal.mixin({toast: true,
					 position: "top-end",showConfirmButton: false,timer: 7000});
					 Toast.fire({type: "success",title: "Pedido enviado correctamente!!"
					 });
		}
</script>';
	} else {
		$respuesta = "";
	}
		if ($this->session->logedin == TRUE) {
								$data = array(
								'categorias' => $this->reposicion_model->listacategorias(),
								'datos' => $this->reposicion_model->listaarticulos(),
								'repo' => $this->reposicion_model->listareposicion(),
								'ultimo' => $this->reposicion_model->ultimoarticulo(),
								'respuesta' => $respuesta);
							$this->load->view('header');
							$this->load->view('menu');
							$this->load->view('reposicion_view', $data);
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

	public function check_session() //verifica si la session se encuentra activa y devuelve true o false
	{
		if ($this->session->logedin == TRUE) {
			echo "true";
	} else echo "false";
}

public function enviar()   //Envia comanda y carga la reposicion en la tabla
{
if ($this->input->post('total') != "") {  //Comprueba que se envien datos POST
$total = $this->input->post('total');
$datosarr = array();

for ($i = 1; $i <= $total; $i++) {
		$codigo = "cant" . $i;
		$sector = "sector" .$i;

		if ($this->input->post($codigo) != 0) {
				$array[] = array(  // Va cargando los datos de los productos seleccionados en un array
													'codigo' => $i,
													'cantidad' => $this->input->post($codigo),
													'sector' => $this->input->post($sector)
			 										);
		} //endif
} //endfor
$repo = $this->reposicion_model->prepara_reposicion($array);  //Llama a la funcion y devuelve si esta OK
$numero_repo = $this->reposicion_model->carga_reposicion($array); // Carga la repo en la tabla
} //endif

$this->index2(1); //Vuelve a la página principal
} //endfunction

public function reimprimir()   //Envia comanda y carga la reposicion en la tabla
{
if ($this->input->post('id') != "") {  //Comprueba que se envien datos POST
$id = $this->input->post('id');
$datosarr = array();
$datosarr = $this->reposicion_model->busca_reposicion($id);
$repo = $this->reposicion_model->prepara_reposicion($datosarr);  //Llama a la funcion y devuelve si esta OK
} //endif
} //endfunction


} //endcontroller
