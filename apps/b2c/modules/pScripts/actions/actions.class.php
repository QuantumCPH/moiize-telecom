<?php
set_time_limit(10000000);
require_once(sfConfig::get('sf_lib_dir').'/changeLanguageCulture.php');
require_once(sfConfig::get('sf_lib_dir').'/emailLib.php');
require_once(sfConfig::get('sf_lib_dir').'/ForumTel.php');
require_once(sfConfig::get('sf_lib_dir').'/commissionLib.php');
require_once(sfConfig::get('sf_lib_dir').'/curl_http_client.php');
require_once(sfConfig::get('sf_lib_dir').'/smsCharacterReplacement.php');
/**
 * scripts actions.
 *
 * @package    WLS2
 * @subpackage scripts
 * @author     Baran Khursheed Khan
 * @version    actions.class.php,v 1.5 2012-01-16 22:20:12 BK Exp $
 */
class pScriptsActions extends sfActions
{
 
    /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  


    public function executeMobAccepted(sfWebRequest $request)
	{
    $order_id = $request->getParameter("orderid");

	  	$this->forward404Unless($order_id || $order_amount);

		$order = CustomerOrderPeer::retrieveByPK($order_id);

		$subscription_id = $request->getParameter("subscriptionid");
	  	$order_amount = ((double)$request->getParameter('amount'))/100;

	  	$this->forward404Unless($order);

	  	$c = new Criteria;
	  	$c->add(TransactionPeer::ORDER_ID, $order_id);

	  	$transaction = TransactionPeer::doSelectOne($c);

	  	//echo var_dump($transaction);

	  	$order->setOrderStatusId(sfConfig::get('app_status_completed', 3)); //completed
	  	//$order->getCustomer()->setCustomerStatusId(sfConfig::get('app_status_completed', 3)); //completed
	  	$transaction->setTransactionStatusId(sfConfig::get('app_status_completed', 3)); //completed




		if($transaction->getAmount() > $order_amount){
	  		//error
	  		$order->setOrderStatusId(sfConfig::get('app_status_error', 5)); //error in amount
	  		$transaction->setTransactionStatusId(sfConfig::get('app_status_error', 5)); //error in amount
	  		//$order->getCustomer()->setCustomerStatusId(sfConfig::get('app_status_completed', 5)); //error in amount


	  	} else if ($transaction->getAmount() < $order_amount){
	  		//$extra_refill_amount = $order_amount;
	  		$order->setExtraRefill($order_amount);
	  		$transaction->setAmount($order_amount);
	  	}





		 //set active agent_package in case customer was registerred by an affiliate
		  if ($order->getCustomer()->getAgentCompany())
		  {
		  	$order->setAgentCommissionPackageId($order->getCustomer()->getAgentCompany()->getAgentCommissionPackageId());
		  }


		  //set subscription id in case 'use current c.c for future auto refills' is set to 1
		  if ($request->getParameter('USER_ATTR_20')=='1')
			$order->getCustomer()->setSubscriptionId($subscription_id);

		//set subscription id also when there is was no subscription for old customers
		if (!$order->getCustomer()->getSubscriptionId())
			$order->getCustomer()->setSubscriptionId($subscription_id);

	  	//set auto_refill amount
	  	if ($is_auto_refill_activated = $request->getParameter('USER_ATTR_1')=='1')
	  	{
	  		//set subscription id
			$order->getCustomer()->setSubscriptionId($subscription_id);

			//auto_refill_amount
	  		$auto_refill_amount_choices = array_keys(ProductPeer::getRefillHashChoices());

	  		$auto_refill_amount = in_array($request->getParameter('USER_ATTR_2'), $auto_refill_amount_choices)?$request->getParameter('USER_ATTR_2'):$auto_refill_amount_choices[0];
	  		$order->getCustomer()->setAutoRefillAmount($auto_refill_amount);


	  		//auto_refill_lower_limit
	  		$auto_refill_lower_limit_choices = array_keys(ProductPeer::getAutoRefillLowerLimitHashChoices());

	  		$auto_refill_min_balance = in_array($request->getParameter('USER_ATTR_3'), $auto_refill_lower_limit_choices)?$request->getParameter('USER_ATTR_3'):$auto_refill_lower_limit_choices[0];
	  		$order->getCustomer()->setAutoRefillMinBalance($auto_refill_min_balance);
	  	}
                else {
                    //disable the auto-refill feature
                    $order->getCustomer()->setAutoRefillAmount(0);

                }



	  	$order->save();
	  	$transaction->save();



	$this->customer = $order->getCustomer();
                $c = new Criteria;
	  	$c->add(CustomerPeer::ID, $order->getCustomerId());
	  	$customer = CustomerPeer::doSelectOne($c);
                $agentid=$customer->getReferrerId();
                $productid=$order->getProductId();
                $transactionid=$transaction->getId();
                if(isset($agentid) && $agentid!=""){
                commissionLib::refilCustomer($agentid,$productid,$transactionid);

                }

	//TODO ask if recharge to be done is same as the transaction amount
	Fonet::recharge($this->customer, $transaction->getAmount());





// Update cloud 9
        c9Wrapper::equateBalance($this->customer);


	//set vat
	$vat = 0;
        $subject = $this->getContext()->getI18N()->__('Payment Confirmation');
	$sender_email = sfConfig::get('app_email_sender_email', 'support@landncall.com');
	$sender_name = sfConfig::get('app_email_sender_name', 'LandNCall AB support');

	$recepient_email = trim($this->customer->getEmail());
	$recepient_name = sprintf('%s %s', $this->customer->getFirstName(), $this->customer->getLastName());
        $referrer_id = trim($this->customer->getReferrerId());

        if($referrer_id):
        $c = new Criteria();
        $c->add(AgentCompanyPeer::ID, $referrer_id);

        $recepient_agent_email  = AgentCompanyPeer::doSelectOne($c)->getEmail();
        $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
        endif;

	//send email
  	$message_body = $this->getPartial('payments/order_receipt', array(
  						'customer'=>$this->customer,
  						'order'=>$order,
  						'transaction'=>$transaction,
  						'vat'=>$vat,
  						'wrap'=>false
  					));



	/*
  	require_once(sfConfig::get('sf_lib_dir').'/swift/lib/swift_init.php');

	$connection = Swift_SmtpTransport::newInstance()
				->setHost(sfConfig::get('app_email_smtp_host'))
				->setPort(sfConfig::get('app_email_smtp_port'))
				->setUsername(sfConfig::get('app_email_smtp_username'))
				->setPassword(sfConfig::get('app_email_smtp_password'));

	$mailer = new Swift_Mailer($connection);

	$message_1 = Swift_Message::newInstance($subject)
	         ->setFrom(array($sender_email => $sender_name))
	         ->setTo(array($recepient_email => $recepient_name))
	         ->setBody($message_body, 'text/html')
	         ;

	$message_2 = Swift_Message::newInstance($subject)
	         ->setFrom(array($sender_email => $sender_name))
	         ->setTo(array($sender_email => $sender_name))
	         ->setBody($message_body, 'text/html')
	         ;

            if (!($mailer->send($message_1) && $mailer->send($message_2)))
                $this->getUser()->setFlash('message', $this->getContext()->getI18N()->__(
                            "Email confirmation is not sent" ));
            */

            //This Seciton For Make The Log History When Complete registration complete - Agent
            //echo sfConfig::get('sf_data_dir');
            $invite_data_file = sfConfig::get('sf_data_dir').'/invite.txt';
            $invite2 = "Customer Refill Account \n";
            $invite2 .= "Recepient Email: ".$recepient_email.' \r\n';
            $invite2 .= " Agent Email: ".$recepient_agent_email.' \r\n';
            $invite2 .= " Sender Email: ".$sender_email.' \r\n';

            file_put_contents($invite_data_file, $invite2, FILE_APPEND);


            //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
            emailLib::sendCustomerRefillEmail($this->customer,$order,$transaction);
    $this->setLayout(false);
	}

     
       

  public function executeAutoRefill(sfWebRequest $request)
  {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        changeLanguageCulture::languageCulture($request,$this);
            
  	//get customers to refill
  	$c = new Criteria();

  	$c->add(CustomerPeer::CUSTOMER_STATUS_ID, sfConfig::get('app_status_completed'));
  	$c->add(CustomerPeer::AUTO_REFILL_AMOUNT, 0, Criteria::NOT_EQUAL);
  	$c->add(CustomerPeer::SUBSCRIPTION_ID, null, Criteria::ISNOTNULL);

  	//$c1 = $c->getNewCriterion(CustomerPeer::LAST_AUTO_REFILL, 'TIMESTAMPDIFF(MINUTE, LAST_AUTO_REFILL, NOW()) > 1' , Criteria::CUSTOM);
        $c1 = $c->getNewCriterion(CustomerPeer::ID, null, Criteria::ISNOTNULL); //just accomodate missing disabled $c1
  	$c2 = $c->getNewCriterion(CustomerPeer::LAST_AUTO_REFILL, null, Criteria::ISNULL);

  	$c1->addOr($c2);

  	$c->add($c1);

  	$epay_con = new EPay();

  	$customer = new Customer();

        var_dump(CustomerPeer::doCount($c));


        try {
            foreach (CustomerPeer::doSelect($c) as $customer)   	{

                $customer_balance = Fonet::getBalance($customer);

                var_dump($customer_balance);
                //if customer balance is less than 10
                if ($customer_balance != null && $customer_balance <= $customer->getAutoRefillMinBalance())   		{



                    //create an order and transaction
                    $customer_order = new CustomerOrder();
                    $customer_order->setCustomer($customer);

                    //select order product
                    $c = new Criteria();
                    $c->add(CustomerProductPeer::CUSTOMER_ID, $customer->getId());
                    $customer_product = CustomerProductPeer::doSelectOne($c);

                    var_dump(CustomerProductPeer::doCount($c));



                    $customer_order->setProduct($customer_product->getProduct());
                    $customer_order->setQuantity(1);
                    $customer_order->setExtraRefill($customer->getAutoRefillAmount());


                    //create a transaction
                    $transaction = new Transaction();
                    $transaction->setCustomer($customer);
                    $transaction->setAmount($customer->getAutoRefillAmount());
                    $transaction->setDescription('Auto refill');



                    //associate transaction with customer order
                    $customer_order->addTransaction($transaction);

                    //save order to get order_id that is required to create a transaction via epay api
                    $customer_order->save();



                    if ($epay_con->authorize(sfConfig::get('app_epay_merchant_number'), $customer->getSubscriptionId(), $customer_order->getId(), $customer->getAutoRefillAmount(), 208, 1)) 			{
                        $customer->setLastAutoRefill(date('Y-m-d H:i:s'));
                        $customer_order->setOrderStatusId(sfConfig::get('app_status_completed'));
                        $transaction->setTransactionStatusId(sfConfig::get('app_status_completed'));
                    }
                    else {
                        die('unauthorized epay');
                    }

                    $customer->save();
                    $customer_order->save();

                    if ($customer_order->getOrderStatusId() == sfConfig::get('app_status_completed') &&
                            Fonet::recharge($customer, $customer->getAutoRefillAmount()))   			{

                        $this->customer = $customer;
                        $TelintaMobile = '46'.$this->customer->getMobileNumber();
                        $emailId = $this->customer->getEmail();
                        $OpeningBalance = $customer->getAutoRefillAmount();
                        $customerPassword = $this->customer->getPlainText();
                        $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0,1);     // bcdef
                        if($getFirstnumberofMobile==0){
                            $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
                            $TelintaMobile =  '46'.$TelintaMobile ;
                        }else{
                            $TelintaMobile = '46'.$this->customer->getMobileNumber();
                        }
                        $uniqueId = $this->customer->getUniqueid();
                      //This is for Recharge the Customer
                       $MinuesOpeningBalance = $OpeningBalance*3;
                      $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$uniqueId.'&amount='.$OpeningBalance.'&type=customer');
                      //This is for Recharge the Account
                      //this condition for if follow me is Active
                        $getvoipInfo = new Criteria();
                        $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $this->customer->getMobileNumber());
                        $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo);//->getId();
                        if(isset($getvoipInfos)){
                            $voipnumbers = $getvoipInfos->getNumber() ;
                            $voip_customer = $getvoipInfos->getCustomerId() ;
                            //$telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$voipnumbers.'&amount='.$OpeningBalance.'&type=account');
                        }else{
                           // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$uniqueId.'&amount='.$OpeningBalance.'&type=account');
                        }
                      
                     // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name=a'.$TelintaMobile.'&amount='.$OpeningBalance.'&type=account');
                     // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name=cb'.$TelintaMobile.'&amount='.$OpeningBalance.'&type=account');

                      $MinuesOpeningBalance = $OpeningBalance*3;
                      //type=<account_customer>&action=manual_charge&name=<name>&amount=<amount>
                      //This is for Recharge the Customer
                     // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=customer&action=manual_charge&name='.$uniqueId.'&amount='.$MinuesOpeningBalance);


			//update cloud 9
			c9Wrapper::equateBalance($customer);


						//send invoices

                        $message_body = $this->getPartial('customer/order_receipt', array(
                                    'customer' => $customer,
                                    'order' => $customer_order,
                                    'transaction' => $transaction,
                                    'vat' => 0,
                                    'wrap' => false
                                ));

                            $subject = $this->getContext()->getI18N()->__('Payment Confirmation');
                            $sender_email = sfConfig::get('app_email_sender_email', 'support@landncall.com');
                            $sender_name = sfConfig::get('app_email_sender_name', 'LandNCall AB support');

                            $recepient_email = trim($this->customer->getEmail());
                            $recepient_name = sprintf('%s %s', $this->customer->getFirstName(), $this->customer->getLastName());


                            //This Seciton For Make The Log History When Complete registration complete - Agent
                            //echo sfConfig::get('sf_data_dir');
                            $invite_data_file = sfConfig::get('sf_data_dir').'/invite.txt';
                            $invite2 = " AutoRefill - pScript \n";
                            $invite2 = "Recepient Email: ".$recepient_email.' \r\n';


                            //Send Email to User/Agent/Support --- when Agent register Customer --- 01/15/11
                            emailLib::sendCustomerAutoRefillEmail($this->customer,$message_body);

  			}
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return sfView::NONE;
  }
