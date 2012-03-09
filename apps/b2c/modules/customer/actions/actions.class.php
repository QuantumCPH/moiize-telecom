<?php

require_once(sfConfig::get('sf_lib_dir') . '/emailLib.php');
require_once(sfConfig::get('sf_lib_dir') . '/smsCharacterReplacement.php');
require_once(sfConfig::get('sf_lib_dir') . '/changeLanguageCulture.php');
require_once(sfConfig::get('sf_lib_dir') . '/parsecsv.lib.php');
require_once(sfConfig::get('sf_lib_dir') . '/telinta.class.php');

/**
 * customer actions.
 *
 * @package    zapnacrm
 * @subpackage customer
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.8 2010-09-19 22:20:12 orehman Exp $
 */
class customerActions extends sfActions {
  private function getTargetUrl() {
        return sfConfig::get('app_main_url');
    }


    


    public function executeTest(sfWebRequest $request) {

    }

    protected function processForm(sfWebRequest $request, sfForm $form, $id) {

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        

        $customer = $request->getParameter($form->getName());
        $product = $customer['product'];
        $plainPws = $customer["password"];
        $refVal = $customer["referrer_id"];


        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        if ($form->isValid()) {

            $customer = $form->save();
            $customer->setPlainText($plainPws);
            if (isset($refVal) && $refVal != '') {

                $customer->setRegistrationTypeId('3');
            } else {
                $customer->setRegistrationTypeId('1');
            }

            $mobile = "";
            $mobile = $customer->getMobileNumber();
            //$form->getMobileNumber();
            //$customer["mobile_number"];

            $sms_text = "";
            $number = $customer->getMobileNumber();
            $mtnumber = $customer->getMobileNumber();

            $numberlength = strlen($mobile);
            $endnumberlength = $numberlength - 2;
            $number = substr($number, 2, $endnumberlength);
            //$uniqueId  = $text;


            $uc = new Criteria();
            $uc->add(UniqueIdsPeer::REGISTRATION_TYPE_ID, 1);
            $uc->addAnd(UniqueIdsPeer::STATUS, 0);
            $availableUniqueCount = UniqueIdsPeer::doCount($uc);
            $availableUniqueId = UniqueIdsPeer::doSelectOne($uc);

            if($availableUniqueCount  == 0){
                // Unique Ids are not avaialable. Then Redirect to the sorry page and send email to the support.
                emailLib::sendUniqueIdsShortage();
                $this->redirect($this->getTargetUrl().'customer/shortUniqueIds');
            }
            $uniqueId = $availableUniqueId->getUniqueNumber();
            $customer->setUniqueid($uniqueId);
            $customer->save();
            $getFirstnumberofMobile = substr($mtnumber, 0, 1);     // bcdef
            if ($getFirstnumberofMobile == 0) {
                $TelintaMobile = substr($mtnumber, 1);
                $TelintaMobile = '46' . $TelintaMobile;
            } else {
                $TelintaMobile = '46' . $mtnumber;
            }
            //------save the callback data
            if ($id != NULL) {
                $invite = InvitePeer::retrieveByPK($id);
                if ($invite) {
                    $invite->setInviteNumber($customer->getMobileNumber());
                    $invite->save();
                }
            }
            $url=$this->getTargetUrl();
                        $this->redirect($url.'payments/signup?cid='.$customer->getId().'&pid='.$product);
            }
    }
     

    public function executeSignupStep2(sfWebRequest $request) {



        $callbackdibs = '';
        if ($request->getParameter('transact')) {
            $this->callbackdibs = 'yes';
        } else {
            //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11
            

            

            $this->form = new PaymentForm();
            $this->callbackdibs = 'Yes';
            $product_id = $request->getParameter('pid');
            $customer_id = $request->getParameter('cid');

            $this->getUser()->setAttribute('product_ids', $product_id);
            $this->getUser()->setAttribute('cusid', $customer_id);

            if ($product_id == '' || $customer_id == '') {
                $this->forward404('Product id not found in session');
            }

            $order = new CustomerOrder();
            $transaction = new Transaction();

            $order->setProductId($product_id);
            $order->setCustomerId($customer_id);
            $order->setExtraRefill($order->getProduct()->getInitialBalance());

            //$extra_refil_choices = ProductPeer::getRefillChoices();
            //TODO: restrict quantity to be 1
            $order->setQuantity(1);

            //$order->setExtraRefill($extra_refil_choices[0]);//minumum refill amount
            $order->setIsFirstOrder(1);

            $order->save();

            $transaction->setAmount($order->getProduct()->getPrice() - $order->getProduct()->getInitialBalance() + $order->getExtraRefill());
            //TODO: $transaction->setAmount($order->getProduct()->getPrice());
           // $this->getContext()->getI18N()->__('Registration and first product order')
            $transaction->setDescription('Registration');
            $transaction->setOrderId($order->getId());
            $transaction->setCustomerId($customer_id);
            //$transaction->setTransactionStatusId() // default value 1

            $transaction->save();

            $this->order = $order;
            $this->forward404Unless($this->order);

            $this->order_id = $order->getId();
            $this->amount = $transaction->getAmount();
        }
    }

  

    public function executeSignup(sfWebRequest $request) {


        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        


        $this->form = new CustomerFormB2C();
        $id = $request->getParameter('invite_id');
        $visitor_id = $request->getParameter('visitor');
        //$this->form->widgetSchema->setLabel('the_field_id', false);
        if ($visitor_id != NULL) {
            $c = new Criteria();
            $c->add(VisitorsPeer::ID, $request->getParameter('visitor'));
            $visitor = VisitorsPeer::doSelectOne($c);
            $status = $visitor->getStatus();
            $visitor->setStatus($status . "> B2C Signup Page ");
            $visitor->save();
        }

        if ($id != NULL) {
            $c = new Criteria();
            //$c->add(InvitePeer::ID,$id);
            //$c->add(InvitePeer::INVITE_STATUS,'2');
            $invite = InvitePeer::retrieveByPK($id);
            if ($invite) {
                $invite->setInviteStatus('2');
                $invite->save();
            }
        }

        //set referrer id
        if ($referrer_id = $request->getParameter('ref')) {
            $c = new Criteria();
            $c->add(AgentCompanyPeer::ID, $referrer_id);

            if (AgentCompanyPeer::doSelectOne($c))
                $this->form->setDefault('referrer_id', $referrer_id);
        }


        unset($this->form['manufacturer']);
        unset($this->form['device_id']);


        if ($request->isMethod('post')) {

            unset($this->form['imsi']);
            unset($this->form['uniqueid']);

            $this->processForm($request, $this->form, $id);
        }
    }

    public function executeGetmobilemodel(sfWebRequest $request) {

        if ($request->isXmlHttpRequest()) {
            // echo $request->getParameter('device_id').'pakistan';
            $device_id = (int) $request->getParameter('device_id');
            if ($device_id) {
                // Get The Mobile Model
                $Mobilemodel = new Criteria();
                $Mobilemodel->add(DevicePeer::MANUFACTURER_ID, $device_id);
                $mModel = DevicePeer::doSelect($Mobilemodel);
                //echo $mModel->getName();
                $output = '<option value=""></option>';
                foreach ($mModel as $mModels) {
                    echo $mModels->getName();
                    $output .= '<option value="' . $mModels->getId() . '">' . $mModels->getName() . '</option>';
                }
                return $this->renderText($output);
            }
        }
    }

    public function executeChangePassword(sfWebRequest $request) {
        //echo 'Request to support@landncall.com';
        //return sfView::NONE;
    }

    public function executeDashboard(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //-----------------------


        /*
          $referer = $request->getReferer();
          $referer = substr($referer, 0, stripos($referer, '?'));

          if($referer == $this->getController()->genUrl('@signup_step2', true) && $request->getParameter('customer_id') != ''){
          $this->getUser()->setAuthenticated(true);
          $this->getUser()->setAttribute('customer_id', $request->getParameter('customer_id'), 'usersession');

          } else if (!$this->getUser()->isAuthenticated()){
          $this->redirect('@b2c_homepage');
          }
         */

        $this->customer = CustomerPeer::retrieveByPK($this->getUser()->getAttribute('customer_id', '', 'usersession'));

        $this->redirectUnless($this->customer, "@homepage");

        $this->customer_balance = -1;

        $country_id = $this->customer->getCountryId();

        //This Section For Get the Language Symbol For Set Currency -
        $enableCountry = new Criteria();
        $enableCountry->add(EnableCountryPeer::ID, $country_id);
        $country_id = EnableCountryPeer::doSelectOne($enableCountry); //->getId();
        if ($country_id) {
            $langSym = $country_id->getLanguageSymbol();
        } else {
            $langSym = 'da';
        }
        //--------------------------------------------------------
        //$lang =  $this->getUser()->getAttribute('activelanguage');
        $lang = $langSym;
        $this->lang = $lang;

        //try to get balance again & again
        $num_tries = 3;

        for ($i = 0; ($i < 3) && $this->customer_balance == -1; $i++) {
            $this->customer_balance = (double) Fonet::getBalance($this->customer);
        }

        //echo  $TelintaMobile = '46'.$this->customer->getMobileNumber();
        $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0, 1);     // bcdef
        if ($getFirstnumberofMobile == 0) {
            $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
            $TelintaMobile = '49' . $TelintaMobile;
        } else {
            $TelintaMobile = '49' . $this->customer->getMobileNumber();
        }
        $emailId = $this->customer->getEmail();
        $uniqueId = $this->customer->getUniqueid();


