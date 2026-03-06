<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    public function index()
    {
        $this->load->library('mailgun_lib');
        
        $to = 'pertuttilomas@gmail.com'; // Hernan's email from request
        $subject = 'Email de Prueba Mailgun - Debug';
        $message = '<h1>¡Hola Hernán!</h1><p>Este es un mail de prueba enviado usando la <b>API de Mailgun</b> con cURL.</p>';

        echo "<h1>Enviando mail de prueba via Mailgun...</h1>";
        
        $result = $this->mailgun_lib->send($to, $subject, $message);

        if ($result['success']) {
            echo "<h2 style='color: green;'>¡Éxito! El mail fue enviado correctamente a $to.</h2>";
        } else {
            echo "<h2 style='color: red;'>Fallo al enviar el mail.</h2>";
            echo "<p>Código HTTP: " . $result['http_code'] . "</p>";
            if ($result['error']) {
                echo "<p>Error cURL: " . $result['error'] . "</p>";
            }
        }

        echo "<h3>Respuesta de Mailgun:</h3>";
        echo "<pre>";
        print_r($result['response']);
        echo "</pre>";
    }
}
