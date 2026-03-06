<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends CI_Controller {


	public function __construct()
	{
			parent::__construct();
			$this->load->model('perfil_model');
			$this->load->model('reposicion_model');
			$this->load->model('articulos_model');
			$this->load->library('session');
	}



	public function index()
	{
		if ($this->session->logged_in == TRUE) {
					$data = array(
					'categorias' => $this->reposicion_model->listacategorias(),
					'datos' => $this->reposicion_model->listadoarticulos(),
					'sectores' => $this->reposicion_model->listasectores()
					);
					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('articulos_view', $data);
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

	public function insertar() {
		if ($this->session->logged_in == TRUE) {
						$data = array(
						'categorias' => $this->reposicion_model->listacategorias(),
						'sectores' => $this->reposicion_model->listasectores()
						);
					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('agrega_art_view', $data);
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

	public function borrar()
	{
		$id = $this->input->post('id');
		$this->articulos_model->borrararticulo($id);
	}
	public function activar()
	{
		$id = $this->input->post('id');
		$this->articulos_model->activar($id);
	}
	public function desactivar()
	{
		$id = $this->input->post('id');
		$this->articulos_model->desactivar($id);
	}
	public function agregar()
	{
		$id = $this->input->post('id');
		$nombre = $this->input->post('nombre_art');
		$descripcion = $this->input->post('descripcion');
		$categoria = $this->input->post('categoria');
		$sector = $this->input->post('sectores');
		$activado = $this->input->post('activado');

		if ($this->articulos_model->agrega_articulo($id,$nombre,$descripcion,$categoria,$sector,$activado))
		 {	$this->index();
		   } else {	echo "ERROR";
  	 }
	 }
	 public function agregar_categoria()
	 {
		 $nombre = $this->input->post('nombre_cat');
		 if ($this->articulos_model->agregar_categoria($nombre))
			{	$this->index();
				} else {	echo "ERROR";
			}
		}
	 public function editar_art()
	 {
		 $id = $this->input->post('id');
		 $nombre = $this->input->post('nombre_art');
		 $descripcion = $this->input->post('descripcion');
		 $categoria = $this->input->post('categoria');
		 $sector = $this->input->post('sectores');
		 $activado = $this->input->post('activado');

		 if ($this->articulos_model->modifica_articulo($id,$nombre,$descripcion,$categoria,$sector,$activado))
			{
				$this->index();
				} else {	echo "ERROR";
			}
		}

	 public function editar() {
		 if(isset($_POST['id'])) {
			 $id = $this->input->post('id');
			 $datos = $this->articulos_model->editar_articulo($id);
			 echo json_encode($datos);
		 }
	 }
}
