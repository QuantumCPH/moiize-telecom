<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div id="sf_admin_container">
     <ul class="customerMenu" style="margin:10px 0;">
            <li><a class="external_link" href="allRegisteredCustomer"><?php echo  __('View All Customer') ?></a></li>
            <li><a class="external_link" href="paymenthistory?id=<?php echo $_REQUEST['id'];  ?>"><?php echo  __('Payment History') ?></a></li>
            <li><a class="external_link"  href="callhistory?id=<?php echo $_REQUEST['id'];  ?>"><?php echo  __('Call History') ?></a></li>
        </ul>
<h1><?php echo  __('Customer Detail') ?></h1>
    <table width="100%" cellspacing="0" cellpadding="2" class="tblAlign">
                       
                      
                      
                          <tr>
                    <td width="11%" class="leftHeadign"><?php echo  __('Customer Balance') ?></td>
                    <td width="53%"  >&nbsp;<?php
                           $uniqueId=$customer->getUniqueid();
                         $cuid=$customer->getId();

                          

                                  $cp = new Criteria();
                                  $cp->add(CustomerProductPeer::CUSTOMER_ID, $cuid);
                                  $custmpr = CustomerProductPeer::doSelectOne($cp);
                                   $p = new Criteria();
                                   $p->add(ProductPeer::ID, $custmpr->getProductId());
                                   $products=ProductPeer::doSelectOne($p);
                                   $pus = 0;
                                 

                        $telintaGetBalance=Telienta::getBalance($customer);

        echo  $telintaGetBalance;
          echo "&euro;";
                         
                          
                     ?> </td>
      </tr>

                     
                   <tr>
                    <td  class="leftHeadign"><?php echo  __('Id') ?></td>
                     <td  >&nbsp;<?php  echo $customer->getId() ?></td>
                      </tr>
                     
                      <tr>
                    <td  class="leftHeadign" id="sf_admin_list_th_first_name" ><?php echo  __('First Name') ?></td>
                      <td>&nbsp;<?php echo  $customer->getFirstName() ?></td>
                        </tr>
                      <tr>
                    <td class="leftHeadign" id="sf_admin_list_th_last_name" ><?php echo  __('Last Name') ?></td>
                       <td>&nbsp;<?php echo  $customer->getLastName() ?></td>
                          </tr>
                      <tr>
		    <td class="leftHeadign" id="sf_admin_list_th_mobile_number" ><?php echo  __('Mobile Number') ?></td>
                      <td>&nbsp;<?php echo  $customer->getMobileNumber() ?></td>
                         </tr>
                         <tr>

		     <td class="leftHeadign" id="sf_admin_list_th_mobile_number" ><?php echo  __('Password') ?></td>
                         <td>&nbsp;<?php echo  $customer->getPlainText() ?></td>
                       </tr>
                       
                       
<?php
$val="";
$val=$customer->getReferrerId();
if(isset($val) && $val!=""){  ?>
                      <tr>
		    <td class="leftHeadign" id="sf_admin_list_th_agent" ><?php echo  __('Agent') ?></td>
                    <?php $agent = AgentCompanyPeer::retrieveByPK( $customer->getReferrerId()) ?>
                  <td>&nbsp;<?php echo  $agent->getName() ?></td>
                      </tr>
                         <tr>
                      <td class="leftHeadign" id="sf_admin_list_th_agent"><?php echo  __('Agent CVR') ?></td>
                      <td>&nbsp;<?php echo  $agent->getCvrNumber() ?></td>
		      </tr>

                      <?php } ?>
                         <tr >
                      <td class="leftHeadign" id="sf_admin_list_th_address" ><?php echo  __('Address') ?></td>
                        <td>&nbsp;<?php echo  $customer->getAddress() ?></td>
                      </tr>
                         <tr>
                      <td class="leftHeadign" id="sf_admin_list_th_city" ><?php echo  __('City') ?></td>
                        <td>&nbsp;<?php echo  $customer->getCity() ?></td>
                      </tr>
                         <tr>
                      <td class="leftHeadign" id="sf_admin_list_th_po_box_number" ><?php echo  __('PO-BOX Number') ?></td>
                      <td>&nbsp;<?php echo  $customer->getPoBoxNumber() ?></td>

                      </tr>
                         <tr>
                      <td class="leftHeadign" id="sf_admin_list_th_email"  ><?php echo  __('Email') ?></td>
                         <td>&nbsp;<?php echo  $customer->getEmail() ?></td>
                      </tr>
                         <tr>
                      <td class="leftHeadign" id="sf_admin_list_th_created_at" ><?php echo  __('Created At') ?></td>
                            <td>&nbsp;<?php echo  $customer->getCreatedAt() ?></td>

  </tr>
                         <tr>

                    <td class="leftHeadign" id="sf_admin_list_th_date_of_birth" ><?php echo  __('Date Of Birth') ?></td>
                      <td>&nbsp;<?php echo  $customer->getDateOfBirth() ?></td>
                      </tr>
                         <tr>
                      <td class="leftHeadign" id="sf_admin_list_th_auto_refill" ><?php echo  __('Auto Refill') ?></td>
                        <?php if ($customer->getAutoRefillAmount()!=NULL && $customer->getAutoRefillAmount()>1){ ?>
                  <td>Yes</td>
                  <?php } else
                      { ?>
                  <td width="36%">&nbsp;No</td>
                  <?php } ?>
                        </tr>
                         <tr>
                        <td class="leftHeadign" id="sf_admin_list_th_auto_refill" ><?php echo  __('Unique ID') ?></td>
                         <td>&nbsp;<?php  echo $customer->getUniqueid();     ?>   </td>
                        </tr  >
                         <tr>
                       <td class="leftHeadign" id="sf_admin_list_th_auto_refill" ><?php echo  __('Active No') ?></td>
                        <td>&nbsp;<?php  $unid   =  $customer->getUniqueid();
        if(isset($unid) && $unid!=""){
            $un = new Criteria();
            $un->add(CallbackLogPeer::UNIQUEID, $unid);

            $un -> addDescendingOrderByColumn(CallbackLogPeer::CREATED);
            $unumber = CallbackLogPeer::doSelectOne($un);
            echo $unumber->getMobileNumber();            
         }else{  }  ?> </td>
                         </tr>
                         <?php  $uid=0;
                      $uid=$customer->getUniqueid();
                      if(isset($uid) && $uid>0){
                      ?>

<!--                       <tr  style="background-color:#FFFFFF">
                    <td    style="float:left;"  >IMSI number</td>
                     <td  ><?php  //echo $unumber->getImsi();  ?></td>
                      </tr>
                        <tr  style="background-color:#EEEEFF">
                    <td    style="float:left;"  >IMSI Registration Date</td>
                     <td  ><?php // echo $unumber->getCreated();  ?></td>
                      </tr>-->

                      <?php } ?>
<!--                  <tr style="background-color:#EEEEFF">
                       <td id="sf_admin_list_th_auto_refill" style="float:left;" >Resenummer </td>
                        <td>  <?php  $cuid   =  $customer->getId();
        if(isset($cuid) && $cuid!=""){
            $un = new Criteria();
            $un->add(SeVoipNumberPeer::CUSTOMER_ID, $cuid);
            $un->add(SeVoipNumberPeer::IS_ASSIGNED, 1);
             $vounumber = SeVoipNumberPeer::doSelectOne($un);
             if(isset($vounumber)&& $vounumber!="" ){
            echo $vounumber->getNumber();
             }
         }else{  }  ?> </td>
                         </tr>-->

                      

                  
              </table>
      <br />        
</div>




