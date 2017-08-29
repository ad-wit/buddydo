<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Breadcrumbs{

	public $_ref;
	public function __construct(){
		$this->_ref =& get_instance();
		$this->_ref->load->database();
		$this->_ref->load->library("parser");
	}

	public function get( $template = null, $data = null ){
		if( !is_null($template) && !is_null($data) ){
			return $this->_ref->parser->parse( $template, $data, true );
		}else{
			return "";
		}
	}

}
