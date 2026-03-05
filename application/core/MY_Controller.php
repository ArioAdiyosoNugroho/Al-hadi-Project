<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller
 * Base controller yang wajib di-extend oleh semua controller yang butuh login.
 *
 * Cara pakai:
 *   class Dashboard extends MY_Controller { ... }
 *
 * Letakkan file ini di: application/core/MY_Controller.php
 */
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->_check_auth();
    }

    /**
     * Cek apakah user sudah login.
     * Jika belum, redirect ke halaman login.
     */
    private function _check_auth() {
        if (!$this->session->userdata('logged_in')) {
            // $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth');
        }
    }
}