public function executeConfirmPayment(sfWebRequest $request)
  {

print_r($_REQUEST);

die;
  	$this->logMessage(print_r($_GET, true));

        $is_transaction_ok = false;
        $subscription_id = '';
        $order_id = "";
        $order_amount = "";
 	//get the order_id from the session
  	//change the status of that order to complete,
  	//change the customer status to compete too

  	$order_id = $request->getParameter('orderid');
        $ticket_id = $request->getParameter('ticket');
        echo $order_id.'<br />';
  	$subscription_id = $request->getParameter('subscriptionid');        
  	$this->logMessage('sub id: '.$subscription_id);
        $order_amount = $request->getParameter('amount')/100;

  	$this->forward404Unless($order_id || $order_amount);

	//get order object
  	$order = CustomerOrderPeer::retrieveByPK($order_id);

  	//check to see if that customer has already purchased this product
  	$c = new Criteria();
  	$c->add(CustomerProductPeer::CUSTOMER_ID, $order->getCustomerId());
  	$c->addAnd(CustomerProductPeer::PRODUCT_ID, $order->getProductId());
  	$c->addJoin(CustomerProductPeer::CUSTOMER_ID, CustomerPeer::ID);
  	$c->addAnd(CustomerPeer::CUSTOMER_STATUS_ID, sfConfig::get('app_status_new'), Criteria::NOT_EQUAL);

        echo 'retrieve order id: '.$order->getId().'<br />';

  	if (CustomerProductPeer::doCount($c)!=0)
  	{
  		echo 'Customer is already registered.';
  		//exit the script successfully
  		return sfView::NONE;
  	}

  	//set subscription id
  	$order->getCustomer()->setSubscriptionId($subscription_id);

  	//set auto_refill amount
  	if (isset($ticket_id) && $ticket_id!="")
  	{
  		
                echo 'is autorefill activated';
                //auto_refill_amount
  		$auto_refill_amount_choices = array_keys(ProductPeer::getRefillHashChoices());

  		$auto_refill_amount = in_array($request->getParameter('USER_ATTR_2'), $auto_refill_amount_choices)?$request->getParameter('USER_ATTR_2'):$auto_refill_amount_choices[0];
  		$order->getCustomer()->setAutoRefillAmount($auto_refill_amount);

  		//auto_refill_lower_limit
  		$auto_refill_lower_limit_choices = array_keys(ProductPeer::getAutoRefillLowerLimitHashChoices());
  		$auto_refill_min_balance = in_array($request->getParameter('USER_ATTR_3'), $auto_refill_lower_limit_choices)?$request->getParameter('USER_ATTR_3'):$auto_refill_lower_limit_choices[0];
  		$order->getCustomer()->setAutoRefillMinBalance($auto_refill_min_balance);
                $order->getCustomer()->setTicketval($ticket_id);
  	}

  	//if order is already completed > 404
  	$this->forward404Unless($order->getOrderStatusId()!=sfConfig::get('app_status_completed'));
  	$this->forward404Unless($order);

        echo 'processing order <br />';

  	$c = new Criteria;
  	$c->add(TransactionPeer::ORDER_ID, $order_id);
  	$transaction = TransactionPeer::doSelectOne($c);

        echo 'retrieved transaction<br />';

  	if($transaction->getAmount() > $order_amount || $transaction->getAmount() < $order_amount){
  		//error
  		$order->setOrderStatusId(sfConfig::get('app_status_error')); //error in amount
  		$transaction->setTransactionStatusId(sfConfig::get('app_status_error')); //error in amount
  		$order->getCustomer()->setCustomerStatusId(sfConfig::get('app_status_error')); //error in amount
                echo 'setting error <br /> ';

  	}
  	else {
  		//TODO: remove it
  		$transaction->setAmount($order_amount);

	  	$order->setOrderStatusId(sfConfig::get('app_status_completed')); //completed
	  	$order->getCustomer()->setCustomerStatusId(sfConfig::get('app_status_completed')); //completed
	  	$transaction->setTransactionStatusId(sfConfig::get('app_status_completed')); //completed
                 echo 'transaction=ok <br /> ';
	  	$is_transaction_ok = true;
  	}


  	$product_price = $order->getProduct()->getPrice() - $order->getExtraRefill();

  	$product_price_vat = .20 * $product_price;

  	$order->setQuantity(1);

  	//set active agent_package in case customer
  	if ($order->getCustomer()->getAgentCompany())
  	{
  		$order->setAgentCommissionPackageId($order->getCustomer()->getAgentCompany()->getAgentCommissionPackageId());
  	}


  	
  	

	 echo 'saving order '.$order->save().'<br /> ';
         echo 'saving transaction '.$transaction->save().' <br /> ';
  	if ($is_transaction_ok)
  	{

                echo 'Assigning Customer ID <br/>';
	  	//set customer's proudcts in use
	  	$customer_product = new CustomerProduct();

	  	$customer_product->setCustomer($order->getCustomer());
	  	$customer_product->setProduct($order->getProduct());

	  	$customer_product->save();

	  	//register to fonet
	  	$this->customer = $order->getCustomer();

	  //	Fonet::registerFonet($this->customer);
	  	//recharge the extra_refill/initial balance of the prouduct
		//Fonet::recharge($this->customer, $order->getExtraRefill());

                echo 'Fonet Id assigned ID <br/>';


                $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0,1);     // bcdef
                if($getFirstnumberofMobile==0){
                  $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
                  $TelintaMobile =  '46'.$TelintaMobile ;
                }else{
                  $TelintaMobile = '46'.$this->customer->getMobileNumber();
                }
                 $uniqueId = $this->customer->getUniqueid();
              $emailId = $this->customer->getEmail();
              $OpeningBalance = $order->getExtraRefill();
              $customerPassword = $this->customer->getPlainText();

              //Section For Telinta Add Cusomter
              $telintaRegisterCus = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?reseller=R_LandNcall&action=add&name='.$uniqueId.'&currency=SEK&opening_balance=0&credit_limit=0&enable_dialingrules=Yes&int_dial_pre=00&email='.$emailId.'&type=customer');

              // For Telinta Add Account
              $telintaAddAccount = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name='.$uniqueId.'&customer='.$uniqueId.'&opening_balance=-'.$OpeningBalance.'&product=YYYLandncall_Forwarding&outgoing_default_r_r=2034&activate_follow_me=Yes&follow_me_number=0&billing_model=1&password='.$customerPassword);
              $telintaAddAccountA = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name=a'.$TelintaMobile.'&customer='.$TelintaMobile.'&opening_balance=-'.$OpeningBalance.'&product=YYYLandncall_CT&outgoing_default_r_r=2034&billing_model=1&password='.$customerPassword);
              $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name=cb'.$TelintaMobile.'&customer='.$TelintaMobile.'&opening_balance=-'.$OpeningBalance.'&product=YYYLandncall_callback&outgoing_default_r_r=2034&billing_model=1&password='.$customerPassword);

              //This is for Recharge the Customer
              $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$uniqueId.'&amount='.$OpeningBalance.'&type=customer');
             

                   //echo "SIP is being Assigned 1";
              $sc = new Criteria();
              $sc->add(SipPeer::ASSIGNED, false);
              $sip = SipPeer::doSelectOne($sc);

              //echo "SIP is being Assigned 2";

              $sip->setCustomerId($this->customer->getId());
              $sip->setAssigned(true);
              $sip->save();

              $cc = new Criteria();
              $cc->add(EnableCountryPeer::ID, $this->customer->getCountryId());
              $country = EnableCountryPeer::doSelectOne($cc);

              $mobile = $country->getCallingCode().$this->customer->getMobileNumber();

              if(strlen($mobile)==11){
//                 echo 'mobile # = 11' ;
                 $mobile = '00'.$mobile;
             }

              $IMdata = array(
                      'type' => 'add',
                      'secret'=>'rnRQSRD0',
                      'username'=>$mobile,
                      'password'=>$this->customer->getPlainText(),
                      'name' =>$this->customer->getFirstName(),
                      'email'=>$this->customer->getEmail()
                );
               $queryString = http_build_query($IMdata,'', '&');
               $res2 = file_get_contents('http://im.zerocall.com:9090/plugins/userService/userservice?'.$queryString);


         // Assign C9 number
         if ($order->getProduct()->getId()=='3'){
                
          $c = new Criteria();
  		  $c->add(C9NumbersPeer::IS_ASSIGNED, false);
          $c9number = C9NumbersPeer::doSelectOne($c);

          $this->customer->setC9CustomerNumber($c9number->getC9Number() );

          $c9number->setIsAssigned(true);
          $c9number->save();
          //$customer = $form->save();
          $this->customer->save();

         c9Wrapper::equateBalance($this->customer);
}



			

                //if the customer is invited, Give the invited customer a bonus of 10dkk
                $invite_c = new Criteria();
                $invite_c->add(InvitePeer::INVITE_NUMBER, $this->customer->getMobileNumber());
                $invite_c->add(InvitePeer::INVITE_STATUS, 2);
                $invite =  InvitePeer::doSelectOne($invite_c);

                if($invite!=NULL){


    $invite2 = "assigning bonuss \r\n";
			 echo " assigning bonuss <br />";
                         $invite_data_file=sfConfig::get('sf_data_dir').'/invite.txt';
			file_put_contents($invite_data_file, $invite2, FILE_APPEND);




    $invite->setInviteStatus(3);

                       $sc = new Criteria();
                $sc->add(CustomerCommisionPeer::ID, 1);
                $commisionary = CustomerCommisionPeer::doSelectOne($sc);
                           $comsion=$commisionary->getCommision();


                           
                $products = new Criteria();
                $products->add(ProductPeer::ID, 11);
                $products = ProductPeer::doSelectOne($products);
                $extrarefill=$products->getInitialBalance();
                //if the customer is invited, Give the invited customer a bonus of 10dkk
            
                $inviteOrder = new CustomerOrder();
                $inviteOrder->setProductId(11);
                $inviteOrder->setQuentity(1);
                $inviteOrder->setOrderStatusId(3);
                $inviteOrder->setCustomerId($invite->getCustomerId());
                $inviteOrder->setExtraRefill($extrarefill);
                $inviteOrder->save();
                $OrderId    =   $inviteOrder->getId();
                // make a new transaction to show in payment history
                $transaction_i = new Transaction();
                $transaction_i->setAmount($comsion);
                $transaction_i->setDescription("Invitation Bonus for Mobile Number: ".$invite->getInviteNumber());
                $transaction_i->setCustomerId($invite->getCustomerId());
                $transaction_i->setOrderId($OrderId);
                $transaction_i->setTransactionStatusId(3);

                //send fonet query to update the balance of invitee by 10dkk
           //     Fonet::recharge(CustomerPeer::retrieveByPK($invite->getCustomerId()), $comsion);

                //save transaction & Invite
                $transaction_i->save();
                $invite->save();
				$invite2 .= "transaction & invite saved  \r\n";
				file_put_contents($invite_data_file, $invite2, FILE_APPEND);
    $invitevar=$invite->getCustomerId();



                 if(isset($invitevar)){
                  emailLib::sendCustomerConfirmRegistrationEmail($invite->getCustomerId());
                            }
}
                //send email

	  	$message_body = $this->getPartial('payments/order_receipt', array(
	  						'customer'=>$this->customer,
	  						'order'=>$order,
	  						'transaction'=>$transaction,
	  						'vat'=>$product_price_vat,
	  						'wrap'=>true
	  					));

                $subject = $this->getContext()->getI18N()->__('Payment Confirmation');
		$sender_email = sfConfig::get('app_email_sender_email', 'support@landncall.com');
		$sender_name = sfConfig::get('app_email_sender_name', 'LandNCall AB support');

		$recepient_email = trim($this->customer->getEmail());
		$recepient_name = sprintf('%s %s', $this->customer->getFirstName(), $this->customer->getLastName());


                //This Seciton For Make The Log History When Complete registration complete - Agent
                //echo sfConfig::get('sf_data_dir');
             
              
                
		//Send Email --- when Confirm Payment --- 01/15/11

               $agentid=$customer->getReferrerId();
                $productid=$product->getId();
                $transactionid=$transaction->getId();
                if(isset($agentid) && $agentid!=""){
                commissionLib::registrationCommissionCustomer($agentid,$productid,$transactionid);
                }
                   emailLib::sendCustomerConfirmPaymentEmail($this->customer,$message_body);
                 emailLib::sendCustomerRegistrationViaWebEmail($this->customer,$order);
              
             
	    $this->order = $order;

  	}//end if
  	else
  	{
  		$this->logMessage('Error in transaction.');

  	} //end else

  	return sfView::NONE;
  }

  


  public function executeRemoveInactiveUsers(sfWebRequest $request)
  {
  	$c = new Criteria();

  	$c->add(CustomerOrderPeer::CUSTOMER_ID,
  		'customer_id IN (SELECT id FROM customer WHERE TIMESTAMPDIFF(MINUTE, NOW(), created_at) >= -30 AND customer_status_id = 1)'
  	, Criteria::CUSTOM);

  	$this->remove_propel_object_list(CustomerOrderPeer::doSelect($c));

  	//now transaction
  	$c = new Criteria();

  	$c->add(TransactionPeer::CUSTOMER_ID,
  		'customer_id IN (SELECT id FROM customer WHERE TIMESTAMPDIFF(MINUTE, NOW(), created_at) >= -30 AND customer_status_id = 1)'
  	, Criteria::CUSTOM);

  	$this->remove_propel_object_list(TransactionPeer::doSelect($c));

  	//now customer
   	$c = new Criteria();

  	$c->add(CustomerPeer::ID,
  		'id IN (SELECT id FROM customer WHERE TIMESTAMPDIFF(MINUTE, NOW(), created_at) >= -30 AND customer_status_id = 1)'
  	, Criteria::CUSTOM);

  	$this->remove_propel_object_list(CustomerPeer::doSelect($c));

  	$this->renderText('last deleted on '. date(DATE_RFC822));

  	return sfView::NONE;

  }

  public function executeSMS(sfWebRequest $request)
  {


  	$sms = SMS::receive($request);

  	if ($sms)
  	{
  		//take action
  		$valid_keywords = array('ZEROCALLS', 'ZEROCALLR', 'ZEROCALLN');

  		if (in_array($sms->getKeyword(), $valid_keywords))
  		{
  			//get voucher info
  			$c = new Criteria();

  			$c->add(VoucherPeer::PIN_CODE, $sms->getMessage());
  			$c->add(VoucherPeer::USED_ON, null, CRITERIA::ISNULL);

  			$is_voucher_ok = false;
  			$voucher = VoucherPeer::doSelectOne($c);

  			switch (strtolower($sms->getKeyword()))
		  	{
		  		case 'zerocalls': //register + refill
		  			//purchaes a product in 0 rs, and 200 refill

		  			//create customer

		  			//create order for a product

		  			//don't create trnsaction for product order

		  			//create refill order for product
		  			//create transaction for refill order

		  			if ($voucher)
		  			{
		  				$is_voucher_ok = $voucher->getType()=='s';

		  				$is_voucher_ok = $is_voucher_ok &&
		  					 ($voucher->getAmount()==200);
		  			}

		  			if ($is_voucher_ok)
		  			{
		  				//check if customer already exists
		  				if ($this->is_mobile_number_exists($sms->getMobileNumber()))
		  				{
		  					$message = $this->getContext()->getI18N()->__('
		  						You mobile number is already registered with LandNCall AB.
		  					');

		  					echo $message;
		  					SMS::send($message, $sms->getMobileNumber());
		  					break;
		  				}

                                              //This Function For Get the Enable Country Id =
                                              $calingcode = '45';
                                              $countryId = $this->getEnableCountryId($calingcode);
                                              
			  			//create a customer
			  			$customer = new Customer();
                                                
			  			$customer->setMobileNumber($sms->getMobileNumber());
			  			$customer->setCountryId($countryId); //denmark;
			  			$customer->setAddress('Street address');
			  			$customer->setCity('City');
			  			$customer->setDeviceId(1);
			  			$customer->setEmail($sms->getMobileNumber().'@zerocall.com');
			  			$customer->setFirstName('First name');
			  			$customer->setLastName('Last name');

			  			$password  = substr(md5($customer->getMobileNumber() .  'jhom$brabar_x'),0,8);
			  			$customer->setPassword($password);

			  			//crete an order of startpackage
			  			$customer_order = new CustomerOrder();
			  			$customer_order->setCustomer($customer);
			  			$customer_order->setProductId(1);
			  			$customer_order->setExtraRefill($voucher->getAmount());
			  			$customer_order->setQuantity(0);
			  			$customer_order->setIsFirstOrder(true);

			  			//set customer_product

			  			$customer_product = new CustomerProduct();

			  			$customer_product->setCustomer($customer);
			  			$customer_product->setProduct($customer_order->getProduct());

			  			//crete a transaction of product price
			  			$transaction = new Transaction();
			  			$transaction->setAmount($voucher->getAmount());
			  			$transaction->setDescription($this->getContext()->getI18N()->__('Product  purchase & refill, via voucher'));
			  			$transaction->setOrderId($customer_order->getId());
			  			$transaction->setCustomer($customer);


			  			$customer->setCustomerStatusId(sfConfig::get('app_status_completed', 3));
			  			$customer_order->setOrderStatusId(sfConfig::get('app_status_completed', 3));
			  			$transaction->setTransactionStatusId(sfConfig::get('app_status_completed', 3));


			  			$customer->save();
			  			$customer_order->save();
			  			$customer_product->save();
			  			$transaction->save();


			  			//save voucher so it can't be reused
			  			$voucher->setUsedOn(date('Y-m-d'));

			  			$voucher->save();

			  			//register with fonet
			  			Fonet::registerFonet($customer);
			  			Fonet::recharge($customer, $transaction->getAmount());

                                                $this->customer = $customer;
                                                $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0,1);     // bcdef
                                                if($getFirstnumberofMobile==0){
                                                  $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
                                                  $TelintaMobile =  '46'.$TelintaMobile ;
                                                }else{
                                                  $TelintaMobile = '46'.$this->customer->getMobileNumber();
                                                }
                                                $uniqueId = $this->customer->getUniqueid();
                                              $emailId = $this->customer->getEmail();
                                              $OpeningBalance = $transaction->getAmount();
                                              $customerPassword = $this->customer->getPlainText();

                                              //Section For Telinta Add Cusomter
                                              $telintaRegisterCus = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?reseller=R_LandNcall&action=add&name='.$uniqueId.'&currency=SEK&opening_balance=0&credit_limit=0&enable_dialingrules=Yes&int_dial_pre=00&email='.$emailId.'&type=customer');

                                              // For Telinta Add Account
                                              $telintaAddAccount = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name='.$uniqueId.'&customer='.$uniqueId.'&opening_balance=-'.$OpeningBalance.'&product=YYYLandncall_Forwarding&outgoing_default_r_r=2034&activate_follow_me=Yes&follow_me_number=0&billing_model=1&password='.$customerPassword);
                                              $telintaAddAccountA = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name=a'.$TelintaMobile.'&customer='.$TelintaMobile.'&opening_balance=-'.$OpeningBalance.'&product=YYYLandncall_CT&outgoing_default_r_r=2034&billing_model=1&password='.$customerPassword);
                                              $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name=cb'.$TelintaMobile.'&customer='.$TelintaMobile.'&opening_balance=-'.$OpeningBalance.'&product=YYYLandncall_callback&outgoing_default_r_r=2034&billing_model=1&password='.$customerPassword);

                                              //This is for Recharge the Customer
                                              $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$uniqueId.'&amount='.$OpeningBalance.'&type=customer');



			  			$message = $this->getContext()->getI18N()->__('
			  			You have been registered to ZerOcall.' /* \n
			  			You can use following login information to access your account.\n
			  			Email: '. $customer->getEmail(). '\n' .
			  			'Password: ' . $password */
			  			);

			  			echo $message;
			  			SMS::send($message, $customer->getMobileNumber());


		  			}
		  			else
		  			{
		  				$invalid_pin_sms = SMS::send($this->getContext()->getI18N()->__('Invalid pin code.'), $sms->getMobileNumber());
		  				echo $invalid_pin_sms;
		  				$this->logMessage('invaild pin sms sent to ' . $sms->getMobileNumber());
		  			}

		  			break;
		  		case 'zerocallr': //refill
		  			//check if mobile number exists?

		  			//create an order for sms refill

		  			//create a transaction
		  			if ($voucher)
		  			{
		  				$is_voucher_ok = $voucher->getType()=='r';

		  				$valid_refills = array(100, 200, 500);

		  				$is_voucher_ok = $is_voucher_ok && in_array($voucher->getAmount(), $valid_refills);
		  			}

		  			if ($is_voucher_ok)
		  			{
		  				//check if customer already exists
		  				if (!$this->is_mobile_number_exists($sms->getMobileNumber()))
		  				{
		  					$message = $this->getContext()->getI18N()->__('
		  						Your mobile number is not registered with LandNCall AB.
		  					');

		  					echo $message;
		  					SMS::send($message, $sms->getMobileNumber());
		  					break;
		  				}
			  			//get the customer

		  				$c = new Criteria();
		  				$c->add(CustomerPeer::MOBILE_NUMBER, $sms->getMobileNumber());


			  			$customer = CustomerPeer::doSelectOne($c);

			  			//create new customer order
			  			$customer_order = new CustomerOrder();
			  			$customer_order->setCustomer($customer);

			  			//get customer product

			  			$c = new Criteria();
			  			$c->add(CustomerProductPeer::CUSTOMER_ID, $customer->getId());

			  			$customer_product = CustomerProductPeer::doSelectOne($c);

			  			//set customer product
			  			$customer_order->setProduct($customer_product->getProduct());

			  			$customer_order->setExtraRefill($voucher->getAmount());
			  			$customer_order->setQuantity(0);
			  			$customer_order->setIsFirstOrder(false);


			  			//crete a transaction of product price
			  			$transaction = new Transaction();
			  			$transaction->setAmount($voucher->getAmount());
			  			$transaction->setDescription($this->getContext()->getI18N()->__('LandNCall AB  Refill, via voucher'));
			  			$transaction->setOrderId($customer_order->getId());
			  			$transaction->setCustomer($customer);


			  			$customer_order->setOrderStatusId(sfConfig::get('app_status_completed', 3));
			  			$transaction->setTransactionStatusId(sfConfig::get('app_status_completed', 3));

			  			$customer_order->save();
			  			$transaction->save();

			  			Fonet::recharge($customer, $transaction->getAmount());


			  			//save voucher so it can't be reused
			  			$voucher->setUsedOn(date('Y-m-d H:i:s'));

			  			$voucher->save();

			  			$message = $this->getContext()->getI18N()->__('
			  			You account has been topped up.' /* \n
			  			You can use following login information to access your account.\n
			  			Email: '. $customer->getEmail(). '\n' .
			  			'Password: ' . $password */
			  			);

			  			echo $message;
			  			SMS::send($message, $sms->getMobileNumber());


		  			}
		  			else
		  			{
		  				$invalid_pin_sms = SMS::send($this->getContext()->getI18N()->__('Invalid pin code.'), $sms->getMobileNumber());
		  				echo $invalid_pin_sms;
		  				$this->logMessage('invaild pin sms sent to ' . $sms->getMobileNumber());
		  			}

		  			break;
		  		case 'zerocalln':
		  			//purchases a 100 product, no refill

		  			//check if pin code
		  			// pin code matches
		  			// not used before
		  			//	type is n, amount eq to gt than product price



		  			if ($voucher)
		  			{
		  				$is_voucher_ok = $voucher->getType()=='n';

		  				$is_voucher_ok = $is_voucher_ok &&
		  					 ($voucher->getAmount()>=ProductPeer::retrieveByPK(1)->getPrice());
		  			}

		  			if ($is_voucher_ok)
		  			{
		  				//check if customer already exists
		  				if ($this->is_mobile_number_exists($sms->getMobileNumber()))
		  				{
		  					$message = $this->getContext()->getI18N()->__('
		  						You mobile number is already registered with LandNCall AB.
		  					');

		  					echo $message;
		  					SMS::send($message, $sms->getMobileNumber());
		  					break;
		  				}

                                                //This Function For Get the Enable Country Id =
                                                $calingcode = '45';
                                                $countryId = $this->getEnableCountryId($calingcode);

			  			//create a customer
			  			$customer = new Customer();

			  			$customer->setMobileNumber($sms->getMobileNumber());
			  			$customer->setCountryId($countryId); //denmark;
			  			$customer->setAddress('Street address');
			  			$customer->setCity('City');
			  			$customer->setDeviceId(1);
			  			$customer->setEmail($sms->getMobileNumber().'@zerocall.com');
			  			$customer->setFirstName('First name');
			  			$customer->setLastName('Last name');

			  			$password  = substr(md5($customer->getMobileNumber() .  'jhom$brabar_x'),0,8);
			  			$customer->setPassword($password);

			  			//crete an order of startpackage
			  			$customer_order = new CustomerOrder();
			  			$customer_order->setCustomer($customer);
			  			$customer_order->setProductId(1);
			  			$customer_order->setExtraRefill(0);
			  			$customer_order->setQuantity(1);
			  			$customer_order->setIsFirstOrder(true);

			  			//set customer_product

			  			$customer_product = new CustomerProduct();

			  			$customer_product->setCustomer($customer);
			  			$customer_product->setProduct($customer_order->getProduct());

			  			//crete a transaction of product price
			  			$transaction = new Transaction();
			  			$transaction->setAmount($customer_order->getProduct()->getPrice()*$customer_order->getQuantity());
			  			$transaction->setDescription($this->getContext()->getI18N()->__('Product  purchase, via voucher'));
			  			$transaction->setOrderId($customer_order->getId());
			  			$transaction->setCustomer($customer);


			  			$customer->setCustomerStatusId(sfConfig::get('app_status_completed', 3));
			  			$customer_order->setOrderStatusId(sfConfig::get('app_status_completed', 3));
			  			$transaction->setTransactionStatusId(sfConfig::get('app_status_completed', 3));


			  			$customer->save();
			  			$customer_order->save();
			  			$customer_product->save();
			  			$transaction->save();


			  			//save voucher so it can't be reused
			  			$voucher->setUsedOn(date('Y-m-d'));

			  			$voucher->save();

			  			//register with fonet
			  			Fonet::registerFonet($customer);

			  			$message = $this->getContext()->getI18N()->__('
			  			You have been registered to LandNCall AB.' /* \n
			  			You can use following login information to access your account.\n
			  			Email: '. $customer->getEmail(). '\n' .
			  			'Password: ' . $password */
			  			);

			  			echo $message;
			  			SMS::send($message, $sms->getMobileNumber());


		  			}
		  			else
		  			{
		  				$invalid_pin_sms = SMS::send($this->getContext()->getI18N()->__('Invalid pin code.'), $sms->getMobileNumber());
		  				echo $invalid_pin_sms;
		  				$this->logMessage('invaild pin sms sent to ' . $sms->getMobileNumber());
		  			}

		  			break;
		  	}
  		}

  	}

  	$this->renderText('completed');

  	return sfView::NONE;
  }

  private function is_mobile_number_exists($mobile_number)
  {
  	$c = new Criteria();

  	$c->add(CustomerPeer::MOBILE_NUMBER, $mobile_number);

  	 if (CustomerPeer::doSelectOne($c))
  	 	return true;
  }

  private function remove_propel_object_list($list)
  {
  	foreach($list as $list_item)
  	{
  		$list_item->delete();
  	}
  }

  public function executeSendEmails(sfWebRequest $request)
  {

  require_once(sfConfig::get('sf_lib_dir').'/swift/lib/swift_init.php');


        echo 'starting the debug';
        echo '<br/>';
        echo sfConfig::get('app_email_smtp_host');
        echo '<br/>';
        echo sfConfig::get('app_email_smtp_port');
        echo '<br/>';
        echo sfConfig::get('app_email_smtp_username');
        echo '<br/>';
        echo sfConfig::get('app_email_smtp_password');
        echo '<br/>';
        echo sfConfig::get('app_email_sender_email', 'support@moiize.com');
        echo '<br/>';
        echo sfConfig::get('app_email_sender_name', 'Moiize Telecom');
        

  	$connection = Swift_SmtpTransport::newInstance()
			->setHost(sfConfig::get('app_email_smtp_host'))
			->setPort(sfConfig::get('app_email_smtp_port'))
			->setUsername(sfConfig::get('app_email_smtp_username'))
			->setPassword(sfConfig::get('app_email_smtp_password'));




	$sender_email = sfConfig::get('app_email_sender_email', 'support@moiize.com');
	$sender_name = sfConfig::get('app_email_sender_name', 'Moiize Telecom');

        echo '<br/>';
        echo $sender_email ;
        echo '<br/>';
        echo $sender_name ;


	$mailer = new Swift_Mailer($connection);

  	$c = new Criteria();
  	$c->add(EmailQueuePeer::EMAIL_STATUS_ID, sfConfig::get('app_status_completed'), Criteria::NOT_EQUAL);
        $emails = EmailQueuePeer::doSelect($c);
  try{
  	foreach( $emails as $email)
  	{
                

		$message = Swift_Message::newInstance($email->getSubject())
		         ->setFrom(array($sender_email => $sender_name))
		         ->setTo(array($email->getReceipientEmail() => $email->getReceipientName()))
		         ->setBody($email->getMessage(), 'text/html')
		         ;

//                $message = Swift_Message::newInstance($email->getSubject())
//		         ->setFrom(array("support@landncall.com"))
//		         ->setTo(array("mohammadali110@gmail.com"=>"Mohammad Ali"))
//		         ->setBody($email->getMessage(), 'text/html')
//		         ;
                echo 'inside loop';
                echo '<br/>';
               
                echo $email->getId();
                echo '<br/>';
                echo '<br/>';

                //This Conditon Add Update Row Which Have the 
		 if($email->getReceipientEmail()!=''){
                    @$mailer->send($message);
                    $email->setEmailStatusId(sfConfig::get('app_status_completed'));
                    //TODO:: add sent_at too
                    $email->save();
                    echo sprintf("Send to %s<br />", $email->getReceipientEmail());
		}

                

  	}
        }catch (Exception $e){

                    echo $e->getLine();
                    echo $e->getMessage();
                }
  	return sfView::NONE;
  }




  public function executeC9invoke(sfWebRequest $request)
  {

        $this->logMessage(print_r($_POST, true));

    // creating model object
	$c9Data = new cloud9_data();

	//setting data in model
        $c9Data->setRequestType($request->getParameter('request_type'));
        $c9Data->setC9Timestamp($request->getParameter('timestamp'));
        $c9Data->setTransactionID($request->getParameter('transactionid'));
        $c9Data->setCallDate($request->getParameter('call_date'));
        $c9Data->setCdr($request->getParameter('cdr_id'));
        $c9Data->setCid($request->getParameter('carrierid'));
        $c9Data->setMcc($request->getParameter('mcc'));
        $c9Data->setMnc($request->getParameter('mnc'));
        $c9Data->setImsi($request->getParameter('imsi'));
        $c9Data->setMsisdn($request->getParameter('msisdn'));
        $c9Data->setDestination($request->getParameter('destination'));
        $c9Data->setLeg($request->getParameter('leg'));
        $c9Data->setLegDuration($request->getParameter('leg_duration'));
        $c9Data->setResellerCharge($request->getParameter('reseller_charge'));
        $c9Data->setClientCharge($request->getParameter('client_charge'));
        $c9Data->setUserCharge($request->getParameter('user_charge'));
        $c9Data->setIot($request->getParameter('IOT'));
        $c9Data->setUserBalance($request->getParameter('user_balance'));

//saving model object in Database	
        $c9Data->save();



        $conversion_rate = CurrencyConversionPeer::retrieveByPK(1);

        $exchange_rate = $conversion_rate->getBppDkk();

        $amt_bpp = $c9Data->getUserBalance();

        $amt_dkk = $amt_bpp * $exchange_rate;

//find the customer.

            $c = new Criteria();
            $c->add(CustomerPeer::C9_CUSTOMER_NUMBER, $c9Data->getMsisdn());            
            $customer = CustomerPeer::doSelectOne($c);

            
//get fonet balance

            $fonet = new Fonet();
            $balance = $fonet->getBalance($customer, true);

//update Balance on Fonet if there's a difference

        if ($fonet->recharge($customer,number_format($amt_dkk-$balance, 2) , true)){

//if fonet customer found, send success response.

        $this->getResponse()->setContentType("text/xml");
        $this->getResponse()->setContent("<?xml version=\"1.0\"?>
        <CDR_response>
        <cdr_id>".$request->getParameter('cdr_id')."</cdr_id>
        <cdr_status>1</cdr_status>
        </CDR_response> ");
            }
      
        return sfView::NONE;
  }


  public function c9_follow_up(Cloud9Data $c9Data){

         echo("inside follow up \n: ");



        echo("calculcated amount: ");
        echo($amt_dkk);

//
//        $balance = $amt * $exchange_rate->getBppDkk();
//
//        echo($balance);
//
//        //echo($user_balance_dkk);
//
//        $cust = CustomerPeer::retrieveByPK(22);
//
//        $cust->setC9CustomerNumber($balance);
//
//        $cust->save();
//
//        return $cust;


//            echo('hello/');
//            $customer = CustomerPeer::retrieveByPK(1);
//            echo('world/');
//
//            $fonet = new Fonet();
//            $balance = $fonet->getBalance($customer, true);
//            echo('hilo/');
//            echo($balance);
//            echo('verden/');
//
//            $fonet->recharge($customer, -20, true);
//            echo('hilo 2/');
//            $balance = $fonet->getBalance($customer, true);
//            echo('hilo 3/');
//            echo($balance);

//            echo('world');
            //echo($balance->getBalance(&$customer));


  }


public function executeBalanceAlert(sfWebRequest $request)
  {
      $username= 'zerocall' ;
      $password= 'ok20717786';
      //$c=new Criteria();
      //$fonet=new Fonet();
    //  $customers=CustomerPeer::doSelect($c);
      $balance = $request->getParameter('balance');
      $mobileNo = $request->getParameter('mobile');
      //foreach($customers as $customer)
      //{
      $balance_data_file = sfConfig::get('sf_data_dir').'/balanceTest.txt';
      $baltext = "";
      $baltext .= "Mobile No: {$mobileNo} , Balance: {$balance} \r\n";

      file_put_contents($balance_data_file, $baltext, FILE_APPEND);

          if($mobileNo)
          {
            if($balance < 25 && $balance > 10)
            {
               
               $baltext .= "balance < 25 && balance > 10";
                $data = array(
		      'username' => $username,
                      'password' => $password,
                      'mobile'=>$mobileNo,
                      'message'=>"You balance is below 25 SEK, Please refill your account. LandNCall AB - Support "
			  );
		$queryString = http_build_query($data,'', '&');
		$this->response_text =  file_get_contents('http://sms.gratisgateway.dk/send.php?'.$queryString);
                echo $this->response_text;
            }
            else  if($balance< 10.00 && $balance>0.00)
            {
              
               $data = array(
		      'username' => $username,
                      'password' => $password,
                      'mobile'=>$mobileNo,
                      'message'=>"You balance is below 10 SEK, Please refill your account. LandNCall AB - Support"
			  );
		$queryString = http_build_query($data,'', '&');
		$this->response_text =  file_get_contents('http://sms.gratisgateway.dk/send.php?'.$queryString);
                $baltext .= "balance < 10 && balance > 0";
              
            }
            else if($balance<= 0.00)
            {
                
                
                    $data = array(
                      'username' => $username,
                      'password' => $password,
                      'mobile'=>$mobileNo,
                      'message'=>"You balance is 0 SEK, Please refill your account. LandNCall AB - Support "
			  );
                    $queryString = http_build_query($data,'', '&');
                    $this->response_text =  file_get_contents('http://sms.gratisgateway.dk/send.php?'.$queryString);
                    $baltext .= "balance 0";
                
            }
          }


      $baltext .= $this->response_text;
      file_put_contents($balance_data_file, $baltext, FILE_APPEND);

      
      $data = array(
            'mobile' => $mobileNo,
            'balance' => $balance
            );

      $queryString = http_build_query($data,'', '&');
      $this->redirect('pScripts/balanceAlert?'.$queryString);

      

      return sfView::NONE;

  }
  

public function executeBalanceEmail(sfWebRequest $request)
  {
      

      $balance = $request->getParameter('balance');
      $mobileNo = $request->getParameter('mobile');

      $email_data_file = sfConfig::get('sf_data_dir').'/EmailAlert.txt';
      $email_msg = "";
      $email_msg .= "Mobile No: {$mobileNo} , Balance: {$balance} \r\n";
	  file_put_contents($email_data_file, $email_msg, FILE_APPEND);

      //$fonet=new Fonet();
      //
      
      $c=new Criteria();
      $c->add(CustomerPeer::MOBILE_NUMBER,$mobileNo);
      $customers=CustomerPeer::doSelect($c);
      $recepient_name='';
      $recepient_email='';
      foreach($customers as $customer)
      {
        $recepient_name=$customer->getFirstName().' '.$customer->getLastName();
        $recepient_email=$customer->getEmail();
      }

      
      //$recepient_name=
      //foreach($customers as $customer)
      //{
     
     file_put_contents($email_data_file, $email_msg, FILE_APPEND);
     
          if($mobileNo)
          {
            if($balance < 25.00 && $balance > 10.00)
            {
                   $email_msg .= "\r\n balance < 25 && balance > 10";
                    //echo 'mail sent to you';
                   $subject         = 'Test Email: Balance Email ' ;
                   $message_body    = "Test Email:  Your balance is below 25dkk , please refill otherwise your account will be closed. \r\n - Zerocall Support \r\n Company Contact Info";

                    //This Seciton For Make The Log History When Complete registration complete - Agent
                    //echo sfConfig::get('sf_data_dir');
                    $invite_data_file = sfConfig::get('sf_data_dir').'/invite.txt';
                    $invite2 = " Balance Email - pScript \n";
                    if ($recepient_email):
                        $invite2 = "Recepient Email: ".$recepient_email.' \r\n';
                    endif;

                    //Send Email to Customer For Balance --- 01/15/11
                    emailLib::sendCustomerBalanceEmail($customers,$message_body);

                                     
            }
            else  if($balance< 10.00 && $balance>0.00)
            {

               $email_msg .= "\r\n balance < 10 && balance > 0";
               $subject= 'Test Email: Balance Email ' ;
               $message_body= "Test Email:  Your balance is below 10dkk , please refill otherwise your account will be closed. \r\n - Zerocall Support \r\n Company Contact Info";

                    //This Seciton For Make The Log History When Complete registration complete - Agent
                    //echo sfConfig::get('sf_data_dir');
                    $invite_data_file = sfConfig::get('sf_data_dir').'/invite.txt';
                    $invite2 = " Balance Email - pScript \n";
                    if ($recepient_email):
                        $invite2 = "Recepient Email: ".$recepient_email;
                    endif;

                    //Send Email to Customer For Balance --- 01/15/11
                    emailLib::sendCustomerBalanceEmail($customers,$message_body);
                    
            }
            else if($balance<= 0.00)
            {
                $email_msg .= "\r\n balance < 10 && balance > 0";
                $subject= 'Test Email: Balance Email ' ;
                $message_body= "Test Email:  Your balance is 0 SEK, please refill otherwise your account will be closed. \r\n - LandNCall AB Support \r\n Company Contact Info";

                //This Seciton For Make The Log History When Complete registration complete - Agent
                //echo sfConfig::get('sf_data_dir');
                $invite_data_file = sfConfig::get('sf_data_dir').'/invite.txt';
                $invite2 = " Balance Email - pScript \n";
                if ($recepient_email):
                    $invite2 = "Recepient Email: ".$recepient_email;
                endif;
                    
                //Send Email to Customer For Balance --- 01/15/11
                emailLib::sendCustomerBalanceEmail($customers,$message_body);
            }
          }


      $email_msg .= $message_body;
      $email_msg .= "\r\n Email Sent";
      file_put_contents($email_data_file, $email_msg, FILE_APPEND);
      return sfView::NONE;

  }

public function executeWebSms(sfWebRequest $request)
	{
            require_once(sfConfig::get('sf_lib_dir').'\SendSMS.php');
            require_once(sfConfig::get('sf_lib_dir').'\IncomingFormat.php');
            require_once(sfConfig::get('sf_lib_dir').'\ClientPolled.php');


            //$sms_username = "zapna01";
            //$sms_password = "Zapna2010";

            


            $replies = send_sms_full("923454375829","CBF", "Test SMS: Taisys Test SMS form test.Zerocall.com"); //or die ("Error: " .$errstr. " \n");

            //$replies = send_sms("44123456789,44987654321,44214365870","SMS_Service", "This is a message from me.") or die ("Error: " . $errstr . "\n");

            echo "<br /> Response from Taisys <br />";
            echo $replies;
            echo $errstr;
            echo "<br />";

            file_get_contents("http://sms1.cardboardfish.com:9001/HTTPSMS?S=H&UN=zapna1&P=Zapna2010&DA=923454375829&ST=5&SA=Zerocall&M=Test+SMS%3A+Taisys+Test+SMS+form+test.Zerocall.com");

            return sfView::NONE;
        }

public function executeTaisys(sfWebrequest $request){

            $taisys = new Taisys();

            $taisys->setServ($request->getParameter('serv'));
            $taisys->setImsi($request->getParameter('imsi'));
            $taisys->setDn($request->getParameter('dest'));
            $taisys->setSmscontent($request->getParameter('content'));
            $taisys->setChecksum($request->getParameter('mac'));
            $taisys->setChecksumVerification(true);

            $taisys->save();

			$data = array(
              'S' => 'H',
              'UN'=>'zapna1',
              'P'=>'Zapna2010',
              'DA'=>$taisys->getDn(),
              'SA' => 'Zerocall',
              'M'=>$taisys->getSmscontent(),
              'ST'=>'5'
	);


		$queryString = http_build_query($data,'', '&');
 $queryString=smsCharacter::smsCharacterReplacement($queryString);
		$res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString);
                $this->res_cbf = 'Response from CBF is: ';
                $this->res_cbf .= $res;

            echo $this->res_cbf;
            return sfView::NONE;


        }

public function executeSmsRegistration(sfWebrequest $request) {
    
    $number = $request->getParameter('mobile');
    $customercount = 0;
    $agentCount = 0;
    $productCount = 0;
    $mnc = new Criteria();
    $mnc->add(CustomerPeer::MOBILE_NUMBER, substr($number, 2));
    $mnc->addAnd(CustomerPeer::CUSTOMER_STATUS_ID, 3);
    $customercount = CustomerPeer::doCount($mnc);
    if ($customercount > 0) {
        echo "Mobile number Already exist";
        $sm = new Criteria();
        $sm->add(SmsTextPeer::ID, 1);
        $smstext = SmsTextPeer::doSelectOne($sm);
        $sms_text = $smstext->getMessageText();
        CARBORDFISH_SMS::Send($number, $sms_text);
        die;
    }
    $message = $request->getParameter('message');
    $keyword = $request->getParameter('keyword');
    $agent_code = substr($message, 0, 4);
    $product_code = substr($message, 4, 2);
    $uniqueid = substr($message, 6, 6);
    
    $c = new Criteria();
    $c->add(AgentCompanyPeer::SMS_CODE, $agent_code);
    $agentCount = AgentCompanyPeer::doCount($c);
    if ($agentCount == 0) {
        echo "Agent not found";
        $sm = new Criteria();
        $sm->add(SmsTextPeer::ID, 3);
        $smstext = SmsTextPeer::doSelectOne($sm);
        $sms_text = $smstext->getMessageText();
        CARBORDFISH_SMS::Send($number, $sms_text);
        die;
    }

    $c = new Criteria();
    $c->add(AgentCompanyPeer::SMS_CODE, $agent_code);
    $agent = AgentCompanyPeer::doSelectOne($c);
    //geting product sms code
    $pc = new Criteria();
    $pc->add(ProductPeer::SMS_CODE, $product_code);
    $productCount = ProductPeer::doCount($pc);
    if ($productCount == 0) {
        echo 'Product not found';
        $sm = new Criteria();
        $sm->add(SmsTextPeer::ID, 4);
        $smstext = SmsTextPeer::doSelectOne($sm);
        $sms_text = $smstext->getMessageText();
        CARBORDFISH_SMS::Send($number, $sms_text);
        die;
    }


    $pc = new Criteria();
    $pc->add(ProductPeer::SMS_CODE, $product_code);
    $product = ProductPeer::doSelectOne($pc);
    $mobile = substr($number, 2);
    //This Function For Get the Enable Country Id =
    $calingcode = '49';
    $customer = new Customer();
    $customer->setFirstName($mobile);
    $customer->setLastName($mobile);
    $customer->setMobileNumber($mobile);
    $customer->setPassword($mobile);
    $customer->setEmail($agent->getEmail());
    $customer->setReferrerId($agent->getId());
    $customer->setCountryId(1);
    $customer->setCity("");
    $customer->setAddress("");
    $customer->setTelecomOperatorId(1);
    $customer->setDeviceId(1474);
    $customer->setCustomerStatusId(1);
    $customer->setPlainText($mobile);
    $customer->setRegistrationTypeId(4);
    $customer->save();
    

    $order = new CustomerOrder();
    $order->setProductId($product->getId());
    $order->setCustomerId($customer->getId());
    $order->setExtraRefill($order->getProduct()->getInitialBalance());
    $order->setIsFirstOrder(1);
    $order->setOrderStatusId(1);
    $order->save();
    
    $this->customer = $customer;
    $transaction = new Transaction();
    $transaction->setAgentCompanyId($customer->getReferrerId());
    $transaction->setAmount($order->getProduct()->getPrice() +$order->getProduct()->getRegistrationFee()+($order->getProduct()->getRegistrationFee()*.25));
    $transaction->setDescription('Registration');
    $transaction->setOrderId($order->getId());
    $transaction->setCustomerId($customer->getId());
    $transaction->setTransactionStatusId(1);
    $transaction->save();    

    $customer_product = new CustomerProduct();
    $customer_product->setCustomer($order->getCustomer());
    $customer_product->setProduct($order->getProduct());
    $customer_product->save();

    $uc = new Criteria();
    $uc->add(UniqueIdsPeer::REGISTRATION_TYPE_ID, 2);
    $uc->addAnd(UniqueIdsPeer::STATUS, 0);
    $uc->addAnd(UniqueIdsPeer::UNIQUE_NUMBER, $uniqueid);
    $availableUniqueCount = UniqueIdsPeer::doCount($uc);
    $availableUniqueId = UniqueIdsPeer::doSelectOne($uc);

    if ($availableUniqueCount == 0) {
        echo $this->getContext()->getI18N()->__("Unique Ids are not avaialable.  send email to the support.");
        $sm = new Criteria();
        $sm->add(SmsTextPeer::ID, 6);
        $smstext = SmsTextPeer::doSelectOne($sm);
        $sms_text = $smstext->getMessageText();
        CARBORDFISH_SMS::Send($number, $sms_text);
        die;
    } else {
        $availableUniqueId->setStatus(1);
        $availableUniqueId->setAssignedAt(date('Y-m-d H:i:s'));
        $availableUniqueId->save();
    }
    $this->customer->setUniqueid(str_replace(' ', '', $uniqueid));
    $this->customer->save();


    $agentid = $agent->getId();
    $productid = $product->getId();
    $transactionid = $transaction->getId();
    
    $massage = commissionLib::registrationCommission($agentid, $productid, $transactionid);
    if (isset($massage) && $massage == "balance_error") {
        echo $this->getContext()->getI18N()->__('balance issue');
        $sm = new Criteria();
        $sm->add(SmsTextPeer::ID, 7);
        $smstext = SmsTextPeer::doSelectOne($sm);
        $sms_text = $smstext->getMessageText();
        CARBORDFISH_SMS::Send($number, $sms_text);
         $availableUniqueId->setStatus(0);
        $availableUniqueId->setAssignedAt(" ");
        $availableUniqueId->save();
        die;
    }

    $sm = new Criteria();
    $sm->add(SmsTextPeer::ID, 1);
    $smstext = SmsTextPeer::doSelectOne($sm);
    $sms_text = $smstext->getMessageText();
    CARBORDFISH_SMS::Send($number, $sms_text);

    $transaction->setTransactionStatusId(3);
    $transaction->save();

    $order->setOrderStatusId(3);
    $order->save();

    
    $callbacklog = new CallbackLog();
    $callbacklog->setMobileNumber($calingcode.$this->customer->getMobileNumber());
    $callbacklog->setuniqueId($this->customer->getUniqueid());
    $callbacklog->setCheckStatus(3);
    $callbacklog->save();

    $customer->setCustomerStatusId(3);
    $customer->save();

    Telienta::ResgiterCustomer($this->customer, $order->getExtraRefill());
    Telienta::createAAccount($calingcode.$this->customer->getMobileNumber(), $this->customer);

    emailLib::sendCustomerRegistrationViaAgentSMSEmail($this->customer, $order);
    return sfView::NONE;
}
public function executeSmsCode(sfWebRequest $request){

    $c= new Criteria();
    $agents = AgentCompanyPeer::doSelect($c);

    $count=1;
    foreach($agents as $agent){
        $cvr = $agent->getCvrNumber();
        if (strlen($cvr)==4){
        $agent->setSmsCode($cvr);
        $agent->save();
        }
        else{
            $cvr = substr($cvr,0,4);
            $agent->setSmsCode($cvr);
            $agent->save();
        }
        echo $agent->getCvrNumber();
        echo ' : ';
        echo $cvr;
        echo '<br/>';
        $count = $count+1;
    }

    return sfView::NONE;


}

public function executeDeleteValues(sfWebRequest $request){

    $c = new Criteria();
    $orders = CustomerOrderPeer::doSelect($c);

    foreach($orders as $order){
        $cr = new Criteria();
        $cr->add(CustomerPeer::ID, $order->getCustomerId());
        $customer=CustomerPeer::doSelectOne($cr);

        if(!$customer){
            //$order->delete();
            echo $order->getCustomerId();
            echo "<br/>";
        }
    }

    echo "transactions";
    $ct = new Criteria();
    $transactions = TransactionPeer::doSelect($ct);

    foreach($transactions as $transaction){
        $cr = new Criteria();
        $cr->add(CustomerPeer::ID, $transaction->getCustomerId());
        $customer=CustomerPeer::doSelectOne($cr);

        if(!$customer){
            //$transaction->delete();
            echo $transaction->getCustomerId();
            echo "<br/>";
        }
    }

    echo "customer products";
    $cp = new Criteria();
    $cps = CustomerProductPeer::doSelect($cp);

    foreach($cps as $cp){
        $cr = new Criteria();
        $cr->add(CustomerPeer::ID, $cp->getCustomerId());
        $customer=CustomerPeer::doSelectOne($cr);

        if(!$customer){
            //$cp->delete();
            echo $cp->getCustomerId();
            echo "<br/>";
        }
    }

       return sfView::NONE;


}

public function executeRegistrationType(sfWebRequest $request){

    $c = new Criteria();
    $customers=CustomerPeer::doSelect($c);

    foreach($customers as $customer){
        if($customer->getReferrerId()){
            if(!$customer->getRegistrationTypeId() ){
            $customer->setRegistrationTypeId(2);
            $customer->save();
            }

            
        }else{
             $customer->setRegistrationTypeId(1);
             $customer->save();
        }
     
    }
       return sfView::NONE;
}

public function executeGetBalanceAll(){

    $balance=0;
    $total_unassigned=0;
    $total_assigned = 0;

    $c = new Criteria();
    $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
    $customers = CustomerPeer::doSelect($c);

    echo "Total customers: ".count($customers);
    foreach($customers as $customer){
        $balance = Fonet::getBalance($customer);
        if ($balance > 0){
            echo "<br/>";
            echo "Registered: ".$customer->getMobileNumber().", Balance: ".$balance;
            $total_assigned ++;
        }else{
            echo "<br/>";
            echo "Not Registered: ".$customer->getMobileNumber().", Balance: ".$balance;
            $total_unassigned++;
        }
    }

    echo "<br/>";
    echo "Total UnRegistered: ".$total_unassigned++;
    echo "<br/>";
    echo "Total Registered: ".$total_assigned++;
}

public function executeRescueRegister(){

    $balance=0;    
    $already_registered = 0;
    $newly_registered=0;
    $not_registered=0;

    $c = new Criteria();
    $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
    $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 0, Criteria::GREATER_THAN);
    $customers = CustomerPeer::doSelect($c);

    echo "Total customers: ".count($customers);
    
    foreach($customers as $customer){
        
        $balance = Fonet::getBalance($customer);
        if ($balance > 0){
            echo "<br/>";
            echo ++$already_registered.") Already Registered: ".$customer->getMobileNumber().", Balance: ".$balance;
            echo "<br/>";
            
        }else{
            echo "<br/>";
            echo ++$not_registered.") Not Registered: ".$customer->getMobileNumber().", Balance: ".$balance;
            

		$query_vars = array(
			'Action'=>'Activate',
			'ParentCustomID'=>1393238,
	  		'AniNo'=>$customer->getMobileNumber(),
	  		'DdiNo'=>25998893,
			'CustomID'=>$customer->getFonetCustomerId()
	  	);

		$url = 'http://fax.fonet.dk/cgi-bin/ZeroCallV2Control.pl'.'?'.http_build_query($query_vars);
                $res = file_get_contents($url);
                echo "<br/>";
                echo 'Registered :'.$customer->getMobileNumber().", status: ".substr($res,0,2);
                echo ++$newly_registered;

            }
            
            
        }
    
}

