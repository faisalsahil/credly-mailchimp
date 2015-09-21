<?php 
class Acceptbadge extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('autobadge_model');
		$this->load->helper('credly_helper');
		$this->load->model('sendbadge_model');
	} 

	public function index()
	{
		//$url = "http://staging.credly.com/";
		$url = BADGEOS_CREDLY_API_URL;

		
		if (isset($_REQUEST['email']))
		{
			echo $_REQUEST['email']. " checking the badge..";
			$hash = $this->sendbadge_model->getcampaignbadges($_REQUEST['stamp'],$_REQUEST['email']);
			var_dump($hash);
			if ($hash !== "0")
			{
				echo $_REQUEST['email']. " accepted the badge";
				$url = 'http://staging.credly.com/badge/'.$hash;
				//redirect($url, 'refresh');
        		//exit();

			}
			else
			{
				echo $_REQUEST['email']. " did not accepted the badge";
			}
		}
		else 
		{
			echo "No Email ID found !";
		}

		

	}

}
?>