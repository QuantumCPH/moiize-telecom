<?php
class EPay {

	private $last_error;
	
	private $proxy_host = '', 
			$proxy_port = '', 
			$proxy_username = '',
			$proxy_password = '';
	
	public function EPay($proxy_host = '', $proxy_port = '', $proxy_username = '', $proxy_password = '')
	{
		$this->proxy_host = $proxy_host;
		$this->proxy_port = $proxy_port;
		$this->proxy_username = $proxy_username;
		$this->proxy_password = $proxy_password;
	}
	
	public function authorize($merchantnumber, $subscriptionid, $orderid, $amount, $currency, $instantcapture) {
		$params_transaction = array(
			'merchantnumber'=>$merchantnumber,
			'subscriptionid'=>$subscriptionid,
			'orderid'=>$orderid,
			'amount'=>$amount*100,
			'currency'=>$currency,
			'instantcapture'=>$instantcapture
		);

		$epay_subscription = new nusoap_client('https://ssl.ditonlinebetalingssystem.dk/remote/subscription.asmx?WSDL', 'wsdl',
						$this->proxy_host, $this->proxy_port, $this->proxy_username, $this->proxy_password, 120, 120);

	  	$result = $epay_subscription->call('authorize', $params_transaction);

                
		// check for a fault
		if ($epay_subscription->fault) {
			$this->setLastError(print_r($result, true));
		} else {
			// check for errors
			$err = $epay_subscription->getError();
			if ($err) {
				$this->setLastError($err);
			} else {
				return $result['authorizeResult']=="true"?true:false;
			}
		}
		
		return false;
	}
	
	protected function setLastError($error_text)
	{
		$this->last_error = $error_text;
	}
	
	
	public function getLastError()
	{
		return $this->last_error;
	}
}
?>