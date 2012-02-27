<?php use_helper('I18N') ?>
<script language="javascript">
		jQuery(document).ready(function(){
		jQuery('#nav2>li.current_page_item ul, #nav2>li.current_page_ancestor ul').css('display','block');
		jQuery('#nav2>li').hover(function(){
			jQuery('#nav2 li ul').css('display','none');
			jQuery(this).children('ul').css('display','block');
		});

		jQuery('#nav2').mouseout(function(){
			setTimeout( function(){
				jQuery('#nav2 li ul').fadeOut('fast')
				}, 20000 );
		});
	});
</script>

    <div style="vertical-align: top; float: right; margin-top: -28px;">
    <?php

//    $enableCountry = new Criteria();
//    $enableCountry->add(EnableCountryPeer::STATUS, '1');
//
//    $form = new sfFormLanguage(
//    $sf_user,
//    array('languages' => array('en', 'da','pl'))
//    );
//    $widgetSchema = $form->getWidgetSchema();
//    $widgetSchema['language']->setAttribute('onChange', "this.form.submit();");
//    $widgetSchema['language']->setAttribute('onChange', "this.form.submit();");
//
//    $widgetSchema['language']->setLabel(false);
    ?>

<!--    <form action="">
        <?php   echo $form ;

        ?>
        <input type="hidden" value="<?php echo $sf_user->getAttribute('product_ids') ?>" name="pid">
        <input type="hidden" value="<?php echo $sf_user->getAttribute('cusid') ?>" name="cid">
    </form>-->
    </div>
      <ul id="nav2" class="clearfloat">
         <?php
         //echo $sf_user->getAttribute('activelanguage');
         if($sf_user->getAttribute('activelanguage')=='pl'){
            //echo file_get_contents('http://pl.zerocall.com/?page_id=544');
         }else if($sf_user->getAttribute('activelanguage')=='da'){
           // echo file_get_contents('http://dk.zerocall.com/?page_id=542');
         }else{
           // echo file_get_contents('http://intl.zerocall.com/?page_id=547');;
         }
        echo file_get_contents('http://zerocall.com/?page_id=332');


         if (!$sf_user->isAuthenticated()):
          ?>
			<li><a href="<?php echo url_for('@signup_step1', true) ?>"><?php echo __('Sign up') ?></a></li>
         	<li class="last"><a href="<?php echo url_for('customer/login', true) ?>" id="login_link"><?php echo __('Login') ?></a></li>
         <?php else: ?>
	     	<li><a href="<?php echo url_for('customer/dashboard', true) ?>"><?php echo __('My Account') ?></a></li>
         	<li class="last"><a href="<?php echo url_for('customer/logout', true) ?>"><?php echo __('Logout') ?></a></li>
         <?php endif; ?>
      </ul>
<script>
   // document.getElementById("language").options[0].text = 'Dansk';
   // document.getElementById("language").options[2].text = 'polski';
</script>