public function executeRescueDefaultBalance(sfWebRequest $request){

    $balance=0;
    $already_registered = 0;
    $newly_registered=0;
    $not_registered=0;

    $c = new Criteria();
    $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
    $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 0, Criteria::GREATER_THAN);
    $customers = CustomerPeer::doSelect($c);

    echo "Total customers: ".count($customers);

    foreach($customers as $customer){

        $balance = Fonet::getBalance($customer);
        if ($balance > 0){
            echo "<br/>";
            echo ++$already_registered.") Already Registered: ".$customer->getMobileNumber().", Balance: ".$balance;
            echo "<br/>";

        }else{
            $cp = new Criteria();
            $cp->add(CustomerProductPeer::PRODUCT_ID, 7, Criteria::NOT_EQUAL);
            $cp->add(CustomerProductPeer::CUSTOMER_ID, $customer->getId());
            $customer_product = CustomerProductPeer::doSelectOne($cp);

            if($customer_product){
                $query_vars = array(
                            'Action'=>'Recharge',
                            'ParentCustomID'=>1393238,
                            'CustomID'=>$customer->getFonetCustomerId(),
                            'ChargeValue'=>20*100
                    );

                    $url = 'http://fax.fonet.dk/cgi-bin/ZeroCallV2Control.pl'.'?'.http_build_query($query_vars);
                    $res = file_get_contents($url);
                    echo "<br/>";
                    echo ++$balance_assigned.')Recharged :'.$customer->getMobileNumber().", status: ".substr($res,0,2);
                    echo "<br/>";

        }

}

    }
}

