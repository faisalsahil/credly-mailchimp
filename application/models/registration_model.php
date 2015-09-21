<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */
class Registration_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function validate(){
		// grab user input
		$username = $this->security->xss_clean($this->input->post('username'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$password = $this->security->xss_clean($this->input->post('password'));
		
		// Prep the query
		$this->db->set('username', $username);
		$this->db->set('email', $email);
		//$this->db->set('password', $password);
		
		// Run the query
		$query = $this->db->insert('users');
		echo $query;
		// Let's check if there are any results
		if($query == 1)
		{
			return true;
		}
		// If the previous process did not validate
		// then return false.
		return false;
	}
}
?>