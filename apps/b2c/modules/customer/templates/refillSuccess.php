<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php include_partial('dashboard_header', array('customer'=> $customer, 'section'=>__('Refill') ) ) ?>
<?php
$customer_form = new CustomerForm($customer);
$customer_form->unsetAllExcept(array('auto_refill_amount', 'auto_refill_min_balance'));

$is_auto_refill_activated = $customer_form->getObject()->getAutoRefillAmount()!=null;
?>
 <?php

        $part2 = rand (99,99999);
        $part3 = date("s");
        $randomOrderId = $order->getId().$part2.$part3;
           ?>
<script type="text/javascript">



	$(document).ready(function(){
		
		$('#frmarchitrade').submit(function() {
			user_attr_2 = jQuery("#user_attr_2 option:selected").val();
			user_attr_3 = jQuery("#user_attr_3 option:selected").val();
    		jQuery('#idcallbackURLauto').val(jQuery('#idcallbackURLauto').val()+"&user_attr_2="+user_attr_2+"&user_attr_3="+user_attr_3);
  return true;
});


$('#refill').submit(function() {
			extra_refill = jQuery("#extra_refill option:selected").val();
			extra_refill = parseInt(extra_refill)*100;
                        jQuery('#idcallbackurl').val(jQuery('#callbackurlfixed').val()+extra_refill);
			jQuery('#total').val(extra_refill);
  return true;
});

	
	});




