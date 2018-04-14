<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
	//	$this->load->model('user_mod');
	}

	public function index() /*Super admin, admin and staff dashboard*/
	{
		if(!$this->session->userdata['userData']['session_user_id']){
			redirect('users/login');
		}
		$this->session->unset_userdata('active_menu');
		$this->session->set_userdata('active_menu', 'dashboard');

		// Define Data array
		$data = array(
			'page_title' => 'Dashboard - bsSelfBusiness System',
			'sidebar_menu_title' => 'DASHBOARD'
		);

		// Send $data array() to index page
		$data['content'] = $this->load->view('dashboard/index', $data, true);
		// Use Layout
		$this->load->view('layout/admin_layout', $data);

	}

}