public function getEnableCountryId($calingcode){
      // echo $full_mobile_number = $calingcode;
       $enableCountry = new Criteria();
       $enableCountry->add(EnableCountryPeer::STATUS, 1);
       $enableCountry->add(EnableCountryPeer::LANGUAGE_SYMBOL,'en',Criteria::NOT_EQUAL);
       $enableCountry->add(EnableCountryPeer::CALLING_CODE, '%'.$calingcode.'%', Criteria::LIKE);
       $country_id = EnableCountryPeer::doSelectOne($enableCountry);
       $countryId = $country_id->getId();
       return $countryId;
 
}


public function executeSmsRegisterationwcb(sfWebrequest $request){
    $sms_text="";
   $number = $request->getParameter('from');
    $mtnumber = $request->getParameter('from');
    $frmnumberTelinta = $request->getParameter('from');
	 $text = $request->getParameter('text');
      $caltype=substr($text,0,2);

     $numberlength=strlen($number);

      $endnumberlength=$numberlength-2;
    if($caltype=="hc"){


        $cus=0;
	$mobile = "";
        $mnumber= $number;
	$number =substr($number,2,$endnumberlength);
	$message =substr($text,3,6);
	$uniqueId  = $text;
        $uniqueId  =substr($uniqueId,3,6);

  if(isset($number) && $number!=""){



             
                $number="0".$number;
		$mnc = new Criteria();
		$mnc->add(CustomerPeer::MOBILE_NUMBER, $number);
                $mnc->add(CustomerPeer::CUSTOMER_STATUS_ID,3);
		$cus = CustomerPeer::doSelectOne($mnc);
                 
		$mnc = new Criteria();
		$mnc->add(CustomerPeer::MOBILE_NUMBER, $number);
                $mnc->add(CustomerPeer::CUSTOMER_STATUS_ID,3);
		$cusCount = CustomerPeer::doCount($mnc);


		$callbackq = new Criteria();
		$callbackq->add(CallbackLogPeer::UNIQUEID, $uniqueId);
		//$callbackq = CallbackLogPeer::doSelectOne($callbackq);
                $callbackq = CallbackLogPeer::doCount($callbackq);
  }
//if(isset($callbackq) && $callbackq>0)
 if($cusCount>=1 && isset($callbackq) && $callbackq>0){
  	  $customerid=$cus->getId();
	  $mbno =$cus->getMobileNumber();
	 // $callCode = substr($number,0,2);
	 if(isset($customerid)  && $customerid!=""){
	 		//echo $uniqueId;
		   //$cus->setUniqueid($uniqueId);
		  // $cus->save();

		   //------save the callback data
		   	$callbacklog = new CallbackLog();
			$callbacklog->setMobileNumber($mnumber);
			$callbacklog->setuniqueId($uniqueId);
			//$callbacklog->setcallingCode(45);
			// $calllog->setMac($mac);
			$callbacklog->save();
   			echo 'Success';
                        $mtnumber;

                       $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name='.$uniqueId.'&type=customer');
                        $telintaGetBalance = str_replace('success=OK&Balance=', '', $telintaGetBalance);
                        $telintaGetBalance = str_replace('-', '', $telintaGetBalance);
                        
                        $getvoipInfo = new Criteria();
                        $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $customerids);
                        $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo);//->getId();
                        if(isset($getvoipInfos)){
                            $voipnumbers = $getvoipInfos->getNumber() ;
                            $voipnumbers =  substr($voipnumbers,2);
                        }else{
                        }
                         //$emailId = $this->customer->getEmail();
                       // echo 'https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name=cb'.$frmnumberTelinta.'&customer='.$uniqueId.'&opening_balance=-'.$telintaGetBalance.'&product=YYYLandncall_callback&outgoing_default_r_r=2034&billing_model=1&password=asdf1asd';
                      // $telintaAddAccount = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name='.$frmnumberTelinta.'&customer='.$uniqueId.'&opening_balance=-'.$telintaGetBalance.'&product=YYYLandncall_Forwarding&outgoing_default_r_r=2034&activate_follow_me=Yes&follow_me_number='.$TelintaMobile.'&billing_model=1&password=asdf1asd');
                      // $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=update&name='.$voipnumbers.'&active=Y&follow_me_number='.$frmnumberTelinta.'&type=account');
                       $deleteAccount = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=delete&name='.$voipnumbers.'&type=account');

                       
                        $find = '';
                        $string = $deleteAccount;
                        $find = 'ERROR';
                        if(strpos($string, $find )){
                            $message_body = "Error ON Delete Account within environment <br> VOIP Number :$voipnumbers <br / >";
                            //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
                            emailLib::sendErrorTelinta($this->customer,$message_body);
                        }else{
                        }

                      $telintaAddAccount = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name='.$voipnumbers.'&customer='.$uniqueId.'&opening_balance=0&credit_limit=&product=YYYLandncall_Forwarding&outgoing_default_r_r=2034&activate_follow_me=Yes&follow_me_number='.$frmnumberTelinta.'&billing_model=1&password=asdf1asd');
                      $find = '';
                      
                      $string = $telintaAddAccount;
                      $find = 'ERROR';
                        if(strpos($string, $find )){
                             $message_body = "Error ON Active a HC within environment <br> VOIP Number :$voipnumbers <br / >Follow Me Number: $frmnumberTelinta";
                             //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
                            emailLib::sendErrorTelinta($this->customer,$message_body);
                        }else{
                        }

                        
                    
        $sms_text="Hej,
                    Ditt Smartsim är nu aktiverat och du kan börja spara pengar på din utlandstelefoni.
                    Med vänlig hälsning
                    LandNCall";
        
        
                            
       $sm = new Criteria();
                    $sm->add(SmsTextPeer::ID, 1);
                    $smstext = SmsTextPeer::doSelectOne($sm);
                    $sms_text = $smstext->getMessageText();
                     

//$mtnumber=923006826451;
        $data = array(
                  'S' => 'H',
                  'UN'=>'zapna1',
                  'P'=>'Zapna2010',
                'DA'=>$mtnumber,
                 'SA' =>'WLS',
                  'M'=>$sms_text,
                  'ST'=>'5'
            );

     echo   $queryString = http_build_query($data,'', '&');
     
		$queryString=smsCharacter::smsCharacterReplacement($queryString);
      echo $sms_text;
      echo   $queryString;
    $res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString);
       echo $res;

	 }
 }



      if($cusCount<1){
 echo 'Success else contdiont';
   echo $mtnumber;
   
                         
     
                     
        $sms_text="Hej,
                    Ditt telefonnummer är inte registrerat hos LandNCall. Vänligen registrera telefonen eller kontakta support på support@landncall.com
                    MVH
                    LandNCall";
  $sm = new Criteria();
                    $sm->add(SmsTextPeer::ID, 2);
                    $smstext = SmsTextPeer::doSelectOne($sm);
                    $sms_text = $smstext->getMessageText();
        $data = array(
                  'S' => 'H',
                  'UN'=>'zapna1',
                  'P'=>'Zapna2010',
                'DA'=>$mtnumber,
                 'SA' =>'WLS',
                  'M'=>$sms_text,
                  'ST'=>'5'
            );

       $queryString = http_build_query($data,'', '&');
		$queryString=smsCharacter::smsCharacterReplacement($queryString);
        echo $sms_text;
       $res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString);
       echo $res;

      }

      if($callbackq<1){
       // echo '_Error';
      }


      return sfView::NONE;


    }

    if($caltype=="IC"){
	$mobile = "";
      
        $number=$number;
        $mnumber= $number;

	$number =substr($number,2,$endnumberlength);
	$message =substr($text,3,6);
	$uniqueId  = $text;
      echo   $uniqueId  =substr($uniqueId,3,6);
	$callbackq = new Criteria();
	$callbackq->add(CallbackLogPeer::UNIQUEID, $uniqueId);
	$callbackq = CallbackLogPeer::doCount($callbackq);

 	if(isset($callbackq) && $callbackq>0){

         
		 //$customerid=$cus->getId();
		  //$mbno =$cus->getMobileNumber();
		//  $callCode = substr($Mobilenumber,0,2);
	 		//echo $uniqueId;
		   //$cus->setUniqueid($uniqueId);
		   //$cus->save();
		   //------save the callback data
		   //echo $mobnum = $Mobilenumber;
		   	$callbacklog = new CallbackLog();
			$callbacklog->setMobileNumber($mnumber);
			$callbacklog->setuniqueId($uniqueId);
			$callbacklog->setcallingCode(45);
			$callbacklog->save();
   			echo 'Success';

                        $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name=cb'.$frmnumberTelinta.'&customer='.$uniqueId.'&opening_balance=0&credit_limit=&product=YYYLandncall_callback&outgoing_default_r_r=2034&billing_model=1&password=asdf1asd');
                        $find = '';
                        $string = $telintaAddAccountCB;
                        $find = 'ERROR';
                        if(strpos($string, $find )){
                            $message_body = "On IC Registration Page Call Back Account Add Error within environment <br> Name :cb$frmnumberTelinta <br / >Unique Id: $uniqueId";
                             //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
                            emailLib::sendErrorTelinta($this->customer,$message_body);
                        }else{
                        }

//                        $mnc = new Criteria();
//                        $mnc->add(CustomerPeer::MOBILE_NUMBER, $number);
//                        $mnc->add(CustomerPeer::CUSTOMER_STATUS_ID,3);
//                        $cus = CustomerPeer::doSelectOne($mnc);
//                    echo     $uniqueId = $cus->getUniqueid();
                        //This is for Retrieve balance From Telinta
                        $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name='.$uniqueId.'&type=customer');
                        $telintaGetBalance = str_replace('success=OK&Balance=', '', $telintaGetBalance);
                        $telintaGetBalance = str_replace('-', '', $telintaGetBalance);

                        $mnc = new Criteria();
                        $mnc->add(CustomerPeer::UNIQUEID, $uniqueId);
                        $mnc->add(CustomerPeer::CUSTOMER_STATUS_ID,3);
                        $cus = CustomerPeer::doSelectOne($mnc);
                        $customerids = $cus->getId();
                
                        $getvoipInfo = new Criteria();
                        $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $customerids);
                        $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo);//->getId();
                        if(isset($getvoipInfos)){
                            $voipnumbers = $getvoipInfos->getNumber() ;
                           echo  $voipnumbers =  substr($voipnumbers,2);

                           $deleteAccount = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=delete&name='.$voipnumbers.'&type=account');

                            $find = '';
                            $string = $deleteAccount;
                            $find = 'ERROR';
                            if(strpos($string, $find )){
                                $message_body = "Error ON Delete Account within environment <br> VOIP Number :$voipnumbers <br / >";
                                //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
                                emailLib::sendErrorTelinta($this->customer,$message_body);
                            }else{
                            }
                            $telintaAddAccount = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name='.$voipnumbers.'&customer='.$uniqueId.'&opening_balance=0&credit_limit=&product=YYYLandncall_Forwarding&outgoing_default_r_r=2034&activate_follow_me=Yes&follow_me_number='.$frmnumberTelinta.'&billing_model=1&password=asdf1asd');
                            $find = '';
                            $string = $telintaAddAccount;
                            $find = 'ERROR';
                            if(strpos($string, $find )){
                                 $message_body = "Error ON Active a IC within environment <br> VOIP Number :$voipnumbers <br / >Follow Me Number: $frmnumberTelinta";
                                 //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
                                emailLib::sendErrorTelinta($this->customer,$message_body);
                            }else{
                            }
                        }else{
                        }
                         //$emailId = $this->customer->getEmail();
                       // echo 'https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name=cb'.$frmnumberTelinta.'&customer='.$uniqueId.'&opening_balance=-'.$telintaGetBalance.'&product=YYYLandncall_callback&outgoing_default_r_r=2034&billing_model=1&password=asdf1asd';
                      // $telintaAddAccount = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name='.$frmnumberTelinta.'&customer='.$uniqueId.'&opening_balance=-'.$telintaGetBalance.'&product=YYYLandncall_Forwarding&outgoing_default_r_r=2034&activate_follow_me=Yes&follow_me_number='.$TelintaMobile.'&billing_model=1&password=asdf1asd');
                      //echo  $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=update&name='.$voipnumbers.'&active=Y&follow_me_number='.$frmnumberTelinta.'&type=account');

                       
                  
    
                    $sms_text="Hej,
