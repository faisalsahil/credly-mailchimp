<?php 

class Webhook extends CI_Controller {

	private $mckey = '';
	private $mcList = '';

	function __construct(){
		parent::__construct();
		$this->load->model('autobadge_model');
		$this->load->helper('credly_helper');
		$this->load->model('template_model');
		$this->load->model('settings_model');
		$this->load->model('sendbadge_model');

		
	}



	public function campaign_create($listId,$segmentid, $html,$emails,$SegmentName , $newhash){

		$config2 = array(
			    	'apikey' => $this->mckey,      // Insert your api key      
		            'secure' => FALSE   // Optional (defaults to FALSE)
		            );
		$this->load->library('MCAPI', $config2, 'mailchimp_webhook');

		$this->load->library('MCAPI', $config2, 'mailchimp_campaign');
		$loginfo="";
		$today = date("F j, Y");
		$type = 'regular';
		$opts['list_id'] = $listId;
		$opts['subject'] = "Credly Badge Assignment ".$today;
        ///////////////////////////////////////////////////////////////////////////////////////////////////

		//$opts['from_email'] = 'zaeem@chimpchamp.com'; 
		$retval = $this->mailchimp_campaign->lists();

		foreach ($retval['data'] as $list){
			if ($list['id'] == $listId)
			{
				$opts['from_email'] =$list['default_from_email'];
				break;


			}
		}

        ///////////////////////////////////////////////////////////////////////////////////////////////////
		$opts['from_name'] = 'Credly - MailChimp';	
		$opts['tracking']=array('opens' => true, 'html_clicks' => true, 'text_clicks' => false);
		$opts['authenticate'] = true;
		$opts['title'] = "";

		$content = array('html_main'=>'',
			'html_sidecolumn' => '',
			'html_header' => '',
			'html_footer' => '',
			'html' => '<html>'.$html. '</html>',
			'text' => 'Please enable html to see the badge assignment'
			);


		$conditions[] = array('field'=>'static_segment', 'op'=>'eq', 'value'=>$segmentid);
		$segment_opts = array('match'=>'all', 'conditions'=>$conditions);

		$campaignId = $this->mailchimp_campaign->campaignCreate($type, $opts, $content,$segment_opts);
		$this->sendbadge_model->insertcampaignbadges($campaignId, $emails[0],$newhash, $SegmentName);

		if ($this->mailchimp_campaign->errorCode){
			$loginfo.= "MCAPI=>" . $this->mckey;
			$loginfo.= " Unable to create campaign!";
			$loginfo.= "\n\tCode=".$this->mailchimp_campaign->errorCode;
			$loginfo.= "\n\tMsg=".$this->mailchimp_campaign->errorMessage."\n";
			$loginfo.=" Error! ";
			echo $loginfo;
		}else{

			$config2 = array(
			    	'apikey' => $this->mckey,      // Insert your api key      
		            'secure' => FALSE   // Optional (defaults to FALSE)
		            );
			$this->load->library('MCAPI', $config2, 'mailchimp_webhook');
			$retval = $this->mailchimp_webhook->campaignSendNow($campaignId);

		}

	}


