<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspects extends MY_Controller {

    /** @var M_aspects */
    public $aspects;

    public function __construct() {
        parent::__construct();
        $this->load->model('M_aspects', 'aspects');
    }

    public function index() {
        $data = [
            'title'   => 'Kelola Aspek Penilaian',
            'content' => 'pages/aspects/index',
            'aspects' => $this->aspects->get_all(),
        ];
        $this->load->view('layouts/main', $data);
    }

    public function store() {
        $aspect_name   = $this->input->post('aspect_name', true);
        $point_bersih  = $this->input->post('point_bersih', true);
        $point_cukup   = $this->input->post('point_cukup', true);
        $point_kotor   = $this->input->post('point_kotor', true);

        if (empty($aspect_name)) {
            $this->session->set_flashdata('error', 'Nama aspek wajib diisi!');
            redirect('aspects');
            return;
        }

        if (!is_numeric($point_bersih) || !is_numeric($point_cukup) || !is_numeric($point_kotor)) {
            $this->session->set_flashdata('error', 'Semua poin harus berupa angka!');
            redirect('aspects');
            return;
        }

        if ((int)$point_bersih < (int)$point_cukup || (int)$point_cukup < (int)$point_kotor) {
            $this->session->set_flashdata('error', 'Poin Bersih harus ≥ Cukup, dan Cukup harus ≥ Kotor!');
            redirect('aspects');
            return;
        }

        $data = [
            'aspect_name'  => $aspect_name,
            'point_bersih' => (int)$point_bersih,
            'point_cukup'  => (int)$point_cukup,
            'point_kotor'  => (int)$point_kotor,
        ];

        if ($this->aspects->insert($data)) {
            $this->session->set_flashdata('success', 'Aspek penilaian berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambah aspek!');
        }

        redirect('aspects');
    }

    public function update($id) {
        $aspect_name   = $this->input->post('aspect_name', true);
        $point_bersih  = $this->input->post('point_bersih', true);
        $point_cukup   = $this->input->post('point_cukup', true);
        $point_kotor   = $this->input->post('point_kotor', true);

        if (empty($aspect_name)) {
            $this->session->set_flashdata('error', 'Nama aspek wajib diisi!');
            redirect('aspects');
            return;
        }

        if (!is_numeric($point_bersih) || !is_numeric($point_cukup) || !is_numeric($point_kotor)) {
            $this->session->set_flashdata('error', 'Semua poin harus berupa angka!');
            redirect('aspects');
            return;
        }

        if ((int)$point_bersih < (int)$point_cukup || (int)$point_cukup < (int)$point_kotor) {
            $this->session->set_flashdata('error', 'Poin Bersih harus ≥ Cukup, dan Cukup harus ≥ Kotor!');
            redirect('aspects');
            return;
        }

        $data = [
            'aspect_name'  => $aspect_name,
            'point_bersih' => (int)$point_bersih,
            'point_cukup'  => (int)$point_cukup,
            'point_kotor'  => (int)$point_kotor,
        ];

        if ($this->aspects->update($id, $data)) {
            $this->session->set_flashdata('success', 'Aspek penilaian berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui aspek!');
        }

        redirect('aspects');
    }

    public function delete($id) {
        $used = $this->aspects->is_used($id);

        if ($used > 0) {
            $this->session->set_flashdata('error', 'Aspek tidak bisa dihapus karena sudah digunakan di ' . $used . ' penilaian!');
            redirect('aspects');
            return;
        }

        if ($this->aspects->delete($id)) {
            $this->session->set_flashdata('success', 'Aspek penilaian berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus aspek!');
        }

        redirect('aspects');
    }
}
