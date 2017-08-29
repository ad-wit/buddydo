<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model{
    public $curl;
    public function __construct(){
        $this->load->database();
        $this->load->library('email');
    }

    public function now(){
        date_default_timezone_set('Asia/Calcutta');
        return date("Y-m-d H:i:s");
    }

    public function nowPlusDays($days){
        date_default_timezone_set('Asia/Calcutta');
        return date('Y-m-d H:i:s', strtotime("+".$days." days"));
    }

     public function makeDatetime($date){
        date_default_timezone_set('Asia/Calcutta');
          return date("Y-m-d H:i:s",strtotime($date));
    }

    public function nowTime(){
        date_default_timezone_set('Asia/Calcutta');
        return time();
    }

    public function sendEmail($options){
        $config['smtp_crypto'] =  'tls';
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "mail1.omailo.com";
        $config['smtp_port'] = "587";
        $config['smtp_user'] = "mailer@shubhyatracabs.in";
        $config['smtp_pass'] = "WkNZ56F-VDu5e-Cne0eMkA";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $this->email->initialize($config);

        $this->email->from($options['from']);
        $this->email->to($options['to']);
        $this->email->subject($options['subject']);
        $this->email->message($options['message']);
        return $this->email->send();
    }

    public function sendSMS($options){
        $this->curl->get('https://www.smsgatewayhub.com/api/mt/SendSMS', array(
            'APIKey' => '27a0f0ce-0cf2-43d8-9f7d-1f0efd3322a3',
            'senderid' => 'UDYGJK',
            'DCS' => 0,
            'number' => $options['number'],
            'text' => $options['message'],
            'route' => 7,
            'flashsms' => 0,
            'channel' => 2
        ));
        if ($this->curl->error) {
            return false;
            // return $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n";
        } else {
            $res = $this->curl->response;
            $res = (array)$res;
            $res["MessageData"] = (array)$res["MessageData"][0];
            $data = array(
                "report_errorcode" => $res["ErrorCode"],
                "report_message" => $res["ErrorMessage"],
                "report_jobid" => $res["JobId"],
                "report_messagedata" => json_encode($res["MessageData"]),
                "report_number" => ( !empty($res["MessageData"]) ? $res["MessageData"]['Number'] : null ),
                "report_messageid" => ( !empty($res["MessageData"]) ? $res["MessageData"]['MessageId'] : null ),
                "report_details" => json_encode($res),
                "report_time" => $this->now()
                );
            $this->db->insert('smsreports', $data);
            if( $res['ErrorMessage'] == "Success" ){
                return true;
            }else{
                return false;
            }
        }
    }

    public function getSelectOptions($table, $val=NULL, $option_value, $option_label, $placeholder = null, $where=NULL){
        if( !is_null($where) ){
            $this->db->where($where);
        }
        $data = $this->db->get($table)->result_array();
        if( !is_null($placeholder) ){
            $option = '<option value="" selected disabled>' . $placeholder . '</option>';
        }else{
            $option = "";
        }
        if( $val ){
            foreach ($data as $key => $value) {
                $option = $option . '<option value="' . $value[$option_value] . '" ' . ( $value[$option_value] == $val ? "selected" : "" ) . '>' . $value[$option_label] . '</option>';
            }
            return $option;
        }else{
            foreach ($data as $key => $value) {
                $option = $option . '<option value="' . $value[$option_value] . '">' . $value[$option_label] . '</option>';
            }
            return $option;
        }
    }

    public function getMultipleSelectOptions($table, $val=NULL, $option_value, $option_label, $placeholder = null, $where=NULL){
        if( !is_null($where) ){
            $this->db->where($where);
        }
        $data = $this->db->get($table)->result_array();
        if( !is_null($placeholder) ){
            $option = '<option value="" selected disabled>' . $placeholder . '</option>';
        }else{
            $option = "";
        }
        if( !is_null($val) && !empty($val) ){
            foreach ($data as $key => $value) {
                $option = $option . '<option value="' . $value[$option_value] . '" ' . ( in_array( $value[$option_value], $val ) ? "selected" : "" ) . '>' . $value[$option_label] . '</option>';
            }
            return $option;
        }else{
            foreach ($data as $key => $value) {
                $option = $option . '<option value="' . $value[$option_value] . '">' . $value[$option_label] . '</option>';
            }
            return $option;
        }
    }

    public function isRecordExists( $table, $where ){
        return ( $this->db->get_where( $table, $where )->num_rows() > 0 );
    }

    public function isValidPublicId( $tableName = null, $columnName = null, $publicId = null ){
        if( !is_null($tableName) && !is_null($columnName) && !is_null($publicId) ){
            $this->db->where($columnName, $publicId);
            $count = $this->db->get($tableName)->num_rows();
            if( $count == 1 ){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function getIdFromPublicId( $tableName = null, $columnName = null, $publicId = null, $primaryKeyColumn = null ){
        if( !is_null($tableName) && !is_null($columnName) && !is_null($publicId) && !is_null($primaryKeyColumn) ){
            if( $this->isValidPublicId( $tableName, $columnName, $publicId ) ){
                $this->db->where($columnName, $publicId);
                $data = $this->db->get($tableName)->row_array();
                return ( isset($data[$primaryKeyColumn]) ? $data[$primaryKeyColumn] : null );
            }else{
                return null;
            }
        }else{
            return false;
        }
    }

    public function getPublicIdFromId( $tableName = null, $PrimaryKeyColumnName = null, $publicIdColumnName = null, $primaryKeyValue = null ){
        if( !is_null($tableName) && !is_null($PrimaryKeyColumnName) && !is_null($publicIdColumnName) && !is_null($primaryKeyValue) ){
            $this->db->where($PrimaryKeyColumnName, $primaryKeyValue);
            $data = $this->db->get($tableName)->row_array();
            return ( isset($data[$publicIdColumnName]) ? $data[$publicIdColumnName] : null );
        }else{
            return false;
        }
    }

    public function getColumn( $tableName = null, $columnName = null, $where = null ){
        if( !is_null($tableName) && !is_null($columnName) && !is_null($where) ){
            $this->db->where($where);
            $data = $this->db->get($tableName)->row_array();
            return ( isset($data[$columnName]) ? $data[$columnName] : null );
        }else{
            return false;
        }
    }

    public function get( $table = null, $where = null ){
        if( !is_null($table) && !is_null($where) ){
            $this->db->where($where);
            $data = $this->db->get($table);
            if( $data->num_rows() == 1 ){
                return $data->row_array();
            }else if( $data->num_rows() > 1 ){
                return $data->result_array();
            }
        }else{
            return array();
        }
    }

}