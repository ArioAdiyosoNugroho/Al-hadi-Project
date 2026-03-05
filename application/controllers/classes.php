<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends MY_Controller {

    /** @var M_classes */
    public $classes;

    public function __construct() {
        parent::__construct();
        $this->load->model('M_classes', 'classes');
    }

    public function index() {
        $data = [
            'title'   => 'Kelola Kelas',
            'content' => 'pages/classes/index',
            'classes' => $this->classes->get_all(),
        ];
        $this->load->view('layouts/main', $data);
    }

    public function store() {
        $class_name = $this->input->post('class_name', true);

        if (empty($class_name)) {
            $this->session->set_flashdata('error', 'Nama Kelas tidak boleh kosong!');
            redirect('classes');
            return;
        }

        $data = ['class_name' => $class_name];
        $insert = $this->classes->insert($data);

        if ($insert) {
            $this->session->set_flashdata('success', 'Data Kelas berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambah data!');
        }

        redirect('classes');
    }

    public function update($id) {
        $class_name = $this->input->post('class_name', true);

        if (empty($class_name)) {
            $this->session->set_flashdata('error', 'Nama Kelas tidak boleh kosong!');
            redirect('classes');
            return;
        }

        $data = ['class_name' => $class_name];
        $update = $this->classes->update($id, $data);

        if ($update) {
            $this->session->set_flashdata('success', 'Data Kelas berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data!');
        }

        redirect('classes');
    }

    public function delete($id) {
        $used = $this->classes->is_used($id);

        if ($used > 0) {
            $this->session->set_flashdata('error', 'Kelas tidak bisa dihapus karena masih digunakan oleh ' . $used . ' penilaian!');
            redirect('classes');
            return;
        }

        if ($this->classes->delete($id)) {
            $this->session->set_flashdata('success', 'Data Kelas berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data!');
        }

        redirect('classes');
    }
}
