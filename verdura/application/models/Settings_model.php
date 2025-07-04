<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_setting($key) {
        $result = $this->db->get_where('settings', array('setting_key' => $key))->row();
        return $result ? $result->setting_value : null;
    }

    public function set_setting($key, $value) {
        $existing = $this->db->get_where('settings', array('setting_key' => $key))->row();
        
        if ($existing) {
            return $this->db->update('settings', 
                array('setting_value' => $value, 'updated_at' => date('Y-m-d H:i:s')), 
                array('setting_key' => $key)
            );
        } else {
            return $this->db->insert('settings', array(
                'setting_key' => $key,
                'setting_value' => $value
            ));
        }
    }

    public function get_all_settings() {
        $results = $this->db->get('settings')->result();
        $settings = array();
        foreach ($results as $result) {
            $settings[$result->setting_key] = $result->setting_value;
        }
        return $settings;
    }
}
