<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends BaseController {

	public function __construct(){
		parent::__construct();
		$this->load->library('uauth');
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
	}

	public function index(){
		$this->dashboard();
	}

	public function dashboard(){
		$this->load->view("admin/common/header");
		$this->load->view("admin/common/navbar");
		$this->load->view("admin/common/sidebar");
		$this->load->view("admin/dashboard");
		$this->load->view("admin/common/footer");
	}

	public function logout(){
		$this->uauth->logout();
		redirect('app');
	}


}
