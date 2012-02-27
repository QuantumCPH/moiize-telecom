<?php
class Fonet
{
	public static function getFonetApiUrl()
	{
		return 'http://fax.fonet.dk/cgi-bin/ZeroCallV2Control.pl';
	}
	
	public static function registerFonet(Customer $customer)
	{
		//confirm this customer exists in database
		
		$customer = CustomerPeer::retrieveByPK($customer->getId());
		
		if (!$customer) return false;
		
		//construct a url
		/*
		 * [ Activate ]
		 * http://fax.fonet.dk/cgi-bin/ZeroCallV2Control.pl?
		 * Action=Activate&
		 * ParentCustomID=1393238&
		 * CustomID=1594502&
		 * AniNo=20717786&
		 * DdiNo=25998893&
		 * Trace=1
		 */
		
		//get an empty fonet_cusomer_id slot
		$c = new Criteria();
		$c->setLimit(1);
		$c->add(FonetCustomerPeer::ACTIVATED_ON, null, Criteria::ISNULL);
		
		if (!$fonet_customer = FonetCustomerPeer::doSelectOne($c)) return false;
		
		
		//build url
		
		$query_vars = array(
			'Action'=>'Activate',
			'ParentCustomID'=>1393238,
	  		'AniNo'=>$customer->getMobileNumber(),
	  		'DdiNo'=>25998893,
			'CustomID'=>$fonet_customer->getFonetCustomerId()
	  	);
		
		$url = self::getFonetApiUrl().'?'.http_build_query($query_vars);
		
		$response = '
<html>
	<body>
		<zerocallv2manager>
			<STATUS>ok</STATUS>
		</zerocallv2manager>
	</body>
</html>
		';
		$xml = self::getXmlFromFonetResponse(BaseUtil::request_url($url));
		
		//$xml = self::getXmlFromFonetResponse($response);
		
		if (!$xml) return false;


		if (self::getParameterFromFonetXml('status', $xml)=='ok')
		{
			$fonet_customer->setActivatedOn(date('Y-m-d H:i:s'));
			
			$fonet_customer->save();
			
			$customer->setFonetCustomerId($fonet_customer->getFonetCustomerId());
			$customer->save();
			return true;
		}
		
	}

        public static function registerFonetZeroCallOut(Customer $customer)
	{
		//confirm this customer exists in database

		$customer = CustomerPeer::retrieveByPK($customer->getId());

		if (!$customer) return false;

		//construct a url
		/*
		 * [ Activate ]
		 * http://fax.fonet.dk/cgi-bin/ZeroCallV2Control.pl?
		 * Action=Activate&
		 * ParentCustomID=1393238&
		 * CustomID=1594502&
		 * AniNo=20717786&
		 * DdiNo=25998893&
		 * Trace=1
		 */

		//get an empty fonet_cusomer_id slot
		$c = new Criteria();
		$c->setLimit(1);
		$c->add(FonetCustomerPeer::ACTIVATED_ON, null, Criteria::ISNULL);

		if (!$fonet_customer = FonetCustomerPeer::doSelectOne($c)) return false;


		//build url

//		$query_vars = array(
//			'Action'=>'Activate',
//			'ParentCustomID'=>1393238,
//	  		'AniNo'=>$customer->getMobileNumber(),
//	  		'DdiNo'=>25998893,
//			'CustomID'=>$fonet_customer->getFonetCustomerId()
//	  	);

                  $query_vars = array(
			'Action'=>'CustUpdate',
			'ParentCustomID'=>1393238,
	  		'AniNo'=>$customer->getMobileNumber(),
	  		'DdiNo'=>25969696,
                        'RateTableName'=>'ZapnaB2Cfree',
                        'Trace'=>1,
			'CustomID'=>$fonet_customer->getFonetCustomerId()
	  	);




		$url = self::getFonetApiUrl().'?'.http_build_query($query_vars);

		$response = '
<html>
	<body>
		<zerocallv2manager>
			<STATUS>ok</STATUS>
		</zerocallv2manager>
	</body>
</html>
		';
		$xml = self::getXmlFromFonetResponse(BaseUtil::request_url($url));

		//$xml = self::getXmlFromFonetResponse($response);

		if (!$xml) return false;


		if (self::getParameterFromFonetXml('status', $xml)=='ok')
		{
			$fonet_customer->setActivatedOn(date('Y-m-d H:i:s'));

			$fonet_customer->save();

			$customer->setFonetCustomerId($fonet_customer->getFonetCustomerId());
			$customer->save();
			return true;
		}

	}




