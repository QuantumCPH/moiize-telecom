<?php

class Company extends BaseCompany
{
	public function __toString()
	{
		return $this->getName();
	}
	
	public function getSupportActivites()
	{
		$c = new Criteria();
		$c->add(EmployeePeer::COMPANY_ID, $this->getId());
		
		return SupportActivityPeer::doSelectJoinEmployee($c);
	}
	
	public function getLatestSalesActivity(){
		$c = new Criteria();
		$c->add(SaleActivityPeer::COMPANY_ID, $this->getId());
		$c->addDescendingOrderByColumn(SaleActivityPeer::CREATED_AT);
		
		return SaleActivityPeer::doSelectOne($c);
	}
	
	public function getLatestSupportActivity(){
		$c = new Criteria();
		$c->addJoin(SupportActivityPeer::EMPLOYEE_ID, EmployeePeer::ID);
		$c->add(EmployeePeer::COMPANY_ID, $this->getId());
		$c->addDescendingOrderByColumn(SupportActivityPeer::CREATED_AT);
		
		return SupportActivityPeer::doSelectOne($c);
	}
        
        public function getAccountManager(){
            return UserPeer::retrieveByPk($this->getAccountManagerId());
        }
       
	public function save(PropelPDO $con = null)
	{
		
	    if (($this->isModified() && $this->isColumnModified(CompanyPeer::CONFIRMED_AT)) ||
	    	($this->isNew() && $this->getConfirmedAt())
	    	)
	    {
	  		
	    	$c = new Criteria();
	    	$c->add(GlobalSettingPeer::NAME, 'Customer_Service_Department_Email');
	    	
	    	$global_setting = GlobalSettingPeer::doSelectOne($c); 
	    	
	    	$customer_service_department_email = $global_setting->getValue();
	    	
	    	
	    	if ($customer_service_department_email)
	    	{
	    		$subject = sfConfig::get('app_email_subject');
				$sender_email = sfConfig::get('app_email_sender_email');
				$sender_name = sfConfig::get('app_email_sender_name');
		
				$recepient_email = trim($customer_service_department_email);
				$recepient_name = 'Customer Service Department';
				
				$body = "Hello $recepient_name!<br/><br/>".
						"You need to dispatch the order for compnay ".$this->getName();
				
				require_once(sfConfig::get('sf_lib_dir').'/swift/lib/swift_init.php');
				
				$connection = Swift_SmtpTransport::newInstance()
							->setHost(sfConfig::get('app_email_smtp_host'));				
				
				$mailer = new Swift_Mailer($connection);
				
				$message = Swift_Message::newInstance($subject)
				         ->setFrom(array($sender_email => $sender_name))
				         ->setTo(array($recepient_email => $recepient_name))
				         ->setBody($body, 'text/html')
				         ;
				         
				  //echo 'hell';
				 // exit;
        
	    	}
	    }
	 
	    if (($ret = parent::save($con)) &&  $mailer)
	    {
	    	try 
	    	{
	    		$mailer->send($message);
	    	}
	    	catch (Execption $ex)
	    	{
	    		throw $ex;
	    	}
	    }
		
	    
		return $ret;
	}
}

