<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends BaseController {

	public function __construct(){
		parent::__construct();
		$this->load->model('courses_model');
	}

	private $module_name = 'course'; // Sigular
	private $module_name_p = 'courses'; // Plural

	public function index(){
		$data["header"] = $this->makeHeader('courses_list');
		$data["assets"] = $this->getAssets('courses_list');
		$data['title'] = ucfirst($this->module_name_p);
		$data['dtUrl'] = base_url('courses/getCourses');
		$this->loadview("admin/$this->module_name_p/list", $data);
		if(isset($_POST["comments"]) && isset($_POST["qid"]) && isset($_SESSION["id"]) && isset($connection)){
    		$comment=$_POST['comments'];
    		$qid= $_POST['qid'];
    		$reslt_user= mysqli_query($connection,"SELECT * FROM tbl_users,`queries` where id='".$_SESSION['id']."' AND  qid= '".$qid."'");
    		$row_lat_lng= mysqli_fetch_array($reslt_user);
    		$stmt = mysqli_query($connection,"INSERT INTO comments set uid='".$_SESSION['id']."',comments='".$comment."',reply='".$reply."', qid= '".$qid."' ");
    	}else{
    		echo "Invalid Request";
    	}
	}

	public function add(){
		$data["header"] = $this->makeHeader('courses_add');
		$data["assets"] = $this->getAssets('courses_add');
		$data["autoSuggestTags"] = $this->tags_model->getTags('csv');
		$data['title'] = "Add " . ucfirst($this->module_name);
		$data['url'] = base_url("$this->module_name_p/save");
		$data['courses'] = $this->common_model->getSelectOptions('courses', null, 'course_public_id', 'course_name', 'Select Parent Course');
		$data['submitButtonText'] = "Add";
		$this->loadview("admin/$this->module_name_p/form", $data);
	}

	public function edit( $publicId = null ){
		$data["header"] = $this->makeHeader('courses_edit');
		$data["assets"] = $this->getAssets('courses_edit');
		$data["autoSuggestTags"] = $this->tags_model->getTags('csv');
		$data['title'] = "Edit " . ucfirst($this->module_name);
		$data['url'] = base_url("$this->module_name_p/save/$publicId");
		$data['course'] = $this->courses_model->getCourse( $publicId );
		$data['courses'] = $data['course']['parentcourses'];
		$data['submitButtonText'] = "Save";
		$data['publicId'] = $publicId;
		$this->loadview("admin/$this->module_name_p/form", $data);
	}

	public function save( $publicId = null ){
		$this->courses_model->save($publicId);
	}

	public function getCourses(){
		$this->courses_model->getCoursesForDatatable();
	}

}
