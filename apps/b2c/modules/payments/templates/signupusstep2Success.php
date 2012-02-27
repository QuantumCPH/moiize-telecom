<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php
$relay_script_url = sfConfig::get('app_epay_relay_script_url');
//$customer_id = $sf_request->getParameter('cid');
//$customer = CustomerPeer::retrieveByPK($customer_id);

$customer_form = new CustomerForm();
$customer_form->unsetAllExcept(array('auto_refill_amount', 'auto_refill_min_balance'));
?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#quantity").blur(function(){
			if(isNaN($("#quantity").val()) || $("#quantity").val()<1)
			{
				//$('#quantity_ok').hide();
				//$('#quantity_decline').show();
				
				//$('#quantity_error').show();
				$('#quantity').val(1);
				calc();
				
			}
			else
			{
				$('#quantity_decline').hide();
				$('#quantity_ok').show();
				
				//$('#quantity_error').hide();
			}
		});
		
		
		
		
		
		
		

		
		$('#quantity').change(function(){
			calc();
		});
		
		/* control was later changed to drop down box
		$('#user_attr_3').blur(function(){
			if ( this.value<0 || this.value>400 || isNaN(this.value) )
				this.value = 0;
		});
		*/
		
		toggleAutoRefill();
	
	});
	
	function toggleAutoRefill()
	{
		document.getElementById('user_attr_2').disabled = ! document.getElementById('user_attr_1').checked;
		document.getElementById('user_attr_3').disabled = ! document.getElementById('user_attr_1').checked;
                if(document.getElementById('user_attr_1').checked){
                $("#autorefilop").html('<input type="hidden" name="maketicket" value="foo" />');
		}else{
                    
                     $("#autorefilop").html('');  
                }
	}
	
	function checkForm()
	{
	
		calc();
		
		var objForm = document.getElementById("payment");
		var valid = true;
		
		if(isNaN(objForm.amount.value) || objForm.amount.value <=0 )
		{

			valid = false;
			
		}
		
		if(isNaN(objForm.quantity.value) || objForm.quantity.value<1)
		{
			//if (valid) //still not declarted as invaid
			objForm.quanity.focus();
			$('#quantity_decline').show();
			valid = false;
		}
		else
			$('#quantity_ok').show();
		
		
		
		//if (!valid)
		//	alert('Please complete out the payment form.');
		
		return valid;
	}
	
	function calc()
	{
		var product_price = $('#product_price').val();
		var quantity = $('#quantity').val();
		
		var extra_refill = $('#extra_refill').val();
		
		var cf_options = {
		  decimalSymbol: ',',
		  digitGroupSymbol: '.',
		  dropDecimals: true,
		  groupDigits: true,
		  symbol: '',
		  roundToDecimalPlace: 2
		};
		
		
		$('#extra_refill_span').text(extra_refill); //update the vat span
		
		//var vat = .20 * (parseFloat(product_price) * parseFloat(quantity));
		var vat = .25 * (parseFloat(product_price) * parseFloat(quantity));
		
		$('#vat').val(vat);
		$('#vat_span').text(vat);
		$('#vat_span').formatCurrency(cf_options);
		
		var total = Math.ceil(parseFloat(product_price) * parseFloat(quantity) + parseFloat(extra_refill) + parseFloat(vat));
		$('#total_span').text(total);
		$('#total_span').formatCurrency(cf_options);
		$('#total').val(total*100);
                att2= $('#user_attr_2').val();
                att3= $('#user_attr_3').val();
                var accepturlstr = "<?php echo $relay_script_url.url_for('@epay_accept_url', true);  ?>?user_attr_2="+att2+"&user_attr_3="+att3+"&accept=yes&subscriptionid=1&orderid=<?php echo $order_id; ?>&amount="+total*100;
                 var callbackurlstr = "<?php echo $relay_script_url.url_for('@dibs_accept_url', true);  ?>?user_attr_2="+att2+"&user_attr_3="+att3+"&accept=yes&subscriptionid=3&orderid=<?php echo $order_id; ?>&amount="+total*100;
                $('#idaccepturl').val(accepturlstr);

                 if(document.getElementById('user_attr_1').checked){
                $('#idcallbackurl').val(callbackurlstr);
                 }else{
                     var callbackurlstrs = "<?php echo $relay_script_url.url_for('@dibs_accept_url', true);  ?>?accept=yes&subscriptionid=1&orderid=<?php echo $order_id; ?>&amount="+total*100;
                    $('#idcallbackurl').val(callbackurlstrs);
                 }
	}
	
	
	
	
