<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends BaseController{
	public function __construct(){
		parent::__construct();
		$this->load->library('uauth');
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
	}
	public function index(){
		$data['title'] = 'Dashboard';
		$bread = array(
			"breadcrumbs" => array(),
			"active" => "Dashboard"
			);
		$data["breadcrumbs"] = $this->breadcrumbs->get("admin/common/admin_breadcrumbs_template", $bread);
		$this->loadview('admin/dashboard', $data);
	}
}
?>