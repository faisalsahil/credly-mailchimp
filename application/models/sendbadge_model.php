<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendbadge_model extends CI_Model{
	
	// $password = $this->session->userdata('password');
	// $email = $this->session->userdata('email');

	function __construct(){
		parent::__construct();
	}

	public function insertcampaignbadges($campaignid, $email,$hash, $stamp){

		echo " ==========  inside db  ==========";

		$data  = array(
			'campaignid' => $campaignid,
			'email' => $email,
			'hash' =>  $hash,
			'stamp' =>  $stamp
			); 
		echo "DB :====>" .$this->db->insert('campaignbadges', $data);

	}

	public function getcampaignbadges($stamp, $email){
	    
	    $this->db->where('email', $email);
	    $this->db->where('stamp', $stamp);
	    $this->db->limit(1);
	    $query = $this->db->get('campaignbadges');
		
		if($query->num_rows > 0)
		{  
			$row = $query->row();
			return $row->hash;
		}
		else 
		{
			return "0";
		}
		
	}
	public function add_errorlog($description,$number)
	{
		$data=array(
			'error_name' => 'sendbadge_error',
			'log_number' => $number,
			'description' => $description

			);
		$this->db->insert('error_log',$data);
	}
	// public function count_number()
	// {
	// 	return $this->db->select('')
	// }


}