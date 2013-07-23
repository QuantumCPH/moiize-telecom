<?php

require_once(sfConfig::get('sf_lib_dir') . '/telintaSoap.class.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Telinta
 * emails are being sent in each of the action and same that is just becuse if Managment needs diffrent messages.
 * @author baran Khan
 */
set_time_limit(10000000);

class Telienta {


    private $currency;
    private $iParentReseller;
    private $telintaSOAPUrl;

    public function __construct() {
        $this->iParentReseller = sfConfig::get("app_telinta_iparent");
        $this->currency = sfConfig::get("app_telinta_currency");
        $this->telintaSOAPUrl = sfConfig::get("app_telinta_soap_url");
        $this->account_prefix = sfConfig::get("app_telinta_account_prefix");
        $this->telinta_soap_user = sfConfig::get("app_telinta_soap_user");
        $this->telinta_soap_password = sfConfig::get("app_telinta_soap_password");
    }

    public function ResgiterCustomer(Customer $customer, $OpeningBalance, $creditLimit=0) {

        $tCustomer = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');


      //  $uniqueid =$this->account_prefix.$customer->getId().$customer->getCustomerNumber();
         $uniqueid =$this->account_prefix.$customer->getCustomerNumber();
        $Parent = $this->iParentReseller;

        while (!$tCustomer && $retry_count < $max_retries) {
            try {

                $tCustomer = $pb->add_customer(array('customer_info' => array(
                                'name' => $uniqueid,
                                'iso_4217' => $this->currency,
                                'i_parent' => $Parent,
                                'i_customer_type' => 1,
                                'opening_balance' => -($OpeningBalance),
                                'credit_limit' => $creditLimit,
                                'dialing_rules' => array('ip' => '00'),
                                'email' => 'okh@zapna.com'
                                )));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                   if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
                       continue;
                    }else{ 
                        emailLib::sendErrorInTelinta("Error in Customer Registration", "We have faced an issue in Customer registration on telinta. this is the error for cusotmer with  id: " . $customer->getId() . " and error is " . $e->faultstring . "  <br/> Please Investigate.");

                        return false;
                    }    
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Error in Customer Registration", "We have faced an issue in Customer registration on telinta.this is the error for cusotmer with  id: " . $customer->getId() . " and error is " . $e->faultstring . "  Error is Even After Max Retries " . $max_retries . "  <br/> Please Investigate.");
            return false;
        }

        $customer->setICustomer($tCustomer->i_customer);
        $customer->save();

        return true;
    }

    public function createAAccount($mobileNumber, Customer $customer) {
        return $this->createAccount($customer, $mobileNumber, 'a', $this->a_iProduct);
    }

    public function terminateAccount(TelintaAccounts $telintaAccount) {
        $account = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');

        while (!$account && $retry_count < $max_retries) {
            try {
                $account = $pb->terminate_account(array('i_account' => $telintaAccount->getIAccount()));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
                       continue;
                    }else{  
                        emailLib::sendErrorInTelinta("Account Deletion: " . $telintaAccount->getIAccount() . " Error!", "We have faced an issue in Customer Account Deletion on telinta. this is the error for cusotmer with  id: " . $telintaAccount->getIAccount() . " error is " . $e->faultstring . "  <br/> Please Investigate.");

                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Account Deletion: " . $telintaAccount->getIAccount() . " Error!", "We have faced an issue in Customer Account Deletion on telinta. this is the error for cusotmer with  id: " . $telintaAccount->getIAccount() . " error is " . $e->faultstring . " Error is Even After Max Retries " . $max_retries . "  <br/> Please Investigate.");
            return false;
        }

        $telintaAccount->setStatus(5);
        $telintaAccount->save();
        return true;
    }
 public function getBalance(Customer $customer) {
        $cInfo = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');

        while (!$cInfo && $retry_count < $max_retries) {
            try {
                $cInfo = $pb->get_customer_info(array(
                            'i_customer' => $customer->getICustomer(),
                        ));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                    if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta"); 
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
                       continue;
                    }else{
                      emailLib::sendErrorInTelinta("Error in getBalance", "We have faced an issue on Success in getBalnace on telinta. this is the error for cusotmer with  id: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");

                      return false;  
                    }                    
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Error in getBalance", "We have faced an issue on Success in getBalnace on telinta. this is the error for cusotmer with  id: " . $customer->getId() . " error is " . $e->faultstring . "  Error is Even After Max Retries " . $max_retries . "  <br/> Please Investigate.");
            return false;
        }
        $Balance = $cInfo->customer_info->balance;
        if ($Balance == 0)
            return 0.001;
        else
            return -1 * $Balance;
    }

    public function charge(Customer $customer, $amount, $description="Charge") {
        return $this->makeTransaction($customer, "Manual charge", $amount, $description);
    }

    public function recharge(Customer $customer, $amount, $description="Refill") {
     
        
        $c = new Criteria;
        $c->add(EmailAlertSentPeer::CUSTOMER_ID, $customer->getId());
        $emailAlertCount = EmailAlertSentPeer::doCount($c);
        if ($emailAlertCount > 0) {
            $emailAlerts = EmailAlertSentPeer::doSelect($c);
            foreach ($emailAlerts as $emailAlert) {
                $emailAlert->setUsageAlertStatusId(null);
                $emailAlert->save();
            }
        }

        $c = new Criteria;
        $c->add(SmsAlertSentPeer::CUSTOMER_ID, $customer->getId());
        $smsAlertCount = SmsAlertSentPeer::doCount($c);
        if ($smsAlertCount > 0) {
            $smsAlerts = SmsAlertSentPeer::doSelect($c);
            foreach ($smsAlerts as $smsAlert) {
                $smsAlert->setUsageAlertStatusId(null);
                $smsAlert->save();
            }
        }

        return $this->makeTransaction($customer, "Manual payment", $amount, $description);
    }

    public function callHistory($customer, $fromDate, $toDate, $reseller=false, $iService=3) {
        $xdrList = false;
        $max_retries = 10;
        $retry_count = 0;
        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');

        if ($reseller)
            $icustomer = $customer;
        else
            $icustomer = $customer->getICustomer();
        while (!$xdrList && $retry_count < $max_retries) {
            try {
                $xdrList = $pb->get_customer_xdr_list(array('i_customer' => $icustomer, 'from_date' => $fromDate, 'to_date' => $toDate));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
                       continue;
                    }else{ 
                        emailLib::sendErrorInTelinta("Customer Call History: " . $icustomer . " Error!", "We have faced an issue with Customer while Fetching Call History  this is the error for cusotmer with  ICustomer: " . $icustomer . " and the i_service is: " . $iService . " error is " . $e->faultstring . "  <br/> Please Investigate.");
                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Customer Call History: " . $icustomer . " Error!", "We have faced an issue with Customer while Fetching Call History on telinta.  and the i_service is:" . $iService . " error is " . $e->faultstring . ". Error is Even After Max Retries " . $max_retries . "  <br/> Please Investigate.");
            return false;
        }

        return $xdrList;
    }

    public function getCustomerInfo($uniqueId) {
        $cInfo = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
        while (!$cInfo && $retry_count < $max_retries) {
            try {
                $cInfo = $pb->get_customer_info(array(
                            'name' => $uniqueId,
                        ));
                
            }catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
                       continue;
                    }else{  
                        emailLib::sendErrorInTelinta("Error in Customer Get Customer Info", "We have faced an issue in Get Customer Info on telinta. this is the error for cusotmer with  uniqueid: " . $uniqueId . " and error is " . $e->faultstring . "  <br/> Please Investigate.");
                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Error in Customer Get Customer Info", "We have faced an issue in Get Customer Info on telinta. this is the error for cusotmer with  uniqueid: " . $uniqueId . " and error is " . $e->faultstring . ". Error is Even After Max Retries " . $max_retries . "  <br/> Please Investigate.");
            return false;
        }
        $i_customer = $cInfo->customer_info->i_customer;
        return $i_customer;
    }

    public function getCustomerAccountList($iCustomer) {
        $cInfo = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
        while (!$cInfo && $retry_count < $max_retries) {
            try {
                $cInfo = $pb->get_account_list(array(
                            'i_customer' => $iCustomer,
                            'offset' => 0,
                            'limit' => 100
                        ));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
                       continue;
                    }else{  
                        emailLib::sendErrorInTelinta("Error in Customer Get Customer Account List", "We have faced an issue in Get Customer Account List on telinta. this is the error for cusotmer with  i_customer: " . $iCustomer . " and error is " . $e->faultstring . "  <br/> Please Investigate.");
                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Error in Customer Get Customer Account List", "We have faced an issue in Get Customer Account List on telinta. this is the error for cusotmer with  i_customer: " . $iCustomer . " and error is " . $e->faultstring . ". Error is Even After Max Retries " . $max_retries . "  <br/> Please Investigate.");
            return false;
        }

        return $cInfo;
    }

    public function updateAccount($accountInfo) {
        $account = false;
        $max_retries = 5;
        $retry_count = 0;
        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');


        //  $accountName = $accountType . $mobileNumber;
        while (!$account && $retry_count < $max_retries) {
            try {
                //Example:
                //$accountInf("i_account"=>"xxxxxx","blocked"=>"Y");
                $account = $pb->update_account(array('account_info' => $accountInfo));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
                       continue;
                    }else{  
                        emailLib::sendErrorInTelinta("Account Update: " . $accountInfo['i_account'] . " Error!", "We have faced an issue in Customer Account updation on telinta. this is the error fo Account" . $accountTitle . " error is " . $e->faultstring . " <br/> Please Investigate.");
                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Account Update: " . $accountInfo['i_account'] . " Error!", "We have faced an issue in Customer Account updation on telinta. this is the error fo Account" . $accountTitle . " error is " . $e->faultstring .". Error is Even After Max Retries" . $max_retries . " <br/> Please Investigate.");
            return false;
        }
        return true;
    }

    public function createCBAccount($TelintaMobile, Customer $customer){        
        return $this->createAccount($customer, $customer->getMobileNumber(), 'cb',  $this->b_iProduct);
    }

//    public function createReseNumberAccount($VOIPNumber, Customer $customer){
//        $c = new Criteria();
//        $c->addJoin(CustomerPeer::ID, CustomerProductPeer::CUSTOMER_ID, Criteria::LEFT_JOIN);
//        $c->addJoin(CustomerProductPeer::PRODUCT_ID, ProductPeer::ID, Criteria::LEFT_JOIN);
//        $c->addJoin(ProductPeer::BILLING_PRODUCT_ID, BillingProductsPeer::ID, Criteria::LEFT_JOIN);
//        $c->addAnd(CustomerProductPeer::STATUS_ID, 3);
//        $c->addAnd(CustomerPeer::ID, $customer->getId());
//        $product = BillingProductsPeer::doSelectOne($c); 
//        return self::createAccount($customer, $VOIPNumber, '', $product->getVoipIproduct());
//    }
    public function deactivateFollowMeNumber($VOIPNumber, $CurrentActiveNumber) {

        $url = "https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=update&name=" . $VOIPNumber . "&active=N&follow_me_number=" . $CurrentActiveNumber . "&type=account";
        $deactivate = file_get_contents($url);
        sleep(0.5);
        if (!$deactivate) {
            emailLib::sendErrorInTelinta("Error in deactivateFollowMeNumber", "Unable to call. We have faced an issue in deactivateFollowMeNumber on telinta. this is the error on the following url: " . $url . "  <br/> Please Investigate.");
            return false;
        }
        parse_str($deactivate);
        if (isset($success) && $success != "OK") {
            emailLib::sendErrorInTelinta("Error in deactivateFollowMeNumber", "We have faced an issue on Success in deactivateFollowMeNumber on telinta. this is the error on the following url:" . $url . " <br/> and error is: " . $deactivate . "  <br/> Please Investigate.");
            return false;
        }
        return true;
    }

    public function createReseNumberAccount($VOIPNumber, $uniqueId, $currentActiveNumber) {

        $url = "https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name=" . $VOIPNumber . "&customer=" . $uniqueId . "&opening_balance=0&credit_limit=&product=" . $this->VoipProduct . "&outgoing_default_r_r=2034&activate_follow_me=Yes&follow_me_number=" . $currentActiveNumber . "&billing_model=1&password=asdf1asd";
        $reseNumber = file_get_contents($url);
        sleep(0.5);
        if (!$reseNumber) {
            emailLib::sendErrorInTelinta("Error in createReseNumberAccount", "Unable to call. We have faced an issue in createReseNumberAccount on telinta. this is the error on the following url: " . $url . "  <br/> Please Investigate.");
            return false;
        }
        parse_str($reseNumber);
        if (isset($success) && $success != "OK") {
            emailLib::sendErrorInTelinta("Error in createReseNumberAccount", "We have faced an issue on Success in createReseNumberAccount on telinta. this is the error on the following url:" . $url . " <br/> and error is: " . $reseNumber . "  <br/> Please Investigate.");
            return false;
        }
        return true;
    }

    //// Private Area.
    private function createAccount(Customer $customer, $mobileNumber, $accountType, $iProduct, $followMeEnabled='N') {
        $account = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
      //  $uniqueid =$this->account_prefix.$customer->getId().$customer->getCustomerNumber(); 
          $uniqueid =$this->account_prefix.$customer->getCustomerNumber(); 

        $accountName = $accountType . $mobileNumber;
        while (!$account && $retry_count < $max_retries) {
            try {

                $account = $pb->add_account(array('account_info' => array(
                                'i_customer' => $customer->getICustomer(),
                                'name' => $accountName, //75583 03344090514
                                'id' => $accountName,
                                'iso_4217' => $this->currency,
                                'opening_balance' => 0,
                                'credit_limit' => null,
                                'i_product' => $iProduct,
                                'i_routing_plan' => 2039,
                                'billing_model' => 1,
                                'password' => 'asdf1asd',
                                'h323_password' => 'asdf1asd',
                                'activation_date' => date('Y-m-d'),
                                'batch_name' => $uniqueid,
                                'follow_me_enabled' => $followMeEnabled
                                )));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
                       continue;
                    }else{  
                        emailLib::sendErrorInTelinta("Account Creation: " . $accountName . " Error!", "We have faced an issue in Customer Account Creation on telinta. this is the error for cusotmer with  id: " . $customer->getId() . " and on Account " . $accountName . " error is " . $e->faultstring . "  <br/> Please Investigate.");

                        return false;
                    }     
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Account Creation: " . $accountName . " Error!", "We have faced an issue in Customer Account Creation on telinta. . this is the error for cusotmer with  id: " . $customer->getId() . " and on Account " . $accountName . " error is " . $e->faultstring . " Error is Even After Max Retries " . $max_retries . "  <br/> Please Investigate.");
            return false;
        }

        $telintaAccount = new TelintaAccounts();
        $telintaAccount->setAccountTitle($accountName);
        $telintaAccount->setParentId($customer->getId());
        $telintaAccount->setParentTable("customer");
        $telintaAccount->setICustomer($customer->getICustomer());
        $telintaAccount->setIAccount($account->i_account);
        if ($accountType == "") {
            $accountType = 'voip';
        }
        $telintaAccount->setAccountType($accountType);
        $telintaAccount->save();
        return true;
    }

    private function makeTransaction(Customer $customer, $action, $amount, $description) {
        $accounts = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');

        while (!$accounts && $retry_count < $max_retries) {
            try {
                $accounts = $pb->make_transaction(array(
                            'i_customer' => $customer->getICustomer(),
                            'action' => $action, //Manual payment, Manual charge
                            'amount' => $amount,
                            'visible_comment' => $description
                        ));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
                       continue;
                    }else{  
                        emailLib::sendErrorInTelinta("Customer Transcation: " . $customer->getId() . " Error!", "We have faced an issue with Customer while making transaction " . $action . " with balance:" . $amount . " this is the error for cusotmer with  Customer ID: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");

                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Customer Transcation: " . $customer->getId() . " Error!", "We have faced an issue with Customer while making transaction " . $action . " with balance:" . $amount . " this is the error for cusotmer with  Customer ID: " . $customer->getId() . " error is " . $e->faultstring . " Error is Even After Max Retries " . $max_retries . "  <br/> Please Investigate.");
            return false;
        }

        return true;
    }
    
    public function chargeAAccount(Customer $customer, $amount,$description="Charge") {
        return $this->makeAAccountTransaction($customer, "Manual charge", $amount, $description);
    }
    
    public function rechargeAAccount(Customer $customer, $amount,$description="Refill") {
        return $this->makeAAccountTransaction($customer, "Manual payment", $amount, $description);
    }
    
    private function makeAAccountTransaction(Customer $customer, $action, $amount, $description) {
        $accounts = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
        $tac = new Criteria();
        $tac->add(TelintaAccountsPeer::PARENT_TABLE,"customer");
        $tac->addAnd(TelintaAccountsPeer::PARENT_ID,$customer->getId());
        $tac->addAnd(TelintaAccountsPeer::I_CUSTOMER,$customer->getICustomer());
        $tac->addAnd(TelintaAccountsPeer::ACCOUNT_TYPE,"a");
        $tacount = TelintaAccountsPeer::doCount($tac);
        if($tacount > 0){
            $telinta_a_account = TelintaAccountsPeer::doSelectOne($tac);
           // $accountName = 'a'.$customer->getMobileNumber();
            $accountName = $telinta_a_account->getAccountTitle();
            while (!$accounts && $retry_count < $max_retries) {
                try {
                    $accounts = $pb->make_transaction(array(
                                'i_customer' => $customer->getICustomer(),
                                'name' => $accountName,
                                'i_account'=>$telinta_a_account->getIAccount(),
                                'action' => $action, //Manual payment, Manual charge
                                'amount' => $amount,
                                'visible_comment' => $description
                            ));
                } catch (SoapFault $e) {
                    if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                        if($e->faultstring=="Authentification failed"){
                           emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta"); 
                           $this->startNewSession();
                           ///// after starting new session, new object must initialize for PortaBillingSoapCient
                           $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
                           continue;
                        }else{  
                            emailLib::sendErrorInTelinta("Customer Transcation: " . $customer->getId() . " Error!", "We have faced an issue with Customer while making transaction " . $action . " with balance:" . $amount . " this is the error for cusotmer with  Customer ID: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");

                            return false;
                        }
                    }
                }
                sleep(0.5);
                $retry_count++;
            }
            if ($retry_count == $max_retries) {
                emailLib::sendErrorInTelinta("Customer Transcation: " . $customer->getId() . " Error!", "We have faced an issue with Customer while making transaction " . $action . " with balance:" . $amount . " this is the error for cusotmer with  Customer ID: " . $customer->getId() . " error is " . $e->faultstring . " Error is Even After Max Retries " . $max_retries . "  <br/> Please Investigate.");
                return false;
            }

        return true;
        } else{
            emailLib::sendErrorInTelinta("Subscription fee error ", "Subscription fee error for customer ".$customer->getId().". Acount info not exist in DB.");
            return false;
        } 
    }
    
    public function getAccountInfo($i_account) {
        $account = false;
        $max_retries = 5;
        $retry_count = 0;
        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');


        //  $accountName = $accountType . $mobileNumber;
        while (!$account && $retry_count < $max_retries) {
            try {
                //Example:
                //$accountInf("i_account"=>"xxxxxx","blocked"=>"Y");
                $account = $pb->get_account_info(array('i_account' => $i_account));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
                       continue;
                    }else{  
                        echo $e->faultstring;
                        emailLib::sendErrorInTelinta("Account Update: " . $accountInfo['i_account'] . " Error!", "We have faced an issue in Customer Account updation on telinta. this is the error fo Account" . $accountTitle . " error is " . $e->faultstring . " <br/> Please Investigate.");
                        return false;
                    }    
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Account Update: " . $accountInfo['i_account'] . " Error!", "We have faced an issue in Customer Account updation on telinta. this is the error fo Account" . $accountTitle . " error is " . $e->faultstring . ". Error is Even After Max Retries" . $max_retries . " <br/> Please Investigate.");
            return false;
        }
        return $account;
    }
    
    public function startNewSession(){
        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
        $session = $pb->_login($this->telinta_soap_user, $this->telinta_soap_password);

        if ($session) {
            $ctc = new Criteria();
            $countTC = TelintaConfigPeer::doCount($ctc);
            if($countTC==0){
                $telintaConfig = new TelintaConfig();
                $telintaConfig->setSession($session);
                $telintaConfig->save();
            }else{
               $telintaConfig = TelintaConfigPeer::doSelectOne($ctc); 
               $telintaConfig->setSession($session);
               $telintaConfig->save();
            }
            emailLib::sendErrorInTelinta("New Session started","New session generated for telinta. session id: ".$session);
            return true;
        }
    }
}

?>
