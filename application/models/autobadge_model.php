<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Autobadge_Model extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	public function validate($email){
		$member_id = $this->GetMemberId($email);
		$response = $this->members_badges($member_id);
		return $response;
	}

	public function GetMemberId($email){
		$result = $this->members($email);
		if ($result->data){
			$member_id = $result->data[0]->id;
			return $member_id;
		}
	}

	public function updatestatus($listname, $badgeid,$include)

	{

		$this->db->where('list_name', $listname);
		$this->db->where('badge_id', $badgeid);
		$query = $this->db->get('badges');
		if($query->num_rows > 0  ){ 
			echo "found";
			if($include === true || $include === "true") 
				$include = 1;
			else 
				$include = 0;


			$data = array(
				'include' => $include
				);
			$this->db->where('list_name', $listname);
			$this->db->where('badge_id', $badgeid);
			echo $this->db->update('badges', $data); 
		}

	}    

	public function members($email) {
		$url = BADGEOS_CREDLY_API_URL . 'members?email='. $email;
		$response = json_decode($this->CallAPI_Members($url));
		return $response;
	}



	public function members_badges($member_id)
	{

		$url = BADGEOS_CREDLY_API_URL . 'members/'.$member_id . '/badges';
		$response = json_decode($this->CallAPI_Members($url));
		return $response;

	}

	public function CallAPI_Members($url)
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($curl);
	}

	public function badges () {
		$url = BADGEOS_CREDLY_API_URL . 'badges';
		$response = json_decode(CallAPI_Members($url));


	}


	public function getemail_fromlist_db($list_id){

		$this->db->where('list_id', $list_id);
		$this->db->limit(1);
		$query = $this->db->get('badges');
		
		if($query->num_rows >= 1)
		{  
			$row = $query->row();
			return $row->email;
		}
		else 
		{
			return 0;
		}
	}



	public function getbadges_db($email,$list_id){

		$this->db->where('email', $email);
		$this->db->where('list_id', $list_id);
		$this->db->where('include', '1');
		
		$query = $this->db->get('badges');


		if($query->num_rows >= 1  ){ 
			return	$query->result();
			
		}
		else 
		{
			return "0";
		}

	}



	public function gettestimonial_db($email,$list_id){

		$this->db->where('email', $email);
		$this->db->where('list_id', $list_id);
		$query = $this->db->get('badges',1);
		if($query->num_rows > 0  ){ 
			$row = $query->row();
			return  $row->testimonial;
		}
		else 
		{
			return "-";
		}

	}


	public function getcustommessage_db($email,$list_id){

		$this->db->where('email', $email);
		$this->db->where('list_id', $list_id);
		$query = $this->db->get('badges',1);
		if($query->num_rows > 0  ){ 
			$row = $query->row();
			return  $row->custommessage;
		}
		else 
		{
			return "-";
		}
	}

	public function getnotify_db($email,$list_id){

		$this->db->where('email', $email);
		$this->db->where('list_id', $list_id);
		$query = $this->db->get('badges',1);
		if($query->num_rows > 0  ){ 
			$row = $query->row();
			return  $row->notification;
		}
		else 
		{
			return "1";
		}
	}




	public function getevidence_db($email,$list_id){

		$this->db->where('email', $email);
		$this->db->where('list_id', $list_id);
		$query = $this->db->get('badges',1);
		if($query->num_rows > 0  ){ 
			$row = $query->row();
			return  $row->evidence;
		}
		else 
		{
			return "-";
		}
	}

	public function delete($list_id,$badge_id)
	{
		$this->db->where('badge_id', $badge_id);
		$this->db->where('list_id', $list_id);
		$this->db->delete('badges');

	}

	public function ifbadgeslistexists_db($badge_id,$list_id){

		$this->db->where('badge_id', $badge_id);
		$this->db->where('list_id', $list_id);
		$query = $this->db->get('badges');

		if($query->num_rows >= 1  ){ 
			return true;
		}
		else 
		{
			return false;
		}

	}



	public function getusertoken($email)
	{
		$this->db->where('email', $email);
		$this->db->limit(1);
		$query = $this->db->get('users');
		if($query->num_rows >= 1)
		{  
			$row = $query->row();
			$access_token = $row->access_token;
			return $access_token;
		}
		else 
		{
			return 0;
		}
	}




}
?>