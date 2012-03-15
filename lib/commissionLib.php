<?php

class commissionLib{

      public static function registrationCommission($gentid,$productid,$transactionid)
    {



    $agent_company_id=$gentid;
$transactionid=$transactionid;
     $tr = new Criteria();
	$tr->add(TransactionPeer::ID, $transactionid);
        $transaction = TransactionPeer::doSelectOne($tr);


         $or = new Criteria();
	$or->add(CustomerOrderPeer::ID, $transaction->getOrderId());
        $order = CustomerOrderPeer::doSelectOne($or);

  $ca = new Criteria();
	$ca->add(AgentCompanyPeer::ID, $agent_company_id);
        $agent = AgentCompanyPeer::doSelectOne($ca);
        echo $agent->getId();

        //getting agent commission
        $cc = new Criteria();
        $cc->add(AgentCommissionPackagePeer::ID, $agent->getAgentCommissionPackageId());
        $commission_package = AgentCommissionPackagePeer::doSelectOne($cc);

                ///////////////////////////commision calculation by agent product ///////////////////////////////////////
                    $cp = new Criteria;
                    $cp->add(AgentProductPeer::AGENT_ID, $agent_company_id);
                     $cp->add(AgentProductPeer::PRODUCT_ID,$productid);
                    $agentproductcount = AgentProductPeer::doCount($cp);
                    $cs = new Criteria;
                    $cs->add(CustomerPeer::ID, $order->getCustomerId());
                    $customer = CustomerPeer::doSelectOne($cs);

                    if($agentproductcount>0){
                      $p = new Criteria;
                      $p->add(AgentProductPeer::AGENT_ID, $agent_company_id);
                      $p->add(AgentProductPeer::PRODUCT_ID,$productid);

                    $agentproductcomesion = AgentProductPeer::doSelectOne($p);
                   $agentcomession=$agentproductcomesion->getRegShareEnable();
                    }

                      ////////   commission setting  through  agent commision//////////////////////

                    if(isset($agentcomession) && $agentcomession!=""){


                if($order->getIsFirstOrder()){
                    if($agentproductcomesion->getIsRegShareValuePc()){
                        $transaction->setCommissionAmount(($transaction->getAmount()/100) * $agentproductcomesion->getRegShareValue());
                    }else{

                        $transaction->setCommissionAmount( $agentproductcomesion->getRegShareValue());
                    }
                }else{
                    if($agentproductcomesion->getIsExtraPaymentsShareValuePc()){
                            $transaction->setAgentCommission(($transaction->getAmount()/100) * $agentproductcomesion->getExtraPaymentsShareValue());
                    }else{
                            $transaction->setAgentCommission($agentproductcomesion->getExtraPaymentsShareValue());
                    }

                }




                    }else{

                if($order->getIsFirstOrder()){
                    if($commission_package->getIsRegShareValuePc()){
                        $transaction->setCommissionAmount(($transaction->getAmount()/100) * $commission_package->getRegShareValue());
                    }else{

                        $transaction->setCommissionAmount( $commission_package->getRegShareValue());
                    }
                }else{
                    if($commission_package->getIsExtraPaymentsShareValuePc()){
                            $transaction->setAgentCommission(($transaction->getAmount()/100) * $commission_package->getExtraPaymentsShareValue());
                    }else{
                            $transaction->setAgentCommission($commission_package->getExtraPaymentsShareValue());
                    }

                }
                    }


	$transaction->save();




/////////////////////////end of commission setting ////////////////////////////////////////////
                   echo 'entering if';
                   echo '<br/>';
                if ($agent->getIsPrepaid()==true)
	  	{

                   echo 'agent is prepaid';
                   echo '<br/>';
                   echo $agent->getBalance();
                   echo '<br/>';
                   echo $transaction->getCommissionAmount();
                   echo '<br/>';
                   echo $agent->getBalance() < $transaction->getCommissionAmount();

                    if($agent->getBalance() < ($transaction->getAmount() - $transaction->getCommissionAmount()) ) {
                      //  $this->redirect('affiliate/setProductDetails?product_id='.$order->getProductId().'&customer_id='.$transaction->getCustomerId().'&balance_error=1');
                  $varerror="balance_error";

                  ///////////////////////////////////////////////////
                            $transaction->setTransactionStatusId(1);
                            $transaction->save();
                  ///////////////////////////////////////////////////

                               $order->setOrderStatusId(1);
                                 $order->save();
                //////////////////////////////////////////////////////////
                   $customer->setCustomerStatusId(1);

                   $customer->save();
              ////////////////////////////////////////////////////////////////////////
                       return $varerror;
                        }
                    $agent->setBalance($agent->getBalance() - ($transaction->getAmount() - $transaction->getCommissionAmount()));
                    $agent->save();
                    ////////////////////////////////////
                      $remainingbalance=$agent->getBalance();
                    $amount=$transaction->getAmount() - $transaction->getCommissionAmount();
                       $amount=-$amount;
                     $aph = new AgentPaymentHistory();
                     $aph->setAgentId($agent_company_id);
                     $aph->setCustomerId($transaction->getCustomerId());
                     $aph->setExpeneseType(1);
                     $aph->setAmount($amount);
                     $aph->setRemainingBalance($remainingbalance);
                     $aph->save();




                    ////////////////////////////////////////////







                    }

                    $varerror="success";


                    return $varerror;
                }


