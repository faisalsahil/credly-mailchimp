<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index($msg = NULL){
		// Load our view to be displayed
		// to the user
		$this->load->helper('url');

		if($this->session->userdata('username')){
			redirect('common/settings', 'refresh');
		}else{
			$data['msg'] = $msg;
			$data['heading'] = "SignUp";
			$this->load->view('common/header',$data);
			$this->load->view('Registration/signup', $data);
		}
		//$this->load->view('common/footer',$data);
	}


	public function CallAPI_Registration($email, $password, $displayname, $fname, $lname)
	{
		$curl = curl_init();
	 	$postdata = http_build_query(array('email' => $email, 'password' => $password, 'first_name' => $fname,'last_name' => $lname,'display_name' => $displayname ));
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($curl, CURLOPT_URL, BADGEOS_CREDLY_API_URL."authenticate/register");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		return curl_exec($curl);
	}


	public function registration($email, $password, $displayname, $fname, $lname) {
		
		return json_decode($this->CallAPI_Registration($email, $password, $displayname, $fname, $lname));
		
	}

	public function process(){
		// Load the model

		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'trim|min_length[6]|matches[password]');
		$this->form_validation->set_rules('email', 'Email', 'required');


		if ($this->form_validation->run() == FALSE)
		{
			// $msg = '<font color=red>Please Enter All fields correctly.</font><br />';
			$this->index(validation_errors());
		}
		else
		{

            $msg ="";
            $data = "";
            $status = "";

			$response = $this->registration($this->input->post('email'),$this->input->post('password'),$this->input->post('username'),$this->input->post('fname'),$this->input->post('lname'));
			// var_dump($response);
			// echo "========";
			// echo $response->meta->status_code;
			// echo "========";
         
			if (isset($response->meta->status_code) && $response->meta->status_code === 400)
			{
				$msg= $response->meta->more_info->email;
				$status = "0";

			}
			else 
			{
				//var_dump($response->data);
				//$msg = $response->data;
				$msg = "Successfully registered the user with credly";
				$status = "1";

			}

            $data['msg'] = $msg;
            $data['status'] = $status ;
			$data['heading'] = "SignUp";
			$this->load->view('common/header',$data);
			$this->load->view('Registration/signup', $data);
			//$this->load->model('registration_model');
			// Validate the user can login
			//$result = $this->registration_model->validate();
			// Now we verify the result
			// if( ! $result){
			// 	// If user did not validate, then show them login page again
			// 	$msg = '<font color=red>Please Enter All Fields.</font><br />';
			// 	$this->index($msg);
			// }else{
			// 	// If user did validate, 
				// Send them to members area

				// $config=Array(
				// 	'protocol' => 'smtp',
				// 	'smtp_host' => 'smtp.gmail.com',
				// 	'smtp_port' => 25,
				// 	'smtp_user' => "usmantest@devsinc.com",
				// 	'smtp_pass' => "helloworld81"

				// // 	);
				// $this->load->library('email', $config);

				// $this->email->from('ZaeemChimpChamp@gmail.com', 'Zaeem Asif');
				// $this->email->to('faisal.bhatti@devsinc.com');  

				// $this->email->subject('Email Test');
				// $this->email->message('Testing the email class.');	
				// $this->email->send();
				// echo $this->email->print_debugger();
				// $msg = '<font color=green>Successfully Signup.</font><br />';
				// // $this->index($msg);
				// redirect('login/login','$msg');
			//}		
		}
	}

	public function do_logout(){
		$this->session->sess_destroy();
		redirect('login/login','refresh');
	}
}
?>