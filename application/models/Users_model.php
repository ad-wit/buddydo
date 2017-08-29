<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Users_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->library('uauth');
		$this->load->model('datatable_model');
	}

	private $module_name = 'user'; // Sigular
	private $module_name_p = 'users'; // Plural
	public $rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|required',
				'errors' => array(
	                    'required' => 'You must provide a name.',
	                )
				),
            array(
            	'field' => 'email',
				'label' => 'Email',
				'rules' => 'trim|required',
				'errors' => array(
	                    'required' => 'You must provide email.',
	                )
            	)
		);
	
	public function save( $publicId = null ){
		$this->validate($publicId);
		if( is_null($publicId) ){
			// Public Id is absent
			// Adding user
			$userName = $this->input->post('name', true);
			$userEmail = $this->input->post('email', true);
			$userPassword = $this->input->post('password', true);
			$retypePassword = $this->input->post('retype_password', true);

			$userPassword = $this->encrypt_model->generatePasswordHash($userPassword);
			$user_public_id = $this->encrypt_model->generatePublicId('users', 'user_public_id');
			$user = array(
				'user_public_id' => $user_public_id,
				'user_name' => $userName,
				'user_email' => $userEmail,
				'user_password' => $userPassword,
				'user_role' => 2,
				'user_created_at' => $this->common_model->now(),
				'user_created_by' => 1
				);
			$this->db->insert('users', $user);
			$this->session->set_flashdata('form_success', 'user Added Successfully');
			redirect($_SERVER["HTTP_REFERER"]);
		}else{
			// Public Is is present
			// Updating user
			$userName = $this->input->post('name', true);
			$userEmail = $this->input->post('email', true);
			$userPassword = $this->input->post('password', true);
			$retypePassword = $this->input->post('retype_password', true);

			

			$user = array(
				'user_name' => $userName,
				'user_email' => $userEmail,
				'user_updated_at' => $this->common_model->now(),
				'user_updated_by' => 1
				);
			if( !empty($userPassword) && !empty($retypePassword) ){
				$userPassword = $this->encrypt_model->generatePasswordHash($userPassword);
				$user['user_password'] = $userPassword;
			}
			$this->db->where('user_public_id', $publicId);
			$this->db->update('users', $user);

			$this->session->set_flashdata('form_success', 'User Updated Successfully');
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}

	public function validate( $publicId = null ){


		$this->form_validation->set_rules($this->rules);
		if( $this->form_validation->run() == true ){
			// While inserting record
			if( is_null($publicId) ){
				$errors = array();
				if( empty($this->input->post('password', true)) ){
					$errors['password'] = 'Password field is missing';
				}
				if( empty($this->input->post('retype_password', true)) ){
					$errors['retype_password'] = 'Retype Password field is missing';
				}
				if( $this->input->post('password', true) != $this->input->post('retype_password', true) ){
					$errors['password'] = 'Passwords do not match';
				}
				if( $this->uauth->isEmailRegistered($this->input->post('email', true)) ){
					$errors['email'] = 'Email already registered';
				}
				if( count($errors) > 0 ){
					$formdata = array(
						'name' => $this->input->post('name', true),
						'email' => $this->input->post('email', true)
						);
					$this->session->set_flashdata('insert_error_formdata', $formdata);
					$this->session->set_flashdata('form_error', $errors);
					redirect($_SERVER["HTTP_REFERER"]);
				}
			}else{
				if( !$this->common_model->isValidPublicId('users', 'user_public_id', $publicId) ){
					$this->session->set_flashdata('form_error', array('custom_error_message' => 'Invalid Request'));
					redirect($_SERVER["HTTP_REFERER"]);
				}
				if($this->input->post('password', true) == true || $this->input->post('retype_password', true) == true){
					if( $this->input->post('password', true) != $this->input->post('retype_password', true) ){
						$errs['password'] = 'Passwords do not match.';
						$this->session->set_flashdata('form_error', $errs);
						redirect($_SERVER["HTTP_REFERER"]);
					}
				}
			}
	    }else{
			$errors = $this->form_validation->error_array();
			if( is_null($publicId) ){
				$errors = array();
				if( empty($this->input->post('password', true)) ){
					$errors['password'] = 'Password field is missing';
				}
				if( empty($this->input->post('retype_password', true)) ){
					$errors['retype_password'] = 'Retype Password field is missing';
				}
				if( $this->input->post('password', true) != $this->input->post('retype_password', true) ){
					$errors['password'] = 'Passwords do not match';
				}
				if( $this->uauth->isEmailRegistered($this->input->post('email', true)) ){
					$errors['email'] = 'Email already registered';
				}
				if( count($errors) > 0 ){
					$formdata = array(
						'name' => $this->input->post('name', true),
						'email' => $this->input->post('email', true)
						);
					$this->session->set_flashdata('insert_error_formdata', $formdata);
					$this->session->set_flashdata('form_error', $errors);
					redirect($_SERVER["HTTP_REFERER"]);
				}
			}else{
				if( !$this->common_model->isValidPublicId('users', 'user_public_id', $publicId) ){
					$this->session->set_flashdata('form_error', array('custom_error_message' => 'Invalid Request'));
					redirect($_SERVER["HTTP_REFERER"]);
				}
				if($this->input->post('password', true) == true || $this->input->post('retype_password', true) == true){
					if( $this->input->post('password', true) != $this->input->post('retype_password', true) ){
						$errs['password'] = 'Passwords do not match.';
						$this->session->set_flashdata('form_error', $errs);
						redirect($_SERVER["HTTP_REFERER"]);
					}
				}
			}
	    }
	}

	public function getusersForDatatable(){
		$table = 'users';
		$primaryKey = 'user_id';
		$columns = array(
			array( 'db' => 'user_name', 'dt' => 0 ),
			array( 'db' => 'user_email', 'dt' => 1 ),
			array( 'db' => 'user_created_at', 'dt' => 2 ),
			array( 'db' => 'user_public_id', 'dt' => 3 )
		);
		$join_where = "WHERE user_role != 1";

		$arr = $this->datatable_model->get_rows( $_GET, $table, $primaryKey, $columns, $join_where );
		$ret = $this->formatArticleData($arr['data']['info']);
	    $a = array(
	        "draw" => $arr['draw'],
	        "recordsTotal" => $arr['recordsFiltered'],
	        "recordsFiltered" => $arr['recordsFiltered'],
	        "data" => $ret
	        );
	    echo json_encode($a);
	}

	public function formatArticleData($data){
	    if(!empty($data)){
	        $res = "";
	        foreach ($data as $key => $value){
				$res[] =  array(
						$value['user_name'],
						$value['user_email'],
						date("d-M-Y", strtotime($value['user_created_at'])),
						'<a class="ui button mini app-button " href="' . base_url('users/edit') . '/' . $value['user_public_id'] .'">Edit</a>'
				    );
				}
				return $res;
	    }else{
	        return "";
	    }
	}

	public function getuser( $publicId = null ){
		if( is_null($publicId) ){
			return array();
		}else{
			// $this->db->join('files', 'files.file_id = users.user_image');
			$data = $this->db->get_where('users', array( 'user_public_id' => $publicId ));
			if( $data->num_rows() == 1 ){
				$data = $data->row_array();

				return array(
					'name' => $data['user_name'],
					'email' => $data['user_email']
					);
			}else{
				return array();
			}
		}
	}

}



?>