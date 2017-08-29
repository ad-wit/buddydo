<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UAuth{
	public $_ref;
	public function __construct(){
		$this->_ref =& get_instance();
		define("UAUTH_USER_SESSION", "e68f2a44bbaf");
		// $this->_ref->load->database();
		// $this->_ref->load->model('Encrypt_model');
	}

	public function login( $email, $password ){
		$pass = $this->_ref->encrypt_model->generatePasswordHash($password);
		$this->_ref->db->where(array(
			'user_email' => $email,
			"user_password" => $pass
			));
		$this->_ref->db->join("roles", "users.user_role = roles.role_id", "left");
		$user = $this->_ref->db->get('users');
		if( $user->num_rows() == 1 ){
			$user = $user->row_array();
			$this->_ref->session->set_userdata(UAUTH_USER_SESSION, $user);
			return true;
		}else{
			return false;
		}
	}

	public function isEmailRegistered($email){
		$user = $this->_ref->db->get_where('users', array('user_email' => $email, 'user_email !=' => 'admin@admin.com' ));
		if( $user->num_rows() > 0 ){
			return true;
		}else{
			return false;
		}
	}

	public function logout(){
		$this->_ref->session->unset_userdata(UAUTH_USER_SESSION);
	}

	public function haspermission($permission_string){
		if( $this->isloggedin() ){
			$user = $this->_ref->session->userdata(UAUTH_USER_SESSION);
			$user_permission = explode("/", $user['role_permission_strings']);
			if( in_array($permission_string, $user_permission) ){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function isloggedin(){
		return $this->_ref->session->userdata(UAUTH_USER_SESSION) == true;
	}
	public function getuser(){
		return($this->_ref->session->userdata(UAUTH_USER_SESSION));
	}
}