<?php
/**
* 
*/
class ESEMES extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$config = array(
			'api_key' => 'a0e1e0d5', 
			'api_secret' => '6c8abc91cb631241',
			'from' => 'poltek',
		);
		$this->load->library('sms',$config);
		$this->load->model('orangtuaModel');
	}

	public function SendSMS()
	{
		// '+6285747577748','+6285701703169','+6285747149129','+628574740719','+6285640846856','+628561185775'
		$listReceiver = array();
		$receivers = $this->orangtuaModel->browse();
		$messages = 'test new library';
		$_url = "https://rest.nexmo.com/sms/json";
		foreach ($receivers as $receiver) {
			array_push($listReceiver, substr_replace($receiver->telepon, '+62', 0, 1));
		}
		print_r($listReceiver);
	}

	public function test()
	{
		echo substr_replace('085640846856', '+62', 0,1);
	}
}
// // url-ify the data for the POST
// 			$post_data = 'api_key='.$config['api_key'].'&api_secret='.$config['api_secret'].'&to='.$receiver->telepon.'&from='.$config['from'].'&text='.$messages;
			
// 			// open connection
// 			$curlSMS = curl_init();

// 			// set the url, POST data
// 			curl_setopt($curlSMS,CURLOPT_URL, $_url);
// 			curl_setopt($curlSMS,CURLOPT_POSTFIELDS, $post_data);

// 			// execute curl
// 			// if error occured while execution this will send an error report
// 			curl_exec($curlSMS);

// 		    // close connection
// 		    curl_close($curlSMS);