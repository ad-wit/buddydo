<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fileupload{

	public $_ref;
	public $relative_filepath = "../uploads/files";
	public $relative_imagepath = "../uploads/images";
	public $filepath;
	public $imagepath;

	public function __construct(){
		$this->_ref =& get_instance();
		$this->_ref->load->database();
		$this->filepath = APPPATH . $this->relative_filepath;
		$this->imagepath = APPPATH . $this->relative_imagepath;
		$this->createDir( $this->filepath );
		$this->createDir( $this->imagepath );
	}

	/**
	 * [upload Upload or update uploaded file]
	 * @param  [array]  $file             [description]
	 * @param  [string]  $name             [description]
	 * @param  [string]  $file_public_name [description]
	 * @param  [int]  $user_id          [description]
	 * @param  [string]  $file_public_id   [description]
	 * @param  boolean $update           [description]
	 * @return [type]                    [description]
	 */
	public function upload($file = null, $name = null, $file_public_name = null, $user_id = null, $file_public_id = null, $update = false){
		if( $update && !is_null($file_public_id) ){
			if( $this->isset_file($file, $name) ){
				$file_name = $file[$name]['name'];
				$name_arr = explode(".", $file_name);
				$file_extension = strtolower(end($name_arr));
				$new_filename = $this->generateFileName('files', "file_name") . "." . $file_extension;
				$file_mimetype = $file[$name]['type'];
				$file_size = $file[$name]['size'];
				$target_path = $this->filepath . "/" . $new_filename;
				if (move_uploaded_file($file[$name]["tmp_name"], $target_path)) {
					$this->deletefile($file_public_id);
					$file_arr = array(
						"file_user_id" => ( is_null($user_id) ? null : $user_id ),
						"file_public_name" => ( is_null($file_public_name) ? null : $file_public_name ),
						"file_mime_type" => $file_mimetype,
						"file_size" => $file_size,
						"file_name" => $new_filename,
						"file_path" => $this->relative_filepath . "/$new_filename",
						"file_extension" => $file_extension,
						);
					$this->_ref->db->where("file_public_id", $file_public_id);
					$status = $this->_ref->db->update('files', $file_arr);
					return $status;
				}else{
					return null;
				}
			}else{
				$file_arr = array(
					"file_public_name" => ( is_null($file_public_name) ? null : $file_public_name )
					);
				$this->_ref->db->where("file_public_id", $file_public_id);
				$status = $this->_ref->db->update('files', $file_arr);
				return $status;
			}
		}else{
			if( $this->isset_file($file, $name) ){
				echo "hello world";
				echo "<pre>";
				echo "name ----- $name";
				print_r ($file);
				echo "</pre>";
				$file_name = $file[$name]['name'];
				$name_arr = explode(".", $file_name);
				$file_extension = end($name_arr);
				$new_filename = $this->generateFileName('files', "file_name") . "." . $file_extension;
				$file_mimetype = $file[$name]['type'];
				$file_size = $file[$name]['size'];
				$target_path = $this->filepath . "/" . $new_filename;
				if (move_uploaded_file($file[$name]["tmp_name"], $target_path)) {
					$file_arr = array(
						"file_public_id" => $this->generatePublicId('files', 'file_public_id'),
						"file_user_id" => ( is_null($user_id) ? null : $user_id ),
						"file_public_name" => ( is_null($file_public_name) ? null : $file_public_name ),
						"file_mime_type" => $file_mimetype,
						"file_size" => $file_size,
						"file_name" => $new_filename,
						"file_path" => $this->relative_filepath . "/$new_filename",
						"file_extension" => $file_extension,
						"file_created_at" => $this->now()
						);
					$this->_ref->db->insert('files', $file_arr);
					return $this->_ref->db->insert_id();
				}else{
					return null;
				}
			}else{
				return null;
			}
		}
	}

	public function delete( $publicId = null ){
		if( !is_null($publicId) ){
			$file = $this->_ref->db->get_where("files", array("file_public_id" => $publicId));
			if( $file->num_rows() > 0 ){
				$file = $file->row_array();
				if( file_exists($this->filepath . "/" . $file["file_name"]) ){
					$status =  unlink( $this->filepath . "/" . $file["file_name"] );
				}else{
					$status = true;
				}
				if( $status ){
					$this->_ref->db->where("file_public_id", $publicId);
					return $this->_ref->db->delete("files");
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function deletefile( $publicId = null ){
		if( !is_null($publicId) ){
			$file = $this->_ref->db->get_where("files", array("file_public_id" => $publicId));
			if( $file->num_rows() > 0 ){
				$file = $file->row_array();
				if( file_exists($this->filepath . "/" . $file["file_name"]) ){
					return unlink( $this->filepath . "/" . $file["file_name"] );
				}else{
					$status = true;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

    public function now(){
        date_default_timezone_set('Asia/Calcutta');
        return date("Y-m-d H:i:s");
    }

	public function generateFileName( $tablename = null, $columnname = null ){
		$hash = $this->randomString(20);
        $sql = $this->_ref->db->get_where($tablename, array($columnname => $hash) );
        if($sql->num_rows() > 0){
            $this->generateFileName($tablename, $columnname);
        }else{
            return $hash;
        }
	}

    public function generatePublicId( $tablename = null, $columnname = null ){
        if( isset($tablename) && isset($columnname) ){
            $hash = $this->generaterandomhash();
            $sql = $this->_ref->db->get_where($tablename, array($columnname => $hash) );
            if($sql->num_rows() > 0){
                $this->generatePublicId($tablename, $columnname);
            }else{
                return $hash;
            }
        }
    }

	function isset_file($file, $name) {
		return (isset($file[$name]) && $file[$name]['error'] != UPLOAD_ERR_NO_FILE);
	}

    public function generaterandomhash(){
        return implode(
            "-",
            str_split(
                md5(
                    uniqid(
                        time() . SALT . rand(0, 9999999)
                    )
                ),
                4
            )
        );
    }

  	public function randomString($length){
    	return substr(md5(uniqid(rand(), true)), 0, $length);
  	}

	function createDir( $path ){
		if( $path ){
			if( !is_dir($path) ){
				return mkdir($path , 0755, true);
			}
		}else{
			return false;
		}
	}
}
?>