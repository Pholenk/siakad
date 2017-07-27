<?php
/**
* 
*/
class SMS extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function SendSMS()
	{
		// $receivers = array('+6285747577748','+6285701703169','+6285747149129','+628574740719','+6285640846856');
		foreach ($receivers as $receiver => $phone) {
			$fields_string  =   "";
			$fields     =   array(
				'api_key'       =>  'a0e1e0d5',
				'api_secret'    =>  '6c8abc91cb631241',
				'to'            =>  $phone,
				'from'          =>  "Pholenk",
				'text'          =>  "Jangan panggil aku pholenk kalau sms broadcast ini gagal",
			);
			$url        =   "https://rest.nexmo.com/sms/json";

			//url-ify the data for the POST
			foreach($fields as $key=>$value) { 
			$fields_string .= $key.'='.$value.'&'; 
			}
			rtrim($fields_string, '&');

			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

			//execute post
			$result = curl_exec($ch);
			//close connection
			curl_close($ch);

			echo "<pre>";
			print_r($result); 
			echo "</pre>";
		}
	}
}