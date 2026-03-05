<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessments extends MY_Controller {

    public $assessments;
    public $aspects;
    public $classes;

    public function __construct() {
        parent::__construct();
        $this->load->model('M_assessments', 'assessments');
        $this->load->model('M_aspects', 'aspects');
        $this->load->model('M_classes', 'classes');
    }

    // Halaman 1: List semua KELAS
    public function index() {
        $data = [
            'title'   => 'Penilaian Kelas',
            'content' => 'pages/assessments/index',
            'classes' => $this->classes->get_all(),
        ];
        $this->load->view('layouts/main', $data);
    }

    // Halaman 2: List semua penilaian milik 1 kelas
    public function class_detail($class_id) {
        $kelas = $this->classes->get_by_id($class_id);
        if (!$kelas) {
            $this->session->set_flashdata('error', 'Kelas tidak ditemukan!');
            redirect('assessments');
        }

        $data = [
            'title'       => 'Penilaian: ' . $kelas->class_name,
            'content'     => 'pages/assessments/class_detail',
            'kelas'       => $kelas,
            'assessments' => $this->assessments->get_by_class($class_id),
        ];
        $this->load->view('layouts/main', $data);
    }

    // Halaman 3: Form tambah penilaian
	public function create() {
	    $aspects = $this->aspects->get_all();

	    if (empty($aspects)) {
	        $this->session->set_flashdata('error', 'Belum ada aspek penilaian. Silakan tambahkan aspek terlebih dahulu!');
	        redirect('assessments');
	        return;
	    }

	    // Ambil class_id dari query string jika ada (dari tombol "Nilai Hari Ini")
	    $selected_class_id = $this->input->get('class_id');
	    $selected_class    = null;

	    if ($selected_class_id) {
	        $selected_class = $this->classes->get_by_id($selected_class_id);
	    }

	    // Ambil hanya kelas yang belum dinilai hari ini (untuk dropdown)
	    $today         = date('Y-m-d');
	    $all_classes   = $this->classes->get_all();
	    $belum_dinilai = [];

	    foreach ($all_classes as $cls) {
	        if (!$this->assessments->check_duplicate($cls->id, $today)) {
	            $belum_dinilai[] = $cls;
	        }
	    }

	    $data = [
	        'title'             => 'Tambah Penilaian',
	        'content'           => 'pages/assessments/create',
	        'classes'           => $belum_dinilai,   // hanya yang belum dinilai
	        'aspects'           => $aspects,
	        'selected_class_id' => $selected_class_id,
	        'selected_class'    => $selected_class,
	    ];
	    $this->load->view('layouts/main', $data);
	}

    // Simpan penilaian
    public function store() {
        $class_id        = $this->input->post('class_id', true);
        $assessment_date = $this->input->post('assessment_date', true);
        $aspect_ids      = $this->input->post('aspect_id');
        $conditions      = $this->input->post('condition_status');
        $points          = $this->input->post('point');

        if (empty($class_id) || empty($assessment_date)) {
            $this->session->set_flashdata('error', 'Kelas dan tanggal penilaian wajib diisi!');
            redirect('assessments/create');
            return;
        }

        // Cek duplikat: 1 kelas hanya 1 penilaian per hari
        if ($this->assessments->check_duplicate($class_id, $assessment_date)) {
            $this->session->set_flashdata('error', 'Kelas ini sudah dinilai pada tanggal tersebut!');
            redirect('assessments/create');
            return;
        }

        if (empty($aspect_ids) || !is_array($aspect_ids)) {
            $this->session->set_flashdata('error', 'Minimal harus ada satu aspek penilaian!');
            redirect('assessments/create');
            return;
        }

        $assessment_data = [
            'class_id'        => (int)$class_id,
            'admin_id'        => $this->session->userdata('user_id') ?? 1,
            'assessment_date' => $assessment_date,
            'total_point'     => 0,
        ];

        $details = [];
        foreach ($aspect_ids as $i => $aspect_id) {
            $details[] = [
                'aspect_id'        => (int)$aspect_id,
                'condition_status' => $conditions[$i],
                'point'            => (int)$points[$i],
            ];
        }

        if ($this->assessments->insert_with_details($assessment_data, $details)) {
            $this->session->set_flashdata('success', 'Penilaian berhasil disimpan!');
            redirect('assessments/class_detail/' . $class_id);
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan penilaian!');
            redirect('assessments/create');
        }
    }

    // Halaman 4: Detail satu penilaian
    public function detail($id) {
        $assessment = $this->assessments->get_by_id($id);

        if (!$assessment) {
            $this->session->set_flashdata('error', 'Data penilaian tidak ditemukan!');
            redirect('assessments');
            return;
        }

        $data = [
            'title'      => 'Detail Penilaian',
            'content'    => 'pages/assessments/detail',
            'assessment' => $assessment,
            'details'    => $this->assessments->get_details($id),
        ];
        $this->load->view('layouts/main', $data);
    }

    // Form edit
    public function edit($id) {
        $assessment = $this->assessments->get_by_id($id);

        if (!$assessment) {
            $this->session->set_flashdata('error', 'Data penilaian tidak ditemukan!');
            redirect('assessments');
            return;
        }

        $data = [
            'title'      => 'Edit Penilaian',
            'content'    => 'pages/assessments/edit',
            'assessment' => $assessment,
            'details'    => $this->assessments->get_details($id),
            'classes'    => $this->classes->get_all(),
            'aspects'    => $this->aspects->get_all(),
        ];
        $this->load->view('layouts/main', $data);
    }

    // Update penilaian
    public function update($id) {
        $class_id        = $this->input->post('class_id', true);
        $assessment_date = $this->input->post('assessment_date', true);
        $aspect_ids      = $this->input->post('aspect_id');
        $conditions      = $this->input->post('condition_status');
        $points          = $this->input->post('point');

        if (empty($class_id) || empty($assessment_date)) {
            $this->session->set_flashdata('error', 'Kelas dan tanggal penilaian wajib diisi!');
            redirect('assessments/edit/' . $id);
            return;
        }

        if ($this->assessments->check_duplicate($class_id, $assessment_date, $id)) {
            $this->session->set_flashdata('error', 'Kelas ini sudah dinilai pada tanggal tersebut!');
            redirect('assessments/edit/' . $id);
            return;
        }

        $assessment_data = [
            'class_id'        => (int)$class_id,
            'assessment_date' => $assessment_date,
        ];

        $details = [];
        foreach ($aspect_ids as $i => $aspect_id) {
            $details[] = [
                'aspect_id'        => (int)$aspect_id,
                'condition_status' => $conditions[$i],
                'point'            => (int)$points[$i],
            ];
        }

        if ($this->assessments->update_with_details($id, $assessment_data, $details)) {
            $this->session->set_flashdata('success', 'Penilaian berhasil diperbarui!');
            redirect('assessments/class_detail/' . $class_id);
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui penilaian!');
            redirect('assessments/edit/' . $id);
        }
    }

    // Hapus penilaian
    public function delete($id) {
        $assessment = $this->assessments->get_by_id($id);
        $class_id   = $assessment ? $assessment->class_id : null;

        if ($this->assessments->delete($id)) {
            $this->session->set_flashdata('success', 'Penilaian berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus penilaian!');
        }

        redirect($class_id ? 'assessments/class_detail/' . $class_id : 'assessments');
    }
}
