<?php
require_once(sfConfig::get('sf_lib_dir').'/parsecsv.lib.php');
require_once(sfConfig::get('sf_lib_dir').'/telinta.class.php');
 
/**
 * customer actions.
 *
 * @package    zapnacrm
 * @subpackage customer
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1 2010-08-05 20:37:53 orehman Exp $
 */
class customerActions extends autocustomerActions
{


     public function executeDeActivateCustomer(sfWebRequest $request)
  {

     $response_text = 'Response From Server: <br/>';
     $this->response_text=$response_text;

     if (isset($_GET['customer_id'])) {
     $deactive_code=6;
     $removal_code=0;

     $customer_id = $request->getParameter('customer_id');
     $response_text .= 'searching for customer id = '.$customer_id;
     $response_text .= '<br/>';

     $this->response_text=$response_text;

     $c = new Criteria();
     $c->add(CustomerPeer::ID,$customer_id );
     $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 6, Criteria::NOT_EQUAL);
     $customer = CustomerPeer::doSelectOne($c);
     if(!$customer){

        $response_text .= 'Customer not active, exiting';
        $response_text .= '<br/>';

        $this->response_text=$response_text;


     }else{

     $response_text .= "Customer Found";
     $response_text .="<br/>";

     $response_text .="Mobile Number = ".$customer->getMobileNumber()." , Fonet ID = ".$customer->getFonetCustomerId();
     $response_text .="<br/>";
     if (Fonet::unregister($customer, false))
                     $response_text .= sprintf("%s is unregistered<br />", $customer->getMobileNumber());
     if ($current_balance = Fonet::getBalance($customer, false))
                      $response_text .= sprintf("Current balance of custoemr is %s<br />", $current_balance);
      if (Fonet::recharge($customer, -$current_balance, false))
                      $response_text .= sprintf("current balance is made 0<br />");

      $con = Propel::getConnection();

      $con->exec('set foreign_key_checks=0');
      $response_text .= 'disabling foreign keys';
      $response_text .= '<br/>';


      $con->exec('UPDATE transaction  SET  transaction_status_id=6  where customer_id='.$customer_id);
      $response_text .= 'transactions deleted';
      $response_text .= '<br/>';

      $con->exec('UPDATE customer_order  SET  order_status_id=6 where customer_id='.$customer_id);
      $response_text .= 'customer order deleted';
      $response_text .= '<br/>';

   //   $con->exec('DELETE FROM customer_product where customer_id='.$customer_id);
     // $response_text .= 'customer product deleted';
     // $response_text .= '<br/>';

      if($customer->getFonetCustomerId()!=NULL){
      $con->exec("UPDATE fonet_customer SET activated_on = NULL where fonet_customer_id=".$customer->getFonetCustomerId());
      $response_text .= 'fonet id freed ';
      $response_text .= '<br/>';
      }

      $con->exec('Update customer set customer_status_id='.$deactive_code.' where id='.$customer_id);
      $response_text .= 'customer status set to 6 (de-activated)';
      $response_text .= '<br/>';

      $response_text .= "Customer De-activated, Customer Id=".$customer_id;
      $response_text .= '<br/>';

      $response_text .= "Exiting gracefully ... done!";

      $this->response_text=$response_text;
     }
     }

