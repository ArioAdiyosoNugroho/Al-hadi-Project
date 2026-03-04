<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('M_users');
    }

    public function index()
    {
		$data = [
			'title' => 'Dashboard',
			'content' => 'pages/dashboard/index',
		];
		$this->load->view('layouts/main', $data);
    }
}
