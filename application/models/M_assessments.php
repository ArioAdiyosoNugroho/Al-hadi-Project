<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_assessments extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    /**
     * Ambil semua penilaian dengan join ke classes & users
     */
    public function get_all() {
        $this->db->select('assessments.*, classes.class_name, users.username as admin_name');
        $this->db->from('assessments');
        $this->db->join('classes', 'classes.id = assessments.class_id');
        $this->db->join('users', 'users.id = assessments.admin_id');
        $this->db->order_by('assessments.id', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Ambil satu assessment by id
     */
    public function get_by_id($id) {
        $this->db->select('assessments.*, classes.class_name, users.username as admin_name');
        $this->db->from('assessments');
        $this->db->join('classes', 'classes.id = assessments.class_id');
        $this->db->join('users', 'users.id = assessments.admin_id');
        $this->db->where('assessments.id', $id);
        return $this->db->get()->row();
    }

	public function get_by_class($class_id) {
	    $this->db->select('assessments.*, classes.class_name, users.username as admin_name');
	    $this->db->from('assessments');
	    $this->db->join('classes', 'classes.id = assessments.class_id');
	    $this->db->join('users', 'users.id = assessments.admin_id');
	    $this->db->where('assessments.class_id', $class_id);
	    $this->db->order_by('assessments.assessment_date', 'DESC');
	    return $this->db->get()->result();
	}

	public function get_rekap_satu_kelas($class_id) {
    	$this->db->select('COUNT(id) as total_penilaian, MAX(assessment_date) as terakhir_dinilai');
    	$this->db->from('assessments');
    	$this->db->where('class_id', $class_id);
    	return $this->db->get()->row();
	}

    /**
     * Cek apakah kelas sudah dinilai pada tanggal tertentu
     */
    public function check_duplicate($class_id, $date, $exclude_id = null) {
        $this->db->where('class_id', $class_id);
        $this->db->where('assessment_date', $date);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results('assessments');
    }

    /**
     * Insert assessment + details dalam satu transaksi
     * $details = array of ['aspect_id' => x, 'condition_status' => y, 'point' => z]
     */
    public function insert_with_details($assessment_data, $details) {
        $this->db->trans_start();

        $this->db->insert('assessments', $assessment_data);
        $assessment_id = $this->db->insert_id();

        $total_point = 0;
        foreach ($details as $d) {
            $total_point += (int)$d['point'];
            $this->db->insert('assessment_details', [
                'assessment_id'    => $assessment_id,
                'aspect_id'        => $d['aspect_id'],
                'condition_status' => $d['condition_status'],
                'point'            => $d['point'],
            ]);
        }

        // Update total_point
        $this->db->where('id', $assessment_id)->update('assessments', ['total_point' => $total_point]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Update assessment + details
     */
    public function update_with_details($id, $assessment_data, $details) {
        $this->db->trans_start();

        $this->db->where('id', $id)->update('assessments', $assessment_data);

        // Hapus detail lama lalu insert ulang
        $this->db->delete('assessment_details', ['assessment_id' => $id]);

        $total_point = 0;
        foreach ($details as $d) {
            $total_point += (int)$d['point'];
            $this->db->insert('assessment_details', [
                'assessment_id'    => $id,
                'aspect_id'        => $d['aspect_id'],
                'condition_status' => $d['condition_status'],
                'point'            => $d['point'],
            ]);
        }

        // Update total_point
        $this->db->where('id', $id)->update('assessments', ['total_point' => $total_point]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Hapus assessment + details
     */
    public function delete($id) {
        $this->db->trans_start();
        $this->db->delete('assessment_details', ['assessment_id' => $id]);
        $this->db->delete('assessments', ['id' => $id]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // ===================== ASSESSMENT DETAILS =====================

    /**
     * Ambil detail penilaian dengan nama aspek
     */
    public function get_details($assessment_id) {
        $this->db->select('assessment_details.*, aspects.aspect_name');
        $this->db->from('assessment_details');
        $this->db->join('aspects', 'aspects.id = assessment_details.aspect_id');
        $this->db->where('assessment_details.assessment_id', $assessment_id);
        $this->db->order_by('aspects.id', 'ASC');
        return $this->db->get()->result();
    }

    // ===================== STATISTIK =====================

    /**
     * Rekap penilaian per kelas (rata-rata total_point)
     */
    public function get_rekap_per_kelas() {
        $this->db->select('classes.class_name, COUNT(assessments.id) as total_penilaian, AVG(assessments.total_point) as rata_rata, MAX(assessments.total_point) as tertinggi, MIN(assessments.total_point) as terendah');
        $this->db->from('assessments');
        $this->db->join('classes', 'classes.id = assessments.class_id');
        $this->db->group_by('assessments.class_id');
        $this->db->order_by('rata_rata', 'DESC');
        return $this->db->get()->result();
    }
}