    public static function registrationCommissionCustomer($gentid,$productid,$transactionid)
    {

    $agent_company_id=$gentid;
$transactionid=$transactionid;
     $tr = new Criteria();
	$tr->add(TransactionPeer::ID, $transactionid);
        $transaction = TransactionPeer::doSelectOne($tr);


         $or = new Criteria();
	$or->add(CustomerOrderPeer::ID, $transaction->getOrderId());
        $order = CustomerOrderPeer::doSelectOne($or);

     $ca = new Criteria();
	$ca->add(AgentCompanyPeer::ID, $agent_company_id);
        $agent = AgentCompanyPeer::doSelectOne($ca);
       //$agent->getId();

        //getting agent commission
        $cc = new Criteria();
        $cc->add(AgentCommissionPackagePeer::ID, $agent->getAgentCommissionPackageId());
        $commission_package = AgentCommissionPackagePeer::doSelectOne($cc);

                ///////////////////////////commision calculation by agent product ///////////////////////////////////////
                    $cp = new Criteria;
                    $cp->add(AgentProductPeer::AGENT_ID, $agent_company_id);
                     $cp->add(AgentProductPeer::PRODUCT_ID,$productid);
                    $agentproductcount = AgentProductPeer::doCount($cp);
                    $cs = new Criteria;
                    $cs->add(CustomerPeer::ID, $order->getCustomerId());
                    $customer = CustomerPeer::doSelectOne($cs);

                    if($agentproductcount>0){
                      $p = new Criteria;
                      $p->add(AgentProductPeer::AGENT_ID, $agent_company_id);
                      $p->add(AgentProductPeer::PRODUCT_ID,$productid);

                    $agentproductcomesion = AgentProductPeer::doSelectOne($p);
                   $agentcomession=$agentproductcomesion->getRegShareEnable();
                    }

                      ////////   commission setting  through  agent commision//////////////////////

                    if(isset($agentcomession) && $agentcomession!=""){


                if($order->getIsFirstOrder()){
                    if($agentproductcomesion->getIsRegShareValuePc()){
                        $transaction->setCommissionAmount(($transaction->getAmount()/100) * $agentproductcomesion->getRegShareValue());
                    }else{

                        $transaction->setCommissionAmount( $agentproductcomesion->getRegShareValue());
                    }
                }else{
                    if($agentproductcomesion->getIsExtraPaymentsShareValuePc()){
                            $transaction->setAgentCommission(($transaction->getAmount()/100) * $agentproductcomesion->getExtraPaymentsShareValue());
                    }else{
                            $transaction->setAgentCommission($agentproductcomesion->getExtraPaymentsShareValue());
                    }

                }




                    }else{

                if($order->getIsFirstOrder()){
                    if($commission_package->getIsRegShareValuePc()){
                        $transaction->setCommissionAmount(($transaction->getAmount()/100) * $commission_package->getRegShareValue());
                    }else{

                        $transaction->setCommissionAmount( $commission_package->getRegShareValue());
                    }
                }else{
                    if($commission_package->getIsExtraPaymentsShareValuePc()){
                            $transaction->setAgentCommission(($transaction->getAmount()/100) * $commission_package->getExtraPaymentsShareValue());
                    }else{
                            $transaction->setAgentCommission($commission_package->getExtraPaymentsShareValue());
                    }

                }
                    }


	$transaction->save();




/////////////////////////end of commission setting ////////////////////////////////////////////
                   //echo 'entering if';
                  // echo '<br/>';
                if ($agent->getIsPrepaid()==true)
	  	{

                  // echo 'agent is prepaid';
                  // echo '<br/>';
                  $agent->getBalance();
                   //echo '<br/>';
                   $transaction->getCommissionAmount();
                  // echo '<br/>';
                 

                    $agent->setBalance($agent->getBalance()+ $transaction->getCommissionAmount());
                    $agent->save();
                    ////////////////////////////////////
                      $remainingbalance=$agent->getBalance();
                    $amount=$transaction->getCommissionAmount();
                       $amount=$amount;
                     $aph = new AgentPaymentHistory();
                     $aph->setAgentId($agent_company_id);
                     $aph->setCustomerId($transaction->getCustomerId());
                     $aph->setExpeneseType(1);
                     $aph->setAmount($amount);
                     $aph->setRemainingBalance($remainingbalance);
                     $aph->save();




                    ////////////////////////////////////////////







                    }

                    $varerror="success";


                    return $varerror;
                }


///////////////////////////////////////////////////////////////////////////////////////
           public static function refilCustomer($gentid,$productid,$transactionid)
    {

   /////////////////////////////////////////////////////////////////////////////////////////////////

    $agent_company_id=$gentid;
$transactionid=$transactionid;
     $tr = new Criteria();
	$tr->add(TransactionPeer::ID, $transactionid);
        $transaction = TransactionPeer::doSelectOne($tr);
        
                 $or = new Criteria();
	$or->add(CustomerOrderPeer::ID, $transaction->getOrderId());
        $order = CustomerOrderPeer::doSelectOne($or);

     $ca = new Criteria();
	$ca->add(AgentCompanyPeer::ID, $agent_company_id);
        $agent = AgentCompanyPeer::doSelectOne($ca);
        echo $agent->getId();

        //getting agent commission
        $cc = new Criteria();
        $cc->add(AgentCommissionPackagePeer::ID, $agent->getAgentCommissionPackageId());
        $commission_package = AgentCommissionPackagePeer::doSelectOne($cc);

                ///////////////////////////commision calculation by agent product ///////////////////////////////////////
                    $cp = new Criteria;
                    $cp->add(AgentProductPeer::AGENT_ID, $agent_company_id);
                     $cp->add(AgentProductPeer::PRODUCT_ID,$productid);
                    $agentproductcount = AgentProductPeer::doCount($cp);
                    $cs = new Criteria;
                    $cs->add(CustomerPeer::ID, $order->getCustomerId());
                    $customer = CustomerPeer::doSelectOne($cs);

                    if($agentproductcount>0){
                      $p = new Criteria;
                      $p->add(AgentProductPeer::AGENT_ID, $agent_company_id);
                      $p->add(AgentProductPeer::PRODUCT_ID,$order->getProductId());

                    $agentproductcomesion = AgentProductPeer::doSelectOne($p);
                   $agentcomession=$agentproductcomesion->getExtraPaymentsShareEnable();
                    }

                      ////////   commission setting  through  agent commision//////////////////////

                    if(isset($agentcomession) && $agentcomession!=""){

                    if($agentproductcomesion->getIsExtraPaymentsShareValuePc()){

                        $transaction->setCommissionAmount(($transaction->getAmount()/100) * $agentproductcomesion->getExtraPaymentsShareValue());
                    }else{



                        $transaction->setCommissionAmount($agentproductcomesion->getExtraPaymentsShareValue());
                    }

                    }else{


                                if($commission_package->getIsExtraPaymentsShareValuePc()){
                                            $transaction->setCommissionAmount(($transaction->getAmount()/100) * $commission_package->getExtraPaymentsShareValue());
                                }else{
                                            $transaction->setCommissionAmount($commission_package->getExtraPaymentsShareValue());
                                }
                    }

                                //calculated amount for agent commission
                              


                                    $is_recharged=1;

//                                echo 'is_recharged '.$is_recharged;
//                                echo '<br/>';
				if ($is_recharged)
				{
//                                    echo 'isrecharged = true';
                                    $transaction->save();

                                    if($agent->getIsPrepaid()==true){
                                        $agent->setBalance($agent->getBalance() +$transaction->getCommissionAmount());
                                       $agent->save();
                                        $remainingbalance=$agent->getBalance();
                                        $amount=$transaction->getCommissionAmount();
                                        $amount=$amount;
                                        $aph = new AgentPaymentHistory();
                                        $aph->setAgentId($agent_company_id);
                                        $aph->setCustomerId($transaction->getCustomerId());
                                        $aph->setExpeneseType(4);
                                        $aph->setAmount($amount);
                                         $aph->setRemainingBalance($remainingbalance);
                                          $aph->save();

                                    }}


                                }



}
?>