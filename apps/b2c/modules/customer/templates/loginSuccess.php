
<?php use_helper('I18N') ?>
<table><tr><td align="center">
<?php include_partial('customer/dashboard_header', array('customer'=> null, 'section'=>__('Login to your account')) ) ?>
	<?php if ($sf_user->hasFlash('send_password_message')): ?>
	<div class="alert_bar">
		<?php echo $sf_user->getFlash('send_password_message') ?>
	</div>
	<?php endif;?>
            <div style="width:500px; margin-top: 15px;"><?php echo __('Hello and welcome to Smartsim - my pages. To log in, use your customer number which is your mobile number and password. On my pages you can see what calls you made, fill the pot, and more.'); //echo $target; ?></div>
  <div class="left-col" style="padding-left:210px;text-align:left;">
    <?php //include_partial('customer/navigation', array('selected'=>'', 'customer_id'=>$customer->getId())) ?>
	<div id="login-modal" style="background-repeat: repeat-x; width: 470px; margin-top: 16px; background: none;">
	<div class="login-left">
	<h4  style="text-align:left;"><?php echo __('Log into your pages') ?></h4>
	<form method="post" id="login_form" action="<?php echo $target; ?>/customer/login">
	<label  style="text-align:left;"><?php echo __('Enter cell phone number') ?></label><br />
	<input type="text"  class="input"  name="mobile_number" id="mobile_number" />
	<p style="color: red; margin-bottom:1px; position: relative; top: -2px;">
	<?php
	if ($sf_user->hasFlash('error_message')): 
		echo $sf_user->getFlash('error_message');
	endif;?>
	&nbsp;
	</p>
	<label style="text-align:left;"><?php echo __('Password') ?></label><br />
        <input  class="input" type="password" name="password" id="password" /><br />
        <span>
        <input type="submit" class="loginbuttun" name="submit" value="<?php echo __('Log in') ?>"></span>
		<!--	<button style="cursor: pointer;" ><?php //echo __('Log in') ?></button>-->
	<script language="javascript" type="text/javascript">
		jq = jQuery.noConflict();
	
		jq('#login_form').submit(function(){
			var valid = true;

			valid = jq('#login_form #mobile_number').val().length>=8?true:false;
			
			
			if (!valid) { // if email is not valid
				jq('#login_form #mobile_number').focus();
				alert('<?php echo __('Please enter a valid mobile number.') ?>');
				return false;			
			}
			
			valid = jq('#login_form #password').val().length>3?true:false;
			
			if (!valid) { // if password is not valid
				jq('#login_form #password').focus();
				alert('<?php echo __('Please enter a password.') ?>');
				return false;			
			}			
			

		});
	</script>
	</form>
	</div>
	<div class="login-right"><h4><?php echo __('Forgot password?') ?></h4>
	<form id="forgot_password_form" method="post" action="<?php echo url_for('customer/sendPassword') ?>">
        <?php
          if($sf_user->getCulture()=='en'){
              $class = '';
          }else{
              $class = 'class="text1"';
          }
        ?>    
	<p <?php echo $class;?>><?php echo __('Write e-mail address you used for registration.<br />Your password will be sent to you via this email.') ?></p>
	<input   class="input"  type="text" name="email" id="forgot_password_email" /><br />
	<?php if ($sf_user->hasFlash('send_password_error_message')): ?>
	<p style="color: red; margin:6px auto;"><?php echo $sf_user->getFlash('send_password_error_message') ?></p>
	<?php endif;?>
        <input  style="cursor: pointer;"  class="loginbuttun"  type="submit" name="submit" value="<?php echo __('Send');?>">
<!--	<button style="cursor: pointer;">Send</button>-->
	<script language="javascript" type="text/javascript">
		jq = jQuery.noConflict();
	
		jq('#forgot_password_form').submit(function(){
			
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			if (reg.test(jq('#forgot_password_email').val())==false)
			{
				jq('#forgot_password_email').focus();
				alert('<?php echo __('Please enter a valid email address.') ?>');
				return false;
			}

		});
	</script>
	</form></div>
	</div>
  </div> <!-- end left-col -->
  <?php //include_partial('customer/sidebar') ?></td></tr></table>
 