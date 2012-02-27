<?php use_helper('I18N') ?>
<?php include_partial('customer/dashboard_header', array('customer'=> null, 'section'=>__('Aktivera Resenummer')) ) ?>
  <div class="left-col">
       <?php include_partial('navigation', array('selected'=>__('Payment Confirmation'), 'customer_id'=>$customer->getId())) ?>
	<div align="center" style="margin:50px auto">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
	<p><?php
		echo __("Thank For Using our services. VoIP unsubscribed successfully.");
		echo '</p>';
		echo '<p>';
		echo __("For any questions please feel free to contact us at");
		echo '</p>';
	?>
	<a href="mailto:support@landncall.com">support@landncall.com</a>.
	</div>
  </div> <!-- end left-col -->
  <?php include_partial('customer/sidebar') ?> 