	public static function recharge(Customer $customer, $amount = 0, $checkCustomer = true)
	{
		/*
		 * http://fax.fonet.dk/cgi-bin/ZeroCallV2Control.pl?
		 * CustomID=1801597
		 * Action=Recharge&
		 * ChargeValue=100&
		 * Trace=1
		 */
		//confirm this customer exists in database
		
		if ($checkCustomer)
		{
			$customer = CustomerPeer::retrieveByPK($customer->getId());
			
			if (!$customer) return false;
		}
		
		//build url
		$query_vars = array(
			'Action'=>'Recharge',
			'ParentCustomID'=>1393238,
			'CustomID'=>$customer->getFonetCustomerId(),
			'ChargeValue'=>$amount*100
	  	);
		
		$url = self::getFonetApiUrl().'?'.http_build_query($query_vars);
		
				//echo $url;
		
				
		$xml = self::getXmlFromFonetResponse(BaseUtil::request_url($url));
		
		if (!$xml) return false;
		

		if (self::getParameterFromFonetXml('status', $xml)=='ok'){
//			if($customer->getC9CustomerNumber() != null ){
//			 $conversion_rate = CurrencyConversionPeer::retrieveByPK(1);
//		     $exchange_rate = $conversion_rate->getDkkBpp();
//			 $c9w = new C9Wrapper();
//             $c9w->updateBalance('12345',$customer->getC9CustomerNumber (),($amount*100)/ $exchange_rate);
//			}
			return true;
		}
	}
	

	
	public static function getBalance($customer, $checkCustomer = true)
	{
		/*
		 * http://fax.fonet.dk/cgi-bin/ZeroCallV2Control.pl?
			CustomID=1801597&
			Action=GetInfo&
			ParentCustomID=1393238 
		 */
		//confirm this customer exists in database
		
		if ($checkCustomer) //check if customer exists in db
		{
			$customer = CustomerPeer::retrieveByPK($customer->getId());
		
			if (!$customer) return null;
		}
		
		//build url
		$query_vars = array(
			'Action'=>'GetInfo',
			'ParentCustomID'=>1393238,
			'CustomID'=>$customer->getFonetCustomerId(),
			'Trace'=>1,
	  	);
		
		$url = self::getFonetApiUrl().'?'.http_build_query($query_vars);
		
		

		$xml = self::getXmlFromFonetResponse(BaseUtil::request_url($url));
		
		
		//return $xml->saveHTML();
		
		if (!$xml) return null;
		
		if (self::getParameterFromFonetXml('status', $xml)=='ok')
			return (double)self::getParameterFromFonetXml('account', $xml)/100;
		else
			return null;
	}
	
	public static function unregister(Customer $customer, $checkCustomer=true)
	{
		if ($checkCustomer) //check if customer exists in db
		{
			$customer = CustomerPeer::retrieveByPK($customer->getId());
		
			if (!$customer) return false;
		}
		
		//build url
		$query_vars = array(
			'Action'=>'Delete',
			'ParentCustomID'=>1393238,
			'CustomID'=>$customer->getFonetCustomerId(),
			'AniNo'=>$customer->getMobileNumber()
	  	);
		
		$url = self::getFonetApiUrl().'?'.http_build_query($query_vars);
                
		$xml = self::getXmlFromFonetResponse(BaseUtil::request_url($url));
		
		//return $xml->saveHTML();
		
		if (!$xml) return false;
		
		if (self::getParameterFromFonetXml('status', $xml)=='ok')
			return true;
		else
			return false;
	}
	
	public static function getParameterFromFonetXml($parameter_name, $xml)
	{
		$q = '//'.$parameter_name;
		
		$xpath = new DOMXPath($xml);
		
		$parameter = $xpath->query($q)->item(0);
		
		if ($parameter)
			return $parameter->nodeValue;
			
	}
	
	public static function getXmlFromFonetResponse($response)
	{
		$xmlDoc = new DOMDocument();
		
		if (@$xmlDoc->loadHTML($response)==true)
		{
			$xpath = new DOMXPath($xmlDoc);
			
			
			$q = '//zerocallv2manager';

			$xml = (string)simplexml_import_dom($xpath->query($q)->item(0))
					->asXML();
					
			$xmlDoc->loadXML($xml);
			
			return $xmlDoc;
		}
	}
}
?>