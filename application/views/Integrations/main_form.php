 <?php for ($i=0; $i < $count; $i++) { 
 	$data['f_name'] = $f_names[$i]; 
 	$data['con_id'] = $con_ids[$i]; 
 	$data['l_name'] = $l_names[$i]; 
 	$data['email'] =  $emails[$i];  
 	$this->load->view('Integrations/sendbadge_form.php', $data); 
 }?>
