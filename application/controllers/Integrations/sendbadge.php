<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class sendbadge extends CI_Controller{
	private $mckey = '';
	private $mcList = '';
	private $error_log1='';
	function __construct(){ 
		parent::__construct();

		$this->check_isvalidated();
		$this->load->model('settings_model');
		$this->load->model('autobadge_model');
		$this->load->model('sendbadge_model');
		$this->load->helper('credly_helper');
		$this->load->model('template_model');

		$this->mckey = $this->settings_model->GetMailchimpApi($this->session->userdata('userid'));
		$this->mcList = $this->settings_model->GetMailchimpList($this->session->userdata('userid'));
		
		
	}

	private function check_isvalidated(){
		$this->load->helper('url');
		if(! $this->session->userdata('validated')){
			redirect('login/login', 'refresh');
		}
	}



	public function savecontact()
	{


		$list_id = '';
		$response ="";

		if (isset($_REQUEST['list_id']))
			$list_id = $_REQUEST['list_id'];

			$access_token = $this->session->userdata('access_token');
			if (isset($_REQUEST['dataString'])){

				$data = json_decode($_REQUEST['dataString']);
				$singlechunk ;
				$count = 0;
				foreach ($data as $d)
				{
					$singlechunk[$count][] =  explode("&", $d);
					$count++;
		 		//var_dump(explode("&", $d));
				}

				$emails;
				$email_id;
				$fname;
				$lname ;
				$testimonial;
				$evidence;
				$count = 0;

				foreach ($singlechunk as $record)
				{

					$fname[$count] = $record[0][0];
					$lname[$count] = $record[0][1];
					$email_id[$count] = $record[0][2];
					$count++;

				}

				$count = 0;
				foreach ($email_id as $email) {
					$ee =explode('=', $email);
					$ee1 = $ee[1];
					$emails[$count] = str_replace('%40','@', $ee1);
					$count++;
				}
				$count = 0;


				foreach ($emails as $email)
				{
					$fn = explode('=', $fname[$count]);
					$fn1 = $fn[1]; 
					$ln = explode('=', $lname[$count]);
					$ln1 = $ln[1];
					$first_name = $fn1;
					$last_name = $ln1;
					$response .="===================<br/>";
					$response .= serialize(addcontactstolist_byemail($access_token, $email, $list_id, $first_name, $last_name));
				}

			}


			//var_dump($response) ;
		}



	public function index(){

		$lists = '';
		$credlylists = '';
		if($this->mckey && $this->mcList){
			$config1 = array(
		    	'apikey' => $this->mckey,      // Insert your api key
	            'secure' => FALSE   // Optional (defaults to FALSE)
	            );
			$this->load->library('MCAPI', $config1, 'mail_chimp1');
			$lists = $this->mail_chimp1->lists();
			$template = $this->mail_chimp1->templates();
			$count = count($template);

		}
		///var_dump($retval['data'][0]['id']);
		$this->load->helper('url');
		$data = '';
		// //////////////   get created badges here ////////////////////////
		$response = $this->badges($this->session->userdata('email'));
		$all_badges_data =$response->data;
		// print_r($all_badges_data);
		$all_badges_count = count($all_badges_data);
		///////////////////// credly list call ////////////////////////////
		$access_token = $this->session->userdata('access_token');
		$lists1 = $this->credly_list($access_token);

		if($lists1->meta->status_code == 200){
			$credlylists = $lists1->data; 

		}

		/////////////////////// GET MAILCHIMP API
		if($this->mckey == '0'){
			$data['MCkey'] = '';
		}else{
			$data['MCkey'] = $this->mckey;
		}


		$data['heading'] = 'Integrations';
		$data['actionMC'] =	site_url('common/settings/MailchimpKey');
		$data['lists'] =$lists['data'];
		$data['templates'] = $this->template_model->GetAllTemplates($this->session->userdata('email'));

		$data['badges1'] = $all_badges_data;
		$data['count1'] = $all_badges_count;
		$data['credly_lists'] = $credlylists;
		$data['credly_count'] = count($credlylists);


		$this->load->view('common/header',$data);
		$this->load->view('common/nav',$data);
		$this->load->view('Integrations/sendbadge',$data);
		$this->load->view('common/footer',$data);


	}

	public function ifacceptbadgeexists()
	{
		$html = '';
		if (isset($_REQUEST['html']))
			$html = $_REQUEST['html'];

		$finalurl = '<a href="http://clients.chimpchamp.com/credly/acceptbadge" role="button" >Accept Credly Badge</a>';
		$finalurl = '<a href="http://clients.chimpchamp.com/credly/acceptbadge" role="button" >Accept Credly Badge</a>';
		if (strpos($html,$finalurl) !== false) {
			echo true;
		}
		else 
		{
			echo false;
		}
	}


	public function add_sendbadge_form(){
		return $this->load->view('Integrations/sendbadge_form.php');
	}


	public function credly_list($access_token){
		$url = BADGEOS_CREDLY_API_URL.'me/lists?page=1&per_page=10&order_direction=ASC&access_token='. $access_token;
		$response = json_decode($this->CallAPI($url));
		return $response;
	}

	public function badges () {
		$member_id = GetMemberId($email = $this->session->userdata('email'));
		$access_token = $this->session->userdata('access_token');
		$response = members_badges_created($member_id,$access_token);
		return $response;

	}

	public function CallAPI_Members($url, $data)
	{

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Api-Key : '.X_Api_Key, 'X-Api-Secret : '.X_Api_Secret));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($curl);
	}


	public function gettemplateHtml()

	{

		$response =$this->template_model->GetTemplateHtml($_REQUEST['templateid']);
		echo $response;

	}

	public function gettemplateHtml_nonAjax($templateid){
		$response =$this->template_model->GetTemplateHtml($templateid);
		return $response;

	}

	public function gettemplateHtmlfromMailChimp()

	{

		$config2 = array(
			    	'apikey' => $this->mckey,      // Insert your api key      
		            'secure' => FALSE   // Optional (defaults to FALSE)
		            );

		$this->load->library('MCAPI', $config2, 'mailchimp_campaign');
		$response = $this->mailchimp_campaign->templateInfo($_REQUEST['templateid']);
		echo $response['source'];

	}

	public function getbadgeimage(){
		$badgeid = $_REQUEST['badgeid'];
		echo Getbadgeimage($badgeid);
	}

	public function sendbadge_form(){
		//echo "------";

		$singlechunk = '';
		$badgeid= '';
		$gevidence= '';
		$gtestimonial= '';
		$html ='';
		$data='';
		$templateid='';

		$custommessage='';
		$includecustommessage='';
		$notify='';
		$senddefaultcredly='';
		//$badgeimagurl = "https://credly.com/addons/shared_addons/themes/credly/img/blank-badge-image.png";
		$badgeimagurl = "https://s3.amazonaws.com/credlysites/mailchimp/credly-placeholder-badge-button.png";

		$selecttimeval ='';
		$datepicker = '';
		//$error_log1='';


		if (isset($_REQUEST['selecttimeval']))
			$selecttimeval = $_REQUEST['selecttimeval'];


		if (isset($_REQUEST['datepicker']))
			$datepicker = $_REQUEST['datepicker'];


		if (isset($_REQUEST['badgeimagurl']))
			$badgeimagurl = $_REQUEST['badgeimagurl'];


		if (isset($_REQUEST['custommessage']))
			$custommessage = $_REQUEST['custommessage'];

		if (isset($_REQUEST['includecustommessage']))
			$includecustommessage = $_REQUEST['includecustommessage'];

		if (isset($_REQUEST['chkincludeemailnotifications']))
			$notify = $_REQUEST['chkincludeemailnotifications'];

		if (isset($_REQUEST['usercredlydefault']))
			$senddefaultcredly = $_REQUEST['usercredlydefault'];

		if ($senddefaultcredly === false  || $senddefaultcredly == "false")
			$notify = false;
		// else 
		// 	$notify = true;


		//echo "!!Attention usercredlydefault".$senddefaultcredly;
		$this->error_log1 .="!!Attention usercredlydefault".$senddefaultcredly;
		$this->error_log1 .="!!Attention notify".$notify;
		//echo "!!Attention notify".$notify;


		if (isset($_REQUEST['templateid']))
			$templateid = $_REQUEST['templateid'];

		$config2 = array(
			    	'apikey' => $this->mckey,      // Insert your api key      
		            'secure' => FALSE   // Optional (defaults to FALSE)
		            );
		$this->load->library('MCAPI', $config2, 'mailchimp_webhook');


		$config1 = array(
			    	'apikey' => $this->mckey,      // Insert your api key      
		            'secure' => FALSE   // Optional (defaults to FALSE)
		            );
		$this->load->library('MCAPI', $config1, 'mailchimp_merge');

		if (isset($_REQUEST['html']))
			$html = $_REQUEST['html'];


		$html  = $this->gettemplateHtml_nonAjax($templateid);


		if (isset($_REQUEST['badgeid']))
			$badgeid = $_REQUEST['badgeid'];


		if (isset($_REQUEST['gevidence']))
			$gevidence = $_REQUEST['gevidence'];


		if (isset($_REQUEST['gtestimonial']))
			$gtestimonial = $_REQUEST['gtestimonial'];


		if (isset($_REQUEST['dataString'])){
			$data = json_decode($_REQUEST['dataString']);
			$singlechunk ;
			$count = 0;
			foreach ($data as $d)
			{
				$singlechunk[$count][] =  explode("&", $d);
				$count++;
				//var_dump(explode("&", $d));
			}

			$emails;
			$email_id;
			$fname;
			$lname ;
			$testimonial;
			$evidence;
			$count = 0;

			foreach ($singlechunk as $record)
			{

				$fname[$count] = $record[0][0];
				$lname[$count] = $record[0][1];
				$email_id[$count] = $record[0][2];
				$testimonial[$count] = $gtestimonial;
				$evidence[$count] = $gevidence;
				// $testimonial[$count] = $record[0][3];
				// $evidence[$count] = $record[0][4];
				$count++;

			}
			$count = 0;
			foreach ($email_id as $email) {
				$ee =explode('=', $email);
				$ee1 = $ee[1];
				$emails[$count] = str_replace('%40','@', $ee1);
				$count++;
			}
			$count = 0;

			$access_token = $this->session->userdata('access_token');

			$this->mailchimp_merge->listMergeVarAdd($_REQUEST['listid'], 'FNAME', "First Name");
			$this->mailchimp_merge->listMergeVarAdd($_REQUEST['listid'], 'LNAME', "Last Name");


			foreach ($emails as $email)
			{
				$fn = explode('=', $fname[$count]);
				$fn1 = $fn[1]; 
				$ln = explode('=', $lname[$count]);
				$ln1 = $ln[1];
				// $tm  =  explode('=', $testimonial[$count]);
				// $tm1 =  $tm[1];
				// $ev  =  explode('=', $evidence[$count]);
				// $ev1 =  $ev[1];
				$merge_vars = array('FNAME'=>$fn1, 'LNAME'=>$ln1);
				$retval = $this->mailchimp_webhook->listSubscribe($_REQUEST['listid'], $email , $merge_vars,'html',false,true);
				$count++;
			}	


			if ($this->mailchimp_webhook->errorCode){
				//echo $this->mailchimp_webhook->errorMessage;
				$this->error_log1 .= $this->mailchimp_webhook->errorMessage;
				$this->error_log1 .= "----- not subscribed".$this->mailchimp_webhook->errorMessage;
			} 


			else  //If if the user is not subscribed, code should go on..so to send default notifications of credly
			{
				

				//echo "----- subscribed";
				$this->error_log1 .="----- subscribed";
				$SegmentName = date("Ymdhisa", time())."";
				$segmentid = $this->mailchimp_webhook->listStaticSegmentAdd($_REQUEST['listid'],$SegmentName);

				$finalurl= '<a target="_blank" href="http://clients.chimpchamp.com/credly/acceptbadge/?stamp=' . $SegmentName. '&email=*|EMAIL|*" role="button" >Accept Credly Badge</a>';
				$defaulturl = '<a title="Accept credly badge" href="http://clients.chimpchamp.com/credly/acceptbadge" target="_blank">Accept Credly Badge</a>';

				if (strpos($html,$defaulturl) !== false) {
					//echo "----  FOUND ----";
					$this->error_log1 .="----  FOUND ----";
					$html = str_replace($defaulturl,$finalurl,$html);
				}
				else 
				{
					//echo "----   NOT FOUND   -----";
					$this->error_log1 .="----   NOT FOUND   -----";
				}

				$finalimg= '<a target="_blank" href="http://clients.chimpchamp.com/credly/acceptbadge/?stamp=' . $SegmentName. '&email=*|EMAIL|*" role="button" ><img alt="Save and share" src="'.$badgeimagurl.'" /></a>';
				$defaultimg = '<img alt="Save and share" src="https://s3.amazonaws.com/credlysites/mailchimp/credly-placeholder-badge-button.png" />';

				if (strpos($html,$defaultimg) !== false) {
					//echo "----  FOUND ----";
					$this->error_log1 .="----  FOUND ----";
					$html = str_replace($defaultimg,$finalimg,$html);
				}
				else 
				{
					//echo "----   NOT FOUND   -----";
					$this->error_log1 .="----   NOT FOUND   -----";
				}



				if ($this->mailchimp_webhook->errorCode){
					//echo $this->mailchimp_webhook->errorMessage;
					$this->error_log1 .=$this->mailchimp_webhook->errorMessage;
				}// Even if the static segment was not added
				else
				{
			  	    ////// 		echo "Before Member added to the segment";	
					$return = $this->mailchimp_webhook->listStaticSegmentMembersAdd($_REQUEST['listid'], $segmentid, $emails);
					if ($this->mailchimp_webhook->errorCode){
						//echo $this->mailchimp_webhook->errorMessage;
						$error_log1 .=$this->mailchimp_webhook->errorMessage;
					}
					else 
					{
						//echo "campaign create";
						//echo "Member added to the segment:";
						$this->error_log1 .="Member added to the segment:";
						$this->campaign_create($config2,$_REQUEST['listid'],$_REQUEST['templateid'],$segmentid, $emails, $badgeid,$gtestimonial,$gevidence,$html,$SegmentName, $notify,$senddefaultcredly,$includecustommessage,$custommessage,$selecttimeval, $datepicker);
					}
				}
			}
		}
	}

	public function campaign_create($config2,$listId,$templateId,$segmentid, $emails,$badgeid,$gtestimonial,$evidence,$html,$SegmentName, $notify, $senddefaultcredly,$includecustommessage,$custommessage,$selecttimeval, $datepicker){
		GLOBAL $log_data;
		GLOBAL $vardump1;
		GLOBAL $vardump2;
		//echo "--------campaign call";

		//$this->load->model('sendbadge_model');
		$error_log = '';
		$error_log .=$this->error_log1;
		$this->load->library('MCAPI', $config2, 'mailchimp_campaign');
		$loginfo="";
		$today = date("F j, Y");
		$type = 'regular';
		$opts['list_id'] = $listId;
		$opts['subject'] = "Credly Badge Assignment ".$today;
		$opts['from_email'] = 'zaeem@chimpchamp.com'; 
		$opts['from_name'] = 'Credly - MailChimp';	
		$opts['tracking']=array('opens' => true, 'html_clicks' => true, 'text_clicks' => false);
		$opts['authenticate'] = true;
		$opts['title'] = "";
		$response = $this->mailchimp_campaign->templateInfo($templateId);
		//$opts['template_id'] = $templateId;

		$content = array('html_main'=>'',
			'html_sidecolumn' => '',
			'html_header' => '',
			'html_footer' => '',
			'html' => '<html>'.$html. '</html>'
				// 'default_content' => array(1 => $template , 2 => $response1), 
				// 'text' => 'ALL THE BOOKS WILL BE HERE http://ereadernewstoday.com/category/free-kindle-books/'
			);

		//echo "----1";
		$conditions[] = array('field'=>'static_segment', 'op'=>'eq', 'value'=>$segmentid);
		$segment_opts = array('match'=>'all', 'conditions'=>$conditions);

		$campaignId = $this->mailchimp_campaign->campaignCreate($type, $opts, $content,$segment_opts);
		if ($this->mailchimp_campaign->errorCode){
			$loginfo.= "MCAPI=>" . $this->mckey;
			$loginfo.= " Unable to create campaign!";
			$loginfo.= "\n\tCode=".$this->mailchimp_campaign->errorCode;
			$loginfo.= "\n\tMsg=".$this->mailchimp_campaign->errorMessage."\n";
			$loginfo.=" Error! ";
			//echo $loginfo;
			$error_log .=$loginfo;
		}else{
			//echo "Campaign with ID:'" .$campaignId. "' Created<br/>";
			$error_log .= "Campaign with ID:" .$campaignId. "Created";
			$Owner_email = $this->session->userdata('email');
			$count =0;
			$recipients = array();
			$count = 0;
			//echo "----2";
			foreach ($emails as $email)
			{ 

				$recipients[$count] = array('email'=> $email, 'testimonial'=> $gtestimonial,'notify' => $notify,'custom_message'=> $custommessage,);
				$count++;

			}
			if (trim($gtestimonial === ""))
			{

				$gtestimonial = ".";
			}

			if (trim($evidence === ""))
			{
				$evidence = ".";
			}

			//echo '-----3';
			$response = issue_badge_to_member_bulk($recipients,$badgeid,$this->autobadge_model->getusertoken($Owner_email),$gtestimonial ,$evidence,$notify,$senddefaultcredly,$includecustommessage,$custommessage);
				//echo "------32";

			if (isset($response->meta->status_code) && $response->meta->status_code == "400")
			{
				//echo "------321";
				//echo("Could not assign badge");
				$error_log .="Could not assign badge";

			}
			elseif($response==NULL or isempty($response) || trim(serialize($response)) == "")
			{
				//echo "Response was NULL, so no need to add a hash of that response";
				$error_log .="Response was NULL, so no need to add a hash of that response";
				//echo "------322";
			}
			else {
				//echo "Successfully! assigned the badge with hash";
				$error_log .="Successfully! assigned the badge with hash";
				//echo "------324";
				$index = 0;
				foreach ($response->data->hashes as $newhash)
				{
					$this->sendbadge_model->insertcampaignbadges($campaignId, $emails[$index],$newhash, $SegmentName);
					$index++;
					//echo "------3213";

				}

			}
			//echo "------4";
			//echo "~~~~the value of Send Default Credly:".$senddefaultcredly;
			//echo "~~~~the value of Notify:".$notify;
			$error_log .= "~~~~the value of Send Default Credly:".$senddefaultcredly;
			$error_log .="~~~~the value of Notify:".$notify;



			$error_log .=$vardump1;
			$error_log .=$log_data;
			$error_log .=$vardump2;
			//echo "--------5";
			$number=0;
			$number=$this->db->count_all('error_log');
			$issue_number=$number+1;
			echo "Log number is ".$issue_number;


            // Old schedule email code. 
			if($senddefaultcredly === false || $senddefaultcredly === "false" )
				$this->schedule_campaign($config2,$campaignId,$selecttimeval,$datepicker);

		}
		$this->sendbadge_model->add_errorlog($error_log,$issue_number);

	}


	public function schedule_campaign($config2,$campaignId,$selecttimeval,$datepicker){

		$this->load->library('MCAPI', $config2, 'mailchimp_schedule_campaign');
		// $date = date('Y-m-d', strtotime(' +0 day'));
		// $schedule_for = date('Y-m-d 19:00:00', strtotime($date));
		
		$date = date('Y-m-d H:i:s', strtotime(' +0 day'));
		//$schedule_for = date("Y-m-d H:i:s", strtotime($date));
		$schedule_for = date("Y-m-d H:i:s", strtotime($datepicker));

		if($selecttimeval === "0"){
			//echo "<br/>ABOUT TO Send CAMPAIGN <br/>";
			$this->error_log1 .= 'ABOUT TO Send CAMPAIGN';
			$retval = $this->mailchimp_schedule_campaign->campaignSendNow($campaignId);
		}else
		{
			$this->error_log1 .= 'ABOUT TO Send CAMPAIGN';
			//echo "<br/>ABOUT TO Schedule CAMPAIGN <br/>";
			$retval = $this->mailchimp_schedule_campaign->campaignSchedule($campaignId, $schedule_for);
		}

		if ($this->mailchimp_schedule_campaign->errorCode){
			$this->error_log1 .="Unable to Schedule Campaign!";
			//echo "Unable to Schedule Campaign!";
			//echo "\n\tCode=".$this->mailchimp_schedule_campaign->errorCode;
			//echo "\n\tMsg=".$this->mailchimp_schedule_campaign->errorMessage."\n";
		} 

	}



	public function CallAPI($url)
	{
		
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Api-Key : '.X_Api_Key, 'X-Api-Secret : '.X_Api_Secret));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		// curl_setopt ($curl, CURLOPT_POSTFIELDS);
		// curl_setopt($curl, CURLOPT_URL, $url, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($curl);
	}

	public function popup_form(){ 
		$data ='';

		if (isset($_REQUEST['listid'])){
			$listid = $_REQUEST['listid'];
			$access_token = $this->session->userdata('access_token');
			$url = BADGEOS_CREDLY_API_URL.'lists/'.$listid.'?page=1&per_page=10&order_direction=ASC&access_token='. $access_token;
			$response = json_decode($this->CallAPI($url));
			// print_r($response);
			if($response->meta->status_code == 200){
				$records = $response->data;
				$data['records'] = $records;
				$data['mailchimp'] = "N";
				$this->load->view('common/nav',$data);
				$this->load->view('Integrations/popup',$data);
				$this->load->view('common/footer1',$data);

			}else{
				$this->load->view('common/footer',$data);
			}
		} 

	}


	public function popup_form_mailchimp(){
		if (isset($_REQUEST['listid'])){
			$listid = $_REQUEST['listid'];

			$config2 = array(
			    	'apikey' => $this->mckey,      // Insert your api key      
		            'secure' => FALSE   // Optional (defaults to FALSE)
		            );
			$this->load->library('MCAPI', $config2, 'mailchimp_getsubscribers');
			$retval = $this->mailchimp_getsubscribers->listMembers($listid, 'subscribed', null, 0, 15000 );

			if ($this->mailchimp_getsubscribers->errorCode){

				$this->load->view('common/footer',$data);
				$data['records'] = $retval['data'];
				$data['mailchimp'] = $this->mailchimp_getsubscribers->errorMessage;

			}else{
				
				$data['records'] = $retval['data'];
				$data['mailchimp'] = "Y";
				$this->load->view('common/nav',$data);
				$this->load->view('Integrations/popup',$data);
				$this->load->view('common/footer1',$data);
			}
		}
	}

	public function append_forms(){
		if (isset($_REQUEST['f_name']) && isset($_REQUEST['l_name']) && isset($_REQUEST['email_arr']) && isset($_REQUEST['ids'])){
			$data_fname = json_decode($_REQUEST['f_name']);
			$data_lname = json_decode($_REQUEST['l_name']);
			$data_email = json_decode($_REQUEST['email_arr']);
			$data_ids = json_decode($_REQUEST['ids']);
			$count = count($data_ids);

			$data['con_ids'] = $data_ids;
			$data['f_names'] = $data_fname;
			$data['l_names'] = $data_lname;
			$data['emails']  = $data_email;
			$data['count']   = $count;
			return $this->load->view('Integrations/main_form', $data);
		}

	}

	public function upload_csv(){

		$this->load->helper('file');
		$uploaddir = 'uploads/';

		$uploadfile = $uploaddir . basename($_FILES['csv-file']['name']);

		if (move_uploaded_file($_FILES['csv-file']['tmp_name'], $uploadfile)) {
			$status = "success";
			$msg = "File successfully uploaded";
		} else {
			$status = 'error';
			$msg = $this->upload->display_errors('', '');

		}

		$fp = fopen($uploadfile,'r') or die("**! Can't open file\n\n");
		$i = 1;

		while($csv_line = fgetcsv($fp,1024)) {

			//if ($i != 0)
			{
				//$json[$i]['id'] = $csv_line[0];
				$json[$i]['first_name'] = $csv_line[0];
				$json[$i]['last_name'] = $csv_line[1];
				$json[$i]['email'] = $csv_line[2]; 
			}
			$i++;

		}

		$json['total_lines']['id'] = $i-1;
		fclose($fp) or die("**! Can't close file\n\n");
		echo json_encode($json);
		
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

}
?>