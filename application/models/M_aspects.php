<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_aspects extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->order_by('id', 'ASC')->get('aspects')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('aspects', ['id' => $id])->row();
    }

    public function insert($data) {
        $this->db->trans_start();
        $this->db->insert('aspects', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update($id, $data) {
        $this->db->trans_start();
        $this->db->where('id', $id)->update('aspects', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete($id) {
        $this->db->trans_start();
        $this->db->delete('aspects', ['id' => $id]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function is_used($id) {
        return $this->db->where('aspect_id', $id)->count_all_results('assessment_details');
    }
}