</script>

<form action="https://payment.architrade.com/paymentweb/start.action"   method="post" id="payment" onsubmit="return checkForm()">
  <div class="left-col">
    <div class="split-form-sign-up">
      <div class="step-details"> <strong><?php echo __('Become a Customer') ?> <span class="inactive">- <?php echo __('Step 1') ?>: <?php echo __('Registrera') ?> </span><span class="active">- <?php echo __('Step 2') ?>: <?php echo __('Payment') ?></span></strong> </div>
      <div class="fl col">
          <ul>
<?php
/*
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
            <li>
              <?php echo $form['extra_refill']->renderLabel() ?>
              <?php echo $form['extra_refill']->render(array('class' => 'radbx')); ?>
            </li>
*/
?>
            
            <!-- payment details -->
            <li>
              <label><?php echo __('Payment details') ?>:</label>
            </li>
            <li>
              <label><?php echo $order->getProduct()->getName() ?>
              	<br />
				<?php echo __('Extra refill amount') ?>
			  </label>

              <input type="hidden" id="product_price" value="<?php 
              	$product_price_vat = ($order->getProduct()->getPrice()-$order->getProduct()->getInitialBalance())*.20;
              	//$product_price = ($order->getProduct()->getPrice()) - ($order->getProduct()->getPrice()*.20); echo $product_price; 
              	$product_price = ($order->getProduct()->getPrice()-$order->getProduct()->getInitialBalance()) - $product_price_vat;
              	
              	echo $product_price;
              	?>" />
              <input type="hidden" id="extra_refill" value="<?php $extra_refill = $order->getExtraRefill(); echo $extra_refill; ?>" />
              
              
              <label class="fr ac">
              	<span class="product_price_span"> <?php echo format_number($product_price) ?> </span>SEK
              	<br />
              	<span id="extra_refill_span">
					<?php echo format_number($extra_refill) ?>
				</span> SEK
			  </label>

            </li>
            <?php
            $error_quantity = false;;
            if($form['quantity']->hasError())
            	$error_quantity = true;
            ?>
             <?php if($error_quantity) { ?>
            <li class="error">
            	<?php echo $form['quantity']->renderError() ?>
            </li>
            <?php } ?>  
          
            <li style="display:none">
              <?php echo $form['quantity']->renderLabel() ?>
			  <?php echo $form['quantity'] ?>
			  <span id="quantity_ok" class="alert">
			  	<?php echo image_tag('../zerocall/images/ok.png', array('absolute'=>true)) ?>
			  </span>
			  <span id="quantity_decline" class="alert">
			  	<?php echo image_tag('../zerocall/images/decl.gif', array('absolute'=>true)) ?>
			  </span>
            </li>
            <li>
              <label><?php echo __('VAT') ?> (25%)<br />
              <?php echo __('Total amount') ?></label>
              <input type="hidden" id="vat" value="<?php $vat = .25 * ($product_price); echo $vat; ?>" />
              <label class="fr ac" >
              	<span id="vat_span">
              	<?php echo format_number($vat) ?>
              	</span> SEK
              <br />
              	<?php $total = $product_price + $extra_refill + $vat ?>
              	<span id="total_span">
              	<?php echo format_number($total) ?>
              	</span> SEK
              </label>
            </li>
			
          </ul>
        <!-- hidden fields -->
		<?php echo $form->renderHiddenFields() ?>
		<?php 
			
			define("DIBS_MD5KEY2","r!oRvYT8}L5%,7XFj~Rlr$+Y[W3t3vho");
			define("DIBS_MD5KEY1","cBI&R8y*KsGD.o}1z^WF]HqK5,*R[Y^w");
			//define("PATH_WEB","http://landncall.zerocall.com/");
			$md5key   =  md5(DIBS_MD5KEY2.md5(DIBS_MD5KEY1.'merchant=90049676&orderid='.$order_id.'&currency=752&amount='.$total));
		?>

		
		<input type="hidden" name="merchant" value="90049676" />
		<input type="hidden" name="amount" id="total" value="<?php echo $total;?>" />
		<input type="hidden" name="currency" value="752" />
		<input type="hidden" name="orderid" value="<?php echo $order_id;?>" />
		
            
		
		<input type="hidden" name="account" value="YTIP" />
		  <input type="hidden" name="addfee" value="0" />
       
                <div id="autorefilop" >
                    <input type="hidden" name="maketicket" value="foo" />
                </div>
           
         <input type="hidden" name="lang" value="sv" />
		
     <input type="hidden" name="status" value="" />
		<input type="hidden" name="cancelurl" value="<?php echo $relay_script_url.url_for('@epay_reject_url', true)  ?>?accept=cancel&subscriptionid=&orderid=<?php echo $order->getId(); ?>&amount=<?php echo $order->getExtraRefill(); ?>" />
                <input type="hidden" name="callbackurl" id="idcallbackurl" value="<?php echo $relay_script_url.url_for('@dibs_accept_url', true);  ?>?accept=yes&subscriptionid=&orderid=<?php echo $order_id; ?>&amount=<?php echo $total; ?>" />
		<input type="hidden" name="accepturl" id="idaccepturl"  value="<?php echo $relay_script_url.url_for('@epay_accept_url', true);  ?>?accept=yes&subscriptionid=&orderid=<?php echo $order_id; ?>&amount=<?php echo $total; ?>" />
		      </div>
      <div class="fr col">
          
        <ul>
            <!-- auto fill -->
            <li>
              <label><?php echo __('Auto refill details:') ?></label>
            </li>
            <li>
            <li>
            	<input type="checkbox" class="fl" style="width:20px;" onchange="toggleAutoRefill()" name="user_attr_1" id="user_attr_1" checked="checked" />
 				<label for="user_attr_1" style="padding-top:0; text-indent: 5px;"><?php echo __('I want to activate auto refill feature') ?></label>
            </li>
            <li id="user_attr_3_field">
                <label for="user_attr_3" style="margin-right: 50px;"><?php echo __('Auto refill minimum balance:') ?>&nbsp;</label>
			  <?php echo $customer_form['auto_refill_min_balance']->render(array(
			  										'name'=>'user_attr_3',
                                                                                                        'id'=>'user_attr_3',
			  										'style'=>'width: 80px;'
			  									)) 
			  ?> sek       
            </li>
           <li id="user_attr_2_field">
              <label for="user_attr_2" style="margin-right: 50px;"><?php echo __('Auto refill amount:') ?></label>
     <?php echo $customer_form['auto_refill_amount']->render(array(
                                                            'name'=>'user_attr_2',
         'id'=>'user_attr_2',
         'style'=>'width:80;',
                                                                                                                                                                      'style'=>'width: 80px;'
                 ));  
     ?>
            </li>
            <li id="" style="border-style:solid;border-width:3px;width: 295px; padding-left: 10px;">
                <br /><b>Vad är automatisk påfyllnad?</b><br />
                LandNCall rekommenderar att aktivera denna tjänst <br />
                så slipper du fylla på manuellt då saldot börjar ta slut.<br />
                100 eller 200 kronor dras när saldot på kontot når<br /> 
                25 eller 50 kronor. Påfyllningsbeloppet adderas till<br />
                ditt konto på några minuter. Din påfyllning<br />
                kan du sedan se under "Översikt – Dina krediter".
                
                <br /><br />
                
                 
            </li>
        </ul>
            <input type="submit"  class="butonsigninsmall"  name="paybutan"  style="cursor: pointer;margin-left: 185px;" value="<?php echo __('Pay') ?>">
			
        <span class="testt">
           
<!--            <button onclick="return checkForm();$('#payment').submit()" style="cursor: pointer; top: 150px"><?php echo __('Pay') ?></button>-->
            </span>
      </div>
    </div>
	<?php //include_partial('signup/steps_indicator', array('active_step'=>2)) ?>
  </div>
</form>

