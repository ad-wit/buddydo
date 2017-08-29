<?php
class Encrypt_model extends CI_Model{
    public function __construct(){
        $this->load->database();
        define("SALT", "$2y$10$7u44A2gBk5VW8RGymL5K9O9HMucPKWDUzLbgVRvIX4iuEppFE1Cn2");
        define("NAMESPACE", "1546058f-5a25-4334-85ae-e68f2a44bbaf");
    }
    public function v3($namespace, $name) {
        if(!$this->is_valid($namespace)) return false;
        $nhex = str_replace(array('-','{','}'), '', $namespace);
        $nstr = '';
        for($i = 0; $i < strlen($nhex); $i+=2) {
            $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
        }
        $hash = md5($nstr . $name);
        return sprintf('%08s-%04s-%04x-%04x-%12s',
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
            substr($hash, 20, 12)
        );
    }
    public function v4() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    public function v5($namespace, $name) {
        if(!$this->is_valid($namespace)) return false;
        $nhex = str_replace(array('-','{','}'), '', $namespace);
        $nstr = '';
        for($i = 0; $i < strlen($nhex); $i+=2) {
            $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
        }
        $hash = sha1($nstr . $name);
        return sprintf('%08s-%04s-%04x-%04x-%12s',
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
            substr($hash, 20, 12)
        );
    }

    public function is_valid($uuid) {
        return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.'[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
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
    public function generatePublicId( $tablename = null, $columnname = null ){
        if( isset($tablename) && isset($columnname) ){
            $hash = $this->v4();
            $sql = $this->db->get_where($tablename, array($columnname => $hash) );
            if($sql->num_rows() > 0){
                $this->generatePublicId($tablename, $columnname);
            }else{
                return $hash;
            }
        }
    }
    public function generateTrackingId( $tablename = null, $columnname = null ){
        if( !is_null($tablename) && !is_null($columnname) ){
            $code = $this->generateTrackingCode();
            $sql = $this->db->get_where($tablename, array($columnname => $code) );
            if($sql->num_rows() > 0){
                $this->generatePublicId($tablename, $columnname);
            }else{
                return $code;
            }
        }else{
            return null;
        }
    }

    /**
     * Generates Six Digit Random Number
     * @return int six digit random number
     */
    public function generateVerificationCode(){
        return rand(111111,999999);
    }
    /**
     * Generates Ten Digit Random Number
     * @return int ten digit random number
     */

    public function generateTrackingCode(){
        return rand(1111111111,9999999999);
    }

    /**
     * [generatePasswordHash Generates 60 Characters long password hash using BCrypt Algorithm]
     * @param  [string] $password [password]
     * @return [string]           [hashed password]
     */
    public function generatePasswordHash($password){
        // return password_hash(SALT . $password . SALT, PASSWORD_BCRYPT);
        return md5(SALT . $password . SALT);
    }
}
