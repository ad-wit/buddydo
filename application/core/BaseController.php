<?php defined('BASEPATH') OR exit('No direct script access allowed');
class BaseController extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library("parser");
	}
	
	private $courses_module_name = 'course'; // Sigular
	private $courses_module_name_p = 'courses'; // Plural

	private $modules_module_name = 'module'; // Sigular
	private $modules_module_name_p = 'modules'; // Plural

	private $users_module_name = 'user'; // Sigular
	private $users_module_name_p = 'users'; // Plural

	public function loadview( $view = null, $data = null ){
		if( !is_null($view) ){
			$this->load->view("admin/common/header", $data);
			$this->load->view("admin/common/navbar", $data);
			$this->load->view("admin/common/sidebar", $data);
			$this->load->view($view, $data);
			$this->load->view("admin/common/footer", $data);
		}else{
			echo "View is null";
		}
	}


	public function makeHeader( $page = null ){
		if( is_null($page) ){
			return '';
		}
		switch ($page) {
			case 'courses_edit':
				$data = array(
					"breadcrumbs" => array(
						array("url" => base_url("dashboard"), "label" => "Dashboard"),
						array("url" => base_url($this->courses_module_name_p), "label" => ucfirst($this->courses_module_name_p))
						),
					"active" => "Edit " . ucfirst($this->courses_module_name),
					'title' => "Edit " . ucfirst($this->courses_module_name),
					'backlink' => array(
						'url' => base_url('courses'),
						'label' => "Back to " . ucfirst($this->courses_module_name_p),
						'icon' => '<i class="left arrow icon"></i>'
						)
					);
				return $this->getHeader($data);
				break;
			
			case 'courses_add':
				$data = array(
					"breadcrumbs" => array(
						array("url" => base_url("dashboard"), "label" => "Dashboard"),
						array("url" => base_url($this->courses_module_name_p), "label" => ucfirst($this->courses_module_name_p))
						),
					"active" => "Add " . ucfirst($this->courses_module_name),
					'title' => "Add " . ucfirst($this->courses_module_name),
					'backlink' => array(
						'url' => base_url("$this->courses_module_name_p"),
						'label' => "Back to " . ucfirst($this->courses_module_name_p),
						'icon' => '<i class="left arrow icon"></i>'
						)
					);
				return $this->getHeader($data);
				break;
			case 'users_add':
				$data = array(
					"breadcrumbs" => array(
						array("url" => base_url("dashboard"), "label" => "Dashboard"),
						array("url" => base_url($this->users_module_name_p), "label" => ucfirst($this->users_module_name_p))
						),
					"active" => "Add " . ucfirst($this->users_module_name),
					'title' => "Add " . ucfirst($this->users_module_name),
					'backlink' => array(
						'url' => base_url("$this->users_module_name_p"),
						'label' => "Back to " . ucfirst($this->users_module_name_p),
						'icon' => '<i class="left arrow icon"></i>'
						)
					);
				return $this->getHeader($data);
				break;
			case 'courses_list':
				$data = array(
					"breadcrumbs" => array(
						array("url" => base_url("dashboard"), "label" => "Dashboard")
						),
					"active" => ucfirst($this->courses_module_name_p),
					'title' => ucfirst($this->courses_module_name_p),
					'backlink' => array(
						'url' => base_url("$this->courses_module_name_p/add"),
						'label' => "Add " . ucfirst($this->courses_module_name),
						'icon' => '<i class="add icon"></i>'
						)
					);
				return $this->getHeader($data);
				break;
			case 'users_list':
				$data = array(
					"breadcrumbs" => array(
						array("url" => base_url("dashboard"), "label" => "Dashboard")
						),
					"active" => ucfirst($this->users_module_name_p),
					'title' => ucfirst($this->users_module_name_p),
					'backlink' => array(
						'url' => base_url("$this->users_module_name_p/add"),
						'label' => "Add " . ucfirst($this->users_module_name),
						'icon' => '<i class="add icon"></i>'
						)
					);
				return $this->getHeader($data);
				break;
			case 'modules_list':
				$data = array(
					"breadcrumbs" => array(
						array("url" => base_url("dashboard"), "label" => "Dashboard")
						),
					"active" => ucfirst($this->modules_module_name_p),
					'title' => ucfirst($this->modules_module_name_p),
					'backlink' => array(
						'url' => base_url("$this->modules_module_name_p/add"),
						'label' => "Add " . ucfirst($this->modules_module_name),
						'icon' => '<i class="add icon"></i>'
						)
					);
				return $this->getHeader($data);
				break;
			case 'modules_add':
				$data = array(
					"breadcrumbs" => array(
						array("url" => base_url("dashboard"), "label" => "Dashboard"),
						array("url" => base_url($this->modules_module_name_p), "label" => ucfirst($this->modules_module_name_p))
						),
					"active" => "Add " . ucfirst($this->modules_module_name),
					'title' => "Add " . ucfirst($this->modules_module_name),
					'backlink' => array(
						'url' => base_url("$this->modules_module_name_p"),
						'label' => "Back to " . ucfirst($this->modules_module_name_p),
						'icon' => '<i class="left arrow icon"></i>'
						)
					);
				return $this->getHeader($data);
				break;
			case 'modules_edit':
				$data = array(
					"breadcrumbs" => array(
						array("url" => base_url("dashboard"), "label" => "Dashboard"),
						array("url" => base_url($this->modules_module_name_p), "label" => ucfirst($this->modules_module_name_p))
						),
					"active" => "Edit " . ucfirst($this->modules_module_name),
					'title' => "Edit " . ucfirst($this->modules_module_name),
					'backlink' => array(
						'url' => base_url("$this->modules_module_name_p"),
						'label' => "Back to " . ucfirst($this->modules_module_name_p),
						'icon' => '<i class="left arrow icon"></i>'
						)
					);
				return $this->getHeader($data);
				break;
			case 'users_edit':
				$data = array(
					"breadcrumbs" => array(
						array("url" => base_url("dashboard"), "label" => "Dashboard"),
						array("url" => base_url($this->users_module_name_p), "label" => ucfirst($this->users_module_name_p))
						),
					"active" => "Edit " . ucfirst($this->users_module_name),
					'title' => "Edit " . ucfirst($this->users_module_name),
					'backlink' => array(
						'url' => base_url("$this->users_module_name_p"),
						'label' => "Back to " . ucfirst($this->users_module_name_p),
						'icon' => '<i class="left arrow icon"></i>'
						)
					);
				return $this->getHeader($data);
				break;
		}
	}

	public function getHeader( $data = null ){
		if( !is_null($data) ){
			$data['breadcrumbs'] = $this->breadcrumbs->get("admin/common/admin_breadcrumbs_template", $data);
			return $this->load->view('admin/common/admin_header_template', $data, true);
		}else{
			return "";
		}
	}


	public function getAssets( $page = null ){
		if( is_null($page) ){
			return array();
		}
		switch ($page) {
			case 'courses_edit':
			case 'courses_add':
			case 'modules_add':
			case 'modules_edit':
			case 'users_edit':
			case 'users_add':
				return array(
					'<link rel="stylesheet" href="' . base_url("assets/css/jquery.tag-editor.css") . '">',
					'<link rel="stylesheet" href="' . base_url("assets/css/jquery-ui.min.css") . '">',
					'<script src="' . base_url("assets/js/jquery-ui.min.js") . '" type="text/javascript" charset="utf-8"></script>',
					'<script src="' . base_url("assets/plugins/ckeditor/ckeditor.js") . '" type="text/javascript" charset="utf-8"></script>',
					'<script src="' . base_url("assets/js/jquery.tag-editor.min.js") . '" type="text/javascript" charset="utf-8"></script>',
					'<script src="' . base_url("assets/js/jquery.caret.min.js") . '" type="text/javascript" charset="utf-8"></script>'
				);
				break;
			case 'courses_list':
			case 'modules_list':
			case 'users_list':
				return array(
					'<link rel="stylesheet" href="' . base_url("assets/plugins/datatables/semantic/dataTables.semanticui.min.css") . '">',
					'<script src="' . base_url("assets/plugins/datatables/semantic/jquery.dataTables.min.js") . '" type="text/javascript" charset="utf-8"></script>',
					'<script src="' . base_url("assets/plugins/datatables/semantic/dataTables.semanticui.min.js") . '" type="text/javascript" charset="utf-8"></script>'
				);
				break;
		}
		
	}
	
}
?>