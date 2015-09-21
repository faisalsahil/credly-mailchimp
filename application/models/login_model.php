<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */


class Login_model extends CI_Model{
   function __construct(){
      parent::__construct();
  }

  public function validate(){
		// grab user input
      $email = $this->security->xss_clean($this->input->post('email'));
      $password = $this->security->xss_clean($this->input->post('password'));
      $result = $this->badgeos_credly_get_api_key($email, $password);

      if($result->meta->status_code == 200 )
      {		
         $token =  $result->data->token;
         $this->db->where('email', $email);
         $query = $this->db->get('users');
         if($query->num_rows > 0  ){ 
            $row = $query->row();	
            $this->db->where('userid', $row->userid);
            $data = array(
                'access_token' => $token
                );

            $this->db->update('users', $data); 

            $data = array(
               'userid' => $row->userid,
               'email' => $row->email,
               'password' => $row->password,
               'access_token' => $token,
               'validated' => true
               );
            $this->session->set_userdata($data);
            return true;

        }else{
									// $this->db->set('u', $username);
            $this->db->set('email', $email);
    				//$this->db->set('password', $password);
            $this->db->set('access_token', $token);
            $query = $this->db->insert('users');
            $this->db->where('email', $email);
            $query = $this->db->get('users');
            $row = $query->row();
            $data = array(
               'userid' => $row->userid,
               'email' => $row->email,
               'password' => $row->password,
               'access_token' => $token,
               'validated' => true
               );
            $this->session->set_userdata($data);
            return true;
        } 

    }
    else
    {
     return false;
 }
}

function CallAPI($url,$data,$username,$password)
{
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Api-Key : '.X_Api_Key, 'X-Api-Secret : '.X_Api_Secret));
  curl_setopt($curl, CURLOPT_POSTFIELDS, serialize($data));

            // Optional Authentication:
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($curl, CURLOPT_USERPWD, $username.":".$password);

  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  return curl_exec($curl);
}


function badgeos_credly_get_api_key( $username, $password) {
  $url = BADGEOS_CREDLY_API_URL . 'authenticate/';
  $data =  array('headers' => array( 'Authorization' => 'Basic ' .  $username . ':' . $password ));
  $response = json_decode($this->CallAPI($url,$data,$username,$password));
  return $response;
}



}
?>
