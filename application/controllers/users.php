<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_users', 'users');
    }

    public function index() {
        $data = [
            'title'   => 'Kelola User',
            'content' => 'pages/users/index',
            'users'   => $this->users->get_all(),
        ];
        $this->load->view('layouts/main', $data);
    }

    public function store() {
        $username = trim($this->input->post('username', true));
        $password = $this->input->post('password');
        $confirm  = $this->input->post('confirm_password');

        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username dan password wajib diisi!');
            redirect('users');
            return;
        }

        if ($password !== $confirm) {
            $this->session->set_flashdata('error', 'Konfirmasi password tidak cocok!');
            redirect('users');
            return;
        }

        if ($this->users->username_exists($username)) {
            $this->session->set_flashdata('error', 'Username sudah digunakan!');
            redirect('users');
            return;
        }

        $save = $this->users->insert([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        if ($save) {
            $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan user!');
        }

        redirect('users');
    }

    public function update($id) {
        $username = trim($this->input->post('username', true));
        $password = $this->input->post('password');
        $confirm  = $this->input->post('confirm_password');

        if (empty($username)) {
            $this->session->set_flashdata('error', 'Username wajib diisi!');
            redirect('users');
            return;
        }

        if ($this->users->username_exists($username, $id)) {
            $this->session->set_flashdata('error', 'Username sudah digunakan!');
            redirect('users');
            return;
        }

        $update_data = ['username' => $username];

        // Hanya update password jika diisi
        if (!empty($password)) {
            if ($password !== $confirm) {
                $this->session->set_flashdata('error', 'Konfirmasi password tidak cocok!');
                redirect('users');
                return;
            }
            $update_data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($this->users->update($id, $update_data)) {
            $this->session->set_flashdata('success', 'User berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui user!');
        }

        redirect('users');
    }

    public function delete($id) {
        // Cegah hapus diri sendiri
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus akun yang sedang digunakan!');
            redirect('users');
            return;
        }

        if ($this->users->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user!');
        }

        redirect('users');
    }
}
