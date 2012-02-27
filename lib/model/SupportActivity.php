<?php

class SupportActivity extends BaseSupportActivity
{
	public function getVatNo()
	{
		return $this->getEmployee()->getCompany()->getVatNo();
	}
	
	
	public function save(PropelPDO $con = null)
	{  
		
	    if ($this->isNew() && !$this->getTicketNumber())
	    {
	    	$lastTicketNumber = 0;
	    
	    	$connection = Propel::getConnection();
			$query = 'SELECT MAX(%s) AS lastTicketNumber FROM %s';
			$query = sprintf($query, SupportActivityPeer::TICKET_NUMBER, SupportActivityPeer::TABLE_NAME);
			$statement = $connection->prepare($query);
			$statement->execute();
			$resultset = $statement->fetch(PDO::FETCH_OBJ);
			$lastTicketNumber = $resultset->lastTicketNumber;

			$lastTicketNumber = $lastTicketNumber == 0? 20000 : $lastTicketNumber;
			
			$this->setTicketNumber($lastTicketNumber+1);
	    }
	    
	   	$mailer = null;
	    
	    if ($this->isNew() && $this->getUserId())
	    {
	    	$assignedToUser = UserPeer::retrieveByPK($this->getUserId());
	    	
			$sender_email = sfConfig::get('app_email_sender_email');
			$sender_name = sfConfig::get('app_email_sender_name');
	
			$recepient_email = trim($assignedToUser->getEmail());
			$recepient_name = $assignedToUser->getName();
			
			$body = "Hello $recepient_name!<br/><br/>".
					"You have been assigned a support activity. Kindly check your <a href='http://crm.zapnam.com'>zapnacrm</a> account";
			
			require_once(sfConfig::get('sf_lib_dir').'/swift/lib/swift_init.php');
			
			$connection = Swift_SmtpTransport::newInstance()
						->setHost(sfConfig::get('app_email_smtp_host'));				
			
			$mailer = new Swift_Mailer($connection);
			
			$message = Swift_Message::newInstance($subject)
			         ->setFrom(array($sender_email => $sender_name))
			         ->setTo(array($recepient_email => $recepient_name))
			         ->setBody($body, 'text/html')
			         ;  
        
		
	    }
	 
	    if ($ret = parent::save($con) && $mailer != null)
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
