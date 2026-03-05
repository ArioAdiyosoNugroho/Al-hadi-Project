<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    /** @var M_users */
    public $users;

    public function __construct() {
        parent::__construct();
        $this->load->model('M_users', 'users');
    }

    public function index() {
        $data = [
            'title'   => 'Kelola Aspek Penilaian',
            'content' => 'pages/users/index',
            'users' => $this->users->get_all(),
        ];
        $this->load->view('layouts/main', $data);
    }
}
