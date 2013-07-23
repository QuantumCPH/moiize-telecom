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
class Telienta {

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

    public function ResgiterCustomer(Customer $customer, $OpeningBalance) {
        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
        
        $uniqueid="MTB2C".$customer->getUniqueid();
        try {
            $tCustomer = $pb->add_customer(array('customer_info' => array(
                            'name' => $uniqueid, //75583 03344090514
                            'iso_4217' => $this->currency,
                            'i_parent' => $this->iParent,
                            'i_customer_type' => 1,
                            'opening_balance' => -($OpeningBalance),
                            'credit_limit' => 0,
                            'dialing_rules' => array('ip' => '00'),
                            'email' => 'okh@zapna.com'
                            )));
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Error in Customer Registration", "We have faced an issue in Customer registration on telinta. this is the error for cusotmer with  id: " . $customer->getId() . " and error is " . $e->faultstring . "  <br/> Please Investigate.");
            
            return false;
        }
        $customer->setICustomer($tCustomer->i_customer);
        $customer->save();
        
        return true;
    }

    public function createAAccount($mobileNumber, Customer $customer) {
        return $this->createAccount($customer, $mobileNumber, 'a', $this->a_iProduct);
    }

    public function createCBount($mobileNumber, Customer $customer) {
        return $this->createAccount($customer, $mobileNumber, 'cb', $this->b_iProduct);
    }

    public function terminateAccount(TelintaAccounts $telintaAccount) {
        try {
            $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
            
            $account = $pb->terminate_account(array('i_account' => $telintaAccount->getIAccount()));
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Account Deletion: " . $accountName . " Error!", "We have faced an issue in Customer Account Deletion on telinta. this is the error for cusotmer with  id: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            
            return false;
        }
        
        $telintaAccount->setStatus(5);
        $telintaAccount->save();
        return true;
    }

    public function getBalance(Customer $customer) {


        try {
            $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
            

            $cInfo = $pb->get_customer_info(array(
                        'i_customer' => $customer->getICustomer(),
                    ));
            $Balance = $cInfo->customer_info->balance;
            
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Customer Balance Fetching: " . $customer->getId() . " Error!", "We have faced an issue in Customer Account Balance Fetch on telinta. this is the error for cusotmer with  Uniqueid: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            
            return false;
        }
        
        if ($Balance == 0)
            return $Balance;
        else
            return -1 * $Balance;
    }

    public function charge(Customer $customer, $amount) {
        return $this->makeTransaction($customer, "Manual charge", $amount);
    }

    public function recharge(Customer $customer, $amount) {
        return $this->makeTransaction($customer, "Manual payment", $amount);
    }

    public function callHistory(Customer $customer, $fromDate, $toDate) {
         $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
            
        try {
            $xdrList = $pb->get_customer_xdr_list(array('i_customer' => $customer->getICustomer(),'from_date'=>$fromDate,'to_date'=>$toDate));
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Customer Call History: " . $customer->getId() . " Error!", "We have faced an issue with Customer while Fetching Call History  this is the error for cusotmer with  Customer ID: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            
        }
        
        return $xdrList;
    }

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

    /*
     * $accountType is for a or cb accounts
     */

    private function createAccount(Customer $customer, $mobileNumber, $accountType, $iProduct, $followMeEnabled='N') {

        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Account');
        
        $batchName="MTB2C".$customer->getUniqueid();
        try {
            $accountName = $accountType . $mobileNumber;
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
                            'batch_name' => $batchName,
                            'follow_me_enabled' => $followMeEnabled
                            )));
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Account Creation: " . $accountName . " Error!", "We have faced an issue in Customer Account Creation on telinta. this is the error for cusotmer with  id: " . $customer->getId() . " and on Account" . $accountName . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            
            return false;
        }

        $telintaAccount = new TelintaAccounts();
        $telintaAccount->setAccountTitle($accountName);
        $telintaAccount->setParentId($customer->getId());
        $telintaAccount->setParentTable("customer");
        $telintaAccount->setICustomer($customer->getICustomer());
        $telintaAccount->setIAccount($account->i_account);
        $telintaAccount->save();
        return true;
    }

    private function makeTransaction(Customer $customer, $action, $amount) {
        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
        
        try {
            $accounts = $pb->make_transaction(array(
                        'i_customer' => $customer->getICustomer(),
                        'action' => $action, //Manual payment, Manual charge
                        'amount' => $amount,
                        'visible_comment' => 'charge by SOAP ' . $action
                    ));
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Customer Transcation: " . $customer->getId() . " Error!", "We have faced an issue with Customer while making transaction " . $action . " this is the error for cusotmer with  Customer ID: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            
            return false;
        }
        
        return true;
    }

    public function getCustomerInfo($icustomer){
        $pb = new PortaBillingSoapClient($this->telintaSOAPUrl, 'Admin', 'Customer');
        
        try {
        $customerInfo = $pb->get_customer_info(array('i_customer'=>$icustomer));
         } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Customer Info: " . $icustomer . " Error!", "We have faced an issue with Customer while fecthing info error for cusotmer with  iCustomer: " . $icustomer . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            
            return false;
        }
        
        return $customerInfo;
    }

}

?>
