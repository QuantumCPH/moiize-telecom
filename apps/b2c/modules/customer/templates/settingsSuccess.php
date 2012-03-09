<?php use_helper('I18N') ?>
<?php include_partial('dashboard_header', array('customer'=> $customer, 'section'=>__('Settings')) ) ?>
<?php echo $form->renderGlobalErrors() ?>

<?php if ($sf_user->hasFlash('message')): ?>
<div class="alert_bar">
	<?php echo $sf_user->getFlash('message') ?>
</div>
<?php endif;?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<form method="post" action="<?php url_for('customer/settings') ?>" id="settingsForm" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <div class="left-col">
    <?php include_partial('navigation', array('selected'=>'settings', 'customer_id'=>$customer->getId())) ?>
	<div class="split-form">
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
         
       

            <li>
            <label class="required"><?php echo __("Active Mobile No") ?></label>
           
            <input type="text" value="<?php

        $unid   =$uniqueidValue;

        //$customer->getUniqueid();
        if(isset($unid) && $unid!=""){
            $un = new Criteria();
            $un->add(CallbackLogPeer::UNIQUEID, $unid);
            $un -> addDescendingOrderByColumn(CallbackLogPeer::CREATED);
            $unumber = CallbackLogPeer::doSelectOne($un);
            echo "00".$unumber->getMobileNumber();
         }else{ echo $customer->getMobileNumber(); }  ?>" disabled="true" />
            <div class="inline-error">&nbsp;</div>
            </li>
            
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
            <li>&nbsp;</br></br></li>
          </ul>
                    
      </div>
      <div class="fr col">
        <ul>
            
           
            <?php
            $error_po_box_number = false;;
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
            <li style="display:none">
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
            <li >
             <?php echo $form['date_of_birth']->renderLabel() ?>
             <?php echo $form['date_of_birth']->render(array('class'=>'strselect')) ?>
             <?php if ($error_date_of_birth): ?>
             <span id="cardno_decl" class="alertstep1">
			  	<?php echo image_tag('../zerocall/images/decl.png', array('absolute'=>true)) ?>
			 </span>
			 <?php endif; ?>
             <div class='inline-error'><?php echo $error_date_of_birth?$form['date_of_birth']->renderError():'&nbsp;'?></div>
            </li>
            <!-- end date of birth -->
<?php /*
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
 */ ?>
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
            <li style="display:none">
             <?php echo $form['is_newsletter_subscriber'] ?>
             <span><?php echo $form['is_newsletter_subscriber']->renderHelp() ?></span>
            </li> </ul>
          <!-- end newsletter -->
          <div>
            &nbsp;</br>
             
            <a href="<?php echo url_for('customer/passwordchange') ?>" class="changePass"><b><?php echo __('Change password') ?></b></a>
<!--            <input type="submit" style="border: 0px;" class="settingbutton" name="submit"  value="<?php echo __('Update') ?>">-->
             
<!--            <button onclick="$('#newCustomerForm').submit();" style="cursor: pointer"><?php echo __('Next') ?></button>-->
            <div class="butonsigninsmall-outer" style="margin-top:5px;"><span class="butonsigninsmall-left"></span><input type="submit" class="butonsigninsmall" style="margin-left:0px !important;"  name="submit" value="<?php echo __('Update') ?>"  /><span class="butonsigninsmall-right"></span></div>
          </div>
      </div>
    </div> <!-- end split-form -->
  </div> <!-- end left-col -->
</form>
  <?php include_partial('sidebar') ?>
<script type="text/javascript">
	$('form li em').prev('label').append(' *');
	$('form li em').remove();
	$(':input[readonly=readonly]').css('background-color', '#f0f0f0');
</script>
<style type="text/css">
	.inline-error {
		color:Red;
		float:right;
		margin-right:7px;
		text-align:right;
		white-space:normal;
	}
</style>
<script type="text/javascript">
        $("#customer_manufacturer").change(function() {
		var url = "<?php echo url_for('customer/getmobilemodel') ?>";
		var value = $(this).val();
			$.get(url, {device_id: value}, function(output) {
				$("#customer_device_id").html(output);
			});
	});
        
        

</script>