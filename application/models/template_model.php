<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	public function GetAllTemplates($email){

		$query = $this->db->get_where('customtemplates', array('email' => $email));
		$result = $query->result();
		$rowcount = $query->num_rows();
		
		if($rowcount == 0){
			return 0;
		}else{
			return $result;
		}
	}


	public function GetTemplateHtml($id){

		$query = $this->db->get_where('customtemplates', array('id' => $id),1);
		$rowcount = $query->num_rows();
		
		if($rowcount == 0){
			return '';
		}else{
			$row = $query->result();
			//return html_entity_decode($row[0]->templatehtml);
			return stripslashes($row[0]->templatehtml);
		}
	}


	
	public function UpdateTemplates($id,$email, $html){

        //$html =htmlentities($html);
        $html =addslashes($html);
		$data = array(
			'email' => $email,
			'templatehtml' => $html,
			);

		$this->db->where('id', $id);
		$this->db->update('customtemplates', $data); 

	}



	public function AddUpdateTemplatesbyNamesEmail($name,$email, $html){
		$query = $this->db->get_where('customtemplates', array('email' => $email,'templatename' => $name));
		$result = $query->result();
		$rowcount = $query->num_rows();

        //$html =htmlentities($html);
        $html =addslashes($html);	

		try

		{
			if($rowcount > 0){
                $this->db->where(array('email' => $email,'templatename' => $name));
				$data = array('templatehtml' => $html);
				$this->db->update('customtemplates', $data); 
				return "Template Updated..";

			}else {

				$this->NewTemplates($name,$email, $html);
				return "New Template Added..";

			}
		} catch (Exception $e)  
		{  
			return "false".$e.message;
		}

	}


	public function NewTemplates($name,$email, $html){

		//$html =htmlentities($html);
		$html =addslashes($html);
		$data = array(
			'email' => $email,
			'templatename' => $name,
			'templatehtml' => $html
			);

		$this->db->insert('customtemplates', $data);
	}



	public function DestroyTemplates($id){

		$this->db->where('id', $id);
		$this->db->delete('customtemplates'); 
	}
}
?>