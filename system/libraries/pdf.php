<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function __construct(){
	parent::__construct();

}

function pdf(){
    $CI = & get_instance();
    log_message('Debug', 'mPDF class is loaded.');
}

function load($param=NULL){
    require_once APPPATH.'/vendor/autoload.php';
    return new \Mpdf\Mpdf([
        'margin_left'       =>  '5',
        'margin_right'      =>  '5',
        'mode'              =>  'utf-8',     //Codepage Values OR Codepage Values
        'format'            =>  'A4',        //A4, Letter, Legal, Executive, Folio, Demy, Royal, etc
        'orientation'       =>  'P'          //"L" for Landscape orientation, "P" for Portrait orientation
    ]);
}
