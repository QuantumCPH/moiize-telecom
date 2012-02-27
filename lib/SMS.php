<?php
class SMS {
	


	private
		$message,
		$mobile_number,
		$keyword,
		$gateway
		
		;
		

	
	
	const 
		sms_api = 'http://sms.gratisgateway.dk/send.php',
	
		username = 'zerocall',
		password = 'ok20717786'
		;
		
		
	public function __construct($message, $mobile_number)
	{
		$this->message = $message;
		$this->mobile_number = $mobile_number;
	}
	
	public function setMessage($message)
	{
		$this->message = $message;
	}
	public function getMessage()
	{
		return $this->message;
	}
	
	public function setMobileNumber($mobile_number)
	{
		$this->mobile_number = $mobile_number;
	}
	public function getMobileNumber()
	{
		return $this->mobile_number;
	}
	
	public function setKeyword($keyword)
	{
		$this->keyword = $keyword;
	}
	
	public function getKeyword()
	{
		return $this->keyword;
	}
	
	public function setGateway($gateway)
	{
		$this->gateway = $gateway;
	}
	
	public function getGateway()
	{
		return $this->gateway;
	}
	
	public static function send($message, $mobile_number)
	{
		
		$query_vars = array(
			'username'=>self::username,
			'password'=>self::password,
			'mobile'=>$mobile_number,
			'message'=>$message,
		);
		
		//build url
		$url = self::sms_api.'?'.http_build_query($query_vars);
		
		//request url
		$response = BaseUtil::request_url($url);
		
		if ($response=='OK')
		{
			return new SMS($message, $mobile_number);
		}
	
	}
	
	public static function receive(sfWebRequest $request)
	{
		$keyword = $request->getParameter('keyword');
	  	
	  	$pin_code = substr($request->getParameter('message'),0, 15);
	  	
	  	$mobile_number = $request->getParameter('mobile');

	  	$gateway = $request->getParameter('gateway');
	  	
	  	if ($keyword && $pin_code && $mobile_number && $gateway)
	  	{
		  	$sms = new SMS($pin_code, $mobile_number);
		  	$sms->setKeyword($keyword);
		  	$sms->setGateway($gateway);
		  	
		  	return $sms;	  		
	  	} 	
	  	
	}
	
}
?>