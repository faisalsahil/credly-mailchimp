<?php 

class Template extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->helper('credly_helper');
		//$this->check_isvalidated();
		$this->load->model('template_model');
		$this->load->model('settings_model');
		$this->mckey = $this->settings_model->GetMailchimpApi($this->session->userdata('userid'));
		$this->mcList = $this->settings_model->GetMailchimpList($this->session->userdata('userid'));
	}

	public function index()
	{
		if($this->mckey && $this->mcList){
			$config1 = array(
		    	'apikey' => $this->mckey,      // Insert your api key
	            'secure' => FALSE   // Optional (defaults to FALSE)
	            );
			$this->load->library('MCAPI', $config1, 'mail_chimp1');
			$lists = $this->mail_chimp1->lists();
			$mctemplates = $this->mail_chimp1->templates();
		}

		$email = $this->session->userdata('email');
		$templates ='0';
		$count = 0;
		$data ='';
		$data['heading'] = 'Customize Templates';
		$data['templates'] = $this->template_model->GetAllTemplates($email);
		if(isset($mctemplates))
			$data['mctemplates'] = $mctemplates;
		else 
			$data['mctemplates'] = '';

		$data['prehtml'] = '';

		$this->load->view('common/header',$data);
		$this->load->view('common/nav',$data);
		$this->load->view('template',$data);
		$this->load->view('common/footer',$data);
	}


	public function gettemplateHtml()
	{
		$response =$this->template_model->GetTemplateHtml($_REQUEST['templateid']);
		echo $response;

	}



	public function edit()
	{
		if($this->mckey && $this->mcList){
			$config1 = array(
		    	'apikey' => $this->mckey,      // Insert your api key
	            'secure' => FALSE   // Optional (defaults to FALSE)
	            );
			$this->load->library('MCAPI', $config1, 'mail_chimp1');
			$lists = $this->mail_chimp1->lists();
			$mctemplates = $this->mail_chimp1->templates();
		}

		$email = $this->session->userdata('email');
		$templates ='0';
		$count = 0;
		$data ='';
		$data['heading'] = 'Customize Templates';
		$data['templates'] = $this->template_model->GetAllTemplates($email);
		$data['mctemplates'] = $mctemplates;
		$data['prehtml'] = '';
		$data['templatename'] = '';

		if (isset($_REQUEST['id']))
		{
			$data['prehtml'] =$this->template_model->GetTemplateHtml($_REQUEST['id']);
			//echo $data['prehtml'];
		}
		if (isset($_REQUEST['name']))
		{
			$data['templatename'] = $_REQUEST['name'];
		}


		$this->load->view('common/header',$data);
		$this->load->view('common/nav',$data);
		$this->load->view('template',$data);
		$this->load->view('common/footer',$data);
	}


	public function addupdateTemplate()
	{

		$templatename='';
		if(!isset($_REQUEST['name']) || !isset($_REQUEST['html'])  || empty($_REQUEST['html']) )
		{
			return false;
		}

		$templatename = $_REQUEST['name'];
		$email = $this->session->userdata('email');
		$templatehtml = $_REQUEST['html'];

		$res = $this->template_model->AddUpdateTemplatesbyNamesEmail($templatename,$email, $templatehtml);
		echo $res;
	}

	public function update()
	{

		$ID = $_REQUEST['id'];
		$this->template_model->DestroyTemplates($ID);
		$this->index();
	}

	public function destroy()
	{
		$ID = $_REQUEST['id'];
		$this->template_model->DestroyTemplates($ID);
		$this->index();
	}

}