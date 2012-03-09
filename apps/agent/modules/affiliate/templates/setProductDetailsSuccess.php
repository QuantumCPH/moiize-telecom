<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>


<script type="text/javascript">
	
    jq = jQuery.noConflict();
	
    jq(document).ready(function(){

        jq("#payment").validate({
            rules: {
                uniqueid: {
                    remote: "<?php echo $target; ?>validateUniqueId"
                }
            }
        });


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
		

	
    });
	
    function checkForm()
    {

    
        unique =  jQuery("#uniqueid").val();
        //alert(unique[0]);
//        if(unique == "" || unique.length != 6 || unique[0] !='1'){
//            alert("<?php //echo __('Please enter the valid Unique ID with 6 digits')?>");
//            return false;
//        }


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
		
     
        return valid;
    }
	
    function calc()
    {
     
		
		

		
    }
	
    jq(document).ready(function(){
       
        jq('#quantity').change(function(){
            calc();
        });
    });
	
	
</script>

<form action="<?php echo url_for('@customer_registraion_complete') ?>"  method="post" id="payment" onsubmit="return(checkForm())">
   <div id="sf_admin_container"><h1><?php echo __('Create a customer') ?> <span class="active">- <?php echo __('Step 2') ?></span></h1></div>
        
  <div class="borderDiv">   
    <div class="left-col">
        <div class="split-form-sign-up">
            <div class="step-details"></div>
            <div class="fl col">
                <ul>
                    <!-- payment details -->
                    <li>
                        <label><?php echo $order->getProduct()->getName() ?> <?php echo __('details') ?>:</label>
                    </li>
                    <li>
                        <label><?php echo __('Unique Id') ?>:</label>
                        <input type="text" id="uniqueid" value="" name="uniqueid"/>
                    </li>
                    <li>
                        <label>
                            <?php echo __('Registration Fee') ?>
                            <br/>
                            <br/>
                            <?php echo __('Product Price'); ?>
                        </label>


                        <label><?php echo $order->getProduct()->getRegistrationFee() ?> &euro;
                            <br/>
                            <br/>
                            <?php echo format_number($order->getProduct()->getPrice()) ?> &euro;
                        </label>


                        <?php
                            $product_price_vat = $order->getProduct()->getRegistrationFee() * .25;
                            $product_price = ($order->getProduct()->getPrice() + $order->getProduct()->getRegistrationFee());
                        ?>
                        </li>
<?php
                            $error_quantity = false;
                            
                            if ($form['quantity']->hasError())
                                $error_quantity = true;
?>
                    <?php if ($error_quantity) {

                    ?>
                                <li class="error">
<?php echo $form['quantity']->renderError() ?>

                                </li>
<?php } ?>        
                   <li class="error" id="quantity_error">
                        <?php echo __('Quanity must be 1 or more') ?>
                           </li>

                        
                           <li style="display: none;">
                            <?php echo $form['quantity']->renderLabel() ?>
<?php echo $form['quantity'] ?>
                           <span id="quantity_ok" class="alert">
                            <?php echo image_tag('../zerocall/images/ok.png', array('absolute' => true)) ?>
                           </span>
                           <span id="quantity_decline" class="alert">

<?php echo image_tag('../zerocall/images/decl.gif', array('absolute' => true)) ?>
                        </span>
                    </li>
                    <li>
                        <label><?php echo __('VAT') ?> (25%)<br />
<?php echo __('Total amount') ?></label>

                        <label class="fr ac" >
                            <span id="vat_span">
<?php echo format_number($product_price_vat) ?>
                            </span> &euro;
                            <br />
<?php $total = $product_price + $product_price_vat ?>
                            <span id="total_span">
<?php echo format_number($total) ?>
                            </span> &euro;
                        </label>
                    </li>
<?php if ($sf_user->hasFlash('error_message')): ?>
                    <li class="error">
<?php echo __($sf_user->getFlash('error_message')); ?>
                                </li>
<?php endif; ?>
                                
                                <li class="fr buttonplacement">
                                        <input type ="submit" value ="<?php echo __('Pay') ?>"  style="cursor: pointer">
                                    </li>
                        </ul>
                        <!-- hidden fields -->
<?php echo $form->renderHiddenFields() ?>

                            <input type="hidden" name="orderid" value="<?php echo $order_id ?>"/>
                                <input type="hidden" name="amount" id="total" value="<?php echo $total ?>"/>

                            </div>
                            <div class="fr col">
                                <ul>
                                   
                </ul>
            </div>

        </div>
    </div>
      <div class="clr"></div>
  </div>    
</form>
<script type="text/javascript">
    jq('#quantity_error').hide();
</script>