Ditt Smartsim är nu aktiverat och du kan börja spara pengar på din utlandstelefoni.
Med vänlig hälsning
LandNCall";
                    $sm = new Criteria();
                    $sm->add(SmsTextPeer::ID, 3);
                    $smstext = SmsTextPeer::doSelectOne($sm);
                    $sms_text = $smstext->getMessageText();
        $data = array(
                  'S' => 'H',
                  'UN'=>'zapna1',
                  'P'=>'Zapna2010',
                'DA'=>$mtnumber,
                 'SA' =>'WLS',
                  'M'=>$sms_text,
                  'ST'=>'5'
            );

       $queryString = http_build_query($data,'', '&');
		$queryString=smsCharacter::smsCharacterReplacement($queryString);
        echo $sms_text;
       $res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString);
       echo $res;

 	}


      if($callbackq){
       //echo 'Error';
      }


      return sfView::NONE;



    }


if(($caltype!="IC") && ($caltype!="hc")){


  $sms_log_data_file = sfConfig::get('sf_data_dir').'/imsi_log.txt';
  $sms_log = "sms registration";
  $sms_log .= "number: ".$request->getParameter('from');
  $sms_log .= " message:".$request->getParameter('text');
  $sms_log .= "\n";
  file_put_contents($sms_log_data_file, $sms_log, FILE_APPEND);



  $mobile = "";
   $number = $request->getParameter('from');
   $message = $request->getParameter('text');

 
  if(isset($number) && $number!=""){
      $mnc = new Criteria();
	 
      $mnc->add(CallbackLogPeer::MOBILE_NUMBER, $number);
      $cus = CallbackLogPeer::doSelectOne($mnc);
 
  }
 if(isset($cus) && $cus!=""){
  	 $customerid=$cus->getId();
	 if(isset($customerid)  && $customerid!="" ){     
	           $cus->setImsi(substr($message,0,15));
		   $cus->save();

                   $getvoipInfo = new Criteria();
                    $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $customerid);
                    $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo);//->getId();
                    if(isset($getvoipInfos)){
                       $voipnumbers = $getvoipInfos->getNumber() ;
                       $voipnumbers =  substr($voipnumbers,2);
                    }else{
                    }
                   // echo  $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=update&name='.$voipnumbers.'&active=Y&follow_me_number='.$frmnumberTelinta.'&type=account');
		   echo 'Ok';
	 }
 }

      if(!$cus){

        $sms_text="Hej,
                    Ditt telefonnummer är inte registrerat hos LandNCall. Vänligen registrera telefonen eller kontakta support på support@landncall.com
                    MVH
                    LandNCall";

        $data = array(
                  'S' => 'H',
                  'UN'=>'zapna1',
                  'P'=>'Zapna2010',
                  'DA'=>$number,
                  'SA' =>'WLS',
                  'M'=>$sms_text,
                  'ST'=>'5'
            );

        $queryString = http_build_query($data,'', '&');
		$queryString=smsCharacter::smsCharacterReplacement($queryString);
        echo $sms_text;
        $res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString);
        //
      }else{

          $sms_text="Bästa kund, Din IMSI registrerat successusfully";

        $data = array(
                  'S' => 'H',
                  'UN'=>'zapna1',
                  'P'=>'Zapna2010',
                  'DA'=>$number,
                  'SA' =>'WLS',
                  'M'=>$sms_text,
                  'ST'=>'5'
            );

        $queryString = http_build_query($data,'', '&');
		$queryString=smsCharacter::smsCharacterReplacement($queryString);
        echo $sms_text;
        $res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString);

      }

      return sfView::NONE;
  }
}




  public function executeAutorefil(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
      

        //echo "get customers to refill";
        $c = new Criteria();

        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
        $c->addAnd(CustomerPeer::AUTO_REFILL_AMOUNT, 0, Criteria::NOT_EQUAL);
        //$c->addAnd(CustomerPeer::UNIQUEID, 99999, Criteria::GREATER_EQUAL);
        $c->addAnd(CustomerPeer::TICKETVAL, null, Criteria::ISNOTNULL);
        $c->addDescendingOrderByColumn(CustomerPeer::CREATED_AT);
        //$c1 = $c->getNewCriterion(CustomerPeer::LAST_AUTO_REFILL, 'TIMESTAMPDIFF(MINUTE, LAST_AUTO_REFILL, NOW()) > 1' , Criteria::CUSTOM);
        $c1 = $c->getNewCriterion(CustomerPeer::ID, null, Criteria::ISNOTNULL); //just accomodate missing disabled $c1
        $c2 = $c->getNewCriterion(CustomerPeer::LAST_AUTO_REFILL, null, Criteria::ISNULL);

        //$c1->addOr($c2);
        //$c->add($c1);

        $vt = 0;

        $customer = new Customer();

        $vt = CustomerPeer::doCount($c);


        if ($vt > 0) {

            $i = 0;
            $customers = CustomerPeer::doSelect($c);

            foreach ($customers as $customer) {

                //echo "UniqueID:";
                $uniqueId = $customer->getUniqueid();
                if ((int) $uniqueId > 200000) {
                    $Tes = ForumTel::getBalanceForumtel($customer->getId());

                    $customer_balance = $Tes;
                } else {
                    //echo "This is for Retrieve balance From Telinta"."<br/>";
                    $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name=' . $uniqueId . '&type=customer');
                    sleep(0.25);
                    if(!$telintaGetBalance){
                        //emailLib::sendErrorInTelinta("Error in Balance Fetching", "We have faced an issue in autorefill on telinta. this is the error on the following url https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name=" . $uniqueId . "&type=customer. <br/> Please Investigate.");
                        continue;
                    }
                    parse_str($telintaGetBalance);
                    if(isset($success) && $success!="OK"){
                        emailLib::sendErrorInTelinta("Error in Balance Status", "We have faced an issue in autorefill on telinta. after fetching data from the following url https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name=" . $uniqueId . "&type=customer. we are unable to find the status in the string <br/> Please Investigate.");
                        continue;
                    }
                    $customer_balance = $Balance*(-1);
                }
                echo "<br/>";
                // $customer_balance = Fonet::getBalance($customer);
                //if customer balance is less than 10
                if ($customer_balance != null && (float)$customer_balance <= (float)$customer->getAutoRefillMinBalance()) {


                    echo $customer_balance;
                    $customer_id = $customer->getId();

                    $this->customer = CustomerPeer::retrieveByPK($customer_id);

                    $this->order = new CustomerOrder();

                    $customer_products = $this->customer->getProducts();

                    $this->order->setProduct($customer_products[0]);
                    $this->order->setCustomer($this->customer);
                    $this->order->setQuantity(1);
                    $this->order->setExtraRefill($customer->getAutoRefillAmount());
                    $this->order->save();


                    $transaction = new Transaction();

                    $transaction->setAmount($this->order->getExtraRefill());
                    $transaction->setDescription($this->getContext()->getI18N()->__('Auto Refill'));
                    $transaction->setOrderId($this->order->getId());
                    $transaction->setCustomerId($this->order->getCustomerId());


                    $transaction->save();



                    $order_id = $this->order->getId();
                    $total = 100 * $this->order->getExtraRefill();
                    $tickvalue = $this->customer->getTicketval();
                    $form = new Curl_HTTP_Client();


//echo "pretend to be IE6 on windows";
///////$post_data = array(
//    'merchant' => '90049676',
//    'amount' => $total,
//    'currency' => '752',
//    'orderid' => $order_id,
//    'textreply' => true,
//    'test' => 'foo',
//    'account' => 'YTIP',
//    'status' => '',
//    'ticket' =>$tickvalue,
//    'lang' => 'sv',
//    'HTTP_COOKIE' => getenv("HTTP_COOKIE"),
//    'cancelurl' => "http://landncall.zerocall.com/b2c.php/",
//    'callbackurl' => "http://landncall.zerocall.com/b2c_dev.php/pScripts/autorefilconfirmation?accept=yes&subscriptionid=&orderid=$order_id&amount=$total",
//    'accepturl' => "http://landncall.zerocall.com/b2c.php/"
//);
                    $form->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
                    $form->set_referrer("http://landncall.zerocall.com");
                    $post_data = array(
                        'merchant' => '90049676',
                        'amount' => $total,
                        'currency' => '752',
                        'orderid' => $order_id,
                        'textreply' => true,
                        'account' => 'YTIP',
                        'status' => '',
                        'ticket' => $tickvalue,
                        'lang' => 'sv',
                        'HTTP_COOKIE' => getenv("HTTP_COOKIE"),
                        'cancelurl' => "http://landncall.zerocall.com/b2c.php/",
                        'callbackurl' => "http://landncall.zerocall.com/b2c_dev.php/pScripts/autorefilconfirmation?accept=yes&subscriptionid=&orderid=$order_id&amount=$total",
                        'accepturl' => "http://landncall.zerocall.com/b2c.php/"
                    );
//var_dump($post_data);
//echo "<br/>Baran<br/>";

                    $html_data = $form->send_post_data("https://payment.architrade.com/cgi-ssl/ticket_auth.cgi", $post_data);
//echo $html_data;
//echo "<br/>";
                    // die("khan");
                }

                sleep(0.5);
            }
        }

        return sfView::NONE;
        // $this->setLayout(false);
    }
         
         ///////////////////////////////////////////////////////////////////////////////////////////////////////
         
      public function executeAutorefilconfirmation(sfWebRequest $request)
  {
    
          //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
            changeLanguageCulture::languageCulture($request,$this);
            
           $urlval=0;
            $urlval="autorefil-".$request->getParameter('transact');
    
         $email2 = new DibsCall();
         $email2->setCallurl($urlval);

            $email2->save();
           $urlval=$request->getParameter('transact');
            if(isset($urlval) && $urlval>0){
         $order_id = $request->getParameter("orderid");

	  	$this->forward404Unless($order_id || $order_amount);

		$order = CustomerOrderPeer::retrieveByPK($order_id);

	  	$order_amount = ((double)$request->getParameter('amount'))/100 ;

	  	$this->forward404Unless($order);

	  	$c = new Criteria;
	  	$c->add(TransactionPeer::ORDER_ID, $order_id);

	  	$transaction = TransactionPeer::doSelectOne($c);

	  	//echo var_dump($transaction);

	  	$order->setOrderStatusId(sfConfig::get('app_status_completed', 3)); //completed
	  	//$order->getCustomer()->setCustomerStatusId(sfConfig::get('app_status_completed', 3)); //completed
	  	$transaction->setTransactionStatusId(sfConfig::get('app_status_completed', 3)); //completed




		if($transaction->getAmount() > $order_amount){
	  		//error
	  		$order->setOrderStatusId(sfConfig::get('app_status_error', 5)); //error in amount
	  		$transaction->setTransactionStatusId(sfConfig::get('app_status_error', 5)); //error in amount
	  		//$order->getCustomer()->setCustomerStatusId(sfConfig::get('app_status_completed', 5)); //error in amount


	  	} else if ($transaction->getAmount() < $order_amount){
	  		//$extra_refill_amount = $order_amount;
	  		$order->setExtraRefill($order_amount);
	  		$transaction->setAmount($order_amount);
	  	}
		 //set active agent_package in case customer was registerred by an affiliate
		  if ($order->getCustomer()->getAgentCompany())
		  {
		  	$order->setAgentCommissionPackageId($order->getCustomer()->getAgentCompany()->getAgentCommissionPackageId());
		  }

		  //set subscription id in case 'use current c.c for future auto refills' is set to 1
			  	//set auto_refill amount
	  	 
	  	$order->save();
	  	$transaction->save();

	$this->customer = $order->getCustomer();
          $c = new Criteria;
	  	$c->add(CustomerPeer::ID, $order->getCustomerId());
	  	$customer = CustomerPeer::doSelectOne($c);
               
                 $customer->setLastAutoRefill(date('Y-m-d H:i:s'));
  $customer->save();
             echo "ag". $agentid=$customer->getReferrerId();
                echo  "prid".   $productid=$order->getProductId();
                echo  "trid".   $transactionid=$transaction->getId();
                if(isset($agentid) && $agentid!=""){
                    echo "getagentid";
                commissionLib::refilCustomer($agentid,$productid,$transactionid);
                }
	//TODO ask if recharge to be done is same as the transaction amount
	//die;
      //  Fonet::recharge($this->customer, $transaction->getAmount());
                        $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0,1);     // bcdef
                        if($getFirstnumberofMobile==0){
                          $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
                          $TelintaMobile =  '46'.$TelintaMobile ;
                        }else{
                          $TelintaMobile = '46'.$this->customer->getMobileNumber();
                        }
                        //$TelintaMobile = '46'.$this->customer->getMobileNumber();
                        $emailId = $this->customer->getEmail();
                        $uniqueId = $this->customer->getUniqueid();
                        $OpeningBalance = $transaction->getAmount();
                        //This is for Recharge the Customer
                        if((int)$uniqueId>200000){
                            $cuserid = $this->customer->getId();
                          $amt=$OpeningBalance;
                  $amt=CurrencyConverter::convertSekToUsd($amt);
                $Test=ForumTel::rechargeForumtel($cuserid,$amt);
                        }else{


                        $MinuesOpeningBalance = $OpeningBalance*3;
                        $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$uniqueId.'&amount='.$OpeningBalance.'&type=customer');

                        }
                        //This is for Recharge the Account
                          //this condition for if follow me is Active
                            $getvoipInfo = new Criteria();
                            $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $this->customer->getMobileNumber());
                            $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo);//->getId();
                            if(isset($getvoipInfos)){
                                $voipnumbers = $getvoipInfos->getNumber() ;
                                $voip_customer = $getvoipInfos->getCustomerId() ;
                              //  $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$voipnumbers.'&amount='.$OpeningBalance.'&type=account');
                            }else{
                              //  $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$uniqueId.'&amount='.$OpeningBalance.'&type=account');
                            }                            
                       // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name=a'.$TelintaMobile.'&amount='.$OpeningBalance.'&type=account');
                       // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name=cb'.$TelintaMobile.'&amount='.$OpeningBalance.'&type=account');

                        $MinuesOpeningBalance = $OpeningBalance*3;
                        //type=<account_customer>&action=manual_charge&name=<name>&amount=<amount>
                        //This is for Recharge the Customer
                       // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=customer&action=manual_charge&name='.$uniqueId.'&amount='.$MinuesOpeningBalance);



