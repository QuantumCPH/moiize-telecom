<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<script type="text/javascript">
	
	jq = jQuery.noConflict();
	
	jq(document).ready(function(){

		jq("#quantity").blur(function(){
			if(isNaN(jq("#quantity").val()) || jq("#quantity").val()<1)
			{
				//$('#quantity_ok').hide();
				//$('#quantity_decline').show();
				
				//$('#quantity_error').show();
				jq('#quantity').val(1);
				calc();
				
			}
			else
			{
				jq('#quantity_decline').hide();
				jq('#quantity_ok').show();
				
				//$('#quantity_error').hide();
			}
		});
		
		/*
		function validate_card(){
			if(isNaN($("#cardno").val()) || $("#cardno").val().length != 16)
			{
				//$('#cardno_error').show();
				
				$('#cardno_decline').show();
				$('#cardno_ok').hide();
			}
			else {
				//$('#cardno_error').hide();
				
				$('#cardno_ok').show();
				$('#cardno_decline').hide();
			}
		}
		
		$("#cardno").blur(validate_card).keyup(validate_card);
		
		function validate_cvc()
		{
			if(isNaN($("#cvc").val()) || $("#cvc").val().length != 3)
			{
				//$('#cvc_error').show();
				
				$('#cvc_ok').hide();
				$('#cvc_decline').show();
			}
			else {
				//$('#cvc_error').hide();
				
				$('#cvc_ok').show();
				$('#cvc_decline').hide();
			}	
		}
		
		$("#cvc").blur(validate_cvc).keyup(validate_cvc);
		*/
	
	});
	
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
			jq('#quantity_decline').show();
			valid = false;
		}
		else
			jq('#quantity_ok').show();
		
		/*
		if(isNaN(objForm.cardno.value) || objForm.cardno.value.length != 16)
		{
			if (valid) //still not declarted as invaid
				objForm.cardno.focus();
				
			$('#cardno_decline').show();
			valid = false;
		}
		else
			$('#cardno_ok').show();

		if(isNaN(objForm.cvc.value) || objForm.cvc.value.length != 3)
		{

			if (valid)
				objForm.cvc.focus();
				
			$('#cvc_decline').show();	
			valid = false;
		}
		else
			$('#cvc_ok').show();
		*/
		
		//if (!valid)
		//	alert('Please complete out the payment form.');
		
		return valid;
	}
	
	function calc()
	{
		var product_price = jq('#product_price').val();
		var quantity = jq('#quantity').val();
		
		var extra_refill = jq('#extra_refill').val();
		
		var cf_options = {
		  decimalSymbol: ',',
		  digitGroupSymbol: '.',
		  dropDecimals: true,
		  groupDigits: true,
		  symbol: '',
		  roundToDecimalPlace: 2
		};
		
		
		//$('#extra_refill_span').text(extra_refill); //update the vat span
		
		var vat = .25 * (parseFloat(product_price) * parseFloat(quantity));
		//alert(vat);
		jq('#vat').val(vat);
		jq('#vat_span').text(vat);
		jq('#vat_span').formatCurrency(cf_options);

               var total = Math.ceil(parseFloat(product_price) * parseFloat(quantity) + parseFloat(extra_refill) + parseFloat(vat));
		
		//var total = parseFloat(product_price) * parseFloat(quantity) + parseFloat(extra_refill) + parseFloat(vat);
		//alert(total);
                jq('#total_span').text(total);
		jq('#total_span').formatCurrency(cf_options);
		jq('#total').val(total*100);
		
		

		
	}
	
	jq(document).ready(function(){
		/*
		$('input:radio[name=extra_refill]').click(function(){
			//alert($(this).attr('value'));
			$('#extra_refill').val($(this).attr('value'));
			calc();
		});
		*/
		jq('#quantity').change(function(){
			calc();
		});
	});
	
	
</script>

<form action="<?php echo url_for('@customer_registraion_completeconversion') ?>"  method="post" id="payment" onsubmit="return checkForm()">
  <div class="left-col">
    <div class="split-form-sign-up">
      <div class="step-details"> <strong><?php echo __('Create a customer') ?> <span class="active">- <?php echo __('Step 2') ?></span></strong> </div>
      <div class="fl col">
          <ul>
            <!-- payment details -->
            
              

            <li>
              <label><?php echo __('Product details') ?>:</label>
            </li>
            <li>
              <label><?php echo $order->getProduct()->getName() ?></label>
             

              <label><?php echo __('Extra refill amount') ?></label>

              <input type="hidden" id="product_price" value="<?php 
              	$product_price_vat = ($order->getProduct()->getPrice()-$order->getProduct()->getInitialBalance())*.20;
              	//$product_price = ($order->getProduct()->getPrice()) - ($order->getProduct()->getPrice()*.20); echo $product_price; 
              	$product_price = ($order->getProduct()->getPrice()-$order->getProduct()->getInitialBalance()) - $product_price_vat;
              	
              	echo $product_price;
              	?>" />
              <label class="fr ac"><span class="vat_span"> <?php echo format_number($product_price) ?> </span>&euro;</label>
              <br />
              <input type="hidden" id="extra_refill" value="<?php $extra_refill = $order->getExtraRefill(); echo $extra_refill; ?>" />

			<label>
              <span id="extra_refill_span">
					<?php echo format_number($extra_refill) ?>
				</span>
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
            <li class="error" id="quantity_error">
            	<?php echo __('Quanity must be 1 or more') ?>
            </li>
            <li>
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
              <label>VAT (25%)<br />
              <?php echo __('Total amount') ?></label>
              <input type="hidden" id="vat" value="<?php $vat = .25 * ($product_price); echo $vat; ?>" />
              <label class="fr ac" >
              	<span id="vat_span">
              	<?php echo format_number($vat) ?>
                </span> &euro;
              <br />
              	<?php $total = $product_price + $extra_refill + $vat ?>
              	<span id="total_span">
              	<?php echo format_number($total) ?>
                </span> &euro;
              </label>
            </li>
            <?php if($sf_user->hasFlash('error_message')): ?>
            <li class="error">
            	<?php echo $sf_user->getFlash('error_message'); ?>
            </li>
            <?php endif; ?>
          </ul>
        <!-- hidden fields -->
		<?php echo $form->renderHiddenFields() ?>
        <input type="hidden" name="orderid" value="<?php echo $order_id ?>"/>
		<input type="hidden" name="amount" id="total" value="<?php echo $total ?>"/>
        
      </div>
      <div class="fr col">
        <ul>
            <?php
          if( $browser->getBrowser() == Browser::BROWSER_IE  )
          {
                   ?>
          <li class="fr buttonplacement" style="margin-left:20px ">
               <input type="submit" value="Next">
          </li>

          <?php } else{ ?>

          <li class="fr buttonplacement">
          <button onclick="return checkForm();$('#payment').submit()" style="cursor: pointer"><?php echo __('Pay') ?></button>
          </li>
          <?php } ?>
          
        </ul>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
	jq('#quantity_error').hide();
</script>