</script>
<?php   
if($is_auto_refill_activated){  ?>  <div class="left-col">
	   <?php include_partial('navigation', array('selected'=>'refill', 'customer_id'=>$customer->getId())) ?>
    
    <div style="width:500px;">
    
    
     <div  style="width:500px;clear:both;"> <br/> <br/>
   <b>  <?php echo __("Automatic replenishment is")?>:<span style="text-decoration:underline"> <?php echo __('Active')?></span>
   </b>
     
     <br/> <br/>


<?php echo __('If your credit card that is registered for the service of any reason is no longer active, you can disable service and then activate it again with another credit card.');?>
 
     
      </div> <br/> 
               <br/>
     
    <div  style="width:500px;">
    <div style="float:left;width:250px;font-weight:bold;"> <?php echo __('You have selected automatic replenishment when the pot is below:');?> </div>
    <div  style="margin-left: 20px;float:left;width:100px;font-weight:bold;"> <?php echo   $customer_form->getObject()->getAutoRefillMinBalance() ?> &euro;</div>
    <div  style="float:left;width:150px;"></div> 
    </div>
  
    <div  style="width:500px;clear:both;">
               <br />
    <div  style="float:left;width:250px;font-weight:bold; "><?php echo __('The pot is filled in with:');?></div>
    <div  style="margin-left: 20px;float:left;width:100px;font-weight:bold;">  <?php echo   $customer_form->getObject()->getAutoRefillAmount() ?> &euro;</div>
    <div class="clr"></div><br />
    <div style="margin-top: 61px; text-align: left; width: 134px;">
    <form method="post" action="<?php echo $target; ?>customer/deActivateAutoRefill">
    <input type="hidden" name="customer_id" value="<?php echo   $customer_form->getObject()->getId() ?>" />
    <div class="clr"></div><br />
                <input type="submit" class="butonsigninsmall" name="button" style="cursor: pointer; margin-left: 0px !important; margin-top: -10px;"  value="<?php echo __('Disable') ?>" />
                </form>			
    </div>
    </div>
     
</div>
</div>
    <?php
}else{ ?>
	
	
  <div class="left-col">
     
    <?php include_partial('navigation', array('selected'=>'refill', 'customer_id'=>$customer->getId())) ?>
	<div class="split-form">
    <div style="width:500px;">
              <div> <?php echo __('The most convenient way to fill the pot is to enable automatic refilling (below), then you do not need to worry about the pot running out. Especially important is such trip abroad where it can be difficult to fill in in any other way.');?><br /><br /></div>
            <div>     <b style="text-decoration:underline;"><?php echo __('Automatic replenishment');?></b> </div>
                 <br />
              <div>   <b><?php echo __('Automatic Replenishment is: Inactive');?></b></div>
                
      <div class="fl col">
      <div class="split-form">  
   <form action="https://payment.architrade.com/paymentweb/start.action" method="post" id="frmarchitrade" >
  <input type="hidden" name="merchant" value="90049676" />
  <input type="hidden" name="amount" value="1" />
      <input type="hidden" name="customerid" value="<?php echo   $customer_form->getObject()->getId() ?>" />
  <input type="hidden" name="currency" value="978" />
  <input type="hidden" name="orderid" value="<?php echo $randomOrderId; ?>" />

    <input type="hidden" name="test" value="yes" />

   <input type="hidden" name="account" value="YTIP" />
  <input type="hidden" name="lang" value="de" />
  <input type="hidden" name="preauth" value="true">
  <input type="hidden" name="cancelurl" value="<?php echo $target; ?>customer/dashboard?lng=<?php echo  $sf_user->getCulture() ?>" />
  <input type="hidden" name="callbackurl" id="idcallbackURLauto" value="<?php echo $target; ?>customer/activateAutoRefill?customerid=<?php echo   $customer_form->getObject()->getId() ?>&lng=<?php echo  $sf_user->getCulture() ?>v" />
  <input type="hidden" name="accepturl" value="<?php echo $target; ?>customer/dashboard?lng=<?php echo  $sf_user->getCulture() ?>" />
 <div style="width:348px;float:left;">
        <ul style="width: 285px;float:none;clear:both;">
            <!-- auto fill -->
                       
           
           
            <li id="user_attr_3_field">
                <label for="user_attr_3" style="margin-right: 50px;"><?php echo __('Load automatically <br /> when the pot is below:') ?></label>
                &nbsp;
			  <?php echo $customer_form['auto_refill_min_balance']->render(array(
			  										'name'=>'user_attr_3',
			  										'style'=>'width: 80px;'
			  									)) 
			  ?>  &euro;
            </li>
            
            
            <li id="user_attr_2_field">
                 <label for="user_attr_2" style="margin-right: 50px;"><?php echo __('Auto refill amount:') ?></label>              
		 &nbsp; <?php echo $customer_form['auto_refill_amount']->render(array(
			  													'name'=>'user_attr_2',
                                                                                                                                'style'=>'width: 80px;'
			  												)); 
			  ?>  &euro;&nbsp;
            </li> 
        </ul>
            </div>
 
          <div style="float:left;"><input type="submit" class="butonsigninsmall" style="width:101px;margin-left:-13px !important;" name="button" value="<?php echo __('Enable') ?>" /></div>
  </form>
  </div>
    
<br/>
<br/>
  <form action="https://payment.architrade.com/paymentweb/start.action"  method="post" id="refill" >
     <div style="width:500px;">
     <div  style="width:340px;float:left;">    <ul>
         	<!-- customer product -->
 			  <li>
              <label for="customer_product" style="text-decoration:underline;"><?php echo __('Manual filling:') ?></label>
             
            </li>
          	<!-- extra_refill -->
            <?php
            $error_extra_refill = false;;
            if($form['extra_refill']->hasError())
            	$error_extra_refill = true;
            ?>
            <?php if($error_extra_refill) { ?>
            <li class="error">
            	<?php echo $form['extra_refill']->renderError() ?>
            </li>
            <?php } ?>
            <li id="selectAmt">
              <label for="extra_refill" class="extra_refill"><?php echo __('Select amount to be loaded:') ?></label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<?php echo $form['extra_refill']?>  &euro;
            </li>

            <?php if($sf_user->hasFlash('error_message')): ?>
            <li class="error" style="white-space: normal;">
            	<?php echo $sf_user->getFlash('error_message'); ?>
            </li>
            <?php endif; ?>


          </ul>
  
        <!-- hidden fields -->
      
        <input type="hidden" name="merchant" value="90049676" />
        <input type="hidden" name="amount" id="total" value="" />
        <input type="hidden" name="currency" value="978" />
        <input type="hidden" name="orderid" value="<?php echo $randomOrderId; ?>" />

    <input type="hidden" name="test" value="yes" />
        <input type="hidden" name="lang" value="de" />
        <input type="hidden" name="account" value="YTIP" />
        <input type="hidden" name="addfee" value="0" />
        <input type="hidden" name="status" value="" />
       <input type="hidden" name="cancelurl" value="<?php echo sfConfig::get('app_epay_relay_script_url').url_for('@epay_refill_reject', true)  ?>?accept=cancel&lng=<?php echo  $sf_user->getCulture() ?>&subscriptionid=&orderid=<?php echo $order->getId(); ?>&amount=<?php echo $order->getExtraRefill(); ?>" />
        <input type="hidden" name="callbackurl" id="idcallbackurl" value="<?php echo sfConfig::get('app_epay_relay_script_url').url_for('@dibs_refill_accept', true)  ?>?accept=yes&lng=<?php echo  $sf_user->getCulture() ?>&subscriptionid=&orderid=<?php echo $order->getId(); ?>&amount=" />
        <input type="hidden" name="accepturl" id="idaccepturl" value="<?php echo sfConfig::get('app_epay_relay_script_url').url_for('@epay_refill_accept', true)  ?>?accept=yes&lng=<?php echo  $sf_user->getCulture() ?>&subscriptionid=&orderid=<?php echo $order->getId(); ?>&amount=<?php echo $order->getExtraRefill(); ?>" />
        <input type="hidden" id="callbackurlfixed" value="<?php echo sfConfig::get('app_epay_relay_script_url').url_for('@dibs_refill_accept', true)  ?>?accept=yes&lng=<?php echo  $sf_user->getCulture() ?>&subscriptionid=&orderid=<?php echo $order->getId(); ?>&amount=" />
            </div>
          <div style="float:left;margin-top:30px;">   
       
                <input type="submit" class="butonsigninsmall" name="button" style="width:101px;cursor: pointer;float: left; margin-left: -5px !important; margin-top: -5px;"  value="<?php echo __('Load') ?>" />
        </div>
        </div></form> 
       </div>
      
    </div><!-- end form-split -->
  </div><div style="clear:both"></div>
</div>
 <?php
}

?>

  <?php include_partial('sidebar') ?>
