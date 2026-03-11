<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // ── STAT CARDS ──────────────────────────────────────────────

    public function total_classes()
    {
        return $this->db->count_all('classes');
    }

    public function total_aspects()
    {
        return $this->db->count_all('aspects');
    }

    // FIX: created_at → assessment_date
    public function total_assessments_this_month()
    {
        $this->db->where('MONTH(assessment_date)', date('m'));
        $this->db->where('YEAR(assessment_date)', date('Y'));
        return $this->db->count_all_results('assessments');
    }

    // FIX: created_at → assessment_date
    public function total_assessments_today()
    {
        $this->db->where('DATE(assessment_date)', date('Y-m-d'));
        return $this->db->count_all_results('assessments');
    }

    // FIX: created_at → assessment_date
    public function avg_point_this_month()
    {
        $this->db->select('AVG(total_point) as avg_point');
        $this->db->where('MONTH(assessment_date)', date('m'));
        $this->db->where('YEAR(assessment_date)', date('Y'));
        $row = $this->db->get('assessments')->row();
        return $row ? round($row->avg_point, 1) : 0;
    }

    // FIX: created_at → assessment_date
    public function classes_assessed_this_month()
    {
        $this->db->select('COUNT(DISTINCT class_id) as total');
        $this->db->where('MONTH(assessment_date)', date('m'));
        $this->db->where('YEAR(assessment_date)', date('Y'));
        $row = $this->db->get('assessments')->row();
        return $row ? (int)$row->total : 0;
    }

    // ── CHART: Tren penilaian 7 hari terakhir ───────────────────

    public function chart_weekly_trend()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));

            $this->db->select('AVG(total_point) as avg_point, COUNT(id) as total');
            $this->db->where('DATE(assessment_date)', $date);
            $row = $this->db->get('assessments')->row();

            $data[] = [
                'label'     => date('d M', strtotime($date)),
                'avg_point' => $row && $row->total > 0 ? round($row->avg_point, 1) : 0,
                'count'     => $row ? (int)$row->total : 0,
            ];
        }
        return $data;
    }

    // ── CHART: Rata-rata poin per kelas bulan ini ────────────────

    // FIX: created_at → assessment_date
    public function chart_avg_point_per_class()
    {
        $this->db->select('c.class_name, AVG(a.total_point) as avg_point, COUNT(a.id) as total_penilaian');
        $this->db->from('assessments a');
        $this->db->join('classes c', 'c.id = a.class_id');
        $this->db->where('MONTH(a.assessment_date)', date('m'));
        $this->db->where('YEAR(a.assessment_date)', date('Y'));
        $this->db->group_by('a.class_id');
        $this->db->order_by('avg_point', 'DESC');
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    // ── CHART: Distribusi kondisi (Bersih/Cukup/Kotor) ──────────

    // FIX: condition_value → condition_status, created_at → assessment_date
    public function chart_condition_distribution()
    {
        $this->db->select('ad.condition_status, COUNT(*) as total');
        $this->db->from('assessment_details ad');
        $this->db->join('assessments a', 'a.id = ad.assessment_id');
        $this->db->where('MONTH(a.assessment_date)', date('m'));
        $this->db->where('YEAR(a.assessment_date)', date('Y'));
        $this->db->group_by('ad.condition_status');
        return $this->db->get()->result();
    }

    // ── CHART: Tren poin bulanan (12 bulan terakhir) ─────────────

	// ── CHART: Tren poin 7 bulan terakhir (sesuai template) ─────
    public function chart_monthly_trend()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $month = date('m', strtotime("-{$i} months"));
            $year  = date('Y', strtotime("-{$i} months"));
            $label = date('M', strtotime("-{$i} months")); 

            $this->db->select('AVG(total_point) as avg_point, COUNT(id) as total');
            $this->db->where('MONTH(assessment_date)', $month);
            $this->db->where('YEAR(assessment_date)',  $year);
            $row = $this->db->get('assessments')->row();

            $data[] = [
                'label'     => $label,
                'avg_point' => $row ? round($row->avg_point, 1) : 0,
                'total'     => $row ? (int)$row->total : 0,
            ];
        }
        return $data;
    }
    // ── TABEL: Ranking kelas terbersih bulan ini ─────────────────
    public function ranking_classes_this_month()
    {
        $this->db->select("
            classes.id                             as class_id,
            classes.class_name,
            COUNT(assessments.id)                  as total_penilaian,
            ROUND(AVG(assessments.total_point), 1) as avg_point,
            MAX(assessments.total_point)           as max_point,
            MIN(assessments.total_point)           as min_point
        ");
        $this->db->from('classes');
        $this->db->join('assessments',
            'assessments.class_id = classes.id
             AND MONTH(assessments.assessment_date) = ' . (int)date('m') . '
             AND YEAR(assessments.assessment_date)  = ' . (int)date('Y'),
            'left'   // ← left join: semua kelas tampil walau belum dinilai
        );
		$this->db->having('total_penilaian >', 0);
        $this->db->group_by('classes.id, classes.class_name');
        $this->db->order_by('avg_point', 'DESC');
        $this->db->order_by('total_penilaian', 'DESC');
        // Tidak pakai LIMIT agar end($ranking) = kelas terkotor yang sesungguhnya
        return $this->db->get()->result();
    }

    // ── TABEL: Penilaian terbaru ──────────────────────────────────

    // FIX: user_id → admin_id, created_at → assessment_date
    public function recent_assessments($limit = 5)
    {
        $this->db->select('a.id, c.class_name, a.total_point, a.assessment_date, u.username as assessor');
        $this->db->from('assessments a');
        $this->db->join('classes c', 'c.id = a.class_id');
        $this->db->join('users u', 'u.id = a.admin_id', 'left');
        $this->db->order_by('a.assessment_date', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // ── HELPER: max possible point ────────────────────────────────

    public function max_possible_point()
    {
        $this->db->select('SUM(point_bersih) as max_point');
        $row = $this->db->get('aspects')->row();
        return $row ? (int)$row->max_point : 100;
    }
}
