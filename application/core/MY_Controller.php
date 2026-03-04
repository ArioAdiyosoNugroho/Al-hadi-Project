<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Migration $migration
 */
class MY_Controller extends CI_Controller
{
    protected $user;

    public function __construct()
    {
        parent::__construct();

        // Load kebutuhan dasar
        $this->load->database();
        $this->load->library('session');

        // // Cek login (kecuali di controller Auth)
        // $current_controller = $this->router->fetch_class();

        // if ($current_controller !== 'auth') {
        //     if (!$this->session->userdata('logged_in')) {
        //         redirect('auth');
        //     }

        //     // simpan data user
        //     $this->user = [
        //         'id'   => $this->session->userdata('user_id'),
        //         'name' => $this->session->userdata('name'),
        //     ];
        // }
    }

    // /**
    //  * Cek role yang diperbolehkan
    //  * contoh:
    //  * $this->require_role('admin');
    //  * $this->require_role(['admin','owner']);
    //  */
    // protected function require_role($roles)
    // {
    //     if (!$this->session->userdata('logged_in')) {
    //         redirect('auth');
    //     }

    //     $user_role = $this->session->userdata('role');

    //     if (is_array($roles)) {
    //         if (!in_array($user_role, $roles)) {
    //             show_error('Akses ditolak', 403);
    //         }
    //     } else {
    //         if ($user_role !== $roles) {
    //             show_error('Akses ditolak', 403);
    //         }
    //     }
    // }
}
