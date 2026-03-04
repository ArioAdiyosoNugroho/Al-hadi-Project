<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_classes extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->order_by('id','DESC')->get('classes')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('classes', ['id' => $id])->row();
    }

    public function insert($data) {
        $this->db->trans_start();
        $this->db->insert('classes', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update($id, $data) {
        $this->db->trans_start();
        $this->db->where('id', $id)->update('classes', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete($id) {
        $this->db->trans_start();
        $this->db->delete('classes', ['id' => $id]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function is_used($id) {
        return $this->db->where('class_id', $id)->count_all_results('assessments');
    }
}