        if ($uniqueId == '') {
            $message_body = "Uniqueid Is not assign Of this Mobile Number $TelintaMobile";
            //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
            emailLib::sendErrorTelinta($this->customer, $message_body);
        }
        //This is for Retrieve balance From Telinta
       // $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name=' . $uniqueId . '&type=customer');
  $telintaGetBalance=Telienta::getBalance($this->customer);
       

      
        $this->customer_balance = $telintaGetBalance;



        if ($this->customer_balance != null)
            $this->customer_balance = $this->customer_balance;
    }

    //This Function add Again new Feature Landncall --
    public function executeSubscribevoip(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //-----------------------


        /*
          $referer = $request->getReferer();
          $referer = substr($referer, 0, stripos($referer, '?'));

          if($referer == $this->getController()->genUrl('@signup_step2', true) && $request->getParameter('customer_id') != ''){
          $this->getUser()->setAuthenticated(true);
          $this->getUser()->setAttribute('customer_id', $request->getParameter('customer_id'), 'usersession');

          } else if (!$this->getUser()->isAuthenticated()){
          $this->redirect('@b2c_homepage');
          }
         */

        $customerids = $request->getParameter('cid');

        $this->customer = CustomerPeer::retrieveByPK($this->getUser()->getAttribute('customer_id', '', 'usersession'));

        //$this->redirectUnless($this->customer, "@homepage");

        $this->customer_balance = -1;

        $country_id = $this->customer->getCountryId();

        //This Section For Get the Language Symbol For Set Currency -
        $enableCountry = new Criteria();
        $enableCountry->add(EnableCountryPeer::ID, $country_id);
        $country_id = EnableCountryPeer::doSelectOne($enableCountry); //->getId();
        if ($country_id) {
            $langSym = $country_id->getLanguageSymbol();
        } else {
            $langSym = 'da';
        }
        //--------------------------------------------------------
        //$lang =  $this->getUser()->getAttribute('activelanguage');
        $lang = $langSym;
        $this->lang = $lang;

        //try to get balance again & again
        $num_tries = 3;

        for ($i = 0; ($i < 3) && $this->customer_balance == -1; $i++) {
            $this->customer_balance = (double) Fonet::getBalance($this->customer);
        }

        //echo  $TelintaMobile = '46'.$this->customer->getMobileNumber();
        $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0, 1);     // bcdef
        if ($getFirstnumberofMobile == 0) {
            $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
            $TelintaMobile = '46' . $TelintaMobile;
        } else {
            $TelintaMobile = '46' . $this->customer->getMobileNumber();
        }
        $emailId = $this->customer->getEmail();
        $uniqueId = $this->customer->getUniqueid();
        //This is for Retrieve balance From Telinta
        $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name=' . $uniqueId . '&type=customer');
        $telintaGetBalance = str_replace('success=OK&Balance=', '', $telintaGetBalance);
        $telintaGetBalance = str_replace('-', '', $telintaGetBalance);
        $this->customer_balance = $telintaGetBalance;


        if ($this->customer_balance != null)
            $this->customer_balance = $this->customer_balance;

            //$this->customer_balance = 100;

        if ($request->isMethod('post')) {

            if ($this->customer_balance > 40) {
                //When the customer register to this – the account should be deducted for 30 SEK for activation + 10 SEK for monthly fee - Ahtsham Asghar
                $voipcharges = "-40";

                $order = new CustomerOrder();
                $order->setProductId(12);
                $order->setCustomerId($customerids);
                $order->setExtraRefill($voipcharges);
                $order->setIsFirstOrder(1);
                $order->setOrderStatusId(3);
                echo 'order' . $order->save();

                echo '<br/>';
                $this->customer = $customerids;
                $transaction = new Transaction();
                $transaction->setAmount($voipcharges);
                //$this->getContext()->getI18N()->__('
                $transaction->setDescription('Transation for VoIP Purchase');
                $transaction->setOrderId($order->getId());
                $transaction->setCustomerId($customerids);
                $transaction->setTransactionStatusId(3);
                echo 'transaction' . $transaction->save();
                echo '<br/>';

                $customer = new Criteria();
                $customer->add(CustomerPeer::ID, $customerids);
                $customer = CustomerPeer::doSelectOne($customer);
                //
                //Fonet::registerFonet($customer);
                //   Fonet::recharge($customer, $order->getExtraRefill());
                //get an empty VoIP slot


                $rs = new Criteria();
                $rs->add(SeVoipNumberPeer::CUSTOMER_ID,$customerids);
                $rs->addAnd(SeVoipNumberPeer::IS_ASSIGNED,3);
                $voip_customer = '';
                if(SeVoipNumberPeer::doCount($rs)>0){
                    $voip_customer = SeVoipNumberPeer::doSelectOne($rs);
                }else{

                    $c = new Criteria();
                    $c->setLimit(1);
                    $c->add(SeVoipNumberPeer::IS_ASSIGNED, 0);
                    if(SeVoipNumberPeer::doCount($c)< 10){
                     emailLib::sendErrorInTelinta("Resenumber about to Finis","Resenumbers in the landncall are lest then 10 . ");

                    }
                    if (!$voip_customer = SeVoipNumberPeer::doSelectOne($c)){
                        emailLib::sendErrorInTelinta("Resenumber Finished","Resenumbers in the landncall are finished. This error is faced by customer id: ".$customerids);
                        return false;
                    }
                }
               // echo $voip_customer->getId()."Baran here<hr/>";
                $voip_customer->setUpdatedAt(date('Y-m-d H:i:s'));
                $voip_customer->setCustomerId($customerids);
                $voip_customer->setIsAssigned(1);
                 $voip_customer->save();

                  //  echo $voip_customer->getId()."Baran here<hr/>";
                   // die;

                //--------------------------Telinta------------------/
                $getvoipInfo = new Criteria();
                $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $customerids);
                $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo); //->getId();
                if (isset($getvoipInfos)) {
                    $voipnumbers = $getvoipInfos->getNumber();
                    $voipnumbers = substr($voipnumbers, 2);
                    $voip_customer = $getvoipInfos->getCustomerId();
                    $this->customer = $customer;
                    $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0, 1);     // bcdef
                    if ($getFirstnumberofMobile == 0) {
                        $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
                        $TelintaMobile = '46' . $TelintaMobile;
                    } else {
                        $TelintaMobile = '46' . $this->customer->getMobileNumber();
                    }

                    //$TelintaMobile = '46'.$this->customer->getMobileNumber();
                    $emailId = $this->customer->getEmail();
                    $uniqueId = $this->customer->getUniqueid();

                    //This Condtion for if IC Active
                    $tc = new Criteria();
                    $tc->add(CallbackLogPeer::UNIQUEID, $uniqueId);
                    $tc->addDescendingOrderByColumn(CallbackLogPeer::CREATED);
                    $MaxUniqueRec = CallbackLogPeer::doSelectOne($tc);
                    if (isset($MaxUniqueRec)) {
                        $TelintaMobile = $MaxUniqueRec->getMobileNumber();
                    }
                    //------------------------------


                    $telintaAddAccount = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name=' . $voipnumbers . '&customer=' . $uniqueId . '&opening_balance=0&credit_limit=&product=YYYLandncall_Forwarding&outgoing_default_r_r=2034&activate_follow_me=Yes&follow_me_number=' . $TelintaMobile . '&billing_model=1&password=asdf1asd');

                    $string = $telintaAddAccount;
                    $find = 'ERROR';
                    if (strpos($string, $find)) {
                        $message_body = "VOIP Subscribe Error:<br /> Duplicate account Id within Environment Of This Voip Against: $voipnumbers <br / >Unique Id: $uniqueId";
                        //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
                        emailLib::sendErrorTelinta($this->customer, $message_body);
                    } else {

                    }

                    //When a customer is assigned a resenummer you need to update the follow me number here is the URL
                    // $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=update&name='.$voipnumbers.'&active=Y&follow_me_number='.$TelintaMobile.'&type=account');
                    $OpeningBalance = '40';
                    //https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=account&action=activate&name='.$voipnumbers.'&customer='.$uniqueId.'&opening_balance=-'.$OpeningBalance.'&product=YYYLandncall_Forwarding&outgoing_default_r_r=2034&activate_follow_me=Yes&follow_me_number='.$TelintaMobile.'&billing_model=1&password=asdf1asd
                    //type=<account_customer>&action=manual_charge&name=<name>&amount=<amount>
                    //This is for Recharge the Customer
                    $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=customer&action=manual_charge&name=' . $uniqueId . '&amount=' . $OpeningBalance);
                }


                //----------------------------------------------------
                //----------------Send Email--------------
                //set vat

                $this->customer = $customer;
                $vat = 0;
                $subject = $this->getContext()->getI18N()->__('Transation for VoIP Purchase');
                $sender_email = sfConfig::get('app_email_sender_email', 'support@landncall.com');
                $sender_name = sfConfig::get('app_email_sender_name', 'LandNCall AB support');

                $recepient_email = trim($this->customer->getEmail());
                $recepient_name = sprintf('%s %s', $this->customer->getFirstName(), $this->customer->getLastName());
                $referrer_id = trim($this->customer->getReferrerId());

                if ($referrer_id):
                    $c = new Criteria();
                    $c->add(AgentCompanyPeer::ID, $referrer_id);

                    $recepient_agent_email = AgentCompanyPeer::doSelectOne($c)->getEmail();
                    $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
                endif;

                //send email
                $message_body = $this->getPartial('payments/order_receipt', array(
                            'customer' => $this->customer,
                            'order' => $order,
                            'transaction' => $transaction,
                            'vat' => $vat,
                            'wrap' => false
                        ));

                //This Seciton For Make The Log History When Complete registration complete - Agent
                //echo sfConfig::get('sf_data_dir');
                $invite_data_file = sfConfig::get('sf_data_dir') . '/invite.txt';
                $invite2 = "Customer Refill Account \n";
                $invite2 .= "Recepient Email: " . $recepient_email . ' \r\n';
                $invite2 .= " Agent Email: " . $recepient_agent_email . ' \r\n';
                $invite2 .= " Sender Email: " . $sender_email . ' \r\n';

                file_put_contents($invite_data_file, $invite2, FILE_APPEND);


                //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
                emailLib::sendvoipemail($this->customer, $order, $transaction);

                //------------------------------
                $this->redirect('http://landncall.zerocall.com/b2c.php/customer/voippurchased');
            }
        }
    }

    public function executeVoiptermsandcondition(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //-----------------------
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        //-----------------------
        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );

        $this->redirectUnless($this->getUser()->isAuthenticated(), "@homepage");
    }

    public function executeVoippurchased(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //-----------------------
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        //-----------------------
        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );

        $this->redirectUnless($this->getUser()->isAuthenticated(), "@homepage");
    }

    public function executeUnsubscribevoip(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //$customerids =  $request->getParameter('cid');
        $customerids = $this->getUser()->getAttribute('customer_id', '', 'usersession');
        $this->customer = CustomerPeer::retrieveByPK($this->getUser()->getAttribute('customer_id', '', 'usersession'));

        //--------------------------Telinta------------------/
        $getvoipInfo = new Criteria();
        $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $customerids);
        $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo); //->getId();
        if (isset($getvoipInfos)) {
            $voipnumbers = $getvoipInfos->getNumber();
            $voipnumbers = substr($voipnumbers, 2);
            $voip_customer = $getvoipInfos->getCustomerId();
            $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0, 1);     // bcdef
            if ($getFirstnumberofMobile == 0) {
                $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
                $TelintaMobile = '46' . $TelintaMobile;
            } else {
                $TelintaMobile = '46' . $this->customer->getMobileNumber();
            }
        }

        $removecustomer = '';
        //get an UnSurbise VoIP 
        $c = new Criteria();
        $c->add(SeVoipNumberPeer::CUSTOMER_ID, $customerids);
        if ($voip_customer = SeVoipNumberPeer::doSelectOne($c)) {
            $voip_customer->setIsAssigned(3);
            $voip_customer->save();
            $uniqueId = $this->customer->getUniqueid();

            $tc = new Criteria();
            $tc->add(CallbackLogPeer::UNIQUEID, $uniqueId);
            $tc->addDescendingOrderByColumn(CallbackLogPeer::CREATED);
            $MaxUniqueRec = CallbackLogPeer::doSelectOne($tc);
            $followMeNumber = $MaxUniqueRec->getMobileNumber();
            //When a customer is DeActive a resenummer you need to update the follow me number here is the URL - Telinta
            $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=update&name=' . $voipnumbers . '&active=N&follow_me_number=' . $followMeNumber . '&type=account');
            // echo 'https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=update&name='.$voipnumbers.'&active=N&follow_me_number='.$followMeNumber.'&type=account';
            $string = $telintaGetBalance;
            $find = 'ERROR';
            if (strpos($string, $find)) {
                $message_body = "Error ON DeActive a resenummer within environment <br> VOIP Number :$voipnumbers <br / >Follow Me Number: $followMeNumber";
                //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
                emailLib::sendErrorTelinta($this->customer, $message_body);
            } else {
                
            }
            $telintaGetBalance = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=delete&name='.$voipnumbers.'&type=account');
            // echo 'https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=update&name='.$voipnumbers.'&active=N&follow_me_number='.$followMeNumber.'&type=account';
            $string = $telintaGetBalance;
            $find = 'ERROR';
            if (strpos($string, $find)) {
                $message_body = "Error ON DeActive a resenummer within environment <br> VOIP Number :$voipnumbers <br / >Follow Me Number: $followMeNumber";
                //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
                emailLib::sendErrorTelinta($this->customer, $message_body);
            } else {

            }
        }
    }

    public function executeRefill(sfWebRequest $request) {
       $this->target = $this->getTargetUrl();
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //-----------------------
        //$this->redirectUnless($this->getUser()->isAuthenticated(),'@b2c_homepage');
        //$customer_id = $this->getUser()->getAttribute('customer_id',null, 'usersession');
        //TODO: authentication is missing

        $customer_id = $request->getParameter('customer_id');

        $this->customer = CustomerPeer::retrieveByPK($customer_id);

        $this->redirectUnless($this->customer, "@homepage");

        $this->form = new ManualRefillForm($customer_id);


        //new order
        $this->order = new CustomerOrder();

        $customer_products = $this->customer->getProducts();

        $this->order->setProduct($customer_products[0]);
        $this->order->setCustomer($this->customer);
        $this->order->setQuantity(1);
        $refills_options = ProductPeer::getRefillChoices();
        $this->order->setExtraRefill($refills_options[0]);
        $this->order->save();

        //new transaction
        $transaction = new Transaction();

        $transaction->setAmount($this->order->getExtraRefill());
        $transaction->setDescription('Refill');
        $transaction->setOrderId($this->order->getId());
        $transaction->setCustomerId($this->order->getCustomerId());

        //save
        $transaction->save();
    }

    public function executeRefillAccept(sfWebRequest $request) {
  $this->getUser()->setCulture($request->getParameter('lng'));

        $this->redirect('customer/dashboard');
    }

    public function executeRefillReject(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        


        $order_id = $request->getParameter('orderid');
        //$error_text = substr($request->getParameter('errortext'), 0, strpos($request->getParameter('errortext'), '!'));
        $error_text = $this->getContext()->getI18N()->__('Payment is unfortunately not accepted because your information is incorrect, please try again by entering correct credit card information');

        $order = CustomerOrderPeer::retrieveByPK($order_id);
        $c = new Criteria();
        $c->add(TransactionPeer::ORDER_ID, $order_id);
        $transaction = TransactionPeer::doSelectOne($c);

        $this->forward404Unless($order);

        $order->setOrderStatusId(sfConfig::get('app_status_cancelled')); //cancelled

        $this->getUser()->setFlash('error_message',
                $error_text
        );

        $this->order = $order;
        $this->forward404Unless($this->order);

        //required for some templates
        $this->customer = $this->order->getCustomer();

        $this->order_id = $order->getId();
        $this->amount = $transaction->getAmount();
        $this->form = new ManualRefillForm($this->order->getCustomerId());
        $this->setTemplate('refill');
    }

    public function executeCallhistory(sfWebRequest $request) {

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        


        //$this->customer = CustomerPeer::retrieveByPK(58);
        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );
        $this->redirectUnless($this->customer, "@homepage");

