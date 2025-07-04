<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_user_by_email($email) {
        return $this->db->get_where('users', array('email' => $email))->row();
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('users', array('id' => $id))->row();
    }

    public function create_user($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('users', $data);
    }

    public function get_all_users() {
        $this->db->select('id, email, name, role, status, created_at');
        return $this->db->get('users')->result();
    }

    public function update_user($id, $data) {
        return $this->db->update('users', $data, array('id' => $id));
    }

    public function delete_user($id) {
        return $this->db->delete('users', array('id' => $id));
    }

    public function verify_password($password, $hash) {
        return password_verify($password, $hash);
    }

    public function approve_user($user_id, $admin_id) {
        $data = array(
            'status' => 'approved',
            'approved_by' => $admin_id,
            'approved_at' => date('Y-m-d H:i:s')
        );
        return $this->db->update('users', $data, array('id' => $user_id));
    }
}
