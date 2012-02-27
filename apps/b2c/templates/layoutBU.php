<?php use_helper('I18N') ?>
<?php $test_dir =  '/testwp'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php include_http_metas() ?>
    <?php include_metas()  ?>
	<?php include_title() ?>

	<?php use_javascript('../zerocall/js/jquery-1.4.2.min.js', '', array('absolute'=>true)) ?>
	<?php use_javascript('../zerocall/js/cufon-yui.js', '', array('absolute'=>true)) ?>
	<?php use_javascript('../zerocall/js/Barmeno_400-Barmeno_400.font.js', '', array('absolute'=>true)) ?>
	<?php use_javascript('../zerocall/js/Barmeno-Medium_400.font.js', '', array('absolute'=>true)) ?>
	<?php use_javascript('../zerocall/js/cufon-replace.js', '', array('absolute'=>true)) ?>
	<?php use_javascript('../zerocall/js/jquery.jcarousel.min.js', '', array('absolute'=>true)) ?>
	<?php use_javascript('../zerocall/js/carousel.js', '', array('absolute'=>true)) ?>

	<?php use_javascript('jquery.formatCurrency-1.3.0.min.js', '', array('absolute'=>true)) ?>		
	<?php use_javascript('i18n/jquery.formatCurrency.all.js', '', array('absolute'=>true)) ?>	
	
	<?php use_stylesheet('../zerocall/style/style.css', 'last', array('absolute'=>true)) ?>
	<?php use_stylesheet('admin.css', '', array('absolute'=>true)) ?>
	<?php use_stylesheet('../sf/sf_admin/css/main.css', '', array('absolute'=>true)) ?>

	<!--[if IE 7]>
	<link href="<?php echo stylesheet_path('../zerocall/style/ie-7.css', true) ?>" rel="stylesheet" type="text/css" />
	<![endif]-->
</head>
<body>
<div id="wrap">
<?php
	// set alert if customer is not yet registered with fonet
	
	//$alert_fonet_customer = CustomerPeer::
?>
  <div id="header">
    <div id="logo">
      <h1><a href="http://zerocall.com<?php echo $test_dir ?>/" title="Zero Call - Zapna">Zero Call - Zapna</a></h1>
    </div>
    <div id="nav">
      <ul>
	      <li><a href="http://zerocall.com<?php echo $test_dir ?>/?page_id=9">S&#229;dan fungerer det</a></li>
	      <li><a href="http://zerocall.com<?php echo $test_dir ?>/?page_id=10">Priser</a></li>
	
	      <li><a href="http://zerocall.com<?php echo $test_dir ?>/?page_id=73" >Produkter</a></li>
	      <li><a href="http://zerocall.com<?php echo $test_dir ?>/?page_id=91" >Om zerocall</a></li>
         <?php
         if (!$sf_user->isAuthenticated()):
          ?>
			<li><a href="<?php echo url_for('@signup_step1', true) ?>"><?php echo __('Sign up') ?></a></li>
         	<li class="last"><a href="<?php echo url_for('customer/login', true) ?>" id="login_link"><?php echo __('Login') ?></a></li>
         <?php else: ?>
	     	<li><a href="<?php echo url_for('customer/dashboard', true) ?>"><?php echo __('My Account') ?></a></li>
         	<li class="last"><a href="<?php echo url_for('customer/logout', true) ?>"><?php echo __('Logout') ?></a></li>        
         <?php endif; ?>
      </ul>
    </div>
  </div> <!-- end header -->

	
  <?php echo $sf_content; ?>
</div> <!-- end wrap -->
<div id="footer">
  <div class="footer">
	<div id="homepage-box-row-footer">
	  <div class="footer-inner">
	    <ul>
			<li><b>Zerocall</b></li>
			<li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=91">Om Us</a></li>
			<li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=17">Nyheder</a></li>
			<li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=19">Kontakt os</a></li>
			<li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=19">Presse</a></li>
	    </ul>
	  </div>
	  <div class="footer-inner">
	    <ul>
			<li><b>Support</b></li>
			<li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=91">FAQ</a></li>
			<li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=19">Hvordan fungere zerocall</a></li>
			<li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=19">Live Support</a></li>
	        <li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=98">Vilk&#229;r</a></li>
		</ul>
	  </div>
	  <div class="footer-inner">
	    <ul>
			<li><b>Produkter</b></li>
			<li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=91">LandNCall AB - free</a></li>
			<li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=19">LandNCall AB - Out</a></li>
			<li>&raquo; <a href="<?php echo $test_dir ?>/?page_id=19">LandNCall AB - SMS</a></li>
		</ul>
	  </div>
	</div>
  </div>
</div>
<div class="cite">
  <div id="cite" class="fl">Copyright &copy; Zer0Call 2010</div>
  <div id="sec" class="fr">
	<script type="text/javascript" src="https://seal.thawte.com/getthawteseal?host_name=zerocall.com&amp;size=S&amp;lang=en"></script>
  </div>
  <div id="ccs" class="fr"><img src="<?php echo image_path('../zerocall/images/ccs.png',true) ?>" alt="Credit Cards" /></div>
</div>
<script type="text/javascript"> 
	Cufon.now(); 
</script>

</body>
</html>
