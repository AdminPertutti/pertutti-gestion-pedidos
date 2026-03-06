<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PHPMailer Wrapper Library for CodeIgniter
 * 
 * Wraps PHPMailer 5.x integration
 */
class Phpmailer_lib {

    protected $mail;

    public function __construct()
    {
        // Load PHPMailer files from third_party
        require_once(APPPATH . 'third_party/PHPMailer/class.phpmailer.php');
        require_once(APPPATH . 'third_party/PHPMailer/class.smtp.php');

        $this->mail = new PHPMailer();
    }

    public $debug_log = '';

    public function load()
    {
        $CI =& get_instance();
        $CI->config->load('email');

        $this->mail->isSMTP();
        $this->mail->Host       = $CI->config->item('smtp_host');
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $CI->config->item('smtp_user');
        $this->mail->Password   = $CI->config->item('smtp_pass');
        
        // PHPMailer 5.2.x uses 'tls' string, not the constant ENCRYPTION_STARTTLS
        $this->mail->SMTPSecure = 'tls'; 
        $this->mail->Port       = 587;
        
        // Enable detailed debugging
        $this->mail->SMTPDebug = 2; 
        
        // Capture debug output instead of echoing
        $self = $this;
        $this->mail->Debugoutput = function($str, $level) use ($self) {
            $self->debug_log .= $str . "<br>\n";
        };
        
        // Force manual TLS if auto fails, or disable auto to rely on SMTPSecure
        $this->mail->SMTPAutoTLS = false; 

        // Options to bypass certificate issues in local environments
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isHTML(true);

        return $this->mail;
    }
    
    public function getDebugLog() {
        return $this->debug_log;
    }
}
