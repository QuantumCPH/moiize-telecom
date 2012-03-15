<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<style type="text/css">
	table {
		margin-bottom: 10px;
	}
	
	table.summary td {
		font-size: 1.2em;
		font-weight: normal;
	}
</style>
<div class="report_container">
  <div id="sf_admin_container"><h1><?php echo __('Registration Receipts') ?> (<?php echo (count($registrations));echo __(" receipts"); ?>)</h1></div>
        
  <div class="borderDiv"> 
   <table cellspacing="0" width="100%" class="summary">	
	<tr>
		<th>&nbsp;</th>
		<th><?php echo __('Date') ?></th>
		<th><?php echo __('Customer name') ?></th>
		<th><?php echo __('Mobile Number') ?></th>
		<th><?php echo __('Amount Refilled') ?></th>
		<th><?php echo __('Description') ?></th>
		<th><?php echo __('Show Receipt') ?></th>
		
	</tr>
	<?php 
	$i = 0;
	foreach($registrations as $registration):
	?>
	<tr <?php echo 'class="'.($i%2 == 0?'odd':'even').'"' ?>>
		<td><?php echo ++$i ?>.</td>
             
		<td><?php echo $registration->getCreatedAt(); ?>
		<td><?php 
			$customer = CustomerPeer::retrieveByPK($registration->getCustomerId());
			//$customer2 = CustomerPeer::retrieveByPK(72);
			//echo $transaction->getCustomerId();
			echo sprintf("%s %s", $customer->getFirstName(), $customer->getLastName());
			?>
            
		</td>
		<td><?php echo $customer->getMobileNumber()?></td>
		<td >
			<?php echo BaseUtil::format_number($registration->getAmount()) ?>
		</td>
		<td>
		<?php echo __($registration->getDescription()) ?>
		</td>
		<td><a href="#" class="receipt" onclick="javascript: window.open('<?php echo url_for('affiliate/printReceipt?tid='.$registration->getId(), true) ?>')"><?php echo __('Receipt') ?></a>
		</td>
		
	</tr>
	<?php endforeach; ?>
        
</table>

  </div>
  <div id="sf_admin_container"><h1><?php echo __('Refill Receipts') ?> (<?php echo (count($refills));echo __(" receipts"); ?>)</h1></div>
        
  <div class="borderDiv"> 

   <table cellspacing="0" width="100%" class="summary">
	<tr>
		<th>&nbsp;</th>
		<th><?php echo __('Date') ?></th>
		<th><?php echo __('Customer name') ?></th>
		<th><?php echo __('Mobile Number') ?></th>
		<th><?php echo __('Amount Refilled') ?></th>
		<th><?php echo __('Description') ?></th>
		<th><?php echo __('Show Receipt') ?></th>

	</tr>
	<?php
	$i = 0;
	foreach($refills as $refill):
	?>
	<tr <?php echo 'class="'.($i%2 == 0?'odd':'even').'"' ?>>
		<td><?php echo ++$i ?>.</td>

		<td><?php echo $refill->getCreatedAt(); ?>
		<td><?php
			$customer = CustomerPeer::retrieveByPK($refill->getCustomerId());
			//$customer2 = CustomerPeer::retrieveByPK(72);
			//echo $transaction->getCustomerId();
			echo sprintf("%s %s", $customer->getFirstName(), $customer->getLastName());
			?>

		</td>
		<td><?php echo $customer->getMobileNumber()?></td>
		<td >
			<?php echo BaseUtil::format_number($refill->getAmount()) ?>
		</td>
		<td>
		<?php echo __($refill->getDescription()) ?>
		</td>
		<td><a href="#" class="receipt" onclick="javascript: window.open('<?php echo url_for('affiliate/printReceipt?tid='.$refill->getId(), true) ?>')"> <?php echo __('Receipt') ?></a>
		</td>

	</tr>
	<?php endforeach; ?>

</table>
        
  </div>
  <p class="pTotal"><?php echo __('Total Receipts for transactions:') ?> <?php echo (count($registrations)+count($refills)) ?></p>
</div>