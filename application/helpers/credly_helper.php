<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//$log_data =''; 
//$vardump1 ='';
//$vardump2 ='';
if ( ! function_exists('validate'))
{

	function validate($email){
		$member_id = GetMemberId($email);
	
		$response = members_badges($member_id);
		return $response;
	}

}



if ( ! function_exists('issue_badge_to_member'))
{
	function issue_badge_to_member($member_id,$badge_id,$access_token){

		$url = BADGEOS_CREDLY_API_URL . 'member_badges?access_token='.$access_token;
		// $url = BADGEOS_CREDLY_API_URL . 'member_badges?access_token='. $access_token;
		$data = http_build_query(array('member_id' => $member_id,'badge_id' => $badge_id));

		$response = json_decode(CallAPI_Issue_badge($url,$data));
		
		return $response;
	}
}



if ( ! function_exists('CreatenewCredlylist'))
{
	function CreatenewCredlylist($access_token,$listname){

		$url = BADGEOS_CREDLY_API_URL . 'me/lists?access_token='.$access_token;
		$data = http_build_query(array('name' => $listname));
		$response = json_decode(CallAPI_Issue_badge($url,$data));
		return $response;
	}
}




if ( ! function_exists('issue_badge_to_member_email'))
{
	function issue_badge_to_member_email($email,$badge_id,$access_token,$first_name, $last_name, $testimonial, $evidence, $custommessage, $notify){
		
		$url = BADGEOS_CREDLY_API_URL . 'member_badges?access_token='.$access_token;
		$data = http_build_query(array('email' => $email,'first_name' => $first_name, 'last_name' => $last_name,'badge_id' => $badge_id, 'notify' => $notify, 'testimonial' => $testimonial, 'evidence_file' => $evidence, 'custom_message' => $custommessage));
		$response = json_decode(CallAPI_Issue_badge($url,$data));
		
		return $response;
	}
}



if (!function_exists('wh_log'))
{

	function wh_log($msg){
		$logfile = 'webhook.log';
		file_put_contents($logfile,date("Y-m-d H:i:s")." | ".$msg."\n",FILE_APPEND);
	}
}


if ( ! function_exists('issue_badge_to_member_bulk'))
{
	function issue_badge_to_member_bulk($recipients,$badge_id,$access_token,$testimonial, $evidence , $notify,$senddefaultcredly,$includecustommessage,$actualmessage ){
		GLOBAL $log_data;
		GLOBAL $vardump1;
		GLOBAL $vardump2;
		//echo "call member bulk";
		$log_data=''; 
        $vardump1='';
		$vardump2='';
		if ($senddefaultcredly === false || $senddefaultcredly === "false")
			$notify ="false";

		$url = BADGEOS_CREDLY_API_URL . 'member_badges?access_token='.$access_token;

		if($actualmessage === "")
			$actualmessage =".";

		if ($notify === "false" || $notify === false )
			$notify =0;
		else
			$notify =1;


			//echo "call member bulk1";
		$data = array(
			'recipients' => json_encode($recipients),
			'badge_id' => $badge_id,
			'notify' => $notify,
			'custom_message'=> $actualmessage
			);
		//$vardump1='';
		ob_start();
		var_dump($data);
		$vardump1 .=ob_get_clean();
		//var_dump($data);

       
        $log_data .="----------------------";
        $log_data .=$testimonial;
        $log_data .=$evidence;
        $log_data .="----------------------";

		if ($testimonial == '' || $testimonial == "" )
		{
			echo "Empty testimonial";
		}
		else {
			$data['testimonial'] = $testimonial;
		}

		if ($evidence != '')
		{
			$data['evidence_file'] = $evidence;
		}
		//$vardump2='';
		ob_start();
		var_dump($data);
		$vardump2 .=ob_get_clean();
		//var_dump($data);
        //echo "----------------------";

		$response = json_decode(CallAPI_Issue_badge($url,$data));
		//var_dump($response);
			//echo "call member bulk3";
		return $response;

	}
}



if ( ! function_exists('CallAPI_Issue_badge'))
{

	function CallAPI_Issue_badge($url,$data)
	{

		$curl = curl_init($url);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  			// curl_setopt ($curl, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Api-Key : '.X_Api_Key, 'X-Api-Secret : '.X_Api_Secret));
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($curl);
	}

}	
if ( ! function_exists('GetMemberId'))
{


	function GetMemberId($email){
		$result = members($email);

		if (isset($result->meta->status_code) && $result->meta->status_code === 400)
			return "0";
		
		else if (isset($result) && isset($result->data)){
			$member_id = $result->data[0]->id;
			return $member_id;
		}
	}
}


if ( ! function_exists('members'))
{

	function members($email) {

		$url = BADGEOS_CREDLY_API_URL . 'members?email='. $email;
		$response = json_decode(CallAPI_Members($url));
		// print_r($response);
		return $response;
	}

}


if ( ! function_exists('addcontactstolist_byemail'))
{

	function addcontactstolist_byemail($access_token, $email, $list_id, $first_name, $last_name) {

		$url = BADGEOS_CREDLY_API_URL . 'lists/'.$list_id.'/contacts';
		$url .='?access_token='.$access_token;

		$data = http_build_query(array('email' => $email,'first_name' => $first_name, 'last_name' => $last_name,'id' => $list_id));
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Api-Key : '.X_Api_Key, 'X-Api-Secret : '.X_Api_Secret));
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($curl));
        //return $url;
		return $response;
	}

}

if ( ! function_exists('Getbadgeimage'))
{

	function Getbadgeimage($badgeid) {
		$url = BADGEOS_CREDLY_API_URL . 'badges/'. $badgeid;
		$response = json_decode(CallAPI_Members($url));
		if (isset($response->meta->status_code) && $response->meta->status_code === 400)
		{
			// $msg= $response->meta->more_info->email;
			return "http://s3.amazonaws.com/experts-production/avatars/thumb/4de6c8a053b08592fb09e725559ea523f95c50e3.png";	
		}
		else if (isset($response->meta->status_code) && $response->meta->status_code === 404)
		{
			// $msg= $response->meta->more_info->email;
			return "http://s3.amazonaws.com/experts-production/avatars/thumb/4de6c8a053b08592fb09e725559ea523f95c50e3.png";	
		}

		return $response->data->image_url;
	}

}



if ( ! function_exists('members_badges'))
{

	function members_badges($member_id)
	{
		$url = BADGEOS_CREDLY_API_URL . 'members/'.$member_id . '/badges';
		$response = json_decode(CallAPI_Members($url));
		return $response;
	}

}



if ( ! function_exists('CallAPI_Members'))
{
	function CallAPI_Members($url)
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Api-Key : '.X_Api_Key, 'X-Api-Secret : '.X_Api_Secret));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($curl);
	}

}



if ( ! function_exists('badges'))
{

	function badges () {
		$url = BADGEOS_CREDLY_API_URL . 'badges';
		$response = json_decode(CallAPI_Members($url));
	}
}


if ( ! function_exists('members_badges_created'))
{

	function members_badges_created($member_id,$access_token)
	{
		$url = BADGEOS_CREDLY_API_URL . 'me/badges/created?page=1&per_page=100&access_token='.$access_token;
		$response = json_decode(CallAPI_Members($url));
		return $response;
	}
}
