<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_classes');
    }

    /**
     * AJAX: cari kelas berdasarkan keyword
     * GET /search/classes?q=keyword
     */
    public function classes()
    {
        $q = trim($this->input->get('q'));

        if (strlen($q) < 1) {
            echo json_encode([]);
            return;
        }

        $this->db->select('id, class_name');
        $this->db->like('class_name', $q);
        $this->db->order_by('class_name', 'ASC');
        $this->db->limit(8);
        $results = $this->db->get('classes')->result();

        $out = [];
        foreach ($results as $row) {
            $out[] = [
                'label' => $row->class_name,
                'url'   => base_url('assessments/class_detail/' . $row->id),
                'icon'  => 'bx-building-house',
                'type'  => 'Kelas',
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($out);
    }
}
