<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    /** @var M_auth */
    public $auth;

    public function __construct() {
        parent::__construct();
        $this->load->model('M_auth', 'auth');
        $this->load->library('session');
    }

    /**
     * Halaman Login
     * Jika sudah login, redirect ke dashboard
     */
    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
            return;
        }

        $data = ['title' => 'Login'];
        $this->load->view('pages/auth/login', $data);
    }

    /**
     * Proses Login
     */
    public function login() {
        // Jika sudah login
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
            return;
        }

        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        // Validasi input kosong
        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username dan password wajib diisi!');
            redirect('auth');
            return;
        }

        // Cari user di database
        $user = $this->auth->get_by_username($username);

        if (!$user) {
            $this->session->set_flashdata('error', 'Username tidak ditemukan!');
            redirect('auth');
            return;
        }

        // Verifikasi password (password_hash)
        if (!password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Password yang Anda masukkan salah!');
            redirect('auth');
            return;
        }

        // Set session login
        $this->session->set_userdata([
            'logged_in' => true,
            'user_id'   => $user->id,
            'username'  => $user->username,
        ]);

        $this->session->set_flashdata('success', 'Selamat datang, ' . $user->username . '!');
        redirect('dashboard');
    }

    /**
     * Logout
     */
    public function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Anda telah berhasil logout.');
        redirect('auth');
    }
}
