<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mailgun_lib
 * 
 * Simple library to send emails via Mailgun API using Curl.
 * Compatible with PHP 5.6+
 */
class Mailgun_lib {

    protected $CI;
    protected $api_key;
    protected $domain;
    protected $from;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->config->load('mailgun');

        $this->api_key = $this->CI->config->item('mailgun_api_key');
        $this->domain  = $this->CI->config->item('mailgun_domain');
        $this->from    = $this->CI->config->item('mailgun_from');
    }

    /**
     * Send an email via Mailgun API
     * 
     * @param string $to Recipient email
     * @param string $subject Email subject
     * @param string $message plain text or html message
     * @param bool $is_html whether the message is HTML
     * @return array Response from Mailgun
     */
    public function send($to, $subject, $message, $is_html = true)
    {
        $url = "https://api.mailgun.net/v3/" . $this->domain . "/messages";

        $post_data = array(
            'from'    => $this->from,
            'to'      => $to,
            'subject' => $subject,
        );

        if ($is_html) {
            $post_data['html'] = $message;
        } else {
            $post_data['text'] = $message;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "api:" . $this->api_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local environments if needed

        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);

        return array(
            'success'   => ($http_code == 200),
            'response'  => json_decode($result, true),
            'http_code' => $http_code,
            'error'     => $error
        );
    }
}
