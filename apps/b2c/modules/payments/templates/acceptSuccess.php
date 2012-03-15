<?php use_helper('I18N') ?>
<?php include_partial('customer/dashboard_header', array('customer'=> $customer, 'section'=>__('Payment Confirmation')) ) ?>
  <div class="left-col">
    <?php //include_partial('customer/navigation', array('selected'=>'', 'customer_id'=>$customer->getId())) ?>
	<p align="center" style="margin:50px auto">
	<?php
		echo __("Thank you for purchasing zer0call %1% package, you will receive package in few days. For any questions please feel free to contact us at"
	  			, array('%1%'=>$order->getProduct()->getName()));
	?>
	<a href="mailto:support@landncall.com">support@landncall.com</a>.
	</p>
  </div> <!-- end left-col -->
  <?php include_partial('customer/sidebar') ?>