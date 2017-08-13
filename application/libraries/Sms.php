<?php
/**
* This library to send an SMS using curl post to nexmo server
*
* usage:
* call this library inside the controller as usually with 
* api_key, api_secret and from as $config
*
* @author: Pholenk
* @link: github.com/Pholenk
*/
class Sms
{
	// declare private variable that use as config
	private $_apiKey = '';
	private $_apiSecret = '';
	private $_from = '';

	// because this use for send curl to nexmo server so this variable is static
	private $_url = "https://rest.nexmo.com/sms/json";

	/**
	 * Constructor
	 *
	 * @param mixed config
	 * @return void
	 */
	function __construct($config = array())
	{
		// initialize private variable value so this library only load once in controller
		$this->_apiKey = $config['api_key'];
		$this->_apiSecret = $config['api_secret'];
		$this->_from = $config['from'];

		log_message('info', 'Sms Class Initialize');
	}

	/**
	 * Perform send text to someone
	 *
	 * @param mixed receivers
	 * @param string text
	 * @return mixed
	 */
	public function send($text, $receivers)
	{
		foreach ($receivers as $receiver => $number)
		{
			// url-ify the data for the POST
			$post_data = 'api_key='.$this->_apiKey.'&api_secret='.$this->_apiSecret.'&to='.$number.'&from='.$this->_from.'&text='.$text;
			
			// open connection
			$curlSMS = curl_init();

			// set the url, POST data
			curl_setopt($curlSMS,CURLOPT_URL, $this->_url);
			curl_setopt($curlSMS,CURLOPT_POSTFIELDS, $post_data);

			// execute curl
			// if error occured while execution this will send an error report
			if(curl_exec($curlSMS))
			{
				$to ='';
				$text='';
			}
			
		}
	    // close connection
	    curl_close($curlSMS);
	}
}