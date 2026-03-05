<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_reports extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Ambil semua bulan + tahun yang punya data penilaian
     * Fix: pakai MIN() pada label supaya kompatibel dengan only_full_group_by
     */
    public function get_available_months() {
        $this->db->select("
            DATE_FORMAT(assessment_date, '%Y-%m') as period,
            MIN(DATE_FORMAT(assessment_date, '%M %Y')) as label
        ");
        $this->db->from('assessments');
        $this->db->group_by("DATE_FORMAT(assessment_date, '%Y-%m')");
        $this->db->order_by('period', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Rekap nilai kebersihan per kelas per bulan
     */
    public function get_rekap_bulanan($bulan, $tahun) {
        $this->db->select("
            classes.id                               as class_id,
            classes.class_name,
            COUNT(assessments.id)                    as jumlah_penilaian,
            SUM(assessments.total_point)             as total_poin,
            ROUND(AVG(assessments.total_point), 1)   as rata_rata,
            MAX(assessments.total_point)             as tertinggi,
            MIN(assessments.total_point)             as terendah
        ");
        $this->db->from('classes');
        $this->db->join('assessments', "assessments.class_id = classes.id
            AND MONTH(assessments.assessment_date) = {$bulan}
            AND YEAR(assessments.assessment_date)  = {$tahun}", 'left');
        $this->db->group_by('classes.id, classes.class_name');
        $this->db->order_by('rata_rata', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Detail penilaian harian semua kelas dalam 1 bulan (untuk PDF)
     */
    public function get_detail_bulanan($bulan, $tahun) {
        $this->db->select('assessments.*, classes.class_name, users.username as admin_name');
        $this->db->from('assessments');
        $this->db->join('classes', 'classes.id = assessments.class_id');
        $this->db->join('users',   'users.id   = assessments.admin_id');
        $this->db->where('MONTH(assessments.assessment_date)', $bulan);
        $this->db->where('YEAR(assessments.assessment_date)',  $tahun);
        $this->db->order_by('assessments.assessment_date', 'ASC');
        $this->db->order_by('classes.class_name', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Ranking kelas berdasarkan rata-rata bulan tertentu atau semua waktu
     */
    public function get_ranking($bulan = null, $tahun = null) {
        $this->db->select("
            classes.id                             as class_id,
            classes.class_name,
            COUNT(assessments.id)                  as jumlah_penilaian,
            ROUND(AVG(assessments.total_point), 1) as rata_rata,
            MAX(assessments.total_point)           as tertinggi,
            MIN(assessments.total_point)           as terendah
        ");
        $this->db->from('classes');
        $this->db->join('assessments', 'assessments.class_id = classes.id', 'left');

        if ($bulan && $tahun) {
            $this->db->where('MONTH(assessments.assessment_date)', $bulan);
            $this->db->where('YEAR(assessments.assessment_date)',  $tahun);
        }

        $this->db->group_by('classes.id, classes.class_name');
        $this->db->order_by('rata_rata', 'DESC');
        $this->db->order_by('jumlah_penilaian', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Summary cards untuk header laporan
     */
    public function get_summary_bulanan($bulan, $tahun) {
        $this->db->select("
            COUNT(DISTINCT assessments.class_id)   as total_kelas_dinilai,
            COUNT(assessments.id)                  as total_penilaian,
            ROUND(AVG(assessments.total_point), 1) as rata_rata_keseluruhan,
            MAX(assessments.total_point)           as poin_tertinggi,
            MIN(assessments.total_point)           as poin_terendah
        ");
        $this->db->from('assessments');
        $this->db->where('MONTH(assessments.assessment_date)', $bulan);
        $this->db->where('YEAR(assessments.assessment_date)',  $tahun);
        return $this->db->get()->row();
    }

    /**
     * Kelas dengan rata-rata tertinggi bulan ini
     */
    public function get_kelas_terbersih($bulan, $tahun) {
        $this->db->select('classes.class_name, ROUND(AVG(assessments.total_point), 1) as rata_rata');
        $this->db->from('assessments');
        $this->db->join('classes', 'classes.id = assessments.class_id');
        $this->db->where('MONTH(assessments.assessment_date)', $bulan);
        $this->db->where('YEAR(assessments.assessment_date)',  $tahun);
        $this->db->group_by('assessments.class_id, classes.class_name');
        $this->db->order_by('rata_rata', 'DESC');
        $this->db->limit(1);
        return $this->db->get()->row();
    }
}
