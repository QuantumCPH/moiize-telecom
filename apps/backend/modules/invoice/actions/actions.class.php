<?php

/**
 * invoice actions.
 *
 * @package    zapnacrm
 * @subpackage invoice
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class invoiceActions extends autoinvoiceActions
{
	
	public function executeCreate($request)
	{
		$this->forward404();
	}
	
	public function executeEdit($request)
	{
		$this->forward404();
	}
	
	protected function addFiltersCriteria ($c)
	{

	  if (isset($this->filters['vat_no']) && $this->filters['vat_no'] !== '')
	  {
			$c->add(CompanyPeer::VAT_NO, strtr($this->filters['vat_no'], '*', '%'), Criteria::LIKE);
			$c->addJoin(CompanyPeer::ID, InvoicePeer::COMPANY_ID);
			
			$this->filters['company_id'] = '';
			$this->filters['invoice_status_id'] = '';
	  }
	  else
	  {
	  	parent::addFiltersCriteria($c);
	  }
		
	}



        function executeSelectIntervalRevenue(sfRequest $request)
	{


	}

        function executeRevenues(sfRequest $request)
	{

		$billing_start_date = date('Y-m-d h:m:s' ,strtotime($request->getParameter('start_date')));
		$billing_end_date  = date('Y-m-d h:m:s' ,strtotime($request->getParameter('end_date')));



//
//
//                 $con = Propel::getConnection('propel');
//  $sql = "Select  sum(billing_cdr_details.duration_minutes*call_rate_table.rate) as total_revenue FROM billing_cdr_details
//left join  call_rate_table on  billing_cdr_details.call_rate_table_id=call_rate_table.call_rate_table_id
//WHERE
//  billing_cdr_details.call_time>='2010-11-15  00:00:00'
//AND   billing_cdr_details.call_time<='2011-01-14 00:00:00'";
//  $stmt = $con->createStatement();
//  // or FETCHMODE_ASSOC if you wish
//  $rs = $stmt->executeQuery($sql, ResultSet::FETCHMODE_NUM);
//    $rs =parent::doSelectRS($rs);
//  print_r($rs);
//  die;
//                Select  sum(billing_cdr_details.duration_minutes*call_rate_table.rate) as total_revenue FROM billing_cdr_details
//left join  call_rate_table on  billing_cdr_details.call_rate_table_id=call_rate_table.call_rate_table_id
//WHERE
//  billing_cdr_details.call_time>='2010-11-15  00:00:00'
//AND   billing_cdr_details.call_time<='2011-01-14 00:00:00';*CallRateTablePeer::RATE.BillingCdrDetailsPeer::DURATION_MINUTES


          
        //    $cr->clearSelectColumns();
     
     //  $cr->addAsColumn('revenu','SUM('.BillingCdrDetailsPeer::DURATION_MINUTES.')');
       //   $cr->addSelectColumn('SUM('.BillingCdrDetailsPeer::DURATION_MINUTES.') as revenu');

  $cr = new Criteria();

         $cr->addJoin( BillingCdrDetailsPeer::CALL_RATE_TABLE_ID,  CallRateTablePeer::CALL_RATE_TABLE_ID ,  Criteria::LEFT_JOIN);
            $criterion = $cr->getNewCriterion(BillingCdrDetailsPeer::CALL_TIME, $billing_start_date, Criteria::GREATER_EQUAL);
            $criterion->addAnd($cr->getNewCriterion(BillingCdrDetailsPeer::CALL_TIME, $billing_end_date, Criteria::LESS_EQUAL));
  
            $cr->add($criterion);
  
              $revenues = BillingCdrDetailsPeer::doSelect($cr);
         $totaraterevenue=0.00;
         $ratevalue=0;
         $ratecountvalue=0;
          foreach($revenues as $revenue){
              
              
               $crr = new Criteria();
                    $crr->add(CallRateTablePeer::CALL_RATE_TABLE_ID, $revenue->getCallRateTableID());
                       $crr->add(CallRateTablePeer::CALL_RATE_TABLE_ID, $revenue->getCallRateTableID());
                       $rateprise = CallRateTablePeer::doSelectOne($crr);
                       $ratevalue=$rateprise->getRate();
              $ratecountvalue=$ratevalue*$revenue->getDurationMinutes();
                       $totaraterevenue=$totaraterevenue+$ratecountvalue;
          }
    
             $this->startdate=$billing_start_date;
                 $this->enddate=$billing_end_date;

            $this->totalrevenue=$totaraterevenue;
        }

	function executeSelectInterval(sfRequest $request)
	{
		
		if ($company_id = $request->getParameter('id'))
		{
			if($company = CompanyPeer::retrieveByPK($company_id))
			{
				$this->company_id = $company_id;
				$this->company_name = $company->getName();
				$this->company_registration_date = $company->getRegistrationDate('m/d/Y');
				
				$this->last_billing_date = 'n/a';
		
				if ($last_paid_invoice = Invoice::getLastPaidInvoice($company_id))
				{
					$this->last_billing_date = $last_paid_invoice->getBillingEndingDate('m/d/Y');
				}
			}
			else
			{
				$this->forward404();
			}
		}
		else
		{
			$this->forward404();
		}
		

	}


	function executeSelectIntervalCompanyList(sfRequest $request)
	{
			

	}


	////////////  Start Billing  Generation////////////////////////////////////////////////////////////////////////
function executeCompanies(sfRequest $request)
	{


		
		$billing_start_date = date('Y-m-d h:m:s' ,strtotime($request->getParameter('start_date')));
		$billing_end_date  = date('Y-m-d h:m:s' ,strtotime($request->getParameter('end_date')));

                   $cl = new Criteria();
                   $cl->addJoin(BillingCdrDetailsPeer::FROM_NUMBER, EmployeePeer::MOBILE_NUMBER, Criteria::LEFT_JOIN);
             $cl->addJoin(EmployeePeer::COMPANY_ID, CompanyPeer::ID, Criteria::LEFT_JOIN);
            
               $criterion = $cl->getNewCriterion(BillingCdrDetailsPeer::CALL_TIME, $billing_start_date, Criteria::GREATER_EQUAL);
               $criterion->addAnd($cl->getNewCriterion(BillingCdrDetailsPeer::CALL_TIME, $billing_end_date, Criteria::LESS_EQUAL));
                $cl->add($criterion);
                             $cl->addGroupByColumn(CompanyPeer::NAME);
                $companies = CompanyPeer::doSelect($cl);
              $this->companies =$companies;
///////////////////////////////////////////////////////////////////////////////////////

               $cr = new Criteria();

         $cr->addJoin( BillingCdrDetailsPeer::CALL_RATE_TABLE_ID,  CallRateTablePeer::CALL_RATE_TABLE_ID ,  Criteria::LEFT_JOIN);
            $criterion = $cr->getNewCriterion(BillingCdrDetailsPeer::CALL_TIME, $billing_start_date, Criteria::GREATER_EQUAL);
            $criterion->addAnd($cr->getNewCriterion(BillingCdrDetailsPeer::CALL_TIME, $billing_end_date, Criteria::LESS_EQUAL));

            $cr->add($criterion);

              $revenues = BillingCdrDetailsPeer::doSelect($cr);
         $totaraterevenue=0.00;
         $ratevalue=0;
         $ratecountvalue=0;
          foreach($revenues as $revenue){


               $crr = new Criteria();
                    $crr->add(CallRateTablePeer::CALL_RATE_TABLE_ID, $revenue->getCallRateTableID());
                       $crr->add(CallRateTablePeer::CALL_RATE_TABLE_ID, $revenue->getCallRateTableID());
                       $rateprise = CallRateTablePeer::doSelectOne($crr);
                       $ratevalue=$rateprise->getRate();
              $ratecountvalue=$ratevalue*$revenue->getDurationMinutes();
                       $totaraterevenue=$totaraterevenue+$ratecountvalue;
          }

             $this->startdate=$billing_start_date;
                 $this->enddate=$billing_end_date;

            $this->totalrevenue=$totaraterevenue;







        }

	function executeBilling(sfRequest $request)
	{


		$company_id = $request->getParameter('company_id');
		$billing_start_date = date('Y-m-d h:i:s' ,strtotime($request->getParameter('start_date')));
		$billing_end_date  = date('Y-m-d h:i:s' ,strtotime($request->getParameter('end_date')));
                
              //  echo $billing_start_date.'<br/>';
                //echo strtotime($request->getParameter('start_date')).'<br/>';
                
              //  echo $billing_end_date.'<br/>';;
                //echo $request->getParameter('end_date').'<br/>';
               
		$this->forward404Unless($company_id && $billing_start_date &&
								$billing_end_date);

		if(!($company = CompanyPeer::retrieveByPK($company_id)))
		{
			$this->forward404();
		}

            $billings=array();
            $ratings=array();
            $bilcharge=00.00;

             $ec = new Criteria();
             $ec->add(EmployeePeer::COMPANY_ID, $company_id);
             $employees = EmployeePeer::doSelect($ec);

             //employee for each loop
             $count = 1;
             $billing_details = array();
             
             foreach($employees as $employee){
                $bc = new Criteria();
                $bc->add(BillingCdrDetailsPeer::EMPLOYEE_ID,$employee->getId());
                $bc->addAnd(BillingCdrDetailsPeer::CALL_TIME, " call_time > '".$billing_start_date."' ", Criteria::CUSTOM);
                $bc->addAnd(BillingCdrDetailsPeer::CALL_TIME, " call_time  < '".$billing_end_date."' ", Criteria::CUSTOM);
                //$c->add(ItineraryPeer::START_TIME, "DATE(".ItineraryPeer::START_TIME . ") =
//".$start_time, Criteria::CUSTOM);
//                //$bc->addAsColumn('call_time',"select billing_cdr_details.call_time from billing_cdr_details where billing_cdr_details.call_time >= '".$billing_start_date."' and billing_cdr_details.call_time <= '".$billing_end_date."'");
//                //$bc->addAnd($bc->getColumnForAs('call_time'));
//
////                $bc->addAnd(BillingCdrDetailsPeer::CALL_TIME," call_time >= STR_TO_DATE('".$billing_start_date." 00:00:00', '%Y-%m-%d %H:%i:%S') and call_time <= STR_TO_DATE('".$billing_end_date." 00:00:00', '%Y-%m-%d %H:%i:%S')", Criteria::CUSTOM );
//                //$bc->addAnd(BillingCdrDetailsPeer::CALL_TIME," STR_TO_DATE('".$billing_end_date."00:00:00', '%Y-%m-%d %H:%i:%S')", Criteria::CUSTOM );
//                $criterion = $bc->getNewCriterion(BillingCdrDetailsPeer::CALL_TIME, "billing_cdr_details.call_time > str_to_date('".$billing_start_date."','%Y-%m-%d %H:%i:%S')", Criteria::CUSTOM);
//                $criterion2 = $bc->getNewCriterion(BillingCdrDetailsPeer::CALL_TIME,"billing_cdr_details.call_time < str_to_date('".$billing_end_date."','%Y-%m-%d %H:%i:%S')", Criteria::CUSTOM);
//                //$criterion->addAnd($bc->getNewCriterion(BillingCdrDetailsPeer::CALL_TIME, $billing_end_date, Criteria::LESS_EQUAL));
//                $bc->addAnd($criterion);
//                $bc->addAnd($criterion2);
                $bc->addGroupByColumn(BillingCdrDetailsPeer::CALL_RATE_TABLE_DESCRIPTION);
                $billings = BillingCdrDetailsPeer::doSelect($bc);

//                 $con = Propel::getConnection();
//                 $query = "SELECT * from billing_cdr_details where billing_cdr_details.employee_id=".$employee->getId()." and billing_cdr_details.call_time > '".$billing_start_date."' and billing_cdr_details.call_time < '".$billing_end_date."' group by billing_cdr_details.call_rate_table_description";
//
//                $billings = $con->exec($query);

                foreach($billings as $billing){
                     $billing_details[$count] = $billing;                   
                     $count = $count+1;
                }
                
             }
                $this->details = $billing_details;
                
                $invoice_id=$company->getInvoiceMethodId();
                $im = new Criteria();
                $im->add(InvoiceMethodPeer::ID,$invoice_id);
                $invoice = InvoiceMethodPeer::doSelectOne($im);
                $this->invoice_cost=$invoice->getCost();
                  $this->invoice_cost=$invoice->getCost();

		//create invoice
		$new_invoice = new Invoice();
		$new_invoice->setCompany($company);
		$new_invoice->setBillingStartingDate($billing_start_date);
		$new_invoice->setBillingEndingDate($billing_end_date);



		//get the billing_due_days for the company
		//$billing_due_days = $company->getPackage()->getBillingDueDays();
                $billing_due_days =$invoice->getBillingdays();
		$due_date = date("Y-m-d H:i:s", time()+((60*60)*24)*$billing_due_days);

		$new_invoice->setDueDate($due_date);
		$new_invoice->save();

		//$new_invoice->reload(true);
		//$new_invoice->get

		$this->invoice_meta = $new_invoice;
		$this->company_meta = $company;

		
//		print_r($this->getGroups($company_id, $billing_start_date, $billing_end_date));
		$this->groups = $this->getGroups($company_id, $billing_start_date, $billing_end_date);

		//get product listing for current billing period

		$c = new Criteria();
		$c->add(ProductOrderPeer::COMPANY_ID, $company_id);
		$c->add(ProductOrderPeer::CREATED_AT, $billing_start_date,CRITERIA::GREATER_EQUAL);
		$c->addAnd(ProductOrderPeer::CREATED_AT, "$billing_end_date 23:59:59", CRITERIA::LESS_EQUAL);

		$this->product_orders = ProductOrderPeer::doSelect($c);
//
                $this->setLayout(false);


                ////////////////////////////////////////////////////////////////////
	}
/////////////////////////////////////////////////////////////////

    public static  function CalculateMinute($seconds){
            $minutes=$seconds/60.00;
            return number_format(ceil($minutes),2);
        }


        ///////////////////////////////////////////////////////////
public static  function GetDestinationId($number){

$rateId=0;
//$number=;
$terminal=10;
$count=1;

//$number=str_replace(' ','',str_replace('-','',str_replace(')','',str_replace('(','',$number))));
while($terminal>1){
 $tcnumber=substr($number,2,$count);
  $r = new Criteria();
  //$r->add(CallRateTablePeer::DESTINATION_NO_FROM, strtr($tcnumber, '*', '%'), Criteria::LIKE);
  $r->add(CallRateTablePeer::DESTINATION_NO_FROM,  '%'.$tcnumber.'%', Criteria::LIKE);

 // $r->add(CallRateTablePeer::DESTINATION_NO_FROM, $tcnumber);
  $terminal = CallRateTablePeer::doCount($r);



 //$terminal=count($ratings);
if($terminal==1){
    $ratings=CallRateTablePeer::doSelect($r);
    foreach ($ratings as $rating){
        $rateId =$rating->getId();
        
    }
} 
if($terminal==0){

        //flag the numbers here !
}
$count=$count+1;
}

return $rateId;
}//end call cost
public static  function CallCost($number){

$bill_charge=0.00;
//$number;
$terminal=10;
$count=2;

//$number=str_replace(' ','',str_replace('-','',str_replace(')','',str_replace('(','',$number))));
while($terminal>1){
 $tcnumber=substr($number,2,$count);
  $r = new Criteria();
  //$r->add(CallRateTablePeer::DESTINATION_NO_FROM, strtr($tcnumber, '*', '%'), Criteria::LIKE);
  $r->add(CallRateTablePeer::DESTINATION_NO_FROM, $tcnumber.'%', Criteria::LIKE);

 // $r->add(CallRateTablePeer::DESTINATION_NO_FROM, $tcnumber);

 $terminal = CallRateTablePeer::doCount($r);
 //$terminal=count($ratings);
 //echo $terminal;
if($terminal==1){
    foreach ($ratings as $rating){
        $ratings=CallRateTablePeer::doSelect($r);
        $bill_charge =$rating->getRate();
        echo $number." : ";
    }
}
if($terminal==0){

        //$bill_charge = -100;
        //echo $tcnumber." : ";
    
}
$count=$count+1;
}

return number_format($bill_charge/100.00, 2);

}//end call cost

//public static  function GroupBilling($billings){
//
//    $collection = array();
//    $count = 1;
//    $minutes = 0;
//    foreach($billings as $billing){
//        $id = inviteActions::GetDestinationId($billing->getToNumber());
//
//        $individual = $minutes + inviteActions::CalculateMinute($billing->getDurationSecond());
//    }
//
//}
       //////////////////// End Billing Generation /////////////////////////////////////////////////////////////
	function executeGenerate(sfRequest $request)
	{
		//print_r($_REQUEST);
		
		$company_id = $request->getParameter('company_id');
		$billing_start_date = $request->getParameter('start_date');
		$billing_end_date  = $request->getParameter('end_date');
		
		$this->forward404Unless($company_id && $billing_start_date &&
								$billing_end_date);

		if(!($company = CompanyPeer::retrieveByPK($company_id)))
		{
			$this->forward404();
		}
		//expire each pending invoice
		
		$invoices;
		if ($invoices = Invoice::getPendingInvoices($company_id))
		{
    		$con = Propel::getConnection();
    		
    		$con->beginTransaction();

    		try 
    		{
				foreach($invoices as $invoice)
				{
					$invoice->setInvoiceStatusId(3); //set to expired
					$invoice->save();
				}
				
				$con->commit();
    		}
    		catch (Exception $e)
    		{
    			$con->rollback();
    			throw $e;
    		}
		}
		
		//create invoice
		$new_invoice = new Invoice();
		$new_invoice->setCompany($company);
		$new_invoice->setBillingStartingDate($billing_start_date);
		$new_invoice->setBillingEndingDate($billing_end_date);
		
		
		
		//get the billing_due_days for the company
		$billing_due_days = $company->getPackage()->getBillingDueDays();
		
		$due_date = date("Y-m-d H:i:s", time()+((60*60)*24)*$billing_due_days);
		$new_invoice->setDueDate($due_date);
		
		$new_invoice->save();
		
		//$new_invoice->reload(true);
		//$new_invoice->get
		
		$this->invoice_meta = $new_invoice;
		$this->company_meta = $company;
		
		//$this->invoice_fee = $company->getPackage()->getInvoiceFee();
		
		$billing_start_date = $this->formatDate($billing_start_date);
		$billing_end_date = $this->formatDate($billing_end_date);
		
//		print_r($this->getGroups($company_id, $billing_start_date, $billing_end_date));
		$this->groups = $this->getGroups($company_id, $billing_start_date, $billing_end_date);
		
		//get product listing for current billing period
		
		$c = new Criteria();
		$c->add(ProductOrderPeer::COMPANY_ID, $company_id);
		$c->add(ProductOrderPeer::CREATED_AT, $billing_start_date,CRITERIA::GREATER_EQUAL);
		$c->addAnd(ProductOrderPeer::CREATED_AT, "$billing_end_date 23:59:59", CRITERIA::LESS_EQUAL);
		
		$this->product_orders = ProductOrderPeer::doSelect($c);
		
		//$this->setLayout(false);
	}
	
	function executeDiscard(sfRequest $request)
	{
		$invoice_id = $request->getParameter('id');
		
		$this->forward404Unless($invoice_id);

		if(!($invoice = InvoicePeer::retrieveByPK($invoice_id)))
		{
			$this->forward404();
		}
		else 
		{
			$invoice->delete();	
			$this->getUser()->setFlash('notice', 'Invoice is discarded.');
			$this->redirect('invoice/selectInterval?id='.$invoice->getCompanyId());
		}
	}
	
	private function formatDate($date)
	{
		list($mon, $day, $year) = sscanf($date, '%2d/%2d/%4d');
		$newt = mktime(0, 0, 0, $mon, $day, $year);
		return date('Y-m-d', $newt);		
	}
	
	private function getGroups($company_id, $start_date='NULL', $end_date = 'NULL')
	{
		$conn = mysqli_connect('67.205.76.170', 'root', '1Qazxsw@', 'zerocalltest');
		
		if (!$conn) {
			printf("Can't connect to MySQL Server. Errorcode: %s\n", mysqli_connect_error());
			exit;
		}
		//$company_id=12;
		//$start_date = $end_date = 'NULL';
		
		$query = "call getCallSpecificationSummary($company_id, '$start_date', '$end_date')";
		//echo $query;
		$call_records = array();
		
		if ($result = mysqli_query($conn, $query)) {
			
			while( $call_record = mysqli_fetch_assoc($result) ){
				//foreach ($call_record as $key=>$value)
					$call_records[] = $call_record;
			}
			
			//print_r($call_records);
			
			$groups = $this->getGroupsOnFromNo($call_records);
			//echo count($call_records)."records<br/>";
			//echo count($groups)."groups<br/>";
			//print_r($groups[0]);
			
			
			//$total_sale_price = (float)getSumForAGroupField($groups[0], 'total_dur_secs');
			//echo 'total sale price = '.$total_sale_price;
			//echo count($groups). " - group(s) <br/>";
			
			return $groups;
		}
	}
	
	private function getGroupsOnFromNo($call_records)
	{
		$groups = array();
	
		$first_index = $last_index = 0;
		for ($i=0; $i<count($call_records); $i++)
		{
			if ($call_records[$i]['from_no'] == $call_records[$last_index]['from_no'])
			{
				$last_index = $i;
			}
			else
			{
				$groups[] = array_slice($call_records, $first_index, $last_index-$first_index+1);
				$first_index = $last_index = $i;
			}
			
			if ($i==(count($call_records)-1))
				$groups[] = array_slice($call_records, $first_index, $last_index-$first_index+1);
		}
		
		//echo count($groups). " - groups <br/>";
		return $groups;
	}
	
	function executeGetPdf(sfWebRequest $request)
	{
	

            $invoice_id = $request->getParameter('id');
		
		$this->forward404Unless($invoice_id);
				  
		if(!($invoice = InvoicePeer::retrieveByPK($invoice_id)))
		{
			$this->forward404();
		}
		else 
		{
			 $htmlcontent  = $invoice->getInvoiceHtml();
		}
	
		 $pdf_title = 'inv_'.$invoice->getCompany()->getName().date('dmY');
              

	//	header('Content-type: application/pdf');
		//header('Content-Disposition: attachment; filename="'.$pdf_title.'.pdf"');
		
		// $pdf_path = util::html2pdf($htmlcontent);
           
	//	 echo   file_get_contents($pdf_path = util::html2pdf($htmlcontent));
		
		//unlink($pdf_path); //delete temp pdf
		//unlink(str_replace('.pdf','.htm',$pdf_path)); //delete the htm
		
		exit(1);
	}
	
	function executeSendEmail(sfRequest $request)
	{

		//var_dump(sfConfig::get('app_email_invoice_smtp_host'));
		//exit;
		
		$invoice_id = $this->request->getParameter('id');
		
		$this->forward404Unless($invoice_id);
				  
		if(!($invoice = InvoicePeer::retrieveByPK($invoice_id)))
		{
			$this->forward404();
		}
		else 
		{
			$htmlcontent  = $invoice->getInvoiceHtml();
		}
		
		$pdf_path = util::html2pdf($htmlcontent);
                //create pdf from html
					// and return the the file path
            //	require_once(sfConfig::get('sf_lib_dir').'/swift/lib/swift_init.php');
		
		$invoice_file = sfConfig::get('sf_lib_dir').'/swift/lib/swift_init.php';
		$invoice_file = $pdf_path; //path to invoice file
		$subject = sfConfig::get('app_email_invoice_subject').sprintf(" %month, %year", date('F'), date('Y'));
				$sender_email = sfConfig::get('app_email_invoice_sender_email');
		$sender_name = sfConfig::get('app_email_invoice_sender_name');
		$recepient_email = trim($invoice->getCompany()->getEmail());
		$recepient_name = $invoice->getCompany()->getContactName();
		$body = sfConfig::get('app_email_invoice_body_header');
		/*
		$connection = Swift_SmtpTransport::newInstance()
						->setUsername('geniussadi@gmail.com')
						->setPassword('sesadi/2')
						->setEncryption('ssl')
						->setPort(465)
						->setHost('smtp.gmail.com');
		*/
		
		$test_recepient_email = sfConfig::get('app_email_test_recepient_email');
		if ($test_recepient_email !== 'off')
			$recepient_email = $test_recepient_email;
               // $recepient_email ="khanmuhammadmalik@gmail.com";
			
		$connection = Swift_SmtpTransport::newInstance()
					->setHost(sfConfig::get('app_email_smtp_host'));				
		
		$mailer = new Swift_Mailer($connection);
		
		$message = Swift_Message::newInstance($subject)
		         ->setFrom(array($sender_email => $sender_name))
		         ->setTo(array($recepient_email => $recepient_name))
		         ->setBody($body, 'text/html')
		         ->attach(Swift_Attachment::fromPath($pdf_path, 'application/pdf'))
		         ;  
        
		if ($mailer->send($message))
		{
			echo "<div class='notice'>Invoice has been sucessfully sent to $recepient_email.</div>";
		}
		else
		{
			echo "<div class='notice'>Error: Invoice not been sent</div>";
		}
		
		//unlink($pdf_path); //delete temp pdf
		//unlink(str_replace('.pdf','.htm',$invoice_file)); //delete the htm		

		//echo "<div class='notice'>Invoice has been sucessfully sent to $recepient_email.</div>";
		exit(1);
	}

}
