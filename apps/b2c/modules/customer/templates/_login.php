<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zero Call - Login Modal Box</title>
<?php use_javascript('/sf/prototype/js/prototype.js', '', array('absolute'=>true)) ?>
<?php use_javascript('main.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/jquery-1.4.2.min.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/cufon-yui.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/Barmeno_400-Barmeno_400.font.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/Barmeno-Medium_400.font.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/cufon-replace.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/jquery.jcarousel.min.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/carousel.js', '', array('absolute'=>true)) ?>


<?php use_stylesheet('../zerocall/style/style.css', 'last', array('absolute'=>true)) ?>
<?php //use_stylesheet('admin.css', '', array('absolute'=>true)) ?>
<?php use_stylesheet('../sf/sf_admin/css/main.css', '', array('absolute'=>true)) ?>
<!--[if IE 7]>
<link href="<?php echo stylesheet_path('../zerocall/style/ie-7.css', true) ?>" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body>
<?php use_helper('I18N') ?>
<div id="login-modal">
<div class="login-left">
<h4><?php echo __('Logga in p&aacute; dina sidor') ?></h4>
<form method="post" id="login_form">
<label><?php echo __('Email') ?></label><br />
<input type="text" name="email" id="email" />
<?php
/* 
if ($sf_user->hasFlash('error_message')): ?>
<p style="color: red; margin:0;"><?php echo $sf_user->getFlash('error_message') ?></p>
<?php endif; */?>
<p id="login_error" style="margin: 0; color: #d00; position: relative; top: -4px;">&nbsp;</p>
<label><?php echo __('Password') ?></label><br />
<input type="password" name="password" id="password" /><br />
<button onclick="submit();"><?php echo __('Log in') ?></button>
<?php
	echo image_tag('loading_green.gif', array(
										'id'=>'login_ind',
										'width'=>16, 
										'height'=>16,
										'style'=>'position: relative; top: 5px; display: none'
										));
?>
</form>
</div>
<div class="login-right"><h4><?php echo __('Forgot password?') ?></h4>
<form id="forgot_password_form" method="post" action="<?php echo url_for('customer/sendPassword') ?>">
<p><?php echo __('Write e-mail address you used for registration.<br />Your password will be sent to you via this email.') ?></p>
<input type="text" name="email" id="forgot_password_email" /><br />
<button>Send</button>
<?php
	echo image_tag('loading_green.gif', array(
										'id'=>'forgot_password_ind',
										'width'=>16, 
										'height'=>16,
										'style'=>'position: relative; top: 5px; display: none'
										));
?>
</form></div>
<div class="fr cb luk"><?php echo __('Close window') ?></div>
</div>
<script type="text/javascript">
	$j = jQuery.noConflict();
	
	$j(document).ready(function(){
		$j('#login_form').submit(function(){
			
			$j('#login_ind').show();
			
			$j.ajax({
			  type: 'POST',
			  url: '<?php echo url_for('customer/login', true) ?>',
			  data: 'email='+$j('#email').val()+'&password='+$j('#password').val(),
			  success: function(data) {
			  	$j('#login_ind').hide();
			    
			    if (data=='invalid')
			    {
			    	$j('#login_error').text("<?php echo __("Email/password don't exist.")?>");
			    }
			    else
			    {
			    	$j('#login_error').text('&nbsp;');
			    	window.location.href = '<?php echo url_for('customer/dashboard', true) ?>';
			    }
			  }
			});			
			return false;
		});

		$j('#forgot_password_form').submit(function(){
			
			$j('#forgot_password_ind').show();
			
			$j.ajax({
			  type: 'POST',
			  url: '<?php echo url_for('customer/sendPassword', true) ?>',
			  data: 'email='+$j('#forgot_password_email').val(),
			  success: function(data) {
			  	$j('#forgot_password_ind').hide();
			    
			    if (data=='invalid')
			    {
			    	//$j('#login_error').text("<?php echo __("Email/password don't exist.")?>");
			    	alert('<?php echo __('Unable to perform your request, make sure your email address exists.') ?>');
			    	$j('#forgot_password_email').select();
			    }
			    else
			    {
			    	//$j('#login_error').text('&nbsp;');
			    	//window.location.href = '<?php echo url_for('customer/dashboard', true) ?>';
			    	alert('<?php __('Password is sent to your email address.') ?>');
			    }
			  }
			});			
			return false;
		});
		
		$j('form button').css('cursor', 'pointer');
		
	});
</script>
<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>