//		$c = new Criteria();
//		$c->add(ZerocallCdrPeer::ANI, BaseUtil::trimMobileNumber($this->customer->getMobileNumber()));
//		$c->add(ZerocallCdrPeer::SOURCECTY, $this->customer->getCountry()->getCallingCode());
//		$c->add(ZerocallCdrPeer::USEDVALUE, 0, Criteria::NOT_EQUAL);
//		$c->addDescendingOrderByColumn(ZerocallCdrPeer::ANSWERTIMEB);
//                $unid   =  $this->customer->getUniqueid();
//                if(isset($unid) && $unid!=""){
//                $un = new Criteria();
//                $un->add(CallbackLogPeer::UNIQUEID, $unid);
//                $un -> addDescendingOrderByColumn(CallbackLogPeer::CREATED);
//                $unumber = CallbackLogPeer::doSelectOne($un);
        //   $c = new Criteria();
        //  $c->add(BillingPeer::CUSTOMER_ID, $this->customer->getId());
        //  $c->addDescendingOrderByColumn(BillingPeer::TIME);
//		//setting filter
//		$this->filter = new ZerocallCdrFormFilter();
//
//		if ($request->getParameter('zerocall_cdr_log_filters'))
//		{
//			$c->add($this->filter->buildCriteria($request->getParameter('zerocall_cdr_log_filters')));
//			//$this->filter->bind($request->getParameter('zerocall_cdr_log_filters'));
//		}
        //set paging
        //	$items_per_page = 25; //shouldn't be 0
        //	$this->page = $request->getParameter('page');
        //    if($this->page == '') $this->page = 1;
        //    $pager = new sfPropelPager('Billing', $items_per_page);
        //    $pager->setPage($this->page);
        //    $pager->setCriteria($c);
        //     $pager->init();
        //     $this->callRecords = $pager->getResults();
        //    $this->total_pages = $pager->getNbResults() / $items_per_page;
    }

    public function executePaymenthistory(sfWebRequest $request) {

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        

        //$this->customer = CustomerPeer::retrieveByPK(58);

        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );

        $this->redirectUnless($this->customer, "@homepage");

        //get  transactions
        $c = new Criteria();
        $c->add(TransactionPeer::CUSTOMER_ID, $this->customer->getId());
        $c->add(TransactionPeer::TRANSACTION_STATUS_ID, sfConfig::get('app_status_completed'));
        /*
          if (isset($request->getParameter('filter')))
          {
          $filter = $request->getParameter('filter');

          $phone_number = isset($filter['phone_number'])?$filter['phone_number']:null;

          $from_date = isset($filter['from_date'])?$filter['from_date']:null;
          $to_date = isset($filter['to_date'])?$filter['to_date']:null;

          if ($phone_number)
          $c->add(CustomerPeer::MOBILE_NUMBER, $phone_number);
          if ($from_date)
          $c->add(TransactionPeer::CREATED_AT, $from_date, Criteria::GREATER_EQUAL);
          if ($to_date && !$from_date)
          $c->add(TransactionPeer::CREATED_AT, $to_date . ' 23:59:59', Criteria::LESS_EQUAL);
          elseif ($to_date && $from_date)
          $c->addAnd(TransactionPeer::CREATED_AT, $to_date . ' 23:59:59', Criteria::LESS_EQUAL);

          }
         */
        //This Section For Get the Language Symbol For Set Currency - Ahtsham - LandNCall AB
        $country_id = $this->customer->getCountryId();
        $enableCountry = new Criteria();
        $enableCountry->add(EnableCountryPeer::ID, $country_id);
        $country_id = EnableCountryPeer::doSelectOne($enableCountry); //->getId();
        if ($country_id) {
            $langSym = $country_id->getLanguageSymbol();
        } else {
            $langSym = 'da';
        }
        //--------------------------------------------------------
        //$lang =  $this->getUser()->getAttribute('activelanguage');
        $lang = $langSym;
        $this->lang = $lang;
        //--------------------------------------------------------

        $c->addDescendingOrderByColumn(TransactionPeer::CREATED_AT);

        //set paging
        $items_per_page = 10; //shouldn't be 0
        $this->page = $request->getParameter('page');
        if ($this->page == '')
            $this->page = 1;

        $pager = new sfPropelPager('Transaction', $items_per_page);
        $pager->setPage($this->page);

        $pager->setCriteria($c);

        $pager->init();

        $this->transactions = $pager->getResults();
        $this->total_pages = $pager->getNbResults() / $items_per_page;
    }

    public function executeRefillpaymenthistory(sfWebRequest $request) {

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        

        //$this->customer = CustomerPeer::retrieveByPK(58);

        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );

        $this->redirectUnless($this->customer, "@homepage");

        //get  transactions
        $c = new Criteria();
        
        $c->add(TransactionPeer::CUSTOMER_ID, $this->customer->getId());
        $c->add(TransactionPeer::TRANSACTION_STATUS_ID, sfConfig::get('app_status_completed')
        );
        // Here we can simple check the transaction stats and we can meet our requirements but here use the description value equel which is i dnt
        // Good approch but me not edit this i just pass one more "Resenummer bekräftelse" - ahtsham
        /*
          if (isset($request->getParameter('filter')))
          {
          $filter = $request->getParameter('filter');

          $phone_number = isset($filter['phone_number'])?$filter['phone_number']:null;

          $from_date = isset($filter['from_date'])?$filter['from_date']:null;
          $to_date = isset($filter['to_date'])?$filter['to_date']:null;

          if ($phone_number)
          $c->add(CustomerPeer::MOBILE_NUMBER, $phone_number);
          if ($from_date)
          $c->add(TransactionPeer::CREATED_AT, $from_date, Criteria::GREATER_EQUAL);
          if ($to_date && !$from_date)
          $c->add(TransactionPeer::CREATED_AT, $to_date . ' 23:59:59', Criteria::LESS_EQUAL);
          elseif ($to_date && $from_date)
          $c->addAnd(TransactionPeer::CREATED_AT, $to_date . ' 23:59:59', Criteria::LESS_EQUAL);

          }
         */
        //This Section For Get the Language Symbol For Set Currency - Ahtsham - LandNCall AB
        $country_id = $this->customer->getCountryId();
        $enableCountry = new Criteria();
        $enableCountry->add(EnableCountryPeer::ID, $country_id);
        $country_id = EnableCountryPeer::doSelectOne($enableCountry); //->getId();
        if ($country_id) {
            $langSym = $country_id->getLanguageSymbol();
        } else {
            $langSym = 'da';
        }
        //--------------------------------------------------------
        //$lang =  $this->getUser()->getAttribute('activelanguage');
        $lang = $langSym;
        $this->lang = $lang;
        //--------------------------------------------------------

        $c->addDescendingOrderByColumn(TransactionPeer::CREATED_AT);

        //set paging
        $items_per_page = 10; //shouldn't be 0
        $this->page = $request->getParameter('page');
        if ($this->page == '')
            $this->page = 1;

        $pager = new sfPropelPager('Transaction', $items_per_page);
        $pager->setPage($this->page);

        $pager->setCriteria($c);

        $pager->init();

        $this->transactions = $pager->getResults();
        $this->total_pages = $pager->getNbResults() / $items_per_page;
    }

    public function executePasswordchange(sfWebRequest $request) {

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //-----------------------

        $this->redirectUnless($this->getUser()->isAuthenticated(), "@homepage");
        //$this->customer = CustomerPeer::retrieveByPK(58);
        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );
        //$this->forward404Unless($this->customer);
        $this->redirectUnless($this->customer, "@homepage");

        $this->form = new CustomerForm(CustomerPeer::retrieveByPK($this->customer->getId()));
      

    unset($this->form['first_name']);
                    unset($this->form['last_name']);
                    unset($this->form['country_id']);
                    unset($this->form['city']);
                    unset($this->form['po_box_number']);
                    unset($this->form['mobile_number']);
                    unset($this->form['device_id']);
                    unset($this->form['email']);
                    unset($this->form['is_newsletter_subscriber']);
                    unset($this->form['created_at']);
                    unset($this->form['updated_at']);
                    unset($this->form['customer_status_id']);
                    unset($this->form['address']);
                    unset($this->form['fonet_customer_id']);
                    unset($this->form['referrer_id']);
                    unset($this->form['telecom_operator_id']);
                    unset($this->form['date_of_birth']);
                    unset($this->form['other']);
                    unset($this->form['subscription_type']);
                    unset($this->form['auto_refill_amount']);
                    unset($this->form['subscription_id']);
                    unset($this->form['last_auto_refill']);
                    unset($this->form['auto_refill_min_balance']);
                    unset($this->form['c9_customer_number']);
                    unset($this->form['registration_type_id']);
                    unset($this->form['imsi']);
                    unset($this->form['uniqueid']);
                    unset($this->form['plain_text']);
                    unset($this->form['ticketval']);
                    unset($this->form['to_date']);
                    unset($this->form['from_date']);
                     unset($this->form['uniqueid']);
                    unset($this->form['plain_text']);
                    unset($this->form['ticketval']);
                    unset($this->form['to_date']);
                    unset($this->form['from_date']);
                    unset($this->form['terms_conditions']);
                    unset($this->form['manufacturer']);
                    unset($this->form['product']);
                   //  unset($this->form['password']);
        // unset($this->form['password_confirm']);
        /////////////////////////////////////
            //   $this->form->getWidget('password')->setAttribute('value', '');
 

        /////////////////////////////////////////
        $this->oldpasswordError = '';
        $this->oldpassword = '';
        if ($request->isMethod('post')) {
            $customers = $request->getParameter($this->form->getName());
            $customerId = $customers["id"];
            //echo '<br>';
            $getcusInfo = new Criteria();
            $getcusInfo->add(CustomerPeer::ID, $customerId);
            $getcusInfos = CustomerPeer::doSelectOne($getcusInfo); //->getId();
            $customeroldpass = $getcusInfos->getPlainText();
            if ($customeroldpass == $customers["oldpassword"]) {
                $this->oldpasswordError = '';
            } else {
                $this->oldpasswordError = 'wrong';
            }
            $this->oldpassword = $customers["oldpassword"];
            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
 

 
            if ($this->form->isValid() && $this->oldpasswordError == '') {
                //	echo 'validated';
                $customer = $this->form->save();

                $plainPws = $customers["password"];


                $customer->setPlainText($plainPws);

                $customer->save();

                $this->getUser()->setFlash('message', $this->getContext()->getI18N()->__('Your Password have been saved.'));
            }
            // echo 'after';
        }


      

    }

    public function executeSettings(sfWebRequest $request) {


        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //-----------------------

        $this->redirectUnless($this->getUser()->isAuthenticated(), "@homepage");
        //$this->customer = CustomerPeer::retrieveByPK(58);
        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );
        //$this->forward404Unless($this->customer);
        $this->redirectUnless($this->customer, "@homepage");

        $this->form = new CustomerForm(CustomerPeer::retrieveByPK($this->customer->getId()));
        unset($this->form['terms_conditions']);
        unset($this->form['password']);
        unset($this->form['product']);
        unset($this->form['password_confirm']);
        /////////////////////////////////////
        unset($this->form['created_at']);
        unset($this->form['fonet_customer_id']);
        unset($this->form['referrer_id']);
        unset($this->form['registration_type_id']);
        unset($this->form['plain_text']);
        unset($this->form['uniqueid']);
        unset($this->form['auto_refill_min_balance']);
        unset($this->form['auto_refill_amount']);
        unset($this->form['last_auto_refill']);
        unset($this->form['manufacturer']);
        unset($this->form['device_id']);
        unset($this->form['ticketval']);
        $this->uniqueidValue = $this->customer->getUniqueId();
        //This Section For Get the Language Symbol For Set Currency -
        $getvoipInfo = new Criteria();
        $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $this->customer->getId());
        $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo); //->getId();
        if (isset($getvoipInfos)) {
            $this->voipnumbers = $getvoipInfos->getNumber();
            $this->voip_customer = $getvoipInfos->getCustomerId();
        } else {
            $this->voipnumbers = '';
            $this->voip_customer = '';
        }


        /////////////////////////////////////////

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
            //  echo 'before validation';

            if ($this->form->isValid()) {
                //	echo 'validated';
                $customer = $this->form->save();

                $this->getUser()->setFlash('message', $this->getContext()->getI18N()->__('Your settings have been saved.'));
            }
            // echo 'after';
        }
        //disable
        //$this->form->widgetSchema['mobile_number']->setAttribute('readonly','readonly');
        $this->form->getWidget('mobile_number')->setAttribute('readonly', 'readonly');
        //$this->form->getWidget('mobile_number')->setAttribute('disabled','disabled');
        //	$this->form->getWidget('email')->setAttribute('readonly','readonly');
        //$this->form->getWidget('email')->setAttribute('disabled','disabled');
        //$this->getValidator['mobile_number'] = new sfValidatorReadOnlyField(array('field' => 'mobile_number', 'object' => $this->form->getObject()));
        //$this->form->getWidget('manufacturer')->setLabel('Mobile brand','Mobile brand');
        // $this->widgetSchema->setLabel('customer_manufacturer','Mobile brand');
        //$this->form->getWidget->('customer_manufacturer', "Yes");
        //$this->form->getWidget('password')->setOption('always_render_empty', false);
        //$this->form->getWidget('password_confirm')->setOption('always_render_empty', false);
        //get default pre-requisites
