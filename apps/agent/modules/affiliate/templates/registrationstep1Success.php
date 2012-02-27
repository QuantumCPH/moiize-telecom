<script type="text/javascript" language="javascript">

jQuery(function(){

jQuery('#newCustomerForm').validate({

});
});
</script>
<form method="post" action="<?php url_for('@customer_registration_step1') ?>" name="newCustomerForm" id="newCustomerForm"  <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

  <div class="left-col">
    <div class="split-form-sign-up">
      <div class="step-details"> <h2><?php echo __('Register a Customer') ?> <span class="active">- <?php echo __('Step 1') ?>: <?php echo __('Register') ?> </span></h2> </div>
      <div class="fl col">
        <?php echo $form->renderHiddenFields() ?>
          <ul>
              <tr>
        <div class='inline-error'>
          <li> <?php // echo $form->renderGlobalErrors() ?></li>
        </div>
        
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
             <?php echo $form['first_name']->render(array('class'=>'required')) ?>
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
             <?php echo $form['last_name']->render(array('class'=>'required')) ?>
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
             <?php echo $form['address']->render(array('class'=>'required')) ?>
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
             <?php echo $form['po_box_number']->render(array('class'=>'required')) ?>
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
             <?php echo $form['city']->render(array('class'=>'required')) ?>
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
         
            <!-- end confirm password -->
          
          
            <?php
            $error_email = false;;
            if($form['email']->hasError())
            	$error_email = true;
            ?>
            <li>
             <?php echo $form['email']->renderLabel() ?>
             <?php echo $form['email']->render(array('class'=>'required email')) ?>
             <?php if ($error_email): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_email?$form['email']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end email -->
          </ul>
      </div>
      <div class="fr col">
        <ul>
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
            <?php
            $error_other = false;;
            if($form['other']->hasError())
            	$error_other = true;
            ?>
            <li>
             <?php echo $form['other']->renderLabel() ?>
             <?php echo $form['other'] ?>
             <?php if ($error_other): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_other?$form['other']->renderError():'&nbsp;'?></div>
            </li>
          <!-- end other -->
            <?php
            $error_subscription_type = false;;
            if($form['subscription_type']->hasError())
            	$error_subscription_type = true;
            ?>
            <li>
             <?php echo $form['subscription_type']->renderLabel() ?>
             <?php echo $form['subscription_type'] ?>
             <?php if ($error_subscription_type): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_subscription_type?$form['subscription_type']->renderError():'&nbsp;'?></div>
            </li>
          <!-- end subscription type -->
            <?php
            $error_manufacturer = false;;
            if($form['manufacturer']->hasError())
            	$error_manufacturer = true;
            ?>
            <li>
             <?php echo $form['manufacturer']->renderLabel() ?>
             <?php echo $form['manufacturer'] ?>
             <?php if ($error_manufacturer): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_manufacturer?$form['manufacturer']->renderError():'&nbsp;'?></div>
            </li>
          <!-- end manufacturer -->
            <?php
            $error_device_id = false;;
            if($form['device_id']->hasError())
            	$error_device_id = true;
            ?>
            <li>
             <?php echo $form['device_id']->renderLabel() ?>
             <?php echo $form['device_id']->render(array('class'=>'required')) ?>
             <?php if ($error_device_id): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_device_id?$form['device_id']->renderError():'&nbsp;'?></div>
            </li>
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
           <li>
		   <input type="checkbox" checked="checked" style="border:0;"/> <?php echo __('Auto Refill')?>?
		   </li>
            
          <!-- end auto_refill -->
          <?php 
          if( $browser->getBrowser() == Browser::BROWSER_IE  )
          {
                   ?>
          <li class="fr buttonplacement" style="margin-left:20px ">
               <input type="submit" value="Next">
          </li>
         
          <?php } else{ ?>
          
          <li class="fr buttonplacement">
          <button onclick="$('#newCustomerForm').submit();" style="cursor: pointer; left: 0px"><?php echo __('Next') ?></button>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
  
</form>


<script type="text/javascript">
	jq = jQuery.noConflict();
	jq('form li em').prev('label').append(' *');
	jq('form li em').remove();
</script>