<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturar extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mfacturar');
		$this->load->helper('array');
	}

	public function index()
	{
		if ($this->session->logedin == TRUE) {

					$id = $this->session->s_idusuario;
		    	$data = array(
												'datos' => $this->mfacturar->facturasrealizadas()
											);
					$this->load->view('header');
					$this->load->view('menu');
					$this->load->view('facturar_view', $data);
					$this->load->view('close_section');
					$this->load->view('footer');

	} else {

				redirect('login');
			}

	}

	public function facturar(){

				/*$data = [];

		    	$hoy = date("dmyhis");
				$mpdf = new \Mpdf\Mpdf();

				$datos = array();
				$datos['local'] = $this->mfacturar->localesafacturar();


				$local = $datos['local'];
				$tot = count($local);
				$datos['cuenta'] = $tot;
				foreach ($local as $key)
				{
					$tot--;
					$mpdf2 = new \Mpdf\Mpdf();
					$empresa = $key->idUsr;
					$datos['localfacturado'] = $key->empresa;
					$datos['mail'] = $key->usuario;
					$datos['telefono'] = $key->telefono;
					$datos['nombre'] = $key->Nombre_Completo;
					$datos['factura'] = $this->mfacturar->pedidosporempresa($empresa);
					// hasta acá se cambió // 
					*/
					$data = [];
		    	$hoy = date("dmyhis");
				$mpdf = new \Mpdf\Mpdf();
				$datos = array();
				$datos['local'] = $this->mfacturar->localesafacturar();
				$local = $datos['local'];
				$tot = count($local);
				$datos['cuenta'] = $tot;

				foreach ($local as $key)
				{
					$tot--;
					$mpdf2 = new \Mpdf\Mpdf();
					$empresa = $key->idUsr;
					$valuesarray = [];
					$datos['localfacturado'] = $key->empresa;
					$datos['mail'] = $key->usuario;
					$datos['telefono'] = $key->telefono;
					$datos['nombre'] = $key->Nombre_Completo;
					$datos_facturacion = $this->mfacturar->pedidosporempresa($empresa);

					foreach ($datos_facturacion as $value) {
						$arraydatos = (array) json_decode($value->json, true);
					

								foreach ($arraydatos as $valor) {
								$valuesAux[] = (object) array(
								'fecha' => $value->fecha,
								'id_pedido' => $value->id,
								'cantidad' => $valor['cantidad'],
								'descripcion' => $this->mfacturar->articulo("nombre", $valor['codigo']),
								'importe_envio' => $this->mfacturar->articulo("importe_envio", $valor['codigo']),
								'importe_produccion' => $this->mfacturar->articulo("importe_produccion" ,$valor['codigo'])
							);
					    	}

					}
					$datos['factura'] = $valuesAux;
					$html = $this->load->view('factura.php',$datos, true);
					$html2 = $this->load->view('factura.php',$datos, true);
					$mpdf2->WriteHTML($html2);
					
					$mpdf->WriteHTML($html);
					
					//$html = $this->load->view('factura.php',$datos, true);
					
					//$mpdf->WriteHTML($html);
					
					$directorio = "facturacion/".$key->empresa;

					if (!file_exists($directorio))  //Si no existe el directorio de cada local, se crea
					  {
						mkdir($directorio, 0700);
						}
					$filename = "facturacion/".$key->empresa."/".$key->empresa."".strval($hoy).".pdf";
					$mpdf2->Output($filename, \Mpdf\Output\Destination::FILE);
					$afacturar = $this->mfacturar->pedidosporempresa($empresa);
					$numero_factura= $this->mfacturar->factura_pedidos($valuesAux, $key->empresa, $empresa);
					$this->mfacturar->actualiza_pdf($numero_factura, $filename);
					$html2 = "";
					$valuesAux = NULL;
					unset($valuesAux);

					 if ($tot != 0) $mpdf->addPage();
					 }
  				$mpdf->Output(); // abrir en el navegador

	}

	public function simular(){

				$data = [];
		    	$hoy = date("dmyhis");
				$mpdf = new \Mpdf\Mpdf();
				$datos = array();
				$datos['local'] = $this->mfacturar->localesafacturar();
				$local = $datos['local'];
				$tot = count($local);
				$datos['cuenta'] = $tot;

				foreach ($local as $key)
				{
					$tot--;
					$mpdf2 = new \Mpdf\Mpdf();
					$empresa = $key->idUsr;
					$valuesarray = [];
					$datos['localfacturado'] = $key->empresa;
					$datos['mail'] = $key->usuario;
					$datos['telefono'] = $key->telefono;
					$datos['nombre'] = $key->Nombre_Completo;
					$datos_facturacion = $this->mfacturar->pedidosporempresa($empresa);

					foreach ($datos_facturacion as $value) {
						$arraydatos = (array) json_decode($value->json, true);
					

								foreach ($arraydatos as $valor) {
								$valuesAux[] = (object) array(
								'fecha' => $value->fecha,
								'id_pedido' => $value->id,
								'cantidad' => $valor['cantidad'],
								'descripcion' => $this->mfacturar->articulo("nombre", $valor['codigo']),
								'importe_envio' => $this->mfacturar->articulo("importe_envio", $valor['codigo']),
								'importe_produccion' => $this->mfacturar->articulo("importe_produccion" ,$valor['codigo'])
							);
					    	}

					}
					$datos['factura'] = $valuesAux;
					$html = $this->load->view('factura.php',$datos, true);
					$valuesAux = NULL;
					unset($valuesAux);
					$mpdf->WriteHTML($html);
					$directorio = "facturacion/".$key->empresa;
					 	if ($tot != 0) $mpdf->addPage();

				 } // end foreach local

  				$mpdf->Output(); // abrir en el navegador

	}



}
