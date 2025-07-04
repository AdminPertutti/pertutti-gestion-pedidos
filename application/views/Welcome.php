<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mpersona');
		$this->load->library('export_excel');
	}

	public function index()
	{
		$this->load->view('chartjs');		
	}

	public function descargar(){

		$data = [];

		$hoy = date("dmyhis");

        //load the view and saved it into $html variable
        $html = 
        "<style>@page {
			    margin-top: 0.5cm;
			    margin-bottom: 0.5cm;
			    margin-left: 0.5cm;
			    margin-right: 0.5cm;
			}
			</style>".
        "<body>
        	<div style='color:#006699;'><b>".$this->input->post('txtPDF')."<b></div>".
        		"<div style='width:50px; height:50px; background-color:red;'>asdf</div>

        </body>";

        // $html = $this->load->view('v_dpdf',$date,true);
 		
 		//$html="asdf";
        //this the the PDF filename that user will get to download
        $pdfFilePath = "cipdf_".$hoy.".pdf";
 
        //load mPDF library
        $this->load->library('M_pdf');
        $mpdf = new mPDF('c', 'A4-L'); 
 		$mpdf->WriteHTML($html);
		$mpdf->Output($pdfFilePath, "D");
       // //generate the PDF from the given html
       //  $this->m_pdf->pdf->WriteHTML($html);
 
       //  //download it.
       //  $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
	}

	public function dExcel(){
		$result = $this->mpersona->getPersona();
		// echo var_dump($result);
		$this->export_excel->to_excel($result, 'lista_de_personas');
	}

	public function getPersonas(){
		$result = $this->mpersona->getPersonas();
		echo json_encode($result);
	}


}
