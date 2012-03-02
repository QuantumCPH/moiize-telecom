<?php
require_once(sfConfig::get('sf_lib_dir') . '/changeLanguageCulture.php');

class emailLib {

    public static function sendAgentRefilEmail(AgentCompany $agent, $agent_order) {
        $vat = 0;

        //create transaction
        //This Section For Get The Agent Information
        $agent_company_id = $agent->getId();
        if ($agent_company_id != '') {
            $c = new Criteria();
            $c->add(AgentCompanyPeer::ID, $agent_company_id);
            $recepient_agent_email = AgentCompanyPeer::doSelectOne($c)->getEmail();
            $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
        } else {
            $recepient_agent_email = '';
            $recepient_agent_name = '';
        }

        //$this->renderPartial('affiliate/order_receipt', array(
        $agentamount = $agent_order->getAmount();
        $createddate = $agent_order->getCreatedAt('m-d-Y');
        $agentid = $agent_order->getAgentOrderId();
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $message_body = get_partial('affiliate/agent_order_receipt', array(
                    'order' => $agentid,
                    'transaction' => $agentamount,
                    'createddate' => $createddate,
                    'vat' => $vat,
                    'agent_name' => $recepient_agent_name,
                    'wrap' => false,
                    'agent' => $agent
                ));


        $subject = __('Agent Payment Confirmation');


        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_emailcdu = sfConfig::get('app_email_sender_email_cdu', 'rs@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_namecdu = sfConfig::get('app_email_sender_name_cdu', 'WLS 2');

        //------------------Sent The Email To Customer
        //----------------------------------------
        //------------------Sent the Email To Agent
        if (trim($recepient_agent_email) != ''):

            $email2 = new EmailQueue();
            $email2->setSubject($subject);
            $email2->setReceipientName($recepient_agent_name);
            $email2->setReceipientEmail($recepient_agent_email);
            $email2->setAgentId($agent_company_id);
            $email2->setEmailType('WLS 2 refill via agent');
            $email2->setMessage($message_body);

            $email2->save();
        endif;
        //---------------------------------------
        //--------------Sent The Email To okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($agent_company_id);
            $email3->setEmailType('WLS 2 refill via agent');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To cdu
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($agent_company_id);
            $email4->setEmailType('WLS 2 refill via agent');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendRefillEmail(Customer $customer, $order) {
        $vat = 0;

        //create transaction
//        $transaction = new Transaction();
//        $transaction->setOrderId($order->getId());
//        $transaction->setCustomer($customer);
//        $transaction->setAmount($order->getExtraRefill());


        $tc = new Criteria();
        $tc->add(TransactionPeer::CUSTOMER_ID, $customer->getId());
        $tc->addDescendingOrderByColumn(TransactionPeer::CREATED_AT);
        $transaction = TransactionPeer::doSelectOne($tc);

        //This Section For Get The Agent Information
        $agent_company_id = $customer->getReferrerId();
        if ($agent_company_id != '') {
            $c = new Criteria();
            $c->add(AgentCompanyPeer::ID, $agent_company_id);
            $recepient_agent_email = AgentCompanyPeer::doSelectOne($c)->getEmail();
            $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
        } else {
            $recepient_agent_email = '';
            $recepient_agent_name = '';
        }
        //$this->renderPartial('affiliate/order_receipt', array(
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $message_body = get_partial('affiliate/refill_order_receipt', array(
                    'customer' => $customer,
                    'order' => $order,
                    'transaction' => $transaction,
                    'vat' => $vat,
                    'agent_name' => $recepient_agent_name,
                    'wrap' => false,
                ));

        $subject = __('Payment Confirmation');
        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());

        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_emailcdu = sfConfig::get('app_email_sender_email_cdu', 'rs@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_namecdu = sfConfig::get('app_email_sender_name_cdu', 'WLS 2');

        //------------------Sent The Email To Customer
        if (trim($recepient_email) != '') {
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setReceipientName($recepient_name);
            $email->setReceipientEmail($recepient_email);
            $email->setAgentId($agent_company_id);
            $email->setCutomerId($customer_id);
            $email->setEmailType('WLS 2 refill via agent');
            $email->setMessage($message_body);
            $email->save();
        }
        //----------------------------------------
        //------------------Sent the Email To Agent
        if (trim($recepient_agent_email) != ''):

            $email2 = new EmailQueue();
            $email2->setSubject($subject);
            $email2->setReceipientName($recepient_agent_name);
            $email2->setReceipientEmail($recepient_agent_email);
            $email2->setAgentId($agent_company_id);
            $email2->setCutomerId($customer_id);
            $email2->setEmailType('WLS 2 refill via agent');
            $email2->setMessage($message_body);

            $email2->save();
        endif;
        //---------------------------------------
        //--------------Sent The Email To okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($agent_company_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('WLS 2 refill via agent');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To cdu
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($agent_company_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('WLS 2 refill via agent');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendCustomerRegistrationViaAgentEmail(Customer $customer, $order) {


        $tc = new Criteria();
        $tc->add(TransactionPeer::CUSTOMER_ID, $customer->getId());
        $tc->addDescendingOrderByColumn(TransactionPeer::CREATED_AT);
        $transaction = TransactionPeer::doSelectOne($tc);


        //This Section For Get The Agent Information
        $agent_company_id = $customer->getReferrerId();
        if ($agent_company_id != '') {
            $c = new Criteria();
            $c->add(AgentCompanyPeer::ID, $agent_company_id);
            $recepient_agent_email = AgentCompanyPeer::doSelectOne($c)->getEmail();
            $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
        } else {
            $recepient_agent_email = '';
            $recepient_agent_name = '';
        }
        $vat = $order->getProduct()->getRegistrationFee() * .25;
        //$this->renderPartial('affiliate/order_receipt', array(
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $message_body = get_partial('affiliate/order_receipt', array(
                    'customer' => $customer,
                    'order' => $order,
                    'transaction' => $transaction,
                    'vat' => $vat,
                    'agent_name' => $recepient_agent_name,
                    'wrap' => false,
                ));

        $subject = __('Payment Confirmation');
        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());

        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_emailcdu = sfConfig::get('app_email_sender_email_cdu', 'rs@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_namecdu = sfConfig::get('app_email_sender_name_cdu', 'WLS 2');

        //------------------Sent The Email To Customer
        if (trim($recepient_email) != '') {
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setReceipientName($recepient_name);
            $email->setReceipientEmail($recepient_email);
            $email->setAgentId($agent_company_id);
            $email->setCutomerId($customer_id);
            $email->setEmailType('WLS 2 Customer registration via agent');
            $email->setMessage($message_body);
            $email->save();
        }
        //----------------------------------------
        //------------------Sent the Email To Agent
        if (trim($recepient_agent_email) != ''):

            $email2 = new EmailQueue();
            $email2->setSubject($subject);
            $email2->setReceipientName($recepient_agent_name);
            $email2->setReceipientEmail($recepient_agent_email);
            $email2->setAgentId($agent_company_id);
            $email2->setCutomerId($customer_id);
            $email2->setEmailType('WLS 2 Customer registration via agent');
            $email2->setMessage($message_body);

            $email2->save();
        endif;
        //---------------------------------------
        //--------------Sent The Email To Okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($agent_company_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('WLS 2 Customer registration via agent');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To CDU
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($agent_company_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('WLS 2 Customer registration via agent');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendForgetPasswordEmail(Customer $customer, $message_body, $subject) {
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');

        // $subject = __("Request for password");
        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());
        $referrer_id = trim($customer->getReferrerId());

        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'support@WLS 2.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2 support');

        //------------------Sent The Email To Customer
        if (trim($recepient_email) != '') {
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setReceipientName($recepient_name);
            $email->setReceipientEmail($recepient_email);
            $email->setCutomerId($customer_id);
            $email->setAgentId($referrer_id);
            $email->setEmailType('WLS 2 Forget Password');
            $email->setMessage($message_body);
            $email->save();
        }
        //----------------------------------------
    }

    public static function sendCustomerRefillEmail(Customer $customer, $order, $transaction) {

        //set vat
        $vat = 0;
        $subject = __('Payment Confirmation');
        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());
        $referrer_id = trim($customer->getReferrerId());

        if ($referrer_id != '') {
            $c = new Criteria();
            $c->add(AgentCompanyPeer::ID, $referrer_id);
            $recepient_agent_email = AgentCompanyPeer::doSelectOne($c)->getEmail();
            $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
        } else {
            $recepient_agent_email = '';
            $recepient_agent_name = '';
        }

        //$this->renderPartial('affiliate/order_receipt', array(
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $message_body = get_partial('payments/order_receipt', array(
                    'customer' => $customer,
                    'order' => $order,
                    'transaction' => $transaction,
                    'vat' => $vat,
                    'agent_name' => $recepient_agent_name,
                    'wrap' => false,
                ));


        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_emailcdu = sfConfig::get('app_email_sender_email', 'rs@zapna.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name', 'WLS 2');
        //------------------Sent The Email To Customer
        if (trim($recepient_email) != '') {
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setReceipientName($recepient_name);
            $email->setReceipientEmail($recepient_email);
            $email->setAgentId($referrer_id);
            $email->setCutomerId($customer_id);
            $email->setEmailType('WLS 2 Customer Registration');
            $email->setMessage($message_body);
            $email->save();
        }
        //----------------------------------------
        //------------------Sent the Email To Agent
        if (trim($recepient_agent_email) != ''):
            $email2 = new EmailQueue();
            $email2->setSubject($subject);
            $email2->setReceipientName($recepient_agent_name);
            $email2->setReceipientEmail($recepient_agent_email);
            $email2->setAgentId($referrer_id);
            $email2->setCutomerId($customer_id);
            $email2->setEmailType('WLS 2 Customer Registration');
            $email2->setMessage($message_body);
            $email2->save();
        endif;
        //---------------------------------------
        //--------------Sent The Email To okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($referrer_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('WLS 2 refill via agent');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To CDU
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($referrer_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('WLS 2 refill via agent');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendCustomerAutoRefillEmail(Customer $customer, $message_body) {

        $subject = __('Payment Confirmation');
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2 ');
        $sender_emailcdu = sfConfig::get('app_email_sender_email_cdu', 'rs@zapna.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name_cdu', 'WLS 2 ');

        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());
        $referrer_id = trim($customer->getReferrerId());

        //send to user
        if (trim($recepient_email) != ''):
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setMessage($message_body);
            $email->setReceipientEmail($recepient_email);
            $email->setReceipientName($recepient_name);
            $email->setCutomerId($customer_id);
            $email->setAgentId($referrer_id);
            $email->setEmailType('WLS 2 Customer Auto Refill');

            $email->save();
        endif;

        //send to OKHAN
        if (trim($sender_email) != ''):
            $email2 = new EmailQueue();
            $email2->setSubject($subject);
            $email2->setMessage($message_body);
            $email2->setReceipientEmail($sender_email);
            $email2->setReceipientName($sender_name);
            $email2->setCutomerId($customer_id);
            $email2->setAgentId($referrer_id);
            $email2->setEmailType('WLS 2 Customer Auto Refill');
            $email2->save();
        endif;
////////////////////////////////////////////////////////
        //send to CDU
        if (trim($sender_emailcdu) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setMessage($message_body);
            $email3->setReceipientEmail($sender_emailcdu);
            $email3->setReceipientName($sender_namecdu);
            $email3->setCutomerId($customer_id);
            $email3->setAgentId($referrer_id);
            $email3->setEmailType('WLS 2 Customer Auto Refill');
            $email3->save();
        endif;
    }

    public static function sendCustomerConfirmPaymentEmail(Customer $customer, $message_body) {


        $subject = __('Payment Confirmation');
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2 ');
        $sender_emailcdu = sfConfig::get('app_email_sender_email_cdu', 'rs@zapna.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name_cdu', 'WLS 2 ');

        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());
        $referrer_id = trim($customer->getReferrerId());


        //send to user
        if (trim($recepient_email) != ''):
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setMessage($message_body);
            $email->setReceipientEmail($recepient_email);
            $email->setReceipientName($recepient_name);
            $email->setCutomerId($customer_id);
            $email->setAgentId($referrer_id);
            $email->setEmailType('WLS 2 Customer Confirm Payment');

            $email->save();
        endif;

        //send to okhan
        if (trim($sender_email) != ''):
            $email2 = new EmailQueue();
            $email2->setSubject($subject);
            $email2->setMessage($message_body);
            $email2->setReceipientEmail($sender_email);
            $email2->setReceipientName($sender_name);
            $email2->setCutomerId($customer_id);
            $email2->setAgentId($referrer_id);
            $email2->setEmailType('WLS 2 Customer Confirm Payment');
            $email2->save();
        endif;
        //send to cdu
        if (trim($sender_emailcdu) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setMessage($message_body);
            $email3->setReceipientEmail($sender_emailcdu);
            $email3->setReceipientName($sender_namecdu);
            $email3->setCutomerId($customer_id);
            $email3->setAgentId($referrer_id);
            $email3->setEmailType('WLS 2 Customer Confirm Payment');
            $email3->save();
        endif;
    }

    public static function sendCustomerConfirmRegistrationEmail($inviteuserid, $customerr, $subject) {

        $c = new Criteria();
        $c->add(CustomerPeer::ID, $inviteuserid);
        $customer = CustomerPeer::doSelectOne($c);
        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());


        $subject = $subject;
        $subject = $subject;
        $sender_email = sfConfig::get('app_email_sender_email', 'support@wls.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2 support');
        $sender_emailcdu = sfConfig::get('app_email_sender_email_cdu', 'rs@zapna.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name_cdu', 'WLS 2 support');

        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $message_body = get_partial('pScripts/bonus_web_reg', array(
                    'customer' => $customerr,
                    'recepient_name' => $recepient_name,
                    'wrap' => true,
                ));
//        $message_body   ='
//Härmed bekräftas att du har fått provision insatt på ditt konto för att du har tipsat en vän om Smartsim från wls.
//Gå in på ”Mina sidor” och gå till ”Övrig historik” under ”Samtalshistorik” så ser du vad du har tjänat.<br/>Med vänlig hälsning,
//<br/>
//wls<br/>
//www.WLS2.zerocall.com';
        //$referrer_id        = trim($customer->getReferrerId());
        //send to user
        if ($recepient_email != ''):
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setMessage($message_body);
            $email->setReceipientEmail($recepient_email);
            $email->setReceipientName($recepient_name);
            $email->setCutomerId($customer_id);
            //$email->setAgentId($referrer_id);
            $email->setEmailType('WLS 2 Customer Confirm Bonus');

            $email->save();
        endif;

        //send to okhan
        if ($sender_email != ''):
            $email2 = new EmailQueue();
            $email2->setSubject($subject);
            $email2->setMessage($message_body);
            $email2->setReceipientEmail($sender_email);
            $email2->setReceipientName($sender_name);
            $email2->setCutomerId($customer_id);
            //$email2->setAgentId($referrer_id);
            $email2->setEmailType('WLS 2 Customer Confirm Bonus');
            $email2->save();
        endif;
        //////////////////////////////////////////////////////////////////
        if ($sender_emailcdu != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setMessage($message_body);
            $email3->setReceipientName($sender_namecdu);
            $email3->setReceipientEmail($sender_emailcdu);
            $email3->setCutomerId($customer_id);
            //$email3->setAgentId($referrer_id);
            $email3->setEmailType('WLS 2 Customer Confirm Bonus');
            $email3->save();
        endif;
    }

//////////////////////////////////////////////////////////////

    public static function sendCustomerRegistrationViaWebEmail(Customer $customer, $order) {


        $tc = new Criteria();
        $tc->add(TransactionPeer::CUSTOMER_ID, $customer->getId());
        $tc->addDescendingOrderByColumn(TransactionPeer::CREATED_AT);
        $transaction = TransactionPeer::doSelectOne($tc);


        //This Section For Get The Agent Information
        $agent_company_id = $customer->getReferrerId();
        if ($agent_company_id != '') {
            $c = new Criteria();
            $c->add(AgentCompanyPeer::ID, $agent_company_id);
            $recepient_agent_email = AgentCompanyPeer::doSelectOne($c)->getEmail();
            $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
        } else {
            $recepient_agent_email = '';
            $recepient_agent_name = '';
        }

        $lang = 'de';
        // $this->lang = $lang;

        $countrylng = new Criteria();
        $countrylng->add(EnableCountryPeer::LANGUAGE_SYMBOL, $lang);
        $countrylng = EnableCountryPeer::doSelectOne($countrylng);
        if ($countrylng) {
            $countryName = $countrylng->getName();
            $languageSymbol = $countrylng->getLanguageSymbol();
            $lngId = $countrylng->getId();

            $postalcharges = new Criteria();
            $postalcharges->add(PostalChargesPeer::COUNTRY, $lngId);
            $postalcharges->add(PostalChargesPeer::STATUS, 1);
            $postalcharges = PostalChargesPeer::doSelectOne($postalcharges);
            if ($postalcharges) {
                $postalcharge = $postalcharges->getCharges();
            } else {
                $postalcharge = '';
            }
        }

        $vat = ($order->getProduct()->getRegistrationFee() + $postalcharge) * .25;

        //$this->renderPartial('affiliate/order_receipt', array(
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $message_body = get_partial('pScripts/order_receipt_web_reg', array(
                    'customer' => $customer,
                    'order' => $order,
                    'transaction' => $transaction,
                    'vat' => $vat,
                    'agent_name' => $recepient_agent_name,
                    'postalcharge' => $postalcharge,
                    'wrap' => true,
                ));


        $subject = __('Registration Confirmation');
        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());

        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2 ');
        $sender_emailcdu = sfConfig::get('app_email_sender_email_cdu', 'rs@zapna.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name_cdu', 'WLS 2 ');

        //------------------Sent The Email To Customer
        if ($recepient_email != '') {
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setReceipientName($recepient_name);
            $email->setReceipientEmail($recepient_email);
            $email->setCutomerId($customer_id);
            $email->setEmailType('WLS 2 Customer registration via link');
            $email->setMessage($message_body);
            $email->save();
        }
        //----------------------------------------
        //------------------Sent the Email To Agent
        //--------------Sent The Email To Support
        if ($sender_email != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('WLS 2 Customer registration via link');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To Support
        if ($sender_emailcdu != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('WLS 2 Customer registration via link');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    ///////////////////////////////////////////////////////////

    public static function sendCustomerRegistrationViaAgentSMSEmail(Customer $customer, $order) {


        $tc = new Criteria();
        $tc->add(TransactionPeer::CUSTOMER_ID, $customer->getId());
        $tc->addDescendingOrderByColumn(TransactionPeer::CREATED_AT);
        $transaction = TransactionPeer::doSelectOne($tc);
        //This Section For Get The Agent Information
        $agent_company_id = $customer->getReferrerId();
        if ($agent_company_id != '') {
            $c = new Criteria();
            $c->add(AgentCompanyPeer::ID, $agent_company_id);
            $recepient_agent_email = AgentCompanyPeer::doSelectOne($c)->getEmail();
            $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
        } else {
            $recepient_agent_email = '';
            $recepient_agent_name = '';
        }
        $vat = ($order->getProduct()->getRegistrationFee()) * .25;
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $message_body = get_partial('pScripts/order_receipt_sms', array(
                    'customer' => $customer,
                    'order' => $order,
                    'transaction' => $transaction,
                    'vat' => $vat,
                    'agent_name' => $recepient_agent_name,
                    'wrap' => false,
                ));

        $subject = __('Registration  Confirmation');
        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());

        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_emailcdu = sfConfig::get('app_email_sender_email_cdu', 'rs@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_namecdu = sfConfig::get('app_email_sender_name_cdu', 'WLS 2');

        //------------------Sent The Email To Customer
        //------------------Sent the Email To Agent

        if (trim($recepient_agent_email) != ''):

            $email2 = new EmailQueue();
            $email2->setSubject($subject);
            $email2->setReceipientName($recepient_agent_name);
            $email2->setReceipientEmail($recepient_agent_email);
            $email2->setAgentId($agent_company_id);
            $email2->setCutomerId($customer_id);
            $email2->setEmailType('Customer registration via agent SMS ');
            $email2->setMessage($message_body);

            $email2->save();
        endif;
        //---------------------------------------
        //--------------Sent The Email To Okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($agent_company_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('Customer registration via agent SMS ');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To CDU
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($agent_company_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('Customer registration via agent SMS ');

            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendCustomerRegistrationViaAgentAPPEmail(Customer $customer, $order) {

        echo 'sending email';
        echo '<br/>';
        $product_price = $order->getProduct()->getPrice() - $order->getExtraRefill();
        echo $product_price;
        echo '<br/>';
        $vat = .20 * $product_price;
        echo $vat;
        echo '<br/>';

//        //create transaction
//        $transaction = new Transaction();
//        $transaction->setOrderId($order->getId());
//        $transaction->setCustomer($customer);
//        $transaction->setAmount($form['extra_refill']);

        $tc = new Criteria();
        $tc->add(TransactionPeer::CUSTOMER_ID, $customer->getId());
        $tc->addDescendingOrderByColumn(TransactionPeer::CREATED_AT);
        $transaction = TransactionPeer::doSelectOne($tc);


        //This Section For Get The Agent Information
        $agent_company_id = $customer->getReferrerId();
        if ($agent_company_id != '') {
            $c = new Criteria();
            $c->add(AgentCompanyPeer::ID, $agent_company_id);
            $recepient_agent_email = AgentCompanyPeer::doSelectOne($c)->getEmail();
            $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
        } else {
            $recepient_agent_email = '';
            $recepient_agent_name = '';
        }
        //$this->renderPartial('affiliate/order_receipt', array(
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $message_body = get_partial('pScripts/order_receipt_sms', array(
                    'customer' => $customer,
                    'order' => $order,
                    'transaction' => $transaction,
                    'vat' => $vat,
                    'agent_name' => $recepient_agent_name,
                    'wrap' => false,
                ));

        $subject = __('Registration Confirmation');
        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());

        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_emailcdu = sfConfig::get('app_email_sender_email_cdu', 'rs@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_namecdu = sfConfig::get('app_email_sender_name_cdu', 'WLS 2');

        //------------------Sent The Email To Customer
        if (trim($recepient_email) != '') {
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setReceipientName($recepient_name);
            $email->setReceipientEmail($recepient_email);
            $email->setAgentId($agent_company_id);
            $email->setCutomerId($customer_id);
            $email->setEmailType('WLS 2 Customer registration via APP');
            $email->setMessage($message_body);
            $email->save();
        }
        //----------------------------------------
        //------------------Sent the Email To Agent
        if (trim($recepient_agent_email) != ''):

            $email2 = new EmailQueue();
            $email2->setSubject($subject);
            $email2->setReceipientName($recepient_agent_name);
            $email2->setReceipientEmail($recepient_agent_email);
            $email2->setAgentId($agent_company_id);
            $email2->setCutomerId($customer_id);
            $email2->setEmailType('WLS 2 Customer registration via APP');
            $email2->setMessage($message_body);

            $email2->save();
        endif;
        //---------------------------------------
        //--------------Sent The Email To Okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($agent_company_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('WLS 2 Customer registration via APP');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To CDU
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($agent_company_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('WLS 2 Customer registration via APP');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendvoipemail(Customer $customer, $order, $transaction) {

        //set vat
        $vat = 0;
        $subject = 'Bekräftelse - nytt resenummer frän wls';
        $recepient_email = trim($customer->getEmail());
        $recepient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());
        $customer_id = trim($customer->getId());
        $referrer_id = trim($customer->getReferrerId());

        if ($referrer_id != '') {
            $c = new Criteria();
            $c->add(AgentCompanyPeer::ID, $referrer_id);
            $recepient_agent_email = AgentCompanyPeer::doSelectOne($c)->getEmail();
            $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
        } else {
            $recepient_agent_email = '';
            $recepient_agent_name = '';
        }

        //$this->renderPartial('affiliate/order_receipt', array(
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
//        $message_body = get_partial('payments/order_receipt', array(
//                'customer'=>$customer,
//                'order'=>$order,
//                'transaction'=>$transaction,
//                'vat'=>$vat,
//                'agent_name'=>$recepient_agent_name,
//                'wrap'=>false,
//        ));
        // Please remove the receipt that is sent out when activating
        $getvoipInfo = new Criteria();
        $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $customer->getId());
        $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo); //->getId();
        if (isset($getvoipInfos)) {
            $voipnumbers = $getvoipInfos->getNumber();
            $voip_customer = $getvoipInfos->getCustomerId();
        } else {
            $voipnumbers = '';
            $voip_customer = '';
        }



        $message_body = "<table width='600px'><tr style='border:0px solid #fff'><td colspan='4' align='right' style='text-align:right; border:0px solid #fff'>" . image_tag('https://wls2.zerocall.com/images/logo.gif') . "</tr></table><table cellspacing='0' width='600px'><tr><td>Grattis till ditt nya resenummer. Detta nummer är alltid kopplat till den telefon där du har Smartsim aktiverat. Med resenumret blir du nådd utomlands då du har ett lokalt SIM-kort. Se prislistan för hur mycket det kostar att ta emot samtal.
Ditt resenummer är $voipnumbers.<br/><br/>
Med vänlig hälsning<br/><br/>
WLS2<br/><a href='http://www.wls2.zerocall.com.com'>www.wls2.zerocall.com.com</a></td></tr></table>";

        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_emailcdu = sfConfig::get('app_email_sender_email', 'rs@zapna.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name', 'WLS 2');
        //------------------Sent The Email To Customer
        if (trim($recepient_email) != '') {
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setReceipientName($recepient_name);
            $email->setReceipientEmail($recepient_email);
            $email->setAgentId($referrer_id);
            $email->setCutomerId($customer_id);
            $email->setEmailType('Transation for VoIP Purchase');
            $email->setMessage($message_body);
            $email->save();
        }
        //----------------------------------------
        //------------------Sent the Email To Agent
        if (trim($recepient_agent_email) != ''):
//            $email2 = new EmailQueue();
//            $email2->setSubject($subject);
//            $email2->setReceipientName($recepient_agent_name);
//            $email2->setReceipientEmail($recepient_agent_email);
//            $email2->setAgentId($referrer_id);
//            $email2->setCutomerId($customer_id);
//            $email2->setEmailType('Transation for VoIP Purchase');
//            $email2->setMessage($message_body);
//            $email2->save();
        endif;
        //---------------------------------------
        //--------------Sent The Email To okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($referrer_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('Transation for VoIP Purchase');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To CDU
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($referrer_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('Transation for VoIP Purchase');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendCustomerBalanceEmail(Customer $customer, $message_body) {

        $subject = ' Balance Email ';
        $recepient_name = '';
        $recepient_email = '';

        $recepient_name = $customer->getFirstName() . ' ' . $customer->getLastName();
        $recepient_email = $customer->getEmail();
        $customer_id = trim($customer->getId());
        $referrer_id = trim($customer->getReferrerId());

        if (trim($recepient_email) != ''):
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setMessage($message_body);
            $email->setReceipientEmail($recepient_email);
            $email->setCutomerId($customer_id);
            $email->setAgentId($referrer_id);
            $email->setEmailType('wls Customer Balance');
            $email->setReceipientName($recepient_name);
            $email->save();
        endif;
    }

    public static function sendErrorTelinta(Customer $customer, $message) {

        $subject = 'Error In Telinta';
        //$this->renderPartial('affiliate/order_receipt', array(
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $message_body = "<table width='600px'><tr style='border:0px solid #fff'><td colspan='4' align='right' style='text-align:right; border:0px solid #fff'></tr></table><table cellspacing='0' width='600px'><tr><td>
             " . $message . " <br/><br/>
Med vänlig hälsning<br/><br/>
WLS2<br/><a href='http://www.wls2.zerocall.com.com'>www.wls2.zerocall.com.com</a></td></tr></table>";

        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_emailcdu = sfConfig::get('app_email_sender_email', 'rs@zapna.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name', 'WLS 2');


        //--------------Sent The Email To okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($referrer_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('Error In Telinta');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To CDU
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($referrer_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('Error In Telinta');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendUniqueIdsShortage() {

        $subject = 'Unique Ids finished.';
        $message_body = "<table width='600px'><tr style='border:0px solid #fff'><td colspan='4' align='right' style='text-align:right; border:0px solid #fff'></tr></table><table cellspacing='0' width='600px'><tr><td>
             " . $message . " <br/><br/>
Uniuqe Ids finsihed.<br/><br/>
WLS2<br/><a href='http://www.wls2.zerocall.com.com'>www.wls2.zerocall.com.com</a></td></tr></table>";

        //Support Informationt
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_emailcdu = sfConfig::get('app_email_sender_email', 'rs@zapna.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name', 'WLS 2');


        //--------------Sent The Email To okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($referrer_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('Unique Ids Finished');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To CDU
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($referrer_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('Unique Ids Finished');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendUniqueIdsIssueAgent($uniqueid, Customer $customer) {

        $subject = 'Unique Ids finished.';
        $message_body = "<table width='600px'><tr style='border:0px solid #fff'><td colspan='4' align='right' style='text-align:right; border:0px solid #fff'></tr></table><table cellspacing='0' width='600px'><tr><td>
             " . $message . " <br/><br/>
Uniuqe Id " . $uniqueid . " has issue while assigning on " . $customer->getMobileNumber() . "<br/><br/>
wls2<br/><a href='http://www.wls2.zerocall.com.com'>www.wls2.zerocall.com.com</a></td></tr></table>";

        //Support Informationt
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_emailcdu = sfConfig::get('app_email_sender_email', 'zerocallengineering@googlegroups.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name', 'WLS 2');


        //--------------Sent The Email To okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($referrer_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('Unique Ids Finished');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To CDU
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($referrer_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('Unique Ids Finished');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendUniqueIdsIssueSmsReg($uniqueid, Customer $customer) {

        $subject = 'Unique Ids finished.';
        $message_body = "<table width='600px'><tr style='border:0px solid #fff'><td colspan='4' align='right' style='text-align:right; border:0px solid #fff'></tr></table><table cellspacing='0' width='600px'><tr><td>
             " . $message . " <br/><br/>
Uniuqe Id " . $uniqueid . " has issue while assigning on " . $customer->getMobileNumber() . " in sms registration<br/><br/>
WLS2<br/><a href='http://www.wls2.zerocall.com'>www.wls2.zerocall.com</a></td></tr></table>";

        //Support Informationt
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_emailcdu = sfConfig::get('app_email_sender_email', 'zerocallengineering@googlegroups.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name', 'WLS 2');


        //--------------Sent The Email To okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($referrer_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('Unique Ids Finished');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To CDU
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($referrer_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('Unique Ids Finished');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

    public static function sendErrorInTelinta($subject, $message) {

        //To RS.
        $email = new EmailQueue();
        $email->setSubject($subject);
        $email->setReceipientName("Raheel Safdar");
        $email->setReceipientEmail("rs@zapna.com");
        $email->setEmailType('Telinta Error');
        $email->setMessage($message);
        $email->save();

        //To Support @ Zerocall
        $email = new EmailQueue();
        $email->setSubject($subject);
        $email->setReceipientName("Support");
        $email->setReceipientEmail("support@zerocall.com");
        $email->setEmailType('Telinta Error');
        $email->setMessage($message);
        $email->save();
    }

    public static function sendCompanyRefillEmail(Company $company, $transaction) {

        //set vat
        $vat = 0;

        $subject = 'Payment Confirmation';
        
        $recepient_email = trim($company->getEmail());
        $recepient_name = sprintf('%s', $company->getName());

        //$this->renderPartial('affiliate/order_receipt', array(
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $message_body = get_partial('company/refill_receipt', array(
                    'company' => $company,
                    'transaction' => $transaction,
                    'vat' => $vat,
                    'wrap' => false,
                ));


        //Support Information
        $sender_email = sfConfig::get('app_email_sender_email', 'okhan@zapna.com');
        $sender_name = sfConfig::get('app_email_sender_name', 'WLS 2');
        $sender_emailcdu = sfConfig::get('app_email_sender_email', 'rs@zapna.com');
        $sender_namecdu = sfConfig::get('app_email_sender_name', 'WLS 2');
        //------------------Sent The Email To Customer
        if (trim($recepient_email) != '') {
            $email = new EmailQueue();
            $email->setSubject($subject);
            $email->setReceipientName($recepient_name);
            $email->setReceipientEmail($recepient_email);
            $email->setAgentId($referrer_id);
            $email->setCutomerId($customer_id);
            $email->setEmailType('Company Refill');
            $email->setMessage($message_body);
            $email->save();
        }
        //----------------------------------------
        //------------------Sent the Email To Agent
        if (trim($recepient_agent_email) != ''):
            $email2 = new EmailQueue();
            $email2->setSubject($subject);
            $email2->setReceipientName($recepient_agent_name);
            $email2->setReceipientEmail($recepient_agent_email);
            $email2->setAgentId($referrer_id);
            $email2->setCutomerId($customer_id);
            $email2->setEmailType('Company Refill');
            $email2->setMessage($message_body);
            $email2->save();
        endif;
        //---------------------------------------
        //--------------Sent The Email To okhan
        if (trim($sender_email) != ''):
            $email3 = new EmailQueue();
            $email3->setSubject($subject);
            $email3->setReceipientName($sender_name);
            $email3->setReceipientEmail($sender_email);
            $email3->setAgentId($referrer_id);
            $email3->setCutomerId($customer_id);
            $email3->setEmailType('Company Refill');
            $email3->setMessage($message_body);
            $email3->save();
        endif;
        //-----------------------------------------
        //--------------Sent The Email To CDU
        if (trim($sender_emailcdu) != ''):
            $email4 = new EmailQueue();
            $email4->setSubject($subject);
            $email4->setReceipientName($sender_namecdu);
            $email4->setReceipientEmail($sender_emailcdu);
            $email4->setAgentId($referrer_id);
            $email4->setCutomerId($customer_id);
            $email4->setEmailType('WLS 2 refill via agent');
            $email4->setMessage($message_body);
            $email4->save();
        endif;
        //-----------------------------------------
    }

}

?>