//	  	$c = new Criteria();
//	  	$c->add(DevicePeer::ID, $this->customer->getDeviceId());
//
//	  	$device = DevicePeer::doSelectOne($c);
//
//	  	$manufacturer = $device->getManufacturer();
//
//	  	$this->form->setDefault(
//	  			'manufacturer', $manufacturer->getId()
//	  	);
//
//                $this->form->setDefault(
//	  			'device_id', $device->getId()
//	  	);
    }

    public function executeLogin(sfWebRequest $request) {
        
        $this->target = $this->getTargetUrl();
        $this->getTargetUrl();
        
        if ($request->isMethod('post') &&
                $request->getParameter('mobile_number') != '' &&
                $request->getParameter('password') != '') {
            $paswordval = $request->getParameter('password');
            $mobile_number = $request->getParameter('mobile_number');
            $password = sha1($request->getParameter('password'));

            $c = new Criteria();
            $c->add(CustomerPeer::MOBILE_NUMBER, $mobile_number);
            $c->add(CustomerPeer::PASSWORD, $password);
            $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);

            $customer = CustomerPeer::doSelectOne($c);


            if ($customer) {

                header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
                $this->getUser()->setAttribute('customer_id', $customer->getId(), 'usersession');
                $this->getUser()->setAuthenticated(true);




                $customer->setPlainText($paswordval);
                $customer->save();
             
 
                //$this->redirect('@customer_dashboard');
                if ($request->isXmlHttpRequest())
                    $this->renderText('ok');
                else {


                    if(isset($pathArray['HTTP_REFERER']) && $pathArray['HTTP_REFERER']!=''){
        $this->redirect($pathArray['HTTP_REFERER']);

}else{
                      $this->redirect($this->getTargetUrl().'customer/dashboard');

}


                  
                }
            } else {
                //
                if ($request->isXmlHttpRequest())
                    $this->renderText('invalid');
                else {
                    $this->getUser()->setFlash('error_message', $this->getContext()->getI18N()->__('Invaild mobile number or password.'));
                }
            }
        } else {
            if ($request->isXmlHttpRequest()) {
                $this->renderPartial('login');
                return sfView::NONE;
            }
        }
    }

    public function executeLogout(sfWebRequest $request) {

        $this->getUser()->getAttributeHolder()->removeNameSpace('usersession');
        $this->getUser()->setAuthenticated(false);
        $this->redirect('@b2c_homepage');

        return sfView::NONE;
    }

    public function executeSendPassword(sfWebRequest $request) {

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        

        //$this->forward404Unless($request->isMethod('post'));
        $this->redirectUnless($request->isMethod('post'), "@homepage");

        $c = new Criteria();

        $c->add(CustomerPeer::EMAIL, $request->getParameter('email'));
        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, sfConfig::get('app_status_completed', 3));

        //echo $c->toString(); exit;
        $customer = CustomerPeer::doSelectOne($c);

        if ($customer) {
            //change the password to some thing uniuque and complex
            $new_password = substr(base64_encode($customer->getPassword()), 0, 8);
            //echo $new_password.''.$customer->getPassword();
            $customer->setPlainText($new_password);
            $customer->setPassword($new_password);
            $message_body = $this->getContext()->getI18N()->__('Hi') . ' ' . $customer->getFirstName() . '!';
            $message_body .= '<br /><br />';
            $message_body .= $this->getContext()->getI18N()->__('Your password has been changed. Please use the following information to login to your WLS2 account.');
            $message_body .= '<br /><br />';
            $message_body .= sprintf($this->getContext()->getI18N()->__('Mobile Number: %s'), $customer->getMobileNumber());
            $message_body .= '<br />';
            $message_body .= $this->getContext()->getI18N()->__('password') . ': ' . $new_password;

            $customer->save();

            //$this->renderText($message_body);
            //send email


            $subject = $this->getContext()->getI18N()->__('Password Request');
            $sender_email = sfConfig::get('app_email_sender_email', 'rs@zapna.com');
            $sender_name = sfConfig::get('app_email_sender_name', 'support');

            $message = $message_body;

            $receipient_email = trim($customer->getEmail());
            $receipient_name = sprintf('%s %s', $customer->getFirstName(), $customer->getLastName());


            //This Seciton For Make The Log History When Complete registration complete - Agent
            //echo sfConfig::get('sf_data_dir');
            $invite_data_file = sfConfig::get('sf_data_dir') . '/invite.txt';
            $invite2 = "Reset Password \n";
            if ($receipient_name):
                $invite2 = "Recepient Email: " . $receipient_email;
            endif;

            file_put_contents($invite_data_file, $invite2, FILE_APPEND);

            //Send Email to User --- when Forget Password Request Come --- 01/15/11
            emailLib::sendForgetPasswordEmail($customer, $message, $subject);

            $this->getUser()->setFlash('send_password_message', $this->getContext()->getI18N()->__('Your account details have been sent to your email address.'));
        }
        else {
            $this->getUser()->setFlash('send_password_error_message', $this->getContext()->getI18N()->__('No customer is registered with this email.'));
        }
