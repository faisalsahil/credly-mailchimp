<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AutobadgeModel extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	
	public function getbadges_db($email,$list_id){

		$this->db->where('email', $email);
		$this->db->where('list_id', $list_id);
		return $this->db->get('badges');
		
	}


}
?>