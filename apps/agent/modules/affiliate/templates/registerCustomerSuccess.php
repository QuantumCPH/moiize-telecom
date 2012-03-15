<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form method="post" action="registerCustomer<?php // url_for('@customer_registration_step1') ?>" name="newCustomerForm"  <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
 <div id="sf_admin_container"><h1><?php echo __('Register a Customer') ?> <span class="active">- <?php echo __('Step 1') ?>: <?php echo __('Register') ?> </span></h1></div>
        
  <div class="borderDiv"> 
       <div class="left-col">
    <div class="split-form-sign-up">
      <div class="step-details"> </div>
      <div class="fl col">
        <?php echo $form->renderHiddenFields() ?>
          <ul>
           <?php
            $error_mobile_number = false;
            if($form['mobile_number']->hasError())
            	$error_mobile_number = true;
            ?>
            <li>
                 <?php echo $form['mobile_number']->renderLabel() ?>
             <?php echo $form['mobile_number'] ?>
             <?php if ($error_mobile_number): ?>
             <span id="cardno_decl" class="alertstep1">
	         <?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
	     </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_mobile_number?$form['mobile_number']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end mobile_number -->           
            <?php
            $error_product = false;;
            if($form['product']->hasError())
            	$error_product = true;
            ?>
            <li>
             <?php echo $form['product']->renderLabel() ?>
             <?php echo $form['product'] ?>
             <?php if ($error_product): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_product?$form['product']->renderError():'&nbsp;'?></div>
            </li>
            <!--  end product -->
            <?php
            $error_first_name = false;;
            if($form['first_name']->hasError())
            	$error_first_name = true;
            ?>
            <li>
             <?php echo $form['first_name']->renderLabel() ?>
             <?php echo $form['first_name'] ?>
             <?php if ($error_first_name): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_first_name?$form['first_name']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end first name -->
            <?php
            $error_last_name = false;;
            if($form['last_name']->hasError())
            	$error_last_name = true;
            ?>
            <li>
             <?php echo $form['last_name']->renderLabel() ?>
             <?php echo $form['last_name'] ?>
             <?php if ($error_last_name): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_last_name?$form['last_name']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end last name -->
            <?php
            $error_address = false;;
            if($form['address']->hasError())
            	$error_address = true;
            ?>
            <li>
             <?php echo $form['address']->renderLabel() ?>
             <?php echo $form['address'] ?>
             <?php if ($error_address): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_address?$form['address']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end address -->
            <?php
            $error_po_box_number = false;
            if($form['po_box_number']->hasError())
            	$error_po_box_number = true;
            ?>
            <li>
             <?php echo $form['po_box_number']->renderLabel() ?>
             <?php echo $form['po_box_number'] ?>
             <?php if ($error_po_box_number): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_po_box_number?$form['po_box_number']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end pobox number -->
            <?php
            $error_city = false;;
            if($form['city']->hasError())
            	$error_city = true;
            ?>
            <li>
             <?php echo $form['city']->renderLabel() ?>
             <?php echo $form['city'] ?>
             <?php if ($error_city): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_city?$form['city']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end city -->
            <?php
            $error_country_id = false;;
            if($form['country_id']->hasError())
            	$error_country_id = true;
            ?>
            <li>
             <?php echo $form['country_id']->renderLabel() ?>
             <?php echo $form['country_id'] ?>
             <?php if ($error_country_id): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_country_id?$form['country_id']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end country -->
           
          </ul>
      </div>
      <div class="fr col">
        <ul>
               <?php
            $error_date_of_birth = false;;
            if($form['date_of_birth']->hasError())
            	$error_date_of_birth = true;
            ?>
            <li>
             <?php echo $form['date_of_birth']->renderLabel() ?>
             <?php echo $form['date_of_birth']->render(array('class'=>'shrinked_select_box')) ?>
             <?php if ($error_date_of_birth): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_date_of_birth?$form['date_of_birth']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end date of birth -->
            <?php
            $error_password = false;;
            if($form['password']->hasError())
            	$error_password = true;
            ?>
            <li>
             <?php echo $form['password']->renderLabel() ?>
             <?php echo $form['password'] ?>
           <?php if ($error_password): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_password?$form['password']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end password -->
            <?php
            $error_password_confirm = false;;
            if($form['password_confirm']->hasError())
            	$error_password_confirm = true;
            ?>
            <li>
             <?php echo $form['password_confirm']->renderLabel() ?>
             <?php echo $form['password_confirm'] ?>
             <?php if ($error_password_confirm): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_password_confirm?$form['password_confirm']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end confirm password -->
            <?php
            $error_email = false;;
            if($form['email']->hasError())
            	$error_email = true;
            ?>
            <li>
             <?php echo $form['email']->renderLabel() ?>
             <?php echo $form['email'] ?>
             <?php if ($error_email): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_email?$form['email']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end email -->
          
            <?php 
            $error_telecom_operator_id = false;
            if($form['telecom_operator_id']->hasError())
            	$error_telecom_operator_id = true;
            ?>
            <li>
             <?php echo $form['telecom_operator_id']->renderLabel() ?>
             <?php echo $form['telecom_operator_id'] ?>
             <?php if ($error_telecom_operator_id): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_telecom_operator_id?$form['telecom_operator_id']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end telecom operator -->
          
           
          
           
            <!-- 
          <li class="fr"><img src="<?php echo image_path('../zerocall/images/moto-flipout.png') ?>" alt=" " /></li>
           -->
          <!-- end device -->
            <?php
            $error_is_newsletter_subscriber = false;;
            if($form['is_newsletter_subscriber']->hasError())
            	$error_is_newsletter_subscriber = true;
            ?>
            <?php if($error_is_newsletter_subscriber) { ?>
            <li class="error">
            	<?php echo $form['is_newsletter_subscriber']->renderError() ?>
            </li>
            <?php } ?>
            <li>
             <?php echo $form['is_newsletter_subscriber'] ?>
             <span><?php echo $form['is_newsletter_subscriber']->renderHelp() ?></span>
            </li>
          <!-- end newsletter -->
           
            
          <!-- end auto_refill -->
          <?php 
          if( $browser->getBrowser() == Browser::BROWSER_IE  )
          {  ?>
          <li class="fr buttonplacement" style="margin-left:20px ">
               <input type="submit" value="Next" style="margin-left:0px !important;">
          </li>
         
          <?php } else{ ?>
          
          <li class="fr buttonplacement">
          <button onclick="$('#newCustomerForm').submit();" style="cursor: pointer; left: -115px"><?php echo __('Next') ?></button>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
      <div class="clr"></div>
</div>
  
</form>


<script type="text/javascript">
	jq = jQuery.noConflict();
	jq('form li em').prev('label').append(' *');
	jq('form li em').remove();
</script>
<script type="text/javascript">
    jq("#customer_manufacturer").change(function() {
		var url = "<?php echo url_for('affiliate/getmobilemodel') ?>";
		var value = jq(this).val();
			jq.get(url, {device_id: value}, function(output) {
				jq("#customer_device_id").html(output);
			});
	});
          jq('#customer_manufacturer').trigger('change');
</script>