//  		require_once(sfConfig::get('sf_lib_dir').'/swift/lib/swift_init.php');
//
//		$connection = Swift_SmtpTransport::newInstance()
//					->setHost(sfConfig::get('app_email_smtp_host', 'localhost'))
//					->setPort(sfConfig::get('app_email_smtp_port', '25'))
//					->setUsername(sfConfig::get('app_email_smtp_username'))
//					->setPassword(sfConfig::get('app_email_smtp_password'));
//
//		$mailer = new Swift_Mailer($connection);
//
//		$message = Swift_Message::newInstance($subject)
//		         ->setFrom(array($sender_email => $sender_name))
//		         ->setTo(array($recepient_email => $recepient_name))
//		         ->setBody($message_body, 'text/html')
//		         ;
//
//
//		if (@$mailer->send($message))
//			if ($request->isXmlHttpRequest())
//			{
//			 	$this->renderText('ok');
//			 	return sfView::NONE;
//			}
//			else
//			{
//	  			$this->getUser()->setFlash('send_password_message', 'Your account details have been sent to your email address.');
//			}
//		else
//			if ($request->isXmlHttpRequest())
//			{
//				$this->renderText('invalid');
//				return sfView::NONE;
//			}
//			else
//			{
//	  			//$this->getUser()->setFlash('send_password_error_message', 'Unable to send details at your email. Please try again later.');
//	  			$email = new EmailQueue($subject, $message_body, $recepient_name, $recepient_email);
//	  			$email->save();
//			}
//  	}
//  	else
//  	{
//		if ($request->isXmlHttpRequest())
//		{
//  			$this->renderText('invalid');
//  			return sfView::NONE;
//		}
//		else
//		{
//	  		$this->getUser()->setFlash('send_password_error_message', 'No customer is registered with this email.');
//		}
        //} //end if
        //return $this->forward('customer', 'login');
        return $this->redirect('customer/login');
    }

