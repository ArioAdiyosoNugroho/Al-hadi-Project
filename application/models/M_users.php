<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->order_by('id','DESC')->get('users')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function insert($data) {
        $this->db->trans_start();
        $this->db->insert('users', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update($id, $data) {
        $this->db->trans_start();
        $this->db->where('id', $id)->update('users', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete($id) {
        $this->db->trans_start();
        $this->db->delete('users', ['id' => $id]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function is_used($id) {
        return $this->db->where('class_id', $id)->count_all_results('assessments');
    }
}