      $this->response_text=$response_text;

  }


    public function executeRegisteredByWeb(sfWebRequest $request)
    {
        $c= new Criteria();
        $c->add(CustomerPeer::REFERRER_ID, NULL );
        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);       
        $this->customers = CustomerPeer::doSelect($c);
           
    }

    public function executeRegisteredByAgent(sfWebRequest $request)
    {
        $c= new Criteria();
        $c->add(CustomerPeer::REFERRER_ID, 0, Criteria::GREATER_THAN );

        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
         $c->add(CustomerPeer::REGISTRATION_TYPE_ID, 2);
        $this->customers = CustomerPeer::doSelect($c);

    }

    public function executeRegisteredByApp(sfWebRequest $request)
    {
        $c= new Criteria();
        //$c->add(CustomerPeer::REFERRER_ID, 0, Criteria::GREATER_THAN );
        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
         $c->add(CustomerPeer::REGISTRATION_TYPE_ID, 5);
        $this->customers = CustomerPeer::doSelect($c);

    }
    
    public function executeRegisteredBySms(sfWebRequest $request)
    {
        $c= new Criteria();                
        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
         $c->add(CustomerPeer::REGISTRATION_TYPE_ID, 4);
        $this->customers = CustomerPeer::doSelect($c);
        
    }

    public function executeRegisteredByAgentLink(sfWebRequest $request)
    {
        $c= new Criteria();
        $c->add(CustomerPeer::REFERRER_ID, 0, Criteria::GREATER_THAN );
        $c->add(CustomerPeer::SUBSCRIPTION_ID, 0, Criteria::GREATER_THAN);
         $c->add(CustomerPeer::REGISTRATION_TYPE_ID, 3);
        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
        $this->customers = CustomerPeer::doSelect($c);

    }


    public function executePartialRegisteredByWeb(sfWebRequest $request)
    {
        $c= new Criteria();
        $c->add(CustomerPeer::REFERRER_ID, NULL );
        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3, Criteria::NOT_EQUAL);
         $c->add(CustomerPeer::REGISTRATION_TYPE_ID, 1);
        $this->customers = CustomerPeer::doSelect($c);

    }


    public function executePartialRegisteredByAgent(sfWebRequest $request)
    {
        $c= new Criteria();
        $c->add(CustomerPeer::REFERRER_ID, 0, Criteria::GREATER_THAN );
        $c->add(CustomerPeer::SUBSCRIPTION_ID, NULL);
        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3, Criteria::NOT_EQUAL);
        $this->customers = CustomerPeer::doSelect($c);
    }

    public function executePartialRegisteredByAgentLink(sfWebRequest $request)
    {
        $c= new Criteria();
        $c->add(CustomerPeer::REFERRER_ID, 0, Criteria::GREATER_THAN );
        $c->add(CustomerPeer::SUBSCRIPTION_ID, 0, Criteria::GREATER_THAN);
        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3, Criteria::NOT_EQUAL);
        $this->customers = CustomerPeer::doSelect($c);

    }

     public function executeAllRegisteredCustomer(sfWebRequest $request)
    {
        $c= new Criteria();
        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
        $this->customers = CustomerPeer::doSelect($c);

    }
  public function executeCustomerDetail(sfWebRequest $request)
    {

        $id = $request->getParameter('id');
        $c= new Criteria();
        $c->add(CustomerPeer::ID, $id);
        $c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
        $this->customer = CustomerPeer::doSelectOne($c);
$this->customer_balance = (double)Fonet::getBalance($this->customer);
    }
public function executePaymenthistory(sfWebRequest $request)
	{


		$this->customer = CustomerPeer::retrieveByPK($request->getParameter('id'));

		$this->redirectUnless($this->customer, "@homepage");

		//get  transactions
		$c = new Criteria();

		$c->add(TransactionPeer::CUSTOMER_ID, $this->customer->getId());
		$c->add(TransactionPeer::TRANSACTION_STATUS_ID,3);
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
                
                $country_id = $this->customer->getCountryId();
                $enableCountry = new Criteria();
                $enableCountry->add(EnableCountryPeer::ID, $country_id);
                $country_id = EnableCountryPeer::doSelectOne($enableCountry);//->getId();
                if($country_id){
                    $langSym = $country_id->getLanguageSymbol();
                }else{
                    $langSym = 'da';
                }
                //--------------------------------------------------------
                //$lang =  $this->getUser()->getAttribute('activelanguage');
                $lang =  $langSym;
                $this->lang = $lang;
                //--------------------------------------------------------

		$c->addDescendingOrderByColumn(TransactionPeer::CREATED_AT);
             $this->transactions =TransactionPeer::doSelect($c);
		//set paging
//		$items_per_page = 10; //shouldn't be 0
//		$this->page = $request->getParameter('page');
//        if($this->page == '') $this->page = 1;
//
//        $pager = new sfPropelPager('Transaction', $items_per_page);
//        $pager->setPage($this->page);
//
//        $pager->setCriteria($c);
//
//        $pager->init();

      //  $this->transactions = $pager->getResults();
		//$this->total_pages = $pager->getNbResults() / $items_per_page;



	}
	public function executeCallhistory(sfWebRequest $request)
	{

            //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
           // $id = $request->getParameter('id');


		//$this->customer = CustomerPeer::retrieveByPK(58);
		$this->customer = CustomerPeer::retrieveByPK($request->getParameter('id'));
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


                    $c = new Criteria();
                    $c->add(BillingPeer::CUSTOMER_ID, $this->customer->getId());
                    $c->addDescendingOrderByColumn(BillingPeer::TIME);



//		//setting filter
//		$this->filter = new ZerocallCdrFormFilter();
//
//		if ($request->getParameter('zerocall_cdr_log_filters'))
//		{
//			$c->add($this->filter->buildCriteria($request->getParameter('zerocall_cdr_log_filters')));
//			//$this->filter->bind($request->getParameter('zerocall_cdr_log_filters'));
//		}

		//set paging
		$items_per_page = 25; //shouldn't be 0
		$this->page = $request->getParameter('page');
                if($this->page == '') $this->page = 1;

                $pager = new sfPropelPager('Billing', $items_per_page);
                $pager->setPage($this->page);

                $pager->setCriteria($c);

                $pager->init();

                $this->callRecords = $pager->getResults();
                $this->total_pages = $pager->getNbResults() / $items_per_page;

	}

}