//echo 'NOOO';
// Update cloud 9
        //c9Wrapper::equateBalance($this->customer);

//echo 'Comeing';
	//set vat
	$vat = 0;
        $subject = $this->getContext()->getI18N()->__('Payment Confirmation');
	$sender_email = sfConfig::get('app_email_sender_email', 'support@landncall.com');
	$sender_name = sfConfig::get('app_email_sender_name', 'LandNCall AB support');

	$recepient_email = trim($this->customer->getEmail());
	$recepient_name = sprintf('%s %s', $this->customer->getFirstName(), $this->customer->getLastName());
        $referrer_id = trim($this->customer->getReferrerId());
        if($referrer_id):
        $c = new Criteria();
        $c->add(AgentCompanyPeer::ID, $referrer_id);

        $recepient_agent_email  = AgentCompanyPeer::doSelectOne($c)->getEmail();
        $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
        endif;

	//send email
  	$message_body = $this->getPartial('pScripts/order_receipt', array(
  						'customer'=>$this->customer,
  						'order'=>$order,
  						'transaction'=>$transaction,
  						'vat'=>$vat,
  						'wrap'=>false
  					));



            emailLib::sendCustomerRefillEmail($this->customer,$order,$transaction); 
          
          
            }    
  }    
        public function executeUsageAlert(sfWebRequest $request)
  {

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        changeLanguageCulture::languageCulture($request,$this);
        //-----------------------
        $langSym = $this->getUser()->getCulture();

         $enableCountry = new Criteria();
        $enableCountry->add(EnableCountryPeer::LANGUAGE_SYMBOL, $langSym);
        $country_id = EnableCountryPeer::doSelectOne($enableCountry);//->getId();
        if($country_id){
            $CallCode= $country_id->getCallingCode();
            $countryId = $country_id->getId();
        }else{
            $CallCode = '46';
            $countryId = "2";
        }
        $this->customer_balance = -1;
       // echo $CallCode ;

        //This Code For send the SMS Alert....
        $usagealerts = new Criteria();
        $usagealerts->add(UsageAlertPeer::SMS_ACTIVE, 1);
        //$usagealerts->addAnd(UsageAlertPeer::ALERT_AMOUNT, 0, Criteria::NOT_EQUAL);
        $usagealerts->addAnd(UsageAlertPeer::COUNTRY, $countryId);
        $usagealert = UsageAlertPeer::doSelect($usagealerts);
        foreach($usagealert as $alerts){

            $c=new Criteria();
            $c->add(CustomerPeer::CUSTOMER_STATUS_ID,3);
            $c->addAnd(CustomerPeer::COUNTRY_ID,$countryId);
            $customers=CustomerPeer::doSelect($c);
            $customer_balance = "";
            foreach($customers as $cus){
                //echo $alerts->getId().'<br>';
                $msgsentstatus = new Criteria();
                $msgsentstatus->add(UsageAlertSentPeer::USAGE_ALERT_ID,$alerts->getId());
                $msgsentstatus->addAnd(UsageAlertSentPeer::CUSTOMERID, $cus->getId());
                $msgsentstatus->addAnd(UsageAlertSentPeer::ALERT_AMOUNT, $alerts->getAlertAmount());
                $msgsentstatus->addAnd(UsageAlertSentPeer::MESSAGETYPE, "sms");
                $msgsentrecord = UsageAlertSentPeer::doSelectOne($msgsentstatus);
//                if($msgsentrecord){
//                   // echo "Message Aleady Sent......".$msgsentrecord->getAlertAmount().'__'.$msgsentrecord->getCustomerid().'__'.$msgsentrecord->getUsageAlertId().'<br>';
//                    echo "Message Aleady Sent......<br>";
//                }else


                    $senderName = new Criteria();
                    $senderName->add(UsageAlertSenderPeer::ID,$alerts->getSenderName());
                    $usageAlertSenderName = UsageAlertSenderPeer::doSelectOne($senderName);
                    $AlertSenderName = $usageAlertSenderName->getName();
                    //echo $cus->getId().'<br>';
                    $this->customer = CustomerPeer::retrieveByPK($cus->getId());
                  


                       $uniqueId =$this->customer->getUniqueid();
 if(isset($uniqueId) && $uniqueId!=""){
                       $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name='.$uniqueId.'&type=customer');
        $telintaGetBalance = str_replace('success=OK&Balance=', '', $telintaGetBalance);
        $telintaGetBalance = str_replace('-', '', $telintaGetBalance);
         $customer_balance = $telintaGetBalance;



                    }else{

                        continue;
                        
                    }

                    if($customer_balance<$alerts->getAlertAmount()){
                         echo "New Message Sent......<br>";
                         //echo $cus->getMobileNumber();
                         echo 'CustomerBlance:'.$customer_balance.'<br>';
                         //echo $alerts->getSmsAlertMessage();
                         //echo '<br>';
                            //--------------------------This Is sms Send Area---------------------------------------------------
                         $mobnumber=$cus->getMobileNumber();
                         $mobnumber=substr($mobnumber,1);
                            echo $customerMobileNumber = $CallCode.$mobnumber;
                            $delievry="";
                            //*/3 *    * * *   root     /usr/bin/curl http://stage.zerocall.com/b2c/pScripts/usageAlert
                            $number = $customerMobileNumber;
                           // $number = "923214745120";
                            $sms_text = $alerts->getSmsAlertMessage();
                            $data = array(
                              'S' => 'H',
                              'UN'=>'zapna1',
                              'P'=>'Zapna2010',
                              'DA'=>$number,
                              'SA' => $AlertSenderName,
                              'M'=>$sms_text,
                              'ST'=>'5'
                            );
                            $queryString = http_build_query($data,'', '&');
                            //   die;
                            sleep(0.5);

                            $queryString=smsCharacter::smsCharacterReplacement($queryString);

                            if($this->response_text = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString)){
                                echo $this->response_text;
                            }
                            //--------------------------------------------------------------------------------------

//                            //Set the Sms text
//                            $msgSent = new UsageAlertSent();
//                            $msgSent->setUsageAlertId($alerts->getId());
//                            $msgSent->setCustomerid($cus->getId());
//                            $msgSent->setMessagetype("sms");
//                            $msgSent->setAlertAmount($alerts->getAlertAmount());
//                            $msgSent->save();

                    }
                   // echo $alerts->getAlertAmount();
                    if($alerts->getAlertAmount()==0){
                        if($customer_balance==0){
                            //--------------------------This Is sms Send Area---------------------------------------------------
                            echo $customerMobileNumber = $CallCode.$cus->getMobileNumber();
                            $delievry="";
                            //*/3 *    * * *   root     /usr/bin/curl http://stage.zerocall.com/b2c/pScripts/usageAlert
                            $number = $customerMobileNumber;
                            //$number = "923214745120";
                            $sms_text = $alerts->getSmsAlertMessage();
                            $data = array(
                              'S' => 'H',
                              'UN'=>'zapna1',
                              'P'=>'Zapna2010',
                              'DA'=>$number,
                              'SA' => $AlertSenderName,
                              'M'=>$sms_text,
                              'ST'=>'5'
                            );
                            $queryString = http_build_query($data,'', '&');
                            //   die;
                            sleep(0.5);

                            $queryString=smsCharacter::smsCharacterReplacement($queryString);

                            if($this->response_text = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString)){
                                echo $this->response_text;
                            }
                            //--------------------------------------------------------------------------------------

//                            //Set the Sms text
//                            $msgSent = new UsageAlertSent();
//                            $msgSent->setUsageAlertId($alerts->getId());
//                            $msgSent->setCustomerid($cus->getId());
//                            $msgSent->setMessagetype("sms");
//                            $msgSent->setAlertAmount($alerts->getAlertAmount());
//                            $msgSent->save();
                        }
                    }
              //  }
            }
        }

         //This Code For send the Email Alert....
        $usagealerts = new Criteria();
        $usagealerts->add(UsageAlertPeer::EMAIL_ACTIVE, 1);
        //$usagealerts->addAnd(UsageAlertPeer::ALERT_AMOUNT, 0, Criteria::NOT_EQUAL);
        $usagealerts->addAnd(UsageAlertPeer::COUNTRY, $countryId);
        $usagealert = UsageAlertPeer::doSelect($usagealerts);
        foreach($usagealert as $alerts){

            $c=new Criteria();
            $c->add(CustomerPeer::CUSTOMER_STATUS_ID,3);
            $c->addAnd(CustomerPeer::COUNTRY_ID,$countryId);
            $customers=CustomerPeer::doSelect($c);
            $customer_balance = "";
            foreach($customers as $cus){
                //echo $alerts->getId().'<br>';
                $msgsentstatus = new Criteria();
                $msgsentstatus->add(UsageAlertSentPeer::USAGE_ALERT_ID,$alerts->getId());
                $msgsentstatus->addAnd(UsageAlertSentPeer::CUSTOMERID, $cus->getId());
                $msgsentstatus->addAnd(UsageAlertSentPeer::ALERT_AMOUNT, $alerts->getAlertAmount());
                $msgsentstatus->addAnd(UsageAlertSentPeer::MESSAGETYPE, "email");
                $msgsentrecord = UsageAlertSentPeer::doSelectOne($msgsentstatus);
//                if($msgsentrecord){
//                   // echo "Message Aleady Sent......".$msgsentrecord->getAlertAmount().'__'.$msgsentrecord->getCustomerid().'__'.$msgsentrecord->getUsageAlertId().'<br>';
//                    echo "Email Aleady Sent......<br>";
//                }else
                    {

                    $senderName = new Criteria();
                    $senderName->add(UsageAlertSenderPeer::ID,$alerts->getSenderName());
                    $usageAlertSenderName = UsageAlertSenderPeer::doSelectOne($senderName);
                    $AlertSenderName = $usageAlertSenderName->getName();

                    //echo $cus->getId().'<br>';
                    $this->customer = CustomerPeer::retrieveByPK($cus->getId());
                         $uniqueId =$this->customer->getUniqueid();
                if(isset($uniqueId) && $uniqueId!=""){

                     //  $customer_balance = (double)Fonet::getBalance($this->customer);


                  

                       $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name='.$uniqueId.'&type=customer');
        $telintaGetBalance = str_replace('success=OK&Balance=', '', $telintaGetBalance);
        $telintaGetBalance = str_replace('-', '', $telintaGetBalance);
         $customer_balance = $telintaGetBalance;






                    }else{
                        continue;

                    }

                    if($customer_balance<$alerts->getAlertAmount()){
                         echo "New Email Sent......<br>";
                         //echo $cus->getMobileNumber();
                         echo 'CustomerBlance:'.$customer_balance.'<br>';
                         //echo $alerts->getSmsAlertMessage();
                         //echo '<br>';
                            //--------------------------This Is Email Send Area------------------------------------
                                $customerMobileNumber = $CallCode.$cus->getMobileNumber();

                                $subject         = 'Usage Alert' ;
                                $message_body     = $alerts->getEmailAlertMessage()." <br />\r\n ".$AlertSenderName;

                                $emailAlertCus=new Criteria();
                                $emailAlertCus->add(CustomerPeer::ID,$cus->getId());
                                $emailAlertCustomer = CustomerPeer::doSelectOne($emailAlertCus);

                                //Send Email to Customer For Balance --- 06/06/11
                                emailLib::sendCustomerBalanceEmail($emailAlertCustomer,$message_body);

                            //--------------------------------------------------------------------------------------

//                            //Set the Sms text
//                            $msgSent = new UsageAlertSent();
//                            $msgSent->setUsageAlertId($alerts->getId());
//                            $msgSent->setCustomerid($cus->getId());
//                            $msgSent->setMessagetype("email");
//                            $msgSent->setAlertAmount($alerts->getAlertAmount());
//                            $msgSent->save();

                    }
                   // echo $alerts->getAlertAmount();
                    if($alerts->getAlertAmount()==0){
                        if($customer_balance==0){
                            //--------------------------This Is sms Send Area--------------------------------------
                                $customerMobileNumber = $CallCode.$cus->getMobileNumber();
                                $subject         = 'Usage Alert' ;
                                $message_body     = $alerts->getEmailAlertMessage()." <br /> \r\n ".$AlertSenderName;

                                $emailAlertCus=new Criteria();
                                $emailAlertCus->add(CustomerPeer::ID,$cus->getId());
                                $emailAlertCustomer=CustomerPeer::doSelectOne($emailAlertCus);

                                //Send Email to Customer For Balance --- 06/06/11
                                emailLib::sendCustomerBalanceEmail($emailAlertCustomer,$message_body);
                            //--------------------------------------------------------------------------------------

//                            //Set the Sms text
//                            $msgSent = new UsageAlertSent();
//                            $msgSent->setUsageAlertId($alerts->getId());
//                            $msgSent->setCustomerid($cus->getId());
//                            $msgSent->setMessagetype("email");
//                            $msgSent->setAlertAmount($alerts->getAlertAmount());
//                            $msgSent->save();
                        }
                    }
                }
            }
        }

        die();

  }


    public function executeCustomerInfo(sfWebRequest $request){
        echo "<pre>";
        var_dump(Telienta::getCustomerInfo($request->getParameter("icustomer")));
        echo "</pre>";
        return sfView::NONE;
    }

    public function executePopulatePasswrod(sfWebRequest $request) {
        $c = new Criteria();
        $c->add(EmployeePeer::PASSWORD, null, Criteria::ISNULL);
        $employees = EmployeePeer::doSelect($c);
        foreach ($employees as $employee) {
            $comid = $employee->getCompanyId();
            $ct = new Criteria();
            $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, sfConfig::get("app_telinta_emp") . $comid . $employee->getId());
            $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
            $telintaAcc = TelintaAccountsPeer::doSelectOne($ct);
            if ($telintaAcc) { //echo $telintaAcc->getIAccount();
                $accountInfo = CompanyEmployeActivation::getAccountInfo($telintaAcc->getIAccount());
                $employee->setPassword($accountInfo->account_info->h323_password);
                $employee->save();
            }
        }
    }

    public function executeUpdateCompanyInfo(sfWebRequest $request){
        $c = new Criteria();
        $c->add(CompanyPeer::I_CUSTOMER, null, Criteria::ISNOTNULL);
        $companies = CompanyPeer::doSelect($c);
        $customer_info['credit_limit']= 25;
        foreach($companies as $company){
            if($company->getICustomer()=="77424")
                    continue;
            $customer_info['i_customer']= $company->getICustomer();
            CompanyEmployeActivation::updateCustomer($customer_info);
        }
    }

    public function executeGetBalanceFromTelienta(sfWebRequest $request){
        $c = new Criteria();
        $c->add(CompanyPeer::I_CUSTOMER, null, Criteria::ISNOTNULL);
        $companies = CompanyPeer::doSelect($c);
        foreach($companies as $company){
            CompanyEmployeActivation::getBalance($company);
        }
    }


   public function executeAutoLineRentCharging(sfWebRequest $request){


                  $liR = new Criteria();
        $liR->add(LineRentPeer::RENT_ACTIVE, 1);
        $lineRentCompanies = LineRentPeer::doSelect($liR);


        foreach ($lineRentCompanies as $lineRentCompany) {

            $oldBalance =0;

            $company = CompanyPeer::retrieveByPK($lineRentCompany->getCompanyId());
            $oldBalance = CompanyEmployeActivation::getBalance($company);


            if (isset($oldBalance) && $oldBalance <> 0) {


                $Tre = new Criteria();
                $Tre->add(CompanyTransactionPeer::TRANSACTION_STATUS_ID, 3);
                $Tre->addAnd(CompanyTransactionPeer::COMPANY_ID, $lineRentCompany->getCompanyId());
                $Tre->addAnd(CompanyTransactionPeer::TRANSACTION_TYPE, 2);
                $Tre->addDescendingOrderByColumn(CompanyTransactionPeer::ID);
                if (CompanyTransactionPeer::doCount($Tre) > 0) {
                    $Transaction = CompanyTransactionPeer::doSelectOne($Tre);

                  $lastTransactionDate = $Transaction->getCreatedAt();
             
                  $lastTransactionDate =strtotime($lastTransactionDate);
                   $tomorrow1 = mktime(0, 0, 0, date("m",$lastTransactionDate), date("d",$lastTransactionDate) + $lineRentCompany->getNumberOfDays(), date("Y",$lastTransactionDate));
                    $dateToday = date("Y-m-d");
                    $TransactionDateDif = date("Y-m-d", $tomorrow1);
                    if ($TransactionDateDif > $dateToday) {

                            $transactionpayment =0;

                    } else {
                            $transactionpayment = 1;
                     
                    }
                    $lineRentCompany->getNumberOfDays();
                } else {
                       $dateToday = date("Y-m-d");
                     $lastTransactionDate =strtotime($lineRentCompany->getCreatedAt());
                  $createdatDate=mktime(0, 0, 0, date("m",$lastTransactionDate), date("d",$lastTransactionDate) + $lineRentCompany->getNumberOfDays(), date("Y",$lastTransactionDate));
                  echo   $TransactionDateDif = date("Y-m-d", $createdatDate);
                    if ($TransactionDateDif > $dateToday) {
                        $transactionpayment = 0;

                    } else {

                            $transactionpayment = 1;

                    }
                }


            $cT = new Criteria();
            $cT->add(TransactionDescriptionPeer::ID,6);
            $description = TransactionDescriptionPeer::doSelectOne($cT);
                if ($transactionpayment) {
                    $transaction = new CompanyTransaction();
                    $transaction->setAmount($lineRentCompany->getRentValue());
                    $transaction->setCompanyId($lineRentCompany->getCompanyId());
                    $transaction->setExtraRefill($lineRentCompany->getRentValue());
                    $transaction->setTransactionStatusId(1);
                    $transaction->setPaymenttype(3); //Refill
                    $transaction->setDescription($description->getTitle());
                    $transaction->setRentDays($lineRentCompany->getNumberOfDays());
                    $transaction->setRentValue($lineRentCompany->getRentValue());
                    $transaction->setTransactionDescriptionId($description->getId());
                    $transaction->setOldBalance($oldBalance);
                    $transaction->setTransactionType(2);
                    $transaction->save();

                    if (CompanyEmployeActivation::charge($company, $lineRentCompany->getRentValue())) {
                        $transaction->setTransactionStatusId(3);
                        $newBalance = CompanyEmployeActivation::getBalance($company);
                        $transaction->setNewBalance($newBalance);
                        $transaction->save();
                    }
                }
            }
        }
         return sfView::NONE;
    }
}
