<?php use_helper('I18N') ?>
<div class="<?php echo __('dash-nav') ?>">
	<a href="<?php echo url_for('customer/dashboard', true) ?>" class="dashboard<?php echo ($selected=='dashboard')?'-s':'' ?>"><?php echo __('Dashboard') ?></a>
	<a href="<?php echo sfConfig::get('app_epay_relay_script_url').url_for('customer/refill?customer_id='.$customer_id, true) ?>" class="refil<?php echo ($selected=='refill')?'-s':'' ?>"><?php echo __('Refil') ?></a>
	<a href="<?php echo url_for('customer/callhistory', true) ?>" class="callhistory<?php echo ($selected=='callhistory')?'-s':'' ?>"><?php echo __('Call History') ?></a>
	<a href="<?php echo url_for('customer/refillpaymenthistory', true) ?>" class="paymenthistory<?php echo ($selected=='paymenthistory')?'-s':'' ?>"><?php echo __('Payment History') ?></a>
	<a href="<?php echo url_for('customer/settings', true) ?>" class="settings<?php echo ($selected=='settings')?'-s':'' ?>"><?php echo __('Settings') ?></a>
        <a href="<?php echo url_for('customer/smsHistory', true) ?>" class="websms<?php echo ($selected=='websms')?'-s':'' ?>"><?php echo __('SMS History') ?></a>
        <a href="<?php echo url_for('customer/logout', true) ?>" class="logout<?php echo ($selected=='logout')?'-s':'' ?>"><?php echo __('Logout') ?></a>
         
</div>