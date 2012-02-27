<?php 

	require_once "SwiftMailer/lib/swift_init.php";

	
class aceMail
{
        /*private $smtp_host 			= 'mail.mobileweaver.dk';
        private $smtp_user 			= 'fa@mobileweaver.dk';
        private $smtp_pass                      = 'killerjoint';
	private $smtp_sender 			= 'fa@mobileweaver.dk';
	private $smtp_sender_name 		= 'Zapna';*/

    	private $smtp_host 				= 'mail.youpark.com';
	private $smtp_user 				= 'system@hubresorts.com';
	private $smtp_pass 				= 'csv%7g@';
	private $smtp_sender 			        = 'confirmation@zapna.com';
	private $smtp_sender_name 		        = 'Zapna';
	
	/*
	 * sendMail send an e-mail to the reciever, with a defined txt mail body and html mail body
	 * 
	 * User: receivers e-mail and name - object with functions - getEmail and getContactName
	 * subject: subject of the e-mail
	 * txtMailBody: e-mail message body in plain text
	 * htmlMailBody: e-mail message body in html
	 * 
	 * returns: void
	*/
	public function sendMail($user = null, $subject = null, $txtMailBody = null, $htmlMailBody = null){
		/*
		try{
			//Create the Transport
			$transport = Swift_SmtpTransport::newInstance( $this->smtp_host, 25)
			  ->setUsername( $this->smtp_user )
			  ->setPassword( $this->smtp_pass )
			  ;
			
			/*
			You could alternatively use a different transport such as Sendmail or Mail:
			
			//Sendmail
			$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
			
			//Mail
			$transport = Swift_MailTransport::newInstance();
			* /
			
			//Create the Mailer using your created Transport
			$mailer = Swift_Mailer::newInstance($transport);
			
			//Create a message
			$message = Swift_Message::newInstance($subject)
			  ->setFrom(array( $this->smtp_sender =>  $this->smtp_sender_name))
			  ->setTo(array( $user->getEmail() => $user->getContactName()))
	
			  ->setBody($txtMailBody)
			  //add alternative body
	  		  ->addPart($htmlMailBody, 'text/html')
			  ;
			  
			//Send the message
			$result = $mailer->send($message);
			
			/*
			You can alternatively use batchSend() to send the message
			
			$result = $mailer->batchSend($message);
			* /
		} catch (sfException $e){
			// do nothing
		}*/
	}	
	
	public function sendMailAlt($userEmail = null, $userName = null, $subject = null, $txtMailBody = null, $htmlMailBody = null){
		
		try{
			//Create the Transport
			$transport = Swift_SmtpTransport::newInstance( $this->smtp_host, 25)
			  ->setUsername( $this->smtp_user )
			  ->setPassword( $this->smtp_pass )
			  ;
			  
			/*
			You could alternatively use a different transport such as Sendmail or Mail:
			
			//Sendmail
			$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
			
			//Mail
			$transport = Swift_MailTransport::newInstance();
			*/
			
			//Create the Mailer using your created Transport
			$mailer = Swift_Mailer::newInstance($transport);
			
			//Create a message
			$message = Swift_Message::newInstance($subject)
			  ->setFrom(array( $this->smtp_sender =>  $this->smtp_sender_name))
			  ->setTo(array( $userEmail => $userName))
	
			  ->setBody($txtMailBody)
			  //add alternative body
	  		  ->addPart($htmlMailBody, 'text/html')
			  ;
			  
			//Send the message
			$result = $mailer->send($message);
			
			/*
			You can alternatively use batchSend() to send the message
			
			$result = $mailer->batchSend($message);
			*/
		} catch (sfException $e){
			//do nothing
                    echo 'exception in mail';
		}
	}	
	
	public function setSenderMail($senderMail = null){
		
		$this->smtp_sender = $senderMail;
	}
}

?>