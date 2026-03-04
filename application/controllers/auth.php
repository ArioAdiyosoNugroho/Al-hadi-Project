<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model di constructor agar tersedia di semua method jika nanti ditambah
        // $this->load->model('M_dashboard');
    }

	public function index(){
        $this->load->view('pages/auth/login');
	}
}
