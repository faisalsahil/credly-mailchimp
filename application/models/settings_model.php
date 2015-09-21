<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	public function GetMailchimpApi($userid){

		$where = "type = 'MC' AND name = 'key' AND userid ='".$userid."'";
		$this->db->where($where);
		$query = $this->db->get('tbl_key');
		$result = $query->row();
		$rowcount = $query->num_rows();
		if($rowcount == 0){
			return 0;
		}else{
			return $result->value;
		}
	}

public function Getuseridfromlist($list_id){

		$where = "type = 'MC' AND name = 'list' AND value ='".$list_id."'";
		$this->db->where($where);
		$query = $this->db->get('tbl_key');
		$result = $query->row();
		$rowcount = $query->num_rows();
		if($rowcount == 0){
			return 0;
		}else{
			return $result->userid;
		}
	}


	public function GetMailchimpList($userid){

		$where = "type = 'MC' AND name = 'list' AND userid ='".$userid."'";
		$this->db->where($where);
		$query = $this->db->get('tbl_key');
		$result = $query->row();
		$rowcount = $query->num_rows();
		if($rowcount == 0){
			return 0;
		}else{
			return $result->value;
		}
	}


	public function InsertMC($data, $userid){
		if($data){
			$this->db->delete('tbl_key', array('type' => 'MC','userid' => $userid));

			foreach ($data as $key => $value) {
				if($key != "type"){
					$data  = array(
						'type' => 'MC' ,
						'userid' => $userid,	
						'name' => mysql_real_escape_string($key) ,
						'value' =>  mysql_real_escape_string($value)
						); 
					$this->db->insert('tbl_key', $data);
				}
			} 
		}
	}

	public function InsertMD($key, $userid){
		if($key){
			$this->db->delete('tbl_key', array('type' => 'MD', 'name' => 'key', 'userid' => $userid));
			$data  = array(
				'type' => 'MD' ,
				'userid' => $userid,	
				'name' => 'key',
				'value' =>  mysql_real_escape_string($key)
				); 
			$this->db->insert('tbl_key', $data);
		}
	}


	public function GetMD($userid){
		$where = "type = 'MD' AND name = 'key' AND userid = '".$userid."'";
		$this->db->where($where);
		$query = $this->db->get('tbl_key');
		$result = $query->row();
		$rowcount = $query->num_rows();
		if($rowcount == 0){
			return 0;
		}else{
			return $result->value;
		}
	}


}
?>