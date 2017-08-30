<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends BaseController {

	public function __construct(){
		parent::__construct();

	}

	public function index(){
		$this->login();
	}

	public function login(){
		$data['title'] = 'Buddy Todo';
		$data['signinUrl'] = base_url('app/signinvalidate');
		$this->load->view('app/login', $data);
	}

	public function signinvalidate(){
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required');
		$this->form_validation->set_rules('user_password', 'Password', 'trim|required');
		if ($this->form_validation->run() == TRUE or FALSE){
			$formdata = array(
				'user_email' => $this->input->post('user_email')
				);
			$this->session->set_flashdata('formdata', $formdata);
			if( $this->uauth->login( $this->input->post('user_email'), $this->input->post('user_password') ) ){
				if( $this->uauth->haspermission('is-user') ){
					redirect('app/dashboard');
				}else if( $this->uauth->haspermission('is-admin') ){
					redirect('dashboard');
				}
			}else{
				$this->session->set_flashdata('formdata', $formdata);
				$this->session->set_flashdata('form_error', 'invalid email or password');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			echo validation_errors();
		}
	}

	public function insert(){
		// $pass = $this->encrypt_model->generatePasswordHash('helloo');
		// $data = array(
		// 		'user_public_id' => $this->encrypt_model->generatePublicId('users', 'user_public_id'),
		// 		'user_name' => 'Vikas Gupta',
		// 		'user_role' => 2,
		// 		'user_email' => 'vkg091@gmail.com',
		// 		'user_password' => $pass,
		// 		'user_created_at' => $this->common_model->now(),
		// 		'user_created_by' => 1
		// 	);
		// $this->db->insert('users', $data);
	}

	public function dashboard(){
		if( !$this->uauth->haspermission('is-user') ){
			show_404();
		}
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		$this->data["formUrl"] = base_url("app/addproject");
		$this->data["title"] = "Dashboard";
		$user = $this->uauth->getuser();
		$this->data["tasks_assigned_to_me"] = $this->db->get_where("lists", array('list_assigned_to' => $user['user_id']))->result_array();
		foreach ($this->data['tasks_assigned_to_me'] as $key => $value) {
			$this->data['tasks_assigned_to_me'][$key]['list_assigned_by'] = $this->db->get_where('users', array( 'user_id' => $value['list_assigned_by'] ))->row_array();
			$this->data['tasks_assigned_to_me'][$key]['is_completed'] = $this->isTaskListCompleted($value['list_id']);
		}
		$this->data["tasks_assigned_by_me"] = $this->db->get_where("lists", array('list_assigned_by' => $user['user_id']))->result_array();
		foreach ($this->data['tasks_assigned_by_me'] as $key => $value) {
			$this->data['tasks_assigned_by_me'][$key]['list_assigned_to'] = $this->db->get_where('users', array( 'user_id' => $value['list_assigned_to'] ))->row_array();
			$this->data['tasks_assigned_by_me'][$key]['is_completed'] = $this->isTaskListCompleted($value['list_id']);
		}
		// echo "<pre>";
		// print_r ( $this->data );
		// echo "</pre>";
		$this->load->view('app/dashboard/common/header', $this->data);
		$this->load->view('app/dashboard/projects', $this->data);
		$this->load->view('app/dashboard/common/footer', $this->data);
	}

	public function isTaskListCompleted($listid){
		$tasks = $this->db->get_where('tasks', array('task_list_id' => $listid))->result_array();
		$incomplete = false;
		if( count($tasks) == 0 ){
			return 'incomplete';
		}
		foreach ($tasks as $key => $value) {
			if( $value['task_iscompleted'] == 0 ){
				$incomplete = true;
			}
		}
		if( $incomplete ){
			return 'incomplete';
		}else{
			return 'completed';
		}
	}	

	public function tasklist($taskid = null){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		if( !$this->uauth->haspermission('is-user') ){
			show_404();
		}
		$this->data["formUrl"] = base_url("app/addproject");
		$this->data["title"] = "Dashboard";
		$this->data["taskid"] = $taskid;
		$user = $this->uauth->getuser();
		$task_list = $list = $this->db->get_where('lists', array('list_public_id' => $taskid))->row_array();
		$this->data["tasks"] = $this->db->get_where('tasks', array('task_list_id' => $task_list['list_id']))->result_array();
		$this->data["tasklist"] = $task_list;
		$this->data['tasklist']['list_assigned_by'] = $this->db->get_where('users', array( 'user_id' => $task_list['list_assigned_by'] ))->row_array();
		$this->data['tasklist']['list_assigned_to'] = $this->db->get_where('users', array( 'user_id' => $task_list['list_assigned_to'] ))->row_array();
		$message = "";
		if( $this->data['tasklist']['list_assigned_by']['user_id'] == $user['user_id'] && $this->data['tasklist']['list_assigned_to']['user_id'] == $user['user_id'] ){
			$msg = "You assigned this task list to yourself.";
		}else if( $this->data['tasklist']['list_assigned_by']['user_id'] == $user['user_id'] ){
			$msg = "You assigned this task list to " . $this->data['tasklist']['list_assigned_to']['user_name'];
		}else if( $this->data['tasklist']['list_assigned_to']['user_id'] == $user['user_id'] ){
			$msg = $this->data['tasklist']['list_assigned_by']['user_name'] . " assigned this task list to you.";
		}
		$incomplete = false;
		foreach ($this->data['tasks'] as $key => $value) {
			if( $value['task_iscompleted'] == 0 ){
				$incomplete = true;
			}
		}
		if( $incomplete ){
			$this->data['status'] = 'In Complete';
		}else{
			if( count($this->data['tasks']) == 0 ){
				$this->data['status'] = 'In Complete';
			}else{
				$this->data['status'] = 'Completed';
			}
		}
		$this->data['summary'] = $msg;
		$this->load->view('app/dashboard/common/header', $this->data);
		$this->load->view('app/dashboard/tasks', $this->data);
		$this->load->view('app/dashboard/common/footer', $this->data);
	}

	public function marktask($what, $taskid){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		$iscompleted = ( $what == 'complete' ? 1 : 0 );
		$task = array(
			'task_iscompleted' => $iscompleted
			);
		$this->db->where('task_public_id', $taskid);
		$this->db->update('tasks', $task);
		redirect($_SERVER["HTTP_REFERER"]);
	}

	public function addtask($taskid){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		if( !$this->uauth->haspermission('is-user') ){
			show_404();
		}
		if( $this->uauth->isloggedin() ){
			if( $this->input->get('tasktext', true) == true ){
				$tasktext = $this->input->get('tasktext', true);
				$list = $this->db->get_where('lists', array('list_public_id' => $taskid));
				if( $list->num_rows() > 0 ){
					$list = $list->row_array();
					$user = $this->uauth->getuser();
					$task = array(
						'task_public_id' => $this->encrypt_model->generatePublicId("tasks", "task_public_id"),
						'task_list_id' => $list['list_id'],
						'task_description' => $tasktext,
						'task_created_at' => $this->common_model->now(),
						'task_created_by' => $user['user_id'],
						);
					$status = $this->db->insert('tasks', $task);
					if( $status ){
						$ret = array(
							'status' => 'success',
							'message' => 'Task added successfully.'
							);
						echo json_encode($ret);
					}else{
						$ret = array(
							'status' => 'error',
							'message' => 'Failed in adding task'
							);
						echo json_encode($ret);
					}
				}else{
					$ret = array(
						'status' => 'error',
						'message' => 'Invalid task list'
						);
					echo json_encode($ret);
				}
			}else{
				$ret = array(
					'status' => 'error',
					'message' => 'Task parameter is reqired'
					);
				echo json_encode($ret);
			}
		}else{
			$ret = array(
				'status' => 'error',
				'message' => 'Session logged out.'
				);
			echo json_encode($ret);	
		}
	}
	// public function form(){
	// 	$this->load->view('app/dashboard/common/header');
	// 	$this->load->view('app/dashboard/form');
	// 	$this->load->view('app/dashboard/common/footer');
	// }
	public function addproject(){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		if( !$this->uauth->haspermission('is-user') ){
			show_404();
		}
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$project = array(
				"project_public_id" => $this->encrypt_model->generatePublicId("projects", "project_public_id"),
				"project_name" => $this->input->post("name", true),
				"project_description" => $this->input->post("description", true),
				"project_created_by" => 1,
				"project_created_at" => $this->common_model->now()
				);
			$status = $this->db->insert("projects", $project);
			if( $status ){
				$this->session->set_flashdata("form_success", "Project Added");
				redirect($_SERVER["HTTP_REFERER"]);
			}else{
				$this->session->set_flashdata("form_error", "Error Occurred");
				redirect($_SERVER["HTTP_REFERER"]);
			}
		} else {
			$this->session->set_flashdata("form_error", validation_errors());
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}

	public function addtasklist(){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		if( !$this->uauth->haspermission('is-user') ){
			show_404();
		}
		if( $this->uauth->isloggedin() ){
			if( $this->input->post('listname', true) == true && $this->input->post('buddyemail', true) == true ){
				$listname = $this->input->post('listname', true);
				$buddyemail = $this->input->post('buddyemail', true);
				$user = $this->uauth->getuser();
				if( $this->uauth->isEmailRegistered($buddyemail) ){
					$to = $this->db->get_where('users', array('user_email' => $buddyemail))->row_array()['user_id'];
					$list = array(
						'list_public_id' => $this->encrypt_model->generatePublicId("lists", "list_public_id"),
						'list_name' => $listname,
						'list_assigned_by' => $user['user_id'],
						'list_assigned_to' => $to,
						'list_created_at' => $this->common_model->now(),
						'list_created_by' => $user['user_id'],
						);
					$status = $this->db->insert('lists', $list);
					if( $status ){
						$ret = array(
							'status' => 'success',
							'message' => 'List assigned successfully.'
							);
						echo json_encode($ret);
					}else{
						$ret = array(
							'status' => 'error',
							'message' => 'Failed in creating list'
							);
						echo json_encode($ret);
					}
				}else{
					$ret = array(
						'status' => 'error',
						'message' => 'Account with this email doesn\'t exists.'
						);
					echo json_encode($ret);
				}
			}else{
				$ret = array(
					'status' => 'error',
					'message' => 'List name and email parameters are required'
					);
				echo json_encode($ret);
			}
		}else{
			$ret = array(
				'status' => 'error',
				'message' => 'Session logged out.'
				);
			echo json_encode($ret);	
		}
	}
	public function project( $publicId = null, $action = null ){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		if( !$this->uauth->haspermission('is-user') ){
			show_404();
		}
		if( !is_null($publicId) && !is_null($action) ){
			if( $this->common_model->isValidPublicId("projects", "project_public_id", $publicId) ){
				if( $action == "tasks" ){
					$this->data["title"] = "Tasks";
					$this->load->view('app/dashboard/common/header', $this->data);
					$this->load->view('app/dashboard/tasks', $this->data);
					$this->load->view('app/dashboard/common/footer', $this->data);
				}else if( $action == "edit" ){
					echo "edit";
				}else if( $action == "delete" ){
					echo "delete";
				}else{
					echo "invalid request";
				}
			}else{
				echo "Invalid Id";
			}
		}else{
			echo "Invalid Request";
		}
	}

	public function logout(){
		$this->uauth->logout();
		redirect('app');
	}


}
