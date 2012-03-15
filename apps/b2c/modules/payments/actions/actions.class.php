<?php
require_once(sfConfig::get('sf_lib_dir') . '/changeLanguageCulture.php');
require_once(sfConfig::get('sf_lib_dir') . '/emailLib.php');
require_once(sfConfig::get('sf_lib_dir') . '/commissionLib.php');
require_once(sfConfig::get('sf_lib_dir') . '/smsCharacterReplacement.php');



/**
 * payments actions.
 *
 * @package    zapnacrm
 * @subpackage payments
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.6 2010-09-19 18:53:06 orehman Exp $
 */
class paymentsActions extends sfActions {
 private function getTargetUrl() {
        return sfConfig::get('app_main_url');
    }
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->forward('default', 'module');
    }

    public function executeThankyou(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11
      $lnaugeval=$request->getParameter('lng');
        if(isset($lnaugeval) && $lnaugeval!=''){
        $this->getUser()->setCulture($request->getParameter('lng'));
        }
        $urlval = "thanks-" . $request->getParameter('transact');

        $email2 = new DibsCall();
        $email2->setCallurl($urlval);

        $email2->save();
    }

    public function executeReject(sfWebRequest $request) {
      
        //get the order_id
        $order_id = $request->getParameter('orderid');
        //$error_text = substr($request->getParameter('errortext'), 0, strpos($request->getParameter('errortext'), '!'));
        $error_text = $this->getContext()->getI18N()->__('Payment is unfortunately not accepted because your information is incorrect, please try again by entering correct credit card information');

        $this->forward404Unless($order_id);

        $order = CustomerOrderPeer::retrieveByPK($order_id);
        $c = new Criteria();
        $c->add(TransactionPeer::ORDER_ID, $order_id);
        $transaction = TransactionPeer::doSelectOne($c);

        $this->forward404Unless($order);

        $order->setOrderStatusId(4); //cancelled

        $this->getUser()->setFlash('error_message',
                $error_text
        );

        $this->order = $order;
        $this->forward404Unless($this->order);

        $this->order_id = $order->getId();
        $this->amount = $transaction->getAmount();
        $this->form = new PaymentForm();

        $this->setTemplate('signup');
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $product_id = $this->getUser()->getAttribute('product_id', '', 'usersignup');
            $customer_id = $this->getUser()->getAttribute('customer_id', '', 'usersignup');

            if ($product_id == '' || $customer_id == '') {
                $this->forward404('Product or customer id not found in session');
            }

            $order = new Order();
            $transaction = new Transaction();
            $product = ProductPeer::retrieveByPK($product_id);

            $order->setProductId($product_id);
            $order->setCustomerId($customer_id);
            $order->setExtraRefill($form->getValue('extra_refill'));
            $order->setIsFirstOrder(1);

            $order->save();

            $transaction->setAmount($product->getPrice() + $order->getExtraRefill());
            $transaction->setDescription('Product order');
            $transaction->setOrderId($order->getId());
            $transaction->setCustomerId($customer_id);
            //$transaction->setTransactionStatusId() // default value 1

            $transaction->save();

            $this->processTransaction($form->getValues(), $transaction, $request);

            $this->redirect('@signup_complete');
        }
    }

    public function executeSignup(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11
      

        //$this->getUser()->setCulture('en');
        //$getCultue = $this->getUser()->getCulture();
        // Store data in the user session
        //$this->getUser()->setAttribute('activelanguage', $getCultue);

        $this->form = new PaymentForm();

///////////////////////postal charges section//////////////////////////////
        $lang =  'de';
        $this->lang = $lang;

        $countrylng = new Criteria();
        $countrylng->add(EnableCountryPeer::LANGUAGE_SYMBOL, $lang);
        $countrylng = EnableCountryPeer::doSelectOne($countrylng);
        if($countrylng){
            $countryName = $countrylng->getName();
            $languageSymbol = $countrylng->getLanguageSymbol();
            $lngId = $countrylng->getId();

            $postalcharges = new Criteria();
            $postalcharges->add(PostalChargesPeer::COUNTRY, $lngId);
            $postalcharges->add(PostalChargesPeer::STATUS, 1);
            $postalcharges = PostalChargesPeer::doSelectOne($postalcharges);
            if($postalcharges){
              $this->postalcharge =  $postalcharges->getCharges();
            }else{
                $this->postalcharge =  0;
            }
        }









///////////////////////////////////////////////////////////////////////////////////////
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
        //$transaction->setAmount($order->getProduct()->getPrice() - $order->getProduct()->getInitialBalance() + $order->getExtraRefill());
        $transaction->setAmount($order->getProduct()->getPrice() + $this->postalcharge + $order->getProduct()->getRegistrationFee()+(($this->postalcharge + $order->getProduct()->getRegistrationFee())*.25));
        //TODO: $transaction->setAmount($order->getProduct()->getPrice());
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

    protected function processTransaction($creditcardinfo = null, Transaction $transactionObj = null, sfWebRequest $request
    ) {

        $relay_script_url = 'https://relay.ditonlinebetalingssystem.dk/relay/v2/relay.cgi/';

        $transactionInfo = array(
            'cardno' => $creditcardinfo['cardno'],
            'expmonth' => $creditcardinfo['expmonth'],
            'expyear' => $creditcardinfo['expyear'],
            'cvc' => $creditcardinfo['cvc'],
            'merchantnumber' => sfConfig::get('app_epay_merchant_number'),
            'currency' => sfConfig::get('app_epay_currency'),
            'instantCapture' => sfConfig::get('app_epay_instant_capture'),
            'authemail' => sfConfig::get('app_epay_authemail'),
            'orderid' => $transactionObj->getOrderId(),
            'amount' => $transactionObj->getAmount(),
            'accepturl' => $relay_script_url . $this->getController()->genUrl('@epay_accept_url'),
            'declineurl' => $relay_script_url . $this->getController()->genUrl('@epay_reject_url'),
        );
    }

    public function executeShowReceipt(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
      

        //is authenticated
        $this->customer = CustomerPeer::retrieveByPK(
                        $this->getUser()->getAttribute('customer_id', null, 'usersession')
        );

        $this->redirectUnless($this->customer, '@customer_login');
        //check to see if transaction id is there

        $transaction_id = $request->getParameter('tid');

        $this->forward404Unless($transaction_id);

        //is this receipt really belongs to authenticated user

        $transaction = TransactionPeer::retrieveByPK($transaction_id);

        $this->forward404Unless($transaction->getCustomerId() == $this->customer->getId(), 'Not allowed');

        //set customer order
        $customer_order = CustomerOrderPeer::retrieveByPK($transaction->getOrderId());

        if ($customer_order) {
            $vat = $customer_order->getIsFirstOrder() ?
                    ($customer_order->getProduct()->getPrice() * $customer_order->getQuantity() -
                    $customer_order->getProduct()->getInitialBalance()) * .20 :
                    0;
        }
        else
            die('Error retreiving');


        $this->renderPartial('payments/order_receipt', array(
            'customer' => $this->customer,
            'order' => CustomerOrderPeer::retrieveByPK($transaction->getOrderId()),
            'transaction' => $transaction,
            'vat' => $vat,
        ));

        return sfView::NONE;
    }

    public function executeConfirmpayment(sfWebRequest $request) {

           $this->getUser()->setCulture($request->getParameter('lng'));
        $urlval = $request->getParameter('transact');
        $email2 = new DibsCall();
        $email2->setCallurl($urlval);
        $email2->save();
        $dibs = new DibsCall();
        $dibs->setCallurl("Ticket Number:".$request->getParameter('ticket'));
        $dibs->save();
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        //print_r($_REQUEST);  	
        // Store data in the user session
        //$this->getUser()->setAttribute('activelanguage', $getCultue);
        ////load the thankSuccess template

        if ($request->getParameter('transact') != '') {

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
            // echo $order_id.'<br />';
            $subscription_id = $request->getParameter('subscriptionid');
            $this->logMessage('sub id: ' . $subscription_id);
            $order_amount = $request->getParameter('amount') / 100;

            $this->forward404Unless($order_id || $order_amount);

            //get order object
            $order = CustomerOrderPeer::retrieveByPK($order_id);


            if (isset($ticket_id) && $ticket_id != "") {

                $subscriptionvalue = 0;

                $subscriptionvalue = $request->getParameter('subscriptionid');


                if (isset($subscriptionvalue) && $subscriptionvalue > 1) {
//  echo 'is autorefill activated';
                    //auto_refill_amount
                    $auto_refill_amount_choices = array_keys(ProductPeer::getRefillHashChoices());

                    $auto_refill_amount = in_array($request->getParameter('user_attr_2'), $auto_refill_amount_choices) ? $request->getParameter('user_attr_2') : $auto_refill_amount_choices[0];
                    $order->getCustomer()->setAutoRefillAmount($auto_refill_amount);


                    //auto_refill_lower_limit
                    $auto_refill_lower_limit_choices = array_keys(ProductPeer::getAutoRefillLowerLimitHashChoices());

                    $auto_refill_min_balance = in_array($request->getParameter('user_attr_3'), $auto_refill_lower_limit_choices) ? $request->getParameter('user_attr_3') : $auto_refill_lower_limit_choices[0];
                    $order->getCustomer()->setAutoRefillMinBalance($auto_refill_min_balance);

                    $order->getCustomer()->setTicketval($ticket_id);
                    $order->save();
                    $auto_refill_amount = "refill amount" . $auto_refill_amount;
                    $email2d = new DibsCall();
                    $email2d->setCallurl($auto_refill_amount);
                    $email2d->save();
                    $minbalance = "min balance" . $auto_refill_min_balance;
                    $email2dm = new DibsCall();
                    $email2dm->setCallurl($minbalance);
                    $email2dm->save();
                }
            }
            //check to see if that customer has already purchased this product
            $c = new Criteria();
            $c->add(CustomerProductPeer::CUSTOMER_ID, $order->getCustomerId());
            $c->addAnd(CustomerProductPeer::PRODUCT_ID, $order->getProductId());
            $c->addJoin(CustomerProductPeer::CUSTOMER_ID, CustomerPeer::ID);
            $c->addAnd(CustomerPeer::CUSTOMER_STATUS_ID, sfConfig::get('app_status_new'), Criteria::NOT_EQUAL);

            // echo 'retrieve order id: '.$order->getId().'<br />';

            if (CustomerProductPeer::doCount($c) != 0) {

                //Customer is already registered.
                echo 'Der Kunde ist bereits registriert.';
                //exit the script successfully
                return sfView::NONE;
            }

            //set subscription id
            //$order->getCustomer()->setSubscriptionId($subscription_id);
            //set auto_refill amount
            //if order is already completed > 404
            $this->forward404Unless($order->getOrderStatusId() != sfConfig::get('app_status_completed'));
            $this->forward404Unless($order);

            //  echo 'processing order <br />';

            $c = new Criteria;
            $c->add(TransactionPeer::ORDER_ID, $order_id);
            $transaction = TransactionPeer::doSelectOne($c);

            //  echo 'retrieved transaction<br />';

            if ($transaction->getAmount() > $order_amount || $transaction->getAmount() < $order_amount) {
                //error
                $order->setOrderStatusId(sfConfig::get('app_status_error')); //error in amount
                $transaction->setTransactionStatusId(sfConfig::get('app_status_error')); //error in amount
                $order->getCustomer()->setCustomerStatusId(sfConfig::get('app_status_error')); //error in amount
                echo 'setting error <br /> ';
            } else {
                //TODO: remove it
                $transaction->setAmount($order_amount);

                $order->setOrderStatusId(sfConfig::get('app_status_completed')); //completed
                $order->getCustomer()->setCustomerStatusId(sfConfig::get('app_status_completed')); //completed
                $transaction->setTransactionStatusId(3); //completed
                // echo 'transaction=ok <br /> ';
                $is_transaction_ok = true;
            }


            $product_price = $order->getProduct()->getPrice() - $order->getExtraRefill();

            $product_price_vat = .20 * $product_price;

            $order->setQuantity(1);
            // $order->getCustomer()->getAgentCompany();
            //set active agent_package in case customer
            if ($order->getCustomer()->getAgentCompany()) {
                $order->setAgentCommissionPackageId($order->getCustomer()->getAgentCompany()->getAgentCommissionPackageId());
                $transaction->setAgentCompanyId($order->getCustomer()->getReferrerId()); //completed
            }

            $order->save();
            $transaction->save();
            if ($is_transaction_ok) {

                // echo 'Assigning Customer ID <br/>';
                //set customer's proudcts in use
                $customer_product = new CustomerProduct();

                $customer_product->setCustomer($order->getCustomer());
                $customer_product->setProduct($order->getProduct());

                $customer_product->save();

                //register to fonet
                $this->customer = $order->getCustomer();

                //Fonet::registerFonet($this->customer);
                //recharge the extra_refill/initial balance of the prouduct
                //Fonet::recharge($this->customer, $order->getExtraRefill());

                $cc = new Criteria();
                $cc->add(EnableCountryPeer::ID, $this->customer->getCountryId());
                $country = EnableCountryPeer::doSelectOne($cc);

                $mobile = $country->getCallingCode() . $this->customer->getMobileNumber();
                
                $getFirstnumberofMobile = substr($this->customer->getMobileNumber(), 0, 1);     // bcdef
                if ($getFirstnumberofMobile == 0) {
                    $TelintaMobile = substr($this->customer->getMobileNumber(), 1);
                    $TelintaMobile = '49' . $TelintaMobile;
                } else {
                    $TelintaMobile = '49' . $this->customer->getMobileNumber();
                }

                
                $uniqueId = $this->customer->getUniqueid();
                echo $uniqueId."<br/>";
                $uc = new Criteria();
                $uc->add(UniqueIdsPeer::UNIQUE_NUMBER, $uniqueId);
                $selectedUniqueId = UniqueIdsPeer::doSelectOne($uc);
                echo $selectedUniqueId->getStatus()."<br/>Baran";
                
                if($selectedUniqueId->getStatus()==0){
                    echo "inside";
                    $selectedUniqueId->setStatus(1);
                    $selectedUniqueId->setAssignedAt(date('Y-m-d H:i:s'));
                    $selectedUniqueId->save();
                    }else{
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
                        $this->customer->setUniqueid($uniqueId);
                        $this->customer->save();
                        $availableUniqueId->setStatus(1);
                        $availableUniqueId->setAssignedAt(date('Y-m-d H:i:s'));
                        $availableUniqueId->save();
                }



             $callbacklog = new CallbackLog();
                $callbacklog->setMobileNumber($TelintaMobile);
                $callbacklog->setuniqueId($uniqueId);
                $callbacklog->setCheckStatus(3);
                $callbacklog->save();




                $emailId = $this->customer->getEmail();
                $OpeningBalance = $order->getExtraRefill();
                $customerPassword = $this->customer->getPlainText();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Section For Telinta Add Cusomter
             
                    Telienta::ResgiterCustomer($this->customer, $OpeningBalance);
                      // For Telinta Add Account
               
                    Telienta::createAAccount($TelintaMobile,$this->customer);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //if the customer is invited, Give the invited customer a bonus of 10dkk
                $invite_c = new Criteria();
                $invite_c->add(InvitePeer::INVITE_NUMBER, $this->customer->getMobileNumber());
                $invite_c->add(InvitePeer::INVITE_STATUS, 2);
                $invite = InvitePeer::doSelectOne($invite_c);
                if ($invite) {
                    $invite->setInviteStatus(3);
                    $sc = new Criteria();
                    $sc->add(CustomerCommisionPeer::ID, 1);
                    $commisionary = CustomerCommisionPeer::doSelectOne($sc);
                    $comsion = $commisionary->getCommision();
                    $products = new Criteria();
                    $products->add(ProductPeer::ID, 2);
                    $products = ProductPeer::doSelectOne($products);
                    $extrarefill = $products->getInitialBalance();
                    //if the customer is invited, Give the invited customer a bonus of 10dkk
                    $inviteOrder = new CustomerOrder();
                    $inviteOrder->setProductId(2);
                    $inviteOrder->setQuantity(1);
                    $inviteOrder->setOrderStatusId(3);
                    $inviteOrder->setCustomerId($invite->getCustomerId());
                    $inviteOrder->setExtraRefill($extrarefill);
                    $inviteOrder->save();
                    $OrderId = $inviteOrder->getId();
                    // make a new transaction to show in payment history
                    $transaction_i = new Transaction();
                    $transaction_i->setAmount($comsion);
                    $transaction_i->setDescription('Invitation Bonus');
                    $transaction_i->setCustomerId($invite->getCustomerId());
                    $transaction_i->setOrderId($OrderId);
                    $transaction_i->setTransactionStatusId(3);

                    $this->customers = CustomerPeer::retrieveByPK($invite->getCustomerId());

                    //send Telinta query to update the balance of invite by 10dkk
                    $getFirstnumberofMobile = substr($this->customers->getMobileNumber(), 0, 1);     // bcdef
                    if ($getFirstnumberofMobile == 0) {
                        $TelintaMobile = substr($this->customers->getMobileNumber(), 1);
                        $TelintaMobile = '49' . $TelintaMobile;
                    } else {
                        $TelintaMobile = '49' . $this->customers->getMobileNumber();
                    }
                    $uniqueId = $this->customers->getUniqueid();
                    $OpeningBalance = $comsion;
                    //This is for Recharge the Customer
                
                         Telienta::recharge($this->customers, $OpeningBalance);

                    //This is for Recharge the Account
                 
                    $transaction_i->save();
                    $invite->save();

                    $invitevar = $invite->getCustomerId();
                    if (isset($invitevar)) {

                         if($this->getUser()->getCulture()=='en'){

          $subject ='Bonus awarded';
   }else{
         $subject ='Bonus vergeben';
   }

  //email abou bonus
    //   emailLib::sendCustomerConfirmRegistrationEmail(1,1,$subject);

                        emailLib::sendCustomerConfirmRegistrationEmail($invite->getCustomerId(),$this->customer,$subject);
                    }
                }
              $lang = 'de';
            $this->lang = $lang;

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
                $message_body = $this->getPartial('payments/order_receipt', array(
                            'customer' => $this->customer,
                            'order' => $order,
                            'transaction' => $transaction,
                            'vat' => $product_price_vat,
                            'postalcharge' => $postalcharge,
                            'wrap' => true
                        ));

                $subject = $this->getContext()->getI18N()->__('Payment Confirmation');
                $sender_email = sfConfig::get('app_email_sender_email', 'support@wls2.com');
                $sender_name = sfConfig::get('app_email_sender_name', 'WLS2 support');

                $recepient_email = trim($this->customer->getEmail());
                $recepient_name = sprintf('%s %s', $this->customer->getFirstName(), $this->customer->getLastName());


                $agentid = $this->customer->getReferrerId();

                $cp = new Criteria;
                $cp->add(CustomerProductPeer::CUSTOMER_ID, $order->getCustomerId());
                $customerproduct = CustomerProductPeer::doSelectOne($cp);
                $productid = $customerproduct->getId();

                $transactionid = $transaction->getId();
                if (isset($agentid) && $agentid != "") {
                    commissionLib::registrationCommissionCustomer($agentid, $productid, $transactionid);
                }
             
                emailLib::sendCustomerRegistrationViaWebEmail($this->customer, $order);


                $this->order = $order;
            }//end if
            else {
                $this->logMessage('Error in transaction.');
            } 
        }
    }

    public function executeCtpay(sfWebRequest $request) {
      
        $urlval = $request->getParameter('transact');
        $email2 = new DibsCall();
        $email2->setCallurl($urlval);
        $email2->save();
    }

  public function executeTest(sfWebRequest $request) {


  
       return sfView::NONE;
    }
 
}