//end funcition

    public function executeGetHeader() {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        

        echo $this->getPartial("header", array('test_dir' => '/testwp'));
        sfConfig::set('sf_web_debug', false);
        return sfView::NONE;
    }

    public function executeC9Callhistory(sfWebRequest $request) {

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        

//try to find customer in session (only possible if user already logged in.)
        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );
        $this->redirectUnless($this->customer, "@homepage");

//create criteria

        $c = new Criteria();
        $c->add(Cloud9DataPeer::MSISDN, $this->customer->getC9CustomerNumber());
        $c->add(Cloud9DataPeer::LEG, "B");


//set paging
        $items_per_page = 25; //shouldn't be 0
        $this->page = $request->getParameter('page');
        if ($this->page == '')
            $this->page = 1;

        $pager = new sfPropelPager('Cloud9Data', $items_per_page);
        $pager->setPage($this->page);

        $pager->setCriteria($c);

        $pager->init();

        $this->callRecords = $pager->getResults();
        $this->total_pages = $pager->getNbResults() / $items_per_page;
    }

    public function executeWebsms(sfWebRequest $request) {

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //-----------------------


        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );
        $this->redirectUnless($this->customer, "@homepage");


        $cunt = new Criteria();
        $cunt->addAscendingOrderByColumn(CountryPeer::NAME);
        $countries = CountryPeer::doSelect($cunt);
        $this->msgSent = "";
        $this->countries = $countries;
        $this->res_cbf = "";
        $this->balance = (double) Telienta::getBalance($this->customer);

        $message = $request->getParameter('message');


        if ($message) {
            $this->msgSent = "No";
            $country_code = $request->getParameter('country');
            $number = $request->getParameter('number');
            $destination = $country_code . $number;

            $c = new Criteria();
            $c->add(CountryPeer::CALLING_CODE, $request->getParameter('country'));
            $country = CountryPeer::doSelectOne($c);

            $messages = array();
            if (strlen($message) < 142) {
                $messages[1] = $message . "-Sent by wls2-";
            } else if (strlen($message) > 142 and strlen($message) < 302) {

                $messages[1] = substr($message, 1, 142) . "-Sent by wls2-";
                $messages[2] = substr($message, 143) . "-Sent by wls2-";
            } else if (strlen($message) > 382) {
                $messages[1] = substr($message, 1, 142) . "-Sent by wls2-";
                $messages[2] = substr($message, 143, 302) . "-Sent by wls2-";
                $messages[3] = substr($message, 303, 432) . "-Sent by wls2-";
            }

            foreach ($messages as $sms_text) {
                $cbf = new Cbf();
                $cbf->setS('H');
                $cbf->setDa($destination);
                $cbf->setMessage($sms_text);
                $cbf->setCountryId($country->getId());
                $cbf->setMobileNumber($this->customer->getMobileNumber());
                $cbf->save();
                
                $amt = $country->getCbfRate();
                $amt = number_format($amt, 2);


                if (CARBORDFISH_SMS::Send($destination, $sms_text, $this->customer->getMobileNumber())) {
                    Telienta::charge($this->customer, $amt);
                    $this->msgSent = "Yes";
                    $this->balance = (double) Telienta::getBalance($this->customer);
                }
            }
        }
    }

