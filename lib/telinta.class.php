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

    private static $customerReseller = "R_Partner_WLS2";
    private static $iParent = 72668;                //Customer Resller ID on Telinta
    private static $companyReseller = '';
    private static $currency = 'EUR';
    private static $AProduct = 'WLS2_CT';
    private static $a_iProduct = 10727;
    private static $CBProduct = '';
    private static $VoipProduct = '';
    private static $telintaSOAPUrl = "https://mybilling.telinta.com";
    private static $telintaSOAPUser = 'API_login';
    private static $telintaSOAPPassword = 'ee4eriny';

    public static function ResgiterCustomer(Customer $customer, $OpeningBalance) {
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Customer');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        $uniqueid="MTB2C".$customer->getUniqueid();
        try {
            $tCustomer = $pb->add_customer(array('customer_info' => array(
                            'name' => $uniqueid, //75583 03344090514
                            'iso_4217' => self::$currency,
                            'i_parent' => self::$iParent,
                            'i_customer_type' => 1,
                            'opening_balance' => -($OpeningBalance),
                            'credit_limit' => 0,
                            'dialing_rules' => array('ip' => '00'),
                            'email' => 'okh@zapna.com'
                            )));
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Error in Customer Registration", "We have faced an issue in Customer registration on telinta. this is the error for cusotmer with  id: " . $customer->getId() . " and error is " . $e->faultstring . "  <br/> Please Investigate.");
            $pb->_logout();
            return false;
        }
        $customer->setICustomer($tCustomer->i_customer);
        $customer->save();
        $pb->_logout();
        return true;
    }

    public static function createAAccount($mobileNumber, Customer $customer) {
        return self::createAccount($customer, $mobileNumber, 'a', self::$a_iProduct);
    }

    public static function createCBount($mobileNumber, Customer $customer) {
        return self::createAccount($customer, $mobileNumber, 'cb', self::$b_iProduct);
    }

    public static function terminateAccount(TelintaAccounts $telintaAccount) {
        try {
            $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Account');
            $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
            $account = $pb->terminate_account(array('i_account' => $telintaAccount->getIAccount()));
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Account Deletion: " . $accountName . " Error!", "We have faced an issue in Customer Account Deletion on telinta. this is the error for cusotmer with  id: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            $pb->_logout();
            return false;
        }
        $pb->_logout();
        $telintaAccount->setStatus(5);
        $telintaAccount->save();
        return true;
    }

    public static function getBalance(Customer $customer) {


        try {
            $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Customer');
            $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);

            $cInfo = $pb->get_customer_info(array(
                        'i_customer' => $customer->getICustomer(),
                    ));
            $Balance = $cInfo->customer_info->balance;
            $pb->_logout();
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Customer Balance Fetching: " . $customer->getId() . " Error!", "We have faced an issue in Customer Account Balance Fetch on telinta. this is the error for cusotmer with  Uniqueid: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            $pb->_logout();
            return false;
        }
        $pb->_logout();
        if ($Balance == 0)
            return $Balance;
        else
            return -1 * $Balance;
    }

    public static function charge(Customer $customer, $amount) {
        return self::makeTransaction($customer, "Manual charge", $amount);
    }

    public static function recharge(Customer $customer, $amount) {
        return self::makeTransaction($customer, "Manual payment", $amount);
    }

    public static function callHistory(Customer $customer, $fromDate, $toDate) {
         $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Customer');
            $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        try {
            $xdrList = $pb->get_customer_xdr_list(array('i_customer' => $customer->getICustomer(),'from_date'=>$fromDate,'to_date'=>$toDate));
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Customer Call History: " . $customer->getId() . " Error!", "We have faced an issue with Customer while Fetching Call History  this is the error for cusotmer with  Customer ID: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            $pb->_logout();
        }
        $pb->_logout();
        return $xdrList;
    }

    public static function deactivateFollowMeNumber($VOIPNumber, $CurrentActiveNumber) {

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

    public static function createReseNumberAccount($VOIPNumber, $uniqueId, $currentActiveNumber) {

        $url = "https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name=" . $VOIPNumber . "&customer=" . $uniqueId . "&opening_balance=0&credit_limit=&product=" . self::$VoipProduct . "&outgoing_default_r_r=2034&activate_follow_me=Yes&follow_me_number=" . $currentActiveNumber . "&billing_model=1&password=asdf1asd";
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

    private static function createAccount(Customer $customer, $mobileNumber, $accountType, $iProduct, $followMeEnabled='N') {

        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Account');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);

        try {
            $accountName = $accountType . $mobileNumber;
            $account = $pb->add_account(array('account_info' => array(
                            'i_customer' => $customer->getICustomer(),
                            'name' => $accountName, //75583 03344090514
                            'id' => $accountName,
                            'iso_4217' => self::$currency,
                            'opening_balance' => 0,
                            'credit_limit' => null,
                            'i_product' => $iProduct,
                            'i_routing_plan' => 2039,
                            'billing_model' => 1,
                            'password' => 'asdf1asd',
                            'h323_password' => 'asdf1asd',
                            'activation_date' => date('Y-m-d'),
                            'batch_name' => $customer->getUniqueid(),
                            'follow_me_enabled' => $followMeEnabled
                            )));
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Account Creation: " . $accountName . " Error!", "We have faced an issue in Customer Account Creation on telinta. this is the error for cusotmer with  id: " . $customer->getId() . " and on Account" . $accountName . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            $pb->_logout();
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

    private static function makeTransaction(Customer $customer, $action, $amount) {
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Customer');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        try {
            $accounts = $pb->make_transaction(array(
                        'i_customer' => $customer->getICustomer(),
                        'action' => $action, //Manual payment, Manual charge
                        'amount' => $amount,
                        'visible_comment' => 'charge by SOAP ' . $action
                    ));
        } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Customer Transcation: " . $customer->getId() . " Error!", "We have faced an issue with Customer while making transaction " . $action . " this is the error for cusotmer with  Customer ID: " . $customer->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            $pb->_logout();
            return false;
        }
        $pb->_logout();
        return true;
    }

    public static function getCustomerInfo($icustomer){
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Customer');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        try {
        $customerInfo = $pb->get_customer_info(array('i_customer'=>$icustomer));
         } catch (SoapFault $e) {
            emailLib::sendErrorInTelinta("Customer Info: " . $icustomer . " Error!", "We have faced an issue with Customer while fecthing info error for cusotmer with  iCustomer: " . $icustomer . " error is " . $e->faultstring . "  <br/> Please Investigate.");
            $pb->_logout();
            return false;
        }
        $pb->_logout();
        return $customerInfo;
    }

}

?>
