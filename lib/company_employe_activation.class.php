<?php

require_once(sfConfig::get('sf_lib_dir') . '/telintaSoap.class.php');
require_once(sfConfig::get('sf_lib_dir') . '/emailLib.php');
/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of company_employe_activation
*
* @author baran
*/set_time_limit(10000000);

class CompanyEmployeActivation {

    //put your code here


    private $iParent;  //Company Resller ID on Telinta
    private $currency;    
    private $telintaSOAPUrl;
    private $telintaSOAPUser;
    private $telintaSOAPPassword;
    
    public function __construct() {
        $this->iParent              = sfConfig::get("app_telinta_iparent");
        $this->currency             = sfConfig::get("app_telinta_currency");
        $this->telintaSOAPUrl       = sfConfig::get("app_telinta_soap_url");
        $this->telintaSOAPUser      = sfConfig::get("app_telinta_soap_user");
        $this->telintaSOAPPassword  = sfConfig::get("app_telinta_soap_password");
    }
    public function telintaRegisterCompany(Company $company) {

        $tCustomer = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
        $uniqueid = "MTB2B" . $company->getVatNo();
        $credit_limit=($company->getCreditLimit()!='')?$company->getCreditLimit():'0';
         while (!$tCustomer && $retry_count < $max_retries) {
            try {
                $tCustomer = $pb->add_customer(array('customer_info' => array(
                                'name' => $uniqueid, //75583 03344090514
                                'iso_4217' => $this->currency,
                                'i_parent' => $this->iParent,
                                'i_customer_type' => 1,
                                'opening_balance' => 0,
                                'credit_limit' => $credit_limit,
                                'dialing_rules' => array('ip' => '00', "cc" => "34"),
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
                        emailLib::sendErrorInTelinta("Error in Company Registration", "We have faced an issue in Company registration on telinta. This is the error for cusotmer with Company Vat No: " . $company->getVatNo() . " and error is " . $e->faultstring . " <br/> Please Investigate.");
                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Error in Company Registration", "We have faced an issue in Company registration on telinta. This is the error for cusotmer with Company Vat No: " . $company->getVatNo() . " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }
            $company->setICustomer($tCustomer->i_customer);
            //$company->save();
            return true;

    }

    public function telintaRegisterEmployee($employeMobileNumber, Company $company, Employee $employee) {
        return $this->createAccount($company, $employeMobileNumber, '', $employee);
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
                        emailLib::sendErrorInTelinta("Account Deletion: " . $telintaAccount->getIAccount() . " Error!", "We have faced an issue in Company Account Deletion on telinta. This is the error for cusotmer with IAccount: " . $telintaAccount->getIAccount() . " and error is " . $e->faultstring . " <br/> Please Investigate.");

                        return false;
                    }
                }
             }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Account Deletion: " . $telintaAccount->getIAccount() . " Error!", "We have faced an issue in Company Account Deletion on telinta. This is the error for cusotmer with IAccount: " . $telintaAccount->getIAccount() . " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }

            $telintaAccount->setStatus(5);
            $telintaAccount->save();
            return true;

    }

    public function getBalance(Company $company) {
        $cInfo = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
        $pb->_setSessionId();
        while (!$cInfo && $retry_count < $max_retries) {
            try {
                $cInfo = $pb->get_customer_info(array(
                            'i_customer' => $company->getICustomer(),
                        ));
               
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
                       continue;
                       return false;
                    }else{  
                       emailLib::sendErrorInTelinta("Company Balance Fetching: " . $company->getId() . " Error!", "We have faced an issue in Company Account Balance Fetch on telinta. This is the error for cusotmer with Company Id: " . $company->getId() . " and error is " . $e->faultstring . " <br/> Please Investigate.");

                       return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Company Balance Fetching: " . $company->getId() . " Error!", "We have faced an issue in Company Account Balance Fetch on telinta. This is the error for cusotmer with Company Id: " . $company->getId() .  " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }

            $Balance = $cInfo->customer_info->balance;
            if ($Balance == 0)
                return $Balance;
            else
                return -1 * $Balance;

    }

    public function charge(Company $company, $amount) {
        return $this->makeTransaction($company, "Manual charge", $amount);
    }

    public function recharge(Company $company, $amount, $transaction='') {
        if ($this->makeTransaction($company, "Manual payment", $amount)) {
            //emailLib::sendCompanyRefillEmail($company, $transaction);
            return true;
        } else {
            return false;
        }
    }

    public function callHistory(Company $company, $fromDate, $toDate, $reseller=false, $iService=3) {
        $xdrList = false;
        $max_retries = 5;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
        if ($reseller){
            $icustomer = $company;
        }else{
            $icustomer = $company->getICustomer();
        }
        while (!$xdrList && $retry_count < $max_retries) {
            try {
                $xdrList = $pb->get_customer_xdr_list(array('i_customer' => $icustomer, 'from_date' => $fromDate, 'to_date' => $toDate,'i_service' => $iService));
            } catch (SoapFault $e) {
                 if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
                       continue;
                    }else{   
                      emailLib::sendErrorInTelinta("Company Call History: " . $company->getId() . " Error!", "We have faced an issue with Company while Fetching Call History from date: ".$fromDate."  and to date: ".$toDate.". This is the error for cusotmer with Company ID: " . $company->getId() . " and error is " . $e->faultstring . " <br/> Please Investigate.");
                      return false;
                      
                    }
                 }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Company Call History: " . $company->getId() . " Error!", "We have faced an issue with Company while Fetching Call History from date: ".$fromDate."  and to date: ".$toDate." on telinta. This is the error for cusotmer with Company ID: " . $company->getId() . " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }

            return $xdrList;

    }

