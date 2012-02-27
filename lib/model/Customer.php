<?php

class Customer extends BaseCustomer
{
	public function save(PropelPDO $con = null)
	{
		
	    if (($this->isModified() && $this->isColumnModified(CustomerPeer::PASSWORD)) ||
	    	($this->isNew() && $this->getPassword())
	    	)
	    {
	    	$this->setPassword(sha1($this->getPassword()));
	    }
	    
	    parent::save($con);
	}
	
	public function registerFonet()
	{
		//Fonet number registration
	  	
	  	$country = $this->getCountry()->getName();
	  	$mobile_number = $this->getMobileNumber();
	  	$pin = substr('0000' . $this->getId(), -4);
	  	$description = 'reg for '. $this->getFirstName();
	  	$key = md5($country . $mobile_number . $pin . $description . 'itLK34gH5Dt6:-g#');
	  	
	  	$query_vars = array(
			'Cmd'=>'CallSaver_U',
			'Ctry'=>$country,
	  		'Ani'=>$mobile_number,
	  		'AniPin'=>$pin,
	  		'Key'=>$key,
	  		'Description'=>$description,
	  	);
	  	
	  	$url = 'https://www.fonet.dk/ZPN.php/?'.http_build_query($query_vars);
	
		if(BaseUtil::request_url($url)=='OK')
		{
			$this->setIsFonetSubscribed(true);
			$this->save();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function unregisterFonet()
	{
		//Fonet number unregistration
	  	
	  	$country = $this->getCountry()->getName();
	  	$mobile_number = $this->getMobileNumber();
	  	$key = md5($country . $mobile_number . 'itLK34gH5Dt6:-g#');
	  	
	  	$query_vars = array(
			'Cmd'=>'CallSaver_D',
			'Ctry'=>$country,
	  		'Ani'=>$mobile_number,
	  		'Key'=>$key,
	  	);
	  	
	  	
	  	$url = 'https://www.fonet.dk/ZPN.php/?'.http_build_query($query_vars);
	
		if(BaseUtil::request_url($url)=='OK')
		{
			$this->setIsFonetSubscribed(true);
			$this->save();
			return true;
		}
		else
			return false;	
	}
	
	public function getProducts(){
		$c = new Criteria();
	  	$c->add(CustomerProductPeer::CUSTOMER_ID, $this->getId());
	  	$c->addJoin(ProductPeer::ID, CustomerProductPeer::PRODUCT_ID);
	  	
	  	return ProductPeer::doSelect($c);
	}
	
	public function getMobileNumberWithCallingCode()
	{
		return sprintf("%s%s", $this->getCountry()->getCallingCode(),
								BaseUtil::trimMobileNumber($this->getMobileNumber())
						);
	}
         public function getBalance()
        {

            $fonet=new Fonet();
            $balance = $fonet->getBalance($this ,true);
            if($balance)
               return $balance;
        }
	    
}
