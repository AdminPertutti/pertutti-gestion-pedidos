<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {


	public function __construct()
	{
			parent::__construct();
			$this->load->model('pedidos_model');
			$this->load->library('session');
	}



	public function index()
	{
		if ($this->session->logedin == TRUE) {
				if ($this->session->s_nivel == 0) {
						  $data = array(
								'pendiente' => $this->pedidos_model->checkpendientes(),
								'datos' => $this->pedidos_model->ultimospedidosporempresa(),
								'ultimo' => $this->pedidos_model->ultimoarticulo(),
								'articulos' => $this->pedidos_model->listaarticulos(), //SE AGREGAN LOS ARTICULOS
								'pedidos' => $this->pedidos_model->ultimospedidossinprocesarporid(),
								'pedido_ok' => 0
								);
							$this->load->view('header');
							$this->load->view('menu');
							$this->load->view('pedidos_view', $data);
							$this->load->view('close_section');
							$this->load->view('footer');
				} elseif ($this->session->s_nivel == 1) {

							$data = array(
							 'datos' => $this->pedidos_model->listalocales(),
							 'ultimo' => $this->pedidos_model->ultimoarticulo(),
							 'articulos' => $this->pedidos_model->listaarticulos(), //SE AGREGAN LOS ARTICULOS
							 'pedidos' => $this->pedidos_model->ultimospedidossinprocesar()
							  );

							$this->load->view('header');
							$this->load->view('menu');
							$this->load->view('pedidos_porlocal', $data);
							$this->load->view('close_section');
							$this->load->view('footer');

				}


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

	$id_pedido = $this->input->post('id_pedido');
	$this->pedidos_model->borrarpedido($id_pedido);

}

public function modificar()
{
	$id_pedido = $this->input->post('id_pedido');
	$id_articulo = $this->input->post('id_articulo');
	$cantidad = $this->input->post('cantidad');
	$this->pedidos_model->modificar($id_pedido, $id_articulo, $cantidad);
}

public function enviar()
{
	$id_pedido = $this->input->post('id_pedido');

	$this->pedidos_model->enviarpedido($id_pedido);
}


public function cargar(){

 //Nuevo tipo de carga para agregar mas productos
	if ($this->input->post('total') != "") {  //Comprueba que se envien datos POST
	$total = $this->input->post('total');
	$datosarr = array();

	for ($i = 1; $i <= $total; $i++) {
			$codigo = "cant" . $i;

			if ($this->input->post($codigo) != 0) {
					$array[] = array(  // Va cargando los datos de los productos seleccionados en un array
														'codigo' => $i,
														'cantidad' => $this->input->post($codigo)
				 										);
			} //endif
	} //endfor
}


	//Carga de pedido viejo para modificar
	$cantidad1 = $this->input->post('cant1');
	$cantidad2 = $this->input->post('cant2');
	$observaciones = $this->input->post('observacion');

		//Falta agregar Json con detalle de productos a agregar
		$numero_pedido = $this->pedidos_model->cargarpedido($cantidad1, $cantidad2, $array);

		$data = array(
			'pendiente' => 0,
			'datos' => $this->pedidos_model->ultimospedidosporempresa(),
			'pedido_ok' => $numero_pedido
			);

			$this->index();





}

public function cargarporlocal(){

	//Nuevo tipo de carga para agregar mas productos
	 if ($this->input->post('total') != "") {  //Comprueba que se envien datos POST
	 $total = $this->input->post('total');
	 $datosarr = array();

	 for ($i = 1; $i <= $total; $i++) {
			 $codigo = "cant" . $i;

			 if ($this->input->post($codigo) != 0) {
					 $array[] = array(  // Va cargando los datos de los productos seleccionados en un array
														 'codigo' => $i,
														 'cantidad' => $this->input->post($codigo)
														 );
			 } //endif
	 } //endfor
 }


	 //Carga de pedido viejo para modificar
	 $cantidad1 = $this->input->post('cant1');
	 $cantidad2 = $this->input->post('cant2');
	 $observaciones = $this->input->post('observacion');
  $idusuario = $this->input->post('idusuario');
	$local = $this->input->post($idusuario);


		$numero_pedido = $this->pedidos_model->cargapedidolocal($cantidad1, $cantidad2, $array, $local, $idusuario);
		$this->index();


}
	public function check_session()
	{
		if ($this->session->logedin == TRUE) {
			echo "true";

	} else echo "false";
}







}
