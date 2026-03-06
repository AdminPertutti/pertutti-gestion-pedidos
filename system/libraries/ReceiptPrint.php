<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// IMPORTANT - Replace the following line with your path to the escpos-php autoload script
// require_once __DIR__ . '\..\..\autoload.php';
require_once __DIR__ . '\..\..\print\autoload.php';

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

class CI_ReceiptPrint {

    private $CI;
    private $connector;
    private $printer;
    // TODO: printer settings
    // Make this configurable by printer (32 or 48 probably)

    private $printer_width = 32;
    function __construct()
    {
      $this->CI =& get_instance(); // This allows you to call models or other CI objects with $this->CI->...
    }

  function connect($impresora)
  {
    $this->connector = new FilePrintConnector($impresora);
    $this->printer = new Printer($this->connector);
    //$this->img_logo = EscposImage::load("\escpos-php-development\logo_pos.png", false); // this line give an error image not found
  }

  private function check_connection()
  {
    if (!$this->connector OR !$this->printer OR !is_a($this->printer, 'Mike42\Escpos\Printer')) {
      throw new Exception("Tried to create receipt without being connected to a printer.");
    }
  }

  public function close_after_exception()
  {
    if (isset($this->printer) && is_a($this->printer, 'Mike42\Escpos\Printer')) {
      $this->printer->close();
    }
    $this->connector = null;
    $this->printer = null;
    $this->emc_printer = null;
  }

  // Calls printer->text and adds new line
  private function add_line($text = "", $should_wordwrap = true)
  {
    $text = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
    $this->printer->text($text."\n");
  }


  public function print_test_receipt($text = "")
  {

    $this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line("TESTING");
    $this->add_line("Receipt Print");
    $this->printer->selectPrintMode();
    $this->add_line(); // blank line
    $this->add_line($text);
    $this->add_line(); // blank line
    $this->add_line(date('Y-m-d H:i:s'));
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->close();
  }

  public function imprimir_separador()
  {
    $this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line("_");
    $this->add_line();
    $this->printer->close();
  } //endfunction

  public function imprimir_comanda($detalle)
  {
    $this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line("COMANDA DE REPO");
    $this->add_line("***************");
    $this->printer->selectPrintMode();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line($detalle);
    $this->add_line(); // blank line
    $this->add_line('FECHA DE REPO');
    $this->add_line(date('d-m-Y'));
    $this->add_line(); // blank line
    $this->add_line('HORA DE PEDIDO');
    date_default_timezone_set ('America/Argentina/Buenos_Aires');
    $hora = date("H:i:s"); 
    $this->add_line($hora);
    $this->add_line('DE PERTUTTI LOMAS');
    $this->add_line('pedidoslomas.ddns.net');
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->printer->feed(3);
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->feed(3);
    $this->printer->feedForm();
    $this->printer->close();
  } //endfunction

  public function imprimir_pedido($detalle)
  {
    $this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line("PEDIDO ESPECIAL");
    $this->add_line("***************");
    $this->printer->selectPrintMode();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line($detalle);
    $this->add_line(); // blank line
    $this->add_line('FECHA PEDIDO');
    $this->add_line(date('d-m-Y'));
    $this->add_line(); // blank line
    $this->add_line('HORA DE PEDIDO');
    date_default_timezone_set ('America/Argentina/Buenos_Aires');
    $hora = date("H:i:s");
    $this->add_line($hora);
    $this->add_line('DE PERTUTTI LOMAS');
    $this->add_line('pedidoslomas.ddns.net');
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->printer->feed(3);
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->feed(3);
    $this->printer->feedForm();
    $this->printer->close();
  } //endfunction


  public function imprimir_remito($detalle)
  {

    $this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line("REMITO DE ENVIO");
    $this->add_line("***************");
    $this->printer->selectPrintMode();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line($detalle);
    $this->add_line(); // blank line
    $this->add_line('FECHA DE REMITO');
    $this->add_line(date('d-m-Y'));
    $this->add_line(); // blank line
    $this->add_line('DE PERTUTTI LOMAS');
    $this->add_line('pedidoslomas.ddns.net');
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->printer->feed(3);
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->close();
  }

  public function abrir_conexion(){
    $this->check_connection();
  }
  public function cerrar_conexion(){
    $this->printer->close();
  }

  public function imprimir_etiquetas($local, $texto1, $texto2)
  {

    //$this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line("ENVIO DE ADEREZO");
    $this->add_line($local);
    $this->printer->selectPrintMode();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->add_line(); // blank line
    $this->add_line($texto1);
    $this->add_line($texto2);
    $this->add_line(); // blank line
    $this->add_line('FECHA DE PRODUCCION');
    $this->add_line(date('d-m-Y'));
    $this->add_line(); // blank line
    $this->add_line('DE PERTUTTI LOMAS');
    $this->add_line('pedidoslomas.ddns.net');
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->printer->feed(3);
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->feed(3);
  //  $this->add_line(); // blank line
  //  $this->printer->feedForm();
  //  $this->printer->close();
  }

}
