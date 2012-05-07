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


    private static $iParent = 74169;                //Company Resller ID on Telinta
    private static $currency = 'EUR';
    private static $a_iProduct = 10897;
    private static $CBProduct = '';
    private static $VoipProduct = '';
    public static $telintaSOAPUrl = "https://mybilling.telinta.com";
    public static $telintaSOAPUser = 'API_login';
    public static $telintaSOAPPassword = 'ee4eriny';

    public static function telintaRegisterCompany(Company $company) {

        $tCustomer = false;
        $max_retries = 5;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Customer');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        $uniqueid = "MTB2B" . $company->getVatNo();
         while (!$tCustomer && $retry_count < $max_retries) {
            try {
                $tCustomer = $pb->add_customer(array('customer_info' => array(
                                'name' => $uniqueid, //75583 03344090514
                                'iso_4217' => self::$currency,
                                'i_parent' => self::$iParent,
                                'i_customer_type' => 1,
                                'opening_balance' => 0,
                                'credit_limit' => 25,
                                'dialing_rules' => array('ip' => '00', "cc" => "34"),
                                'email' => 'okh@zapna.com'
                                )));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Error in Company Registration", "We have faced an issue in Company registration on telinta. this is the error for cusotmer with  id: " . $company->getVatNo() . " and error is " . $e->faultstring . "  <br/> Please Investigate.");
                    $pb->_logout($session);
                    return false;
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Error in Company Registration", "We have faced an issue in Company registration on telinta. Error is Even After Max Retries".$max_retries."  <br/> Please Investigate.");
            return false;
        }
            $company->setICustomer($tCustomer->i_customer);
            //$company->save();
            $pb->_logout($session);
            return true;
        
    }

    public static function telintaRegisterEmployee($employeMobileNumber, Company $company, Employee $employee) {
        return self::createAccount($company, $employeMobileNumber, '', $employee);
    }

    public static function terminateAccount(TelintaAccounts $telintaAccount) {
        $account = false;
        $max_retries = 5;
        $retry_count = 0;

        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Account');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        while (!$account && $retry_count < $max_retries) {
            try {
                $account = $pb->terminate_account(array('i_account' => $telintaAccount->getIAccount()));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Account Deletion: " . $telintaAccount->getIAccount() . " Error!", "We have faced an issue in Company Account Deletion on telinta. this is the error for cusotmer with  id: " . $telintaAccount->getIAccount() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
                    $pb->_logout($session);
                    return false;
                }
             }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Account Deletion: " . $telintaAccount->getIAccount() . " Error!", "We have faced an issue in Company Account Deletion on telinta. Error is Even After Max Retries".$max_retries."  <br/> Please Investigate.");
            return false;
        }

            $telintaAccount->setStatus(5);
            $telintaAccount->save();
            $pb->_logout($session);
            return true;
       
    }

    public static function getBalance(Company $company) {
        $cInfo = false;
        $max_retries = 5;
        $retry_count = 0;
        
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Customer');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        while (!$cInfo && $retry_count < $max_retries) {
            try {
                $cInfo = $pb->get_customer_info(array(
                            'i_customer' => $company->getICustomer(),
                        ));
                
                $pb->_logout($session);
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Company Balance Fetching: " . $company->getId() . " Error!", "We have faced an issue in Company Account Balance Fetch on telinta. this is the error for cusotmer with  Uniqueid: " . $company->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
                    $pb->_logout($session);
                    return false;
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Company Balance Fetching: " . $company->getId() . " Error!", "We have faced an issue in Company Account Balance Fetch on telinta. Error is Even After Max Retries".$max_retries."  <br/> Please Investigate.");
            return false;
        }
            $pb->_logout($session);
            $Balance = $cInfo->customer_info->balance;
            if ($Balance == 0)
                return $Balance;
            else
                return -1 * $Balance;
        
    }

    public static function charge(Company $company, $amount) {
        return self::makeTransaction($company, "Manual charge", $amount);
    }

    public static function recharge(Company $company, $amount, $transaction='') {
        if (self::makeTransaction($company, "Manual payment", $amount)) {
            //emailLib::sendCompanyRefillEmail($company, $transaction);
            return true;
        } else {
            return false;
        }
    }

    public static function callHistory(Company $company, $fromDate, $toDate) {
        $xdrList = false;
        $max_retries = 5;
        $retry_count = 0;
        
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Customer');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        while (!$xdrList && $retry_count < $max_retries) {
            try {
                $xdrList = $pb->get_customer_xdr_list(array('i_customer' => $company->getICustomer(), 'from_date' => $fromDate, 'to_date' => $toDate));
            } catch (SoapFault $e) {
                 if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Company Call History: " . $company->getId() . " Error!", "We have faced an issue with Company while Fetching Call History  this is the error for cusotmer with  Company ID: " . $company->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
                    $pb->_logout($session);
                 }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Company Call History: " . $company->getId() . " Error!", "We have faced an issue with Company while Fetching Call History on telinta. Error is Even After Max Retries".$max_retries."  <br/> Please Investigate.");
            return false;
        }
            $pb->_logout($session);
            return $xdrList;
       
    }

    public static function getAccountInfo($iAccount) {
        $aInfo = false;
        $max_retries = 5;
        $retry_count = 0;
        
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Account');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        while (!$aInfo && $retry_count < $max_retries) {
            try {
                $aInfo = $pb->get_account_info(array(
                            'i_account' => $iAccount,
                        ));
                $pb->_logout($session);
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Employee Account info Fetching:  Error!", "We have faced an issue in Employee Account Info Fetch on telinta. this is the error for Employee with  account: " . $iAccount . " error is " . $e->faultstring . "  <br/> Please Investigate.");
                    $pb->_logout($session);
                    return false;
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Employee Account info Fetching:  Error!", "We have faced an issue in Employee Account Info Fetch on telinta. Error is Even After Max Retries".$max_retries."  <br/> Please Investigate.");
            return false;
        }
            $pb->_logout($session);
            return $aInfo;
       
    }

    public static function getAccountCallHistory($iAccount, $fromDate, $toDate) {
        $xdrList = false;
        $max_retries = 5;
        $retry_count = 0;
        
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Account');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        while (!$xdrList && $retry_count < $max_retries) {
            try {
                $xdrList = $pb->get_xdr_list(array('i_account' => $iAccount, 'from_date' => $fromDate, 'to_date' => $toDate));
            } catch (SoapFault $e) {
               if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Employee Call History: " . $iAccount . " Error!", "We have faced an issue with Employee while Fetching Call History  this is the error for cusotmer with ID: " . $iAccount . " error is " . $e->faultstring . "  <br/> Please Investigate.");
                    $pb->_logout($session);
               }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Employee Call History: " . $iAccount . " Error!", "We have faced an issue with Employee while Fetching Call History on telinta. Error is Even After Max Retries".$max_retries."  <br/> Please Investigate.");
            return false;
        }
            $pb->_logout($session);
            return $xdrList;
        
    }

    // Private Area:
    //2039
    private static function createAccount(Company $company, $mobileNumber, $accountType, Employee $employee, $followMeEnabled='N') {
        $account = false;
        $max_retries = 5;
        $retry_count = 0;
        
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Account');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        $pass = self::randomAlphabets(4) . self::randomNumbers(1) . self::randomAlphabets(3);
        $accountName = $accountType . $mobileNumber;
        while (!$account && $retry_count < $max_retries) {
            try {
                
                $account = $pb->add_account(array('account_info' => array(
                                'i_customer' => $company->getICustomer(),
                                'name' => $accountName, //75583 03344090514
                                'id' => $accountName,
                                'iso_4217' => self::$currency,
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
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Account Creation: " . $accountName . " Error!", "We have faced an issue in Company Account Creation on telinta. this is the error for cusotmer with  id: " . $company->getId() . " and on Account" . $accountName . " error is " . $e->faultstring . "  <br/> Please Investigate.");
                    $pb->_logout($session);
                    return false;
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Account Creation: " . $accountName . " Error!", "We have faced an issue in Company Account Creation on telinta. Error is Even After Max Retries".$max_retries."  <br/> Please Investigate.");
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

    private static function makeTransaction(Company $company, $action, $amount) {
        $accounts = false;
        $max_retries = 5;
        $retry_count = 0;
        
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Customer');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        while (!$accounts && $retry_count < $max_retries) {
            try {
                $accounts = $pb->make_transaction(array(
                            'i_customer' => $company->getICustomer(),
                            'action' => $action, //Manual payment, Manual charge
                            'amount' => $amount,
                            'visible_comment' => 'charge by SOAP ' . $action
                        ));
            } catch (SoapFault $e) {
                 if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Customer Transcation: " . $company->getId() . " Error!", "We have faced an issue with Customer while making transaction " . $action . " this is the error for cusotmer with  Customer ID: " . $company->getId() . " error is " . $e->faultstring . "  <br/> Please Investigate.");
                    $pb->_logout($session);
                    return false;
                 }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Customer Transcation: " . $company->getId() . " Error!", "We have faced an issue with Customer while making transaction on telinta. Error is Even After Max Retries".$max_retries."  <br/> Please Investigate.");
            return false;
        }
            $pb->_logout($session);
            return true;
        
    }

    private static function randomAlphabets($length) {
        $random = "";
        srand((double) microtime() * 1000000);
        $data = "abcdefghijklmnopqrstuvwxyz";
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $random;
    }

    private static function randomNumbers($length) {
        $random = "";
        srand((double) microtime() * 1000000);
        $data = "0123456789";
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $random;
    }

    public static function updateAccount(Employee $employee, $iProduct, $iRoutingPlan, $block='N') {
        $account = false;
        $max_retries = 5;
        $retry_count = 0;
        
        $accountTitle = sfConfig::get("app_telinta_emp") . $employee->getCompanyId() . $employee->getId();
        $til = new Criteria();
        $til->add(TelintaAccountsPeer::ACCOUNT_TITLE, $accountTitle);
        $til->addAnd(TelintaAccountsPeer::STATUS, 3);
        $tilentaAccount = TelintaAccountsPeer::doSelectOne($til);
     
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Account');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        $pass = self::randomAlphabets(4) . self::randomNumbers(1) . self::randomAlphabets(3);
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
                if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Account Update: " . $accountTitle . " Error!", "We have faced an issue in Company Account updation on telinta. this is the error for cusotmer with  id: " . $employee->getCompanyId() . " and on Account" . $accountTitle . " error is " . $e->faultstring . "  <br/> Please Investigate.");
                    $pb->_logout($session);
                    return false;
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Account Update: " . $accountTitle . " Error!", "We have faced an issue in Company Account updation on telinta. Error is Even After Max Retries".$max_retries."  <br/> Please Investigate.");
            return false;
        }
            return true;
       
    }

    public static function updateCustomer($update_customer_request){
        $customer = false;
        $max_retries = 5;
        $retry_count = 0;
        
        $pb = new PortaBillingSoapClient(self::$telintaSOAPUrl, 'Admin', 'Customer');
        $session = $pb->_login(self::$telintaSOAPUser, self::$telintaSOAPPassword);
        while (!$customer && $retry_count < $max_retries) {
            try {
                $customer = $pb->update_customer(array('customer_info' => $update_customer_request));
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Customer Update: " . $update_customer_request["i_customer"] . " Error!", "We have faced an issue in Company updation on telinta. this is the error for comapny with  icustomer: " . $update_customer_request["i_customer"] . " error is " . $e->faultstring . "  <br/> Please Investigate.");
                    $pb->_logout($session);
                    return false;
                }
            }
            sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Customer Update: " . $update_customer_request["i_customer"] . " Error!", "We have faced an issue in Company updation on telinta. Error is Even After Max Retries".$max_retries."  <br/> Please Investigate.");
            return false;
        }
       
    }

}

?>