    public function getAccountInfo($iAccount) {
        $aInfo = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');

        while (!$aInfo && $retry_count < $max_retries) {
            try {
                $aInfo = $pb->get_account_info(array(
                            'i_account' => $iAccount,
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
                        emailLib::sendErrorInTelinta("Employee Account info Fetching: " . $iAccount . " Error!", "We have faced an issue in Employee Account Info Fetch on telinta. This is the error for Employee with IAccount: " . $iAccount . " and error is " . $e->faultstring . " <br/> Please Investigate.");

                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Employee Account info Fetching: " . $iAccount . " Error!", "We have faced an issue in Employee Account Info Fetch on telinta. This is the error for Employee with IAccount: " . $iAccount . " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }

            return $aInfo;

    }

    public function getAccountCallHistory($iAccount, $fromDate, $toDate) {
        $xdrList = false;
        $max_retries = 5;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
        while (!$xdrList && $retry_count < $max_retries) {
            try {
                $xdrList = $pb->get_xdr_list(array('i_account' => $iAccount, 'from_date' => $fromDate, 'to_date' => $toDate));
            } catch (SoapFault $e) {
               if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
                       continue;
                    }else{ 
                        emailLib::sendErrorInTelinta("Employee Call History: " . $iAccount . " Error!", "We have faced an issue with Employee while Fetching Call History from date: ".$fromDate." and to date: ".$toDate.". This is the error for cusotmer with IAccount: " . $iAccount . " and error is " . $e->faultstring . " <br/> Please Investigate.");
                        return false;                    
                    }
               }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Employee Call History: " . $iAccount . " Error!", "We have faced an issue with Employee while Fetching Call History from date: ".$fromDate." and to date: ".$toDate." on telinta. This is the error for cusotmer with IAccount: " . $iAccount .  " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }
            return $xdrList;

    }

    // Private Area:
    //2039
    private function createAccount(Company $company, $mobileNumber, $accountType, Employee $employee, $followMeEnabled='N') {
        $account = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
        $pass = $this->randomAlphabets(4) . $this->randomNumbers(1) . $this->randomAlphabets(3);
      echo  $accountName = $accountType . $mobileNumber;
        while (!$account && $retry_count < $max_retries) {
            try {                
                $account = $pb->add_account(array('account_info' => array(
                                'i_customer' => $company->getICustomer(),
                                'name' => $accountName, //75583 03344090514
                                'id' => $accountName,
                                'iso_4217' => $this->currency,
                                'opening_balance' => 0,
                                'credit_limit' => null,
                                'i_product' => $employee->getTelintaProductId(),
                                'i_routing_plan' => $employee->getTelintaRoutingplanId(),
                                'billing_model' => 1,
                                'password' => $pass,
                                'h323_password' => $pass,
                                'activation_date' => date('Y-m-d'),
                                'batch_name' =>"MTB2B".$company->getVatNo(),
                                'follow_me_enabled' => $followMeEnabled
                                )));
                        var_dump($account);
                        
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
                       continue;
                    }else{  
                        emailLib::sendErrorInTelinta("Account Creation: " . $accountName . " Error!", "We have faced an issue in Company Account Creation on telinta. This is the error for cusotmer with Company Id: " . $company->getId() . " and on Account " . $accountName . " and error is " . $e->faultstring . " <br/> Please Investigate.");
                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Account Creation: " . $accountName . " Error!", "We have faced an issue in Company Account Creation on telinta. This is the error for cusotmer with Company Id: " . $company->getId() . " and on Account " . $accountName .  " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }

            $employee->setPassword($pass);
            $employee->save();
            $telintaAccount = new TelintaAccounts();
            $telintaAccount->setAccountTitle($accountName);
            $telintaAccount->setParentId($company->getId());
            $telintaAccount->setParentTable("company");
            $telintaAccount->setICustomer($company->getICustomer());
            $telintaAccount->setIAccount($account->i_account);
            $telintaAccount->save();
            return true;

    }

    private function makeTransaction(Company $company, $action, $amount) {
        $accounts = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');

        while (!$accounts && $retry_count < $max_retries) {
            try {
                $accounts = $pb->make_transaction(array(
                            'i_customer' => $company->getICustomer(),
                            'action' => $action, //Manual payment, Manual charge
                            'amount' => $amount,
                            'visible_comment' => 'Portal ' . $action
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
                        emailLib::sendErrorInTelinta("Customer Transcation: " . $company->getId() . " Error!", "We have faced an issue with Customer while making transaction " . $action . ". This is the error for cusotmer with Company ID: " . $company->getId() . " and error is " . $e->faultstring . " <br/> Please Investigate.");

                        return false;
                    }
                 }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Customer Transcation: " . $company->getId() . " Error!", "We have faced an issue with Customer while making transaction " . $action . " on telinta. This is the error for cusotmer with Company ID: " . $company->getId() . " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }

            return true;

    }

    public function updateAccount(Employee $employee, $iProduct, $iRoutingPlan, $block='N') {
        $account = false;
        $max_retries = 10;
        $retry_count = 0;

        $accountTitle = sfConfig::get("app_telinta_emp") . $employee->getCompanyId() . $employee->getId();
        $til = new Criteria();
        $til->add(TelintaAccountsPeer::ACCOUNT_TITLE, $accountTitle);
        $til->addAnd(TelintaAccountsPeer::STATUS, 3);
        $tilentaAccount = TelintaAccountsPeer::doSelectOne($til);
        if($tilentaAccount){
       // var_dump($tilentaAccount);die;
        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');

        $pass = $this->randomAlphabets(4) . $this->randomNumbers(1) . $this->randomAlphabets(3);
        $accountName = $accountType . $mobileNumber;
        while (!$account && $retry_count < $max_retries) {
            try {

                $account = $pb->update_account(array('account_info' => array(
                                'i_account' => $tilentaAccount->getIAccount(),
                                'i_product' => $iProduct,
                                'i_routing_plan' => $iRoutingPlan,
                                'blocked' => $block,
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
                        emailLib::sendErrorInTelinta("Account Update: " . $accountTitle . " Error!", "We have faced an issue in Company Account updation on telinta. This is the error for cusotmer with Employee Id: " . $employee->getCompanyId() . " and on Account" . $accountTitle . " and error is " . $e->faultstring . " <br/> Please Investigate.");

                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Account Update: " . $accountTitle . " Error!", "We have faced an issue in Company Account updation on telinta. This is the error for cusotmer with Employee Id: " . $employee->getCompanyId() . " and on Account" . $accountTitle . " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }
            return true;
        }
    }

    public function updateCustomer($update_customer_request){
        $customer = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');

        while (!$customer && $retry_count < $max_retries) {
            try {
                $customer = $pb->update_customer(array('customer_info' => $update_customer_request));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host' && $e->faultstring != 'Internal Server Error' && $e->faultstring != 'Bad Gateway') {
                  if($e->faultstring=="Authentification failed"){
                       emailLib::sendErrorInTelinta("Authentification failed","Authentification failed on telinta");
                       $this->startNewSession();
                       ///// after starting new session, new object must initialize for PortaBillingSoapCient
                       $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
                       continue;
                    }else{  
                        emailLib::sendErrorInTelinta("Customer Update: " . $update_customer_request["i_customer"] . " Error!", "We have faced an issue in Company updation on telinta. This is the error for comapny with ICustomer: " . $update_customer_request["i_customer"] . " and error is " . $e->faultstring . " <br/> Please Investigate.");

                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Customer Update: " . $update_customer_request["i_customer"] . " Error!", "We have faced an issue in Company updation on telinta. This is the error for comapny with ICustomer: " . $update_customer_request["i_customer"] . " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }
        return true;
    }


    public function getCustomerInfo(Company $company) {

        $cInfo = false;
        $max_retries = 10;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
        $pb->_setSessionId();
        while (!$cInfo && $retry_count < $max_retries) {
            try {
                $cInfo = $pb->get_customer_info(array(
                            'i_customer' => $company->getICustomer(),
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
                        emailLib::sendErrorInTelinta("Company  info Fetching: " . $company->getId() . " Error!", "We have faced an issue in Company Account info Fetch on telinta. This is the error for cusotmer with Company Id: " . $company->getId() . " and error is " . $e->faultstring . " <br/> Please Investigate.");

                        return false;
                    }
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Company info Fetching: " . $company->getId() . " Error!", "We have faced an issue in Company Account info Fetch on telinta. This is the error for cusotmer with Company Id: " . $company->getId() . " and error is " . $e->faultstring . ". Error is Even After Max Retries ".$max_retries." <br/> Please Investigate.");
            return false;
        }

            $CustomerInfo = $cInfo->customer_info;
           
                return $CustomerInfo;

    }

    private function randomAlphabets($length) {
        $random = "";
        srand((double) microtime() * 1000000);
        $data = "abcdefghijklmnopqrstuvwxyz";
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $random;
    }

    private function randomNumbers($length) {
        $random = "";
        srand((double) microtime() * 1000000);
        $data = "0123456789";
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $random;
    }
    
   private function startNewSession(){
        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
        $session = $pb->_login($this->telintaSOAPUser, $this->telintaSOAPPassword);

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
            return $session;
        }
    } 
} ///// Class END
    
    
?>