	public function index()
	{
		echo " ================= inside webhook call =================";
		wh_log(" ================= inside webhook call =================");

		if(isset($_REQUEST) && isset($_REQUEST['type']) && $_REQUEST['type'] == "subscribe")
		{
			

			$email = $_REQUEST['data']['email'];
			$list_id = $_REQUEST['data']['list_id'];

			//$email = 'zaeem.asif@gmail.com';
			//$Owner_email = 'zaeem@chimpchamp.com';
			//$list_id = '69859009cd';


			wh_log($this->settings_model->Getuseridfromlist($list_id));
			echo $this->settings_model->Getuseridfromlist($list_id);
			$this->mckey = $this->settings_model->GetMailchimpApi($this->settings_model->Getuseridfromlist($list_id));

			wh_log($this->mckey);
			wh_log("After key");
			echo $this->mckey;

			$config2 = array(
			    	'apikey' => $this->mckey,      // Insert your api key      
		            'secure' => FALSE   // Optional (defaults to FALSE)
		            );
			$this->load->library('MCAPI', $config2, 'mailchimp_webhook');


			$first_name ='  ';
			$last_name ='  ';
			$testimonial =' ';
			$evidence = '  ';
			$custommessage = '  ';
			$notify = '1';


			if(isset($_REQUEST['data']['merges']['FNAME']))
				$first_name = $_REQUEST['data']['merges']['FNAME'];

			if(isset($_REQUEST['data']['merges']['LNAME']))
				$last_name = $_REQUEST['data']['merges']['LNAME'];


			//Get the owner's email id form list id;
			$Owner_email = $this->autobadge_model->getemail_fromlist_db($list_id);
			$testimonial = $this->autobadge_model->gettestimonial_db($Owner_email,$list_id);
			$evidence = $this->autobadge_model->getevidence_db($Owner_email,$list_id);
			$custommessage = $this->autobadge_model->getcustommessage_db($Owner_email,$list_id);
			$notify = $this->autobadge_model->getnotify_db($Owner_email,$list_id);

			echo " $list_id  was the list id and Email: $Owner_email having First Name:". $first_name." and Last Name: ".$last_name ." and testimonial:". $testimonial ."<br/>";
			echo "=============================================================================================== <br/>";
			wh_log(" $list_id  was the list id and Email: $Owner_email having First Name:". $first_name." and Last Name: ".$last_name ." and testimonial:". $testimonial ."<br/>");



			$result = $this->autobadge_model->getbadges_db($Owner_email,$list_id);


			if ($result !== "0")
			{

				foreach ($result as $row)
				{
					
					if($row->defaultcredly == 1)
					{
						$response = issue_badge_to_member_email($email,$row->badge_id,$this->autobadge_model->getusertoken($Owner_email), $first_name, $last_name, $testimonial, $evidence, $custommessage, $notify);
						var_dump($response);
						echo "badge id: $row->badge_id is assigned to $email by $Owner_email";
						wh_log("badge id: $row->badge_id is assigned to $email by $Owner_email");

						if ($response->meta->status_code && $response->meta->status_code == 400)
						{
							echo($response->meta->more_info[1]);
						}
						else {
							echo $email." is assigned the badge <br/>";
						}
						var_dump($response);
					}else
					{
						echo "Not default Credly";
						$response = issue_badge_to_member_email($email,$row->badge_id,$this->autobadge_model->getusertoken($Owner_email), $first_name, $last_name, $testimonial, $evidence, $custommessage, '0');
						$response = $response->data->hashes[0];
						var_dump($response);
						echo "badge id: $row->badge_id is assigned to $email by $Owner_email and the hash was $response";
						wh_log("badge id: $row->badge_id is assigned to $email by $Owner_email and the hash was $response");


						if (isset($response->meta->status_code) && $response->meta->status_code == 400)
						{
							echo($response->meta->more_info[1]);
						}
						else 
						{
							echo $email." is assigned the badge <br/>";
							$html = $this->template_model->GetTemplateHtml($row->templateid);

							echo "----- subscribed";
							$SegmentName = date("Ymdhisa", time())."";
							$segmentid = $this->mailchimp_webhook->listStaticSegmentAdd($list_id,$SegmentName);

							$finalurl= '<a target="_blank" href="http://clients.chimpchamp.com/credly/acceptbadge/?stamp=' . $SegmentName. '&email=*|EMAIL|*" role="button" >Save & Share</a>';
							$defaulturl = '<a title="Save &amp; share" href="http://clients.chimpchamp.com/credly/acceptbadge" target="_blank">Save &amp; Share</a>';

							if (strpos($html,$defaulturl) !== false) {
								wh_log("----  FOUND ----");
								$html = str_replace($defaulturl,$finalurl,$html);
							}
							else 
							{
								wh_log( "----   NOT FOUND   -----");
							}


                			// Save & Save BUTTON
							$finalimg= '<a target="_blank" href="http://clients.chimpchamp.com/credly/acceptbadge/?stamp=' . $SegmentName. '&email=*|EMAIL|*" role="button" ><img width=157px  height=42px alt="Save & Share" src="https://s3.amazonaws.com/credlysites/mailchimp/credly-save-and-share-button.png"/></a>';
							//$defaultimg = '<img alt="Save and share" src="https://s3.amazonaws.com/credlysites/mailchimp/credly-placeholder-badge-button.png" />';
							$defaultimg = '<img alt="Save &amp; share" src="https://s3.amazonaws.com/credlysites/mailchimp/credly-save-and-share-button.png" />';

							if (strpos($html,$defaultimg) !== false) {
								wh_log( "----  FOUND ----");
								$html = str_replace($defaultimg,$finalimg,$html);
							}
							else 
							{
								wh_log( "----   NOT FOUND   -----");
							}


                			// IMAGE BUTTON

							$finalimg= '<a target="_blank" href="http://clients.chimpchamp.com/credly/acceptbadge/?stamp=' . $SegmentName. '&email=*|EMAIL|*" role="button" ><img width=180px height=180px alt="Save & Share" src="'.$row->path.'" /></a>';
							$defaultimg = '<img alt="Save &amp; share" src="https://s3.amazonaws.com/credlysites/mailchimp/credly-placeholder-badge.png" />';

							if (strpos($html,$defaultimg) !== false) {
								wh_log( "----  FOUND ----");
								$html = str_replace($defaultimg,$finalimg,$html);
							}
							else 
							{
								wh_log( "----   NOT FOUND   -----");
							}


							$emails[0] = $email;
							$return = $this->mailchimp_webhook->listStaticSegmentMembersAdd($list_id, $segmentid, $emails);
							if ($this->mailchimp_webhook->errorCode){
								wh_log($this->mailchimp_webhook->errorMessage);
							}
							else 
							{
								wh_log( "Member added to the segment:");
								$this->campaign_create($list_id,$segmentid,$html,$emails,$SegmentName ,$response);
							
							}

						}
					}

                 }//for loop

             }
         }  

    }//index

}



