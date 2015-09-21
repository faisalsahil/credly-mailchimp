<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class autobadge extends CI_Controller{
	private $mckey = '';
	private $mcList = '';
	function __construct(){
		parent::__construct(); 

		$this->check_isvalidated();
		$this->load->model('settings_model');
		$this->load->helper('credly_helper');
		$this->load->model('autobadge_model');
		$this->load->model('template_model');

		$this->mckey = $this->settings_model->GetMailchimpApi($this->session->userdata('userid'));
		$this->mcList = $this->settings_model->GetMailchimpList($this->session->userdata('userid'));
	}

	public function upload_doc(){

		$this->load->helper('file');
		$uploaddir = 'uploads/';

		$uploadfile = $uploaddir . basename($_FILES['doc-file']['name']);

		if (move_uploaded_file($_FILES['doc-file']['tmp_name'], $uploadfile)) {
			$status = "success";
			$msg = "File successfully uploaded";

			$fp = fopen($uploadfile,'r') or die("**! Can't open file\n\n");
			$filecontents = '';
			while($csv_line = fgets($fp,1024)) {
				$filecontents  .= $csv_line;
			}

			fclose($fp) or die("**! Can't close file\n\n");

			echo base64_encode($filecontents);

		} else {
			$status = 'error';
			$msg = $this->upload->display_errors('', '');
			echo $msg;

		}
	}



	public function index(){

		$lists = '';
		$badges= '';
		$badges1 = '';
		if($this->mckey && $this->mcList){
			$config1 = array(
		    	'apikey' => $this->mckey,      // Insert your api key
	            'secure' => FALSE   // Optional (defaults to FALSE)
	            );
			$this->load->library('MCAPI', $config1, 'mail_chimp1');
			$lists = $this->mail_chimp1->lists();
			$count = count($lists);
			
		}
		$this->load->helper('url');
		$data = '';

		
		// GET MAILCHIMP API
		if($this->mckey == '0'){
			$data['MCkey'] = '';
		}else{
			$data['MCkey'] = $this->mckey;
		}

		$email = $this->session->userdata('email');
		$this->db->where('email', $email);
		$query = $this->db->get('badges');
		$count = $query->num_rows();
	 ////////////////////////// List of All Badges Api call /////////////////////////////////////////////////////
		$response = $this->badges($email);
		//response = $this->badges($this->session->userdata('email'));

		$all_badges_data =$response->data;
		// print_r($all_badges_data);
		$all_badges_count = count($all_badges_data);
		
		$data['heading'] = 'Integrations';
		$data['actionMC'] =	site_url('Integrations/Autobadge/MailchimpKey');

		if (isset($lists['data']))
		$data['lists'] =$lists['data'];
	    else 
		$data['lists'] ='';

		$data['templates'] = $this->template_model->GetAllTemplates($this->session->userdata('email'));
		$data['count'] = $count;
		$data['badges1'] = $all_badges_data;
		$data['count1'] = $all_badges_count;
		$data['badges'] = $query;

		
		$this->load->view('common/header',$data);
		$this->load->view('common/nav',$data);
		$this->load->view('Integrations/Autobadge',$data);
		$this->load->view('common/footer',$data);


	}

	public function CallAPI_Members($url)
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Api-Key : '.X_Api_Key, 'X-Api-Secret : '.X_Api_Secret));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($curl);
	}


	public function ChangeCheckedStatus() {
		
		$this->autobadge_model->updatestatus($_REQUEST['listname'], $_REQUEST['badgeid'],$_REQUEST['include']);    
		
	}

	public function badges ($email) {
		// $url = BADGEOS_CREDLY_API_URL.'badges?page=1&per_page=10&order_direction=ASC';
		// $response = json_decode($this->CallAPI_Members($url));
		$member_id = GetMemberId($email);
		$access_token = $this->session->userdata('access_token');
		$response = members_badges_created($member_id,$access_token);
		return $response;
		
	}
	public function destroy()
	{
		if(isset($_REQUEST['lid']) && isset($_REQUEST['bid']))
		{
			$this->autobadge_model->delete($_REQUEST['lid'], $_REQUEST['bid']);
		}
		$this->index();

	}


	public function Saveautobadge(){
		$data ='';
		$this->load->library('session');
		$this->load->model('settings_model');

		$userid = $this->session->userdata('userid');
		$email = $this->session->userdata('email');

		if(isset($_POST['Badges_lists']) &&  isset($_POST['list'])  && $_POST['Badges_lists'] && $_POST['list']){   
			$this->db->set('badge_id', $_POST['Badges_lists']);
			$this->db->set('badge_title', $_POST['title-'.$_POST['Badges_lists']]);
			$this->db->set('path', $_POST['image-url-'.$_POST['Badges_lists']]);
			$list = explode("-", $_POST['list']);
			if (isset($list))
			{
				if (isset($list[0]))
					$this->db->set('list_id', $list[0]); 

				if (isset($list[1]))
					$this->db->set('list_name',$list[1]); 
			}
			$this->db->set('user_id', $userid);
			$this->db->set('email',$email);


			$evidence = '';
			$testimonial = '';
			$hiddenemailnotificationflag = '';
			$hiddencustommessage= '';
			$hiddentemplateid= '';
			$hiddendefaultcredly= '';


			if (isset($_REQUEST['hiddentemplateid']))
				$hiddentemplateid = $_REQUEST['hiddentemplateid'];

			if (isset($_REQUEST['hiddendefaultcredly']))
				$hiddendefaultcredly = $_REQUEST['hiddendefaultcredly'];
			

			if (isset($_REQUEST['fileevidence']))
				$evidence = $_REQUEST['fileevidence'];


			if (isset($_REQUEST['hiddentestimonial']))
				$testimonial = $_REQUEST['hiddentestimonial'];


			if (isset($_REQUEST['hiddenemailnotificationflag']))
				$hiddenemailnotificationflag  = $_REQUEST['hiddenemailnotificationflag'];

			if (isset($_REQUEST['hiddencustommessage']))
				$hiddencustommessage  = $_REQUEST['hiddencustommessage'];


			
			$this->db->set('evidence',$evidence);
			$this->db->set('custommessage',$hiddencustommessage);
			$this->db->set('notification',$hiddenemailnotificationflag);
			$this->db->set('testimonial',$testimonial);
			$this->db->set('defaultcredly',$hiddendefaultcredly);
			$this->db->set('templateid',$hiddentemplateid);



			if ($this->autobadge_model->ifbadgeslistexists_db($_POST['Badges_lists'],$list[0]))
			{
				$data['msg'] = "You have already added this badge above";
			}

			else 
			{	
				$query = $this->db->insert('badges');

				$config2 = array(
			    	'apikey' => $this->mckey,      // Insert your api key      
		            'secure' => FALSE   // Optional (defaults to FALSE)
		            );

				$this->load->library('MCAPI', $config2, 'mailchimp_webhook');
				$action = array(
					'subscribe' => true,
					'unsubscribe' => true, 
					'profile' => true, 
					'cleaned' => true, 
					'upemail' => true,
					'campaign' => true 
					);
				$source =array('api' => true, 'admin' => true );	
				//$url = 'http://clients.chimpchamp.com/credly/webhook';
				$url = 'http://clients.chimpchamp.com/credly/webhook';
				$retval = $this->mailchimp_webhook->listWebhookAdd($list[0],$url, $action, $source);

				if ($this->mailchimp_webhook->errorCode){
					$data['msg'] = 'Unable to add webhook to the list because '.$this->mailchimp_webhook->errorMessage.'The url was '.$url;
				} else {
					$data['msg'] = "Webhooks succuessfully added to the list !\n";
				}
			}
		}else{

			$data['msg'] = "No MailChimp lists or Credly badges found!";
		}

        //Added by zaeem for redirection

		$lists = '';
		$badges= '';
		$badges1 = '';

		if($this->mckey && $this->mcList){
			$config1 = array(
		    	'apikey' => $this->mckey,      // Insert your api key
	            'secure' => FALSE   // Optional (defaults to FALSE)
	            );
			$this->load->library('MCAPI', $config1, 'mail_chimp1');
			$lists = $this->mail_chimp1->lists();
			$count = count($lists);
			
		}
		$this->load->helper('url');
		// GET MAILCHIMP API
		if($this->mckey == '0'){
			$data['MCkey'] = '';
		}else{
			$data['MCkey'] = $this->mckey;
		}
		$email = $this->session->userdata('email');

		
		$result = validate($email);
		$list_badges = $result->data;
		// $count = count($result->data);
		/////////////////////////////// database record ///////////////////////////
		$this->db->where('email', $email);
		$query = $this->db->get('badges');
		$count = $query->num_rows();
			 ////////////////////////// List of All Badges Api call /////////////////////////////////////////////////////
		$response = $this->badges($this->session->userdata('email'));

		$all_badges_data =$response->data;
		$all_badges_count = count($all_badges_data);
		$data['templates'] = $this->template_model->GetAllTemplates($this->session->userdata('email'));
		
		$data['heading'] = 'Integrations';
		$data['actionMC'] =	site_url('Integrations/Autobadge/MailchimpKey');
		$data['lists'] =$lists['data'];
		// $data['badges'] = $list_badges;
		$data['badges'] = $query;
		$data['count'] = $count;
		$data['badges1'] = $all_badges_data;
		$data['count1'] = $all_badges_count;

		$this->load->view('common/header',$data);
		$this->load->view('common/nav',$data);
		$this->load->view('Integrations/Autobadge',$data);
		$this->load->view('common/footer',$data);
	}

	private function check_isvalidated(){
		$this->load->helper('url');
		if(! $this->session->userdata('validated')){
			redirect('login/login', 'refresh');
		}
	}

}
?>