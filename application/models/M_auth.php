<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Cari user berdasarkan username
     */
    public function get_by_username($username) {
        return $this->db->get_where('users', ['username' => $username])->row();
    }

    /**
     * Cari user berdasarkan id
     */
    public function get_by_id($id) {
        return $this->db->get_where('users', ['id' => $id])->row();
    }
}