public function executeSmsHistory(sfWebrequest $request){

    //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
    changeLanguageCulture::languageCulture($request,$this);
    //-----------------------
    $this->customer = CustomerPeer::retrieveByPK(
			$this->getUser()->getAttribute('customer_id', null, 'usersession')
			);
		$this->redirectUnless($this->customer, "@homepage");
                $c = new Criteria();
                $c->add(CbfPeer::MOBILE_NUMBER, $this->customer->getMobileNumber());
                $c->addDescendingOrderByColumn(CbfPeer::CREATED_AT);
		$items_per_page = 25; //shouldn't be 0
		$this->page = $request->getParameter('page');
        if($this->page == '') $this->page = 1;

        $pager = new sfPropelPager('Cbf', $items_per_page);
        $pager->setPage($this->page);

        $pager->setCriteria($c);

        $pager->init();

        $this->smsRecords = $pager->getResults();
		$this->total_pages = $pager->getNbResults() / $items_per_page;

}


    public function executeTellAFriend(sfWebRequest $request) {

        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );

        $this->redirectUnless($this->getUser()->isAuthenticated(), "@homepage");


        $invite = new Invite();


        if ($request->isMethod('post')) {

            //$this->form = new ContactForm();

            $recepient_email = $request->getParameter('email');
            $recepient_name = $request->getParameter('name');

            $message = $request->getParameter('message');
            $invite->setEmail($recepient_email);
            $invite->setInviteName($recepient_name);
            $invite->setInviteStatus('1');
            $invite->setCustomerId($this->customer->getId());
            $invite->setMessage($message);
            $invite->save();

            $subject = $this->getContext()->getI18N()->__("WLS2 invitation");

            $name = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
            $message_body = $this->getContext()->getI18N()->__('Hi ') . $recepient_name . ',<br /> ' . $this->getContext()->getI18N()->__("This invitation is sent to you with the reference of") . ' ' . $name . ', ' . $this->getContext()->getI18N()->__("a user of Smartsim from the WLS2.");

            $message_body_end = $this->getContext()->getI18N()->__('Please click accept to start saving money immediately with Smartsim.') . ' <a  href="http://wls2.zerocall.com/b2c.php/customer/signup?invite_id=' . $invite->getId() . '"> ' . $this->getContext()->getI18N()->__("Accept") . '</a><br/>'. $this->getContext()->getI18N()->__('Read more').' <a href="wls2.zerocall.com">wls2.zerocall.com</a>';

            //send email
            if ($recepient_name != ''):
                $email = new EmailQueue();
                $email->setSubject($subject);
                $email->setMessage($message_body . "<br />" . $message . "<br/>" . $message_body_end);
                $email->setReceipientName($recepient_name);
                $email->setReceipientEmail($recepient_email);

                $email->save();
            endif;
        }
    }

    public function executeRegister(sfWebRequest $request) {

        //validation patterns
        $svk_pattern = "/^[0-9]*$/";
        $product_pattern = "/^[0-9]{2}$/";

        //initialize flags
        $alreadyRegistered = false;
        $invalidMobile = false;
        $invalidEmail = false;
        $valid_product_code = false;
        $customer_registered = false;
        $valid_country_code = false;

        //initialize parameter variables
        $mobile = "";
        $product_code = "";
        $name = "";
        $email = "";
        $country_code = "";
        $city = "";

        //initialize object variables
        $product = NULL;
        $country = NULL;
        $customer = new Customer();
        $order = new CustomerOrder();
        $customer_product = new CustomerProduct();
        $transaction = new Transaction();

        //start function execution
        try {

            //get request parameters
            $name = $request->getParameter('name');
            $mobile = $request->getParameter('mobile');
            $email = $request->getParameter('email');
            $product_code = $request->getParameter('product_code');
            $city = $request->getParameter('city');
            $country_code = $request->getParameter('country');

            //geting product sms code
            if (preg_match($product_pattern, $product_code)) {
                $pc = new Criteria();
                $pc->add(ProductPeer::SMS_CODE, $product_code);
                $product = ProductPeer::doSelectOne($pc);

                if ($product != NULL) {
                    $valid_product_code = true;
//             echo 'product code valid';
//             echo '<br/>';
                }//end if(preg_match($product_pattern,$product_code))
            } else {
                $valid_product_code = false;
//         echo 'product code in-valid';
//             echo '<br/>';
            }//if ($code!="")
//  echo 'checking mobile pattern';
//  echo '<br/>';
            echo preg_match($svk_pattern, $mobile);
//  echo '<br/>';

            if (preg_match($svk_pattern, $mobile)) {

                $invalidMobile = false;
//      echo 'mobile valid';
//      echo '<br/>';
                $mnc = new Criteria();
                $mnc->add(CustomerPeer::MOBILE_NUMBER, $mobile);
                $mnc->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
                $cus = CustomerPeer::doSelectOne($mnc);

                $cc = new Criteria();
                $cc->add(EnableCountryPeer::ID, $country_code);
                $country = EnableCountryPeer::doSelectOne($cc);

                if ($country != NULL) {
                    $valid_country_code = true;
//          echo 'country code valid';
//          echo '<br/>';
                }

                if ($cus != NULL) {
//        echo 'Already Registered';
//        echo '<br/>';
                    $alreadyRegistered = true;
                }
            }


            if (!$invalidMobile and !$alreadyRegistered and !$invalidEmail and $valid_product_code and $valid_country_code) {

//        echo "inside if(invalidMobile and !alreadyRegistered and valid_code and !invalidEmail)";

                $customer->setFirstName($name);
                $customer->setLastName(".");
                $customer->setMobileNumber($mobile);
                $customer->setPassword($mobile);
                $customer->setEmail($email);
                $customer->setCountryId($country->getId());
                $customer->setCity($city);
                $customer->setAddress("not given");
                $customer->setTelecomOperatorId(13);
                $customer->setDeviceId(2191);
                $customer->setCustomerStatusId(sfConfig::get('app_status_completed'));
                $customer->setRegistrationTypeId(6);
                $customer->setPlainText($mobile);
                $customer->setReferrerId(154);

                $mobile = "";
                $numberlength = strlen($mobile);
                $endnumberlength = $numberlength - 2;
                $mnumber = $mobile;
                $number = substr($number, 2, $endnumberlength);
                $message = substr($text, 3, 6);
                $uniqueId = $text;
                $uniqueId = substr($uniqueId, 3, 6);
                $customer->setUniqueid($uniqueId);


                $customer->save();
//        echo '<br/>';
//        echo 'customer'.$customer->save();
//        echo '<br/>';

                $order->setProductId($product->getId());
                $order->setCustomerId($customer->getId());
                $order->setExtraRefill($order->getProduct()->getInitialBalance());
                $order->setIsFirstOrder(1);
                $order->setOrderStatusId(sfConfig::get('app_status_completed'));
                $order->save();
//            echo 'order with product'.$order->save();
//            echo '<br/>';

                $customer_product->setCustomerId($order->getCustomerId());
                $customer_product->setProductId($order->getProductId());
                $customer_product->save();
//            echo 'customer_product'.$customer_product->save();
//            echo '<br/>';


                $transaction->setAgentCompanyId($customer->getReferrerId());
                $transaction->setAmount($order->getProduct()->getPrice() - $order->getProduct()->getInitialBalance() + $order->getExtraRefill());
                $transaction->setDescription($this->getContext()->getI18N()->__('Anmeldung inc. sprechen'));
                $transaction->setOrderId($order->getId());
                $transaction->setCustomerId($customer->getId());
                $transaction->setTransactionStatusId(3);
                $transaction->save();
//        echo 'transaction'.$transaction->save();
//        echo '<br/>';

                $customer_registered = true;






//////////////////////////////////////////////////////////////////////////////////////
                $this->customer = $customer;
                $gentid = $customer->getReferrerId();
                $productid = $product->getId();
                $transactionid = $transaction->getId();
                if (isset($gentid) && $gentid != "") {
                    $massage = commissionLib::registrationCommission($gentid, $productid, $transactionid);
                }//end if isset
//////////////////////////////////////////////////////////////////////////     /
                Fonet::registerFonet($customer);
                Fonet::recharge($customer, $order->getExtraRefill());

////////////////////////////////////////////////////////////////////////////////////
                $this->customer = $cus;
                //emailLib::sendCustomerRegistrationViaAgentEmail($this->customer,$order);
                echo "success, Customer Registered";
            } else {

//     $sms_text = "Customer not registered, please retry. ";
                if ($invalidMobile) {
//         $sms_text = "error, invalid Mobile Number";
                    echo 'error, invalid Mobile Number';
                } else if ($invalidEmail) {
//         $sms_text = "error, invalid Email";
                    echo 'error, invalid email';
                } else if ($alreadyRegistered) {
//         $sms_text = "error, Number Already Registered";
                    echo "error, Number Already Registered";
                } else if (!$product) {
//         $sms_text = "error, invalid promo code";
                    echo "error, invalid product code";
                } else if (!$valid_country_code) {
                    echo "error, invalid country code";
                }
            }
        } catch (Exception $e) {

            echo "error, internal server error ";
            echo "<br/>";
            echo $e->getLine() . ' : ' . $e->getMessage();
        }

        return sfView::NONE;
    }

    public function executeLandncallRefill(sfWebRequest $request) {

        $valid_amount_pattern = false;
        $valid_amount = false;
        $valid_mobile_pattern = false;
        $valid_number = false;

        $customer = NULL;
        $order = new CustomerOrder();
        $transaction = new Transaction();

        $mobile = "";
        $amount = "";


        $mobile = $request->getParameter('mobile');
        $amount = $request->getParameter('amount');
        $svk_pattern = "/^[0-9]*$/";
        $amount_pattern = "/^[0-9]*$/";

        if (preg_match($amount_pattern, $amount)) {
            $valid_amount_pattern = true;
        }

        if ($amount > 0) {
            $valid_amount = true;
        }

        if (preg_match($svk_pattern, $mobile)) {
            $valid_mobile_pattern = true;
        }


        $mpc = new Criteria();
        $mpc->add(CustomerPeer::MOBILE_NUMBER, $mobile);
        $customer = CustomerPeer::doSelectOne($mpc);

        if ($customer != NULL) {
            $valid_number = true;
        }

        if ($valid_number and $valid_mobile_pattern and $valid_amount and $valid_amount_pattern) {

            $cpc = new Criteria();
            $cpc->add(CustomerPeer::ID, $customer->getId());
            $customer_product = CustomerProductPeer::doSelectOne($cpc);

            $order->setProductId($customer_product->getProductId());
            $order->setCustomerId($customer->getId());
            $order->setExtraRefill($amount / 100);
            $order->setIsFirstOrder(0);
            $order->setOrderStatusId(sfConfig::get('app_status_completed'));
            $order->save();
//            echo 'order with product'.$order->save();
//            echo '<br/>';

            $transaction->setAgentCompanyId($customer->getReferrerId());
            $transaction->setAmount($order->getExtraRefill());
            $transaction->setDescription($this->getContext()->getI18N()->__('Customer Refill'));
            $transaction->setOrderId($order->getId());
            $transaction->setCustomerId($customer->getId());
            $transaction->setTransactionStatusId(3);
            $transaction->save();

            // Fonet::recharge($customer, $order->getExtraRefill() );
            $this->customer = $customer;
            //////////////////////////////////////////////////////////////////////////////////////
            $gentid = $customer->getReferrerId();
            $productid = $customer_product->getCustomerId();
            $transactionid = $transaction->getId();
            if (isset($gentid) && $gentid != "") {
                $massage = commissionLib::refilCustomer($gentid, $productid, $transactionid);
            }//end if isset


            $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0, 1);     // bcdef
            if ($getFirstnumberofMobile == 0) {
                $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
                $TelintaMobile = '49' . $TelintaMobile;
            } else {
                $TelintaMobile = '49' . $this->customer->getMobileNumber();
            }
            $uniqueId = $this->customer->getUniqueid();
            $OpeningBalance = $order->getExtraRefill();
            //This is for Recharge the Customer
            $MinuesOpeningBalance = $OpeningBalance * 3;
            $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name=' . $uniqueId . '&amount=' . $OpeningBalance . '&type=customer');
            //This is for Recharge the Account
            $find = '';
            $string = $telintaAddAccountCB;
            $find = 'ERROR';
            if (strpos($string, $find)) {
                $message_body = "Error ON Refill Customer within Environment <br> Unique Id :$uniqueId <br / >Amount: $OpeningBalance";
                //Send Email to User/Agent/Support --- when Customer Refilll --- 01/15/11
                emailLib::sendErrorTelinta($this->customer, $message_body);
            } else {
                
            }
            //this condition for if follow me is Active
            $getvoipInfo = new Criteria();
            $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $this->customer->getMobileNumber());
            $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo); //->getId();
            if (isset($getvoipInfos)) {
                $voipnumbers = $getvoipInfos->getNumber();
                $voip_customer = $getvoipInfos->getCustomerId();
                //$telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$voipnumbers.'&amount='.$OpeningBalance.'&type=account');
            } else {
                //$telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$uniqueId.'&amount='.$OpeningBalance.'&type=account');
            }
            //$telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name=a'.$TelintaMobile.'&amount='.$OpeningBalance.'&type=account');
            // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name=cb'.$TelintaMobile.'&amount='.$OpeningBalance.'&type=account');

            $MinuesOpeningBalance = $OpeningBalance * 3;
            //type=<account_customer>&action=manual_charge&name=<name>&amount=<amount>
            //This is for Recharge the Customer
            //$telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=customer&action=manual_charge&name='.$uniqueId.'&amount='.$MinuesOpeningBalance);


            echo "success, Amount: " . ($amount / 100) . " recharged to mobile: " . $mobile;
            return sfView::NONE;
        } else {

            if (!$valid_amount_pattern) {
                echo "error, incorrect Amount";
            } else if (!$valid_amount) {
                echo "error, incorrect Amount";
            } else if (!$valid_mobile_pattern) {
                echo "error, Invalid Mobile Number";
            } else if (!$valid_number) {
                echo "error, Mobile Number does not exists";
            }
            return sfView::NONE;
        }
    }

    public function executeCalbackrefill(sfWebRequest $request) {
    $this->getUser()->setCulture($request->getParameter('lng'));
        $order_id = $request->getParameter("orderid");
        $urlval = $order_id." refill page-qqqqqqqqq" . $request->getParameter('transact');

        $email2 = new DibsCall();
        $email2->setCallurl($urlval);

        $email2->save();


        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //-----------------------

     

        $this->forward404Unless($order_id || $order_amount);

        $order = CustomerOrderPeer::retrieveByPK($order_id);

        $subscription_id = $request->getParameter("subscriptionid");
        $order_amount = ((double) $request->getParameter('amount')) / 100;
        $this->forward404Unless($order);
        $c = new Criteria;
        $c->add(TransactionPeer::ORDER_ID, $order_id);
        $transaction = TransactionPeer::doSelectOne($c);
        //echo var_dump($transaction);
        $order->setOrderStatusId(sfConfig::get('app_status_completed', 3)); //completed
        //$order->getCustomer()->setCustomerStatusId(sfConfig::get('app_status_completed', 3)); //completed
        $transaction->setTransactionStatusId(sfConfig::get('app_status_completed', 3)); //completed
        if ($transaction->getAmount() > $order_amount) {
            //error
            $order->setOrderStatusId(sfConfig::get('app_status_error', 5)); //error in amount
            $transaction->setTransactionStatusId(sfConfig::get('app_status_error', 5)); //error in amount
            //$order->getCustomer()->setCustomerStatusId(sfConfig::get('app_status_completed', 5)); //error in amount
        } else if ($transaction->getAmount() < $order_amount) {
            //$extra_refill_amount = $order_amount;
            $order->setExtraRefill($order_amount);
            $transaction->setAmount($order_amount);
        }
        //set active agent_package in case customer was registerred by an affiliate
        if ($order->getCustomer()->getAgentCompany()) {
            $order->setAgentCommissionPackageId($order->getCustomer()->getAgentCompany()->getAgentCommissionPackageId());
        }
        $ticket_id = $request->getParameter('transact');
        //set subscription id in case 'use current c.c for future auto refills' is set to 1
        //set auto_refill amount
    
        $order->save();
        $transaction->save();

        $this->customer = $order->getCustomer();
        $c = new Criteria;
        $c->add(CustomerPeer::ID, $order->getCustomerId());
        $customer = CustomerPeer::doSelectOne($c);
        echo "ag" . $agentid = $customer->getReferrerId();
        echo "prid" . $productid = $order->getProductId();
        echo "trid" . $transactionid = $transaction->getId();
        if (isset($agentid) && $agentid != "") {
            echo "getagentid";
            commissionLib::refilCustomer($agentid, $productid, $transactionid);
              $transaction->setAgentCompanyId($agentid);
           $transaction->save();
            
        }



        //TODO ask if recharge to be done is same as the transaction amount
        //die;
        $exest = $order->getExeStatus();
        if ($exest == 1) {
            
        } else {
            //  Fonet::recharge($this->customer, $transaction->getAmount());
            $vat = 0;

            $TelintaMobile = '49' . $this->customer->getMobileNumber();
            $emailId = $this->customer->getEmail();
            $OpeningBalance = $transaction->getAmount();
            $customerPassword = $this->customer->getPlainText();
            $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0, 1);     // bcdef
            if ($getFirstnumberofMobile == 0) {
                $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
                $TelintaMobile = '49' . $TelintaMobile;
            } else {
                $TelintaMobile = '49' . $this->customer->getMobileNumber();
            }

  $unidc=$this->customer->getUniqueid();

 echo $unidc;
 echo "<br/>";


    //echo $OpeningBalance."Balance";
    //echo "<br/>";
    
            //This is for Recharge the Customer
          //  $MinuesOpeningBalance = $OpeningBalance * 3;
            Telienta::recharge($this->customer, $OpeningBalance);
          
                         
            //This is for Recharge the Account
            //this condition for if follow me is Active
            $getvoipInfo = new Criteria();
            $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $this->customer->getMobileNumber());
            $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo); //->getId();
            if (isset($getvoipInfos)) {
                $voipnumbers = $getvoipInfos->getNumber();
                $voip_customer = $getvoipInfos->getCustomerId();
                // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$voipnumbers.'&amount='.$OpeningBalance.'&type=account');
            } else {
                //  $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name='.$uniqueId.'&amount='.$OpeningBalance.'&type=account');
            }
            // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name=a'.$TelintaMobile.'&amount='.$OpeningBalance.'&type=account');
            // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=recharge&name=cb'.$TelintaMobile.'&amount='.$OpeningBalance.'&type=account');

            $MinuesOpeningBalance = $OpeningBalance * 3;
            //type=<account_customer>&action=manual_charge&name=<name>&amount=<amount>
            //This is for Recharge the Customer
            // $telintaAddAccountCB = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=customer&action=manual_charge&name='.$uniqueId.'&amount='.$MinuesOpeningBalance);


            $subject = $this->getContext()->getI18N()->__('Payment Confirmation');
            $sender_email = sfConfig::get('app_email_sender_email', 'support@landncall.com');
            $sender_name = sfConfig::get('app_email_sender_name', 'LandNCall AB support');

            $recepient_email = trim($this->customer->getEmail());
            $recepient_name = sprintf('%s %s', $this->customer->getFirstName(), $this->customer->getLastName());
            $referrer_id = trim($this->customer->getReferrerId());

            if ($referrer_id):
                $c = new Criteria();
                $c->add(AgentCompanyPeer::ID, $referrer_id);

                $recepient_agent_email = AgentCompanyPeer::doSelectOne($c)->getEmail();
                $recepient_agent_name = AgentCompanyPeer::doSelectOne($c)->getName();
            endif;

            //send email

              $unidid = $this->customer->getUniqueid();
           
              $message_body = $this->getPartial('payments/order_receipt', array(
                        'customer' => $this->customer,
                        'order' => $order,
                        'transaction' => $transaction,
                        'vat' => $vat,
                        'wrap' => false
                    ));



            emailLib::sendCustomerRefillEmail($this->customer, $order, $transaction);
        }

        $order->setExeStatus(1);
        $order->save();
//echo 'NOOO';
// Update cloud 9
        //c9Wrapper::equateBalance($this->customer);
//echo 'Comeing';
        //set vat

        echo 'Yes';
        return sfView::NONE;
    }

    public function executeDeActivateAutoRefill(sfWebRequest $request) {



        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        
        //-----------------------
        $customerid = $request->getParameter('customer_id');
        $ca = new Criteria();
        $ca->add(CustomerPeer::ID, $customerid);
        $customer = CustomerPeer::doSelectOne($ca);

        $customer->setAutoRefillMinBalance(NULL);
        $customer->setAutoRefillAmount(NULL);
        $customer->save();
        $this->getUser()->setFlash('message', $this->getContext()->getI18N()->__('Auto Refill is deactivated.'));
        return $this->redirect('customer/dashboard');
        // return sfView::NONE;
    }
    public function executeActivateAutoRefill(sfWebRequest $request) {
          $this->getUser()->setCulture($request->getParameter('lng'));
        $urlval = $request->getParameter('transact');
        $customerid = $request->getParameter('customerid');
        $user_attr_3 = $request->getParameter('user_attr_3');
        $user_attr_2 = $request->getParameter('user_attr_2');
        $db1 = new DibsCall();
        $db1->setCallurl($urlval);
        $db1->save();
        $db2 = new DibsCall();
        $db2->setCallurl($customerid);
        $db2->save();
        $db3 = new DibsCall();
        $db3->setCallurl($user_attr_3);
        $db3->save();
        $db4 = new DibsCall();
        $db4->setCallurl($user_attr_2);
        $db4->save();
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        //-----------------------

        $ca = new Criteria();
        $ca->add(CustomerPeer::ID, $customerid);
        $customer = CustomerPeer::doSelectOne($ca);

        $customer->setAutoRefillMinBalance($user_attr_3);
        $customer->setAutoRefillAmount($user_attr_2);
        $customer->setTicketval($urlval);
        $customer->save();
        $this->getUser()->setFlash('message', $this->getContext()->getI18N()->__('Auto Refill is Activated.'));
        return $this->redirect('customer/dashboard');
    }


    public function executeShortUniqueIds(sfWebRequest $request){
        
    }
  public function executeChangeCulture(sfWebRequest $request){

     // var_dump($request->getParameter('new'));
        $this->getUser()->setCulture($request->getParameter('new'));
       	//$this->redirect('customer/dashboard');
        $pathArray = $request->getPathInfoArray();
        $this->redirect($pathArray['HTTP_REFERER']);

    }
 public function executeTermsAndCondition(sfWebRequest $request){

    

    }
}
