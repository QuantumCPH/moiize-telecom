<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>

<?Php if($companyval!=''){?><div id="sf_admin_container">
	<div id="sf_admin_content">
            <a href="<?php echo url_for('employee/index').'?company_id='.$companyval."&filter=filter" ?>" class="external_link" target="_self"><?php echo __('PCO Lines') ?></a>
            <a href="<?php echo url_for('company/usage').'?company_id='.$companyval; ?>" class="external_link" target="_self"><?php echo __('Usage') ?></a>
            <a href="<?php echo url_for('company/paymenthistory').'?company_id='.$companyval.'&filter=filter' ?>" class="external_link" target="_self"><?php echo __('Payment History') ?></a>
        </div>
    </div>
<?php } ?>

<div id="sf_admin_container"><h1><?php echo __('Payment History') ?></h1>
<?php if ($sf_user->hasFlash('message')): ?>
<div class="save-ok">
  <h2><?php echo __($sf_user->getFlash('message')) ?></h2>
</div>
<?php endif; ?>
</div>
<table width="75%" cellspacing="0" cellpadding="2" class="tblAlign">
<tr class="headings">
    <th><?php echo __('Date & Time') ?></th>
    <th><?php echo __('Agent Name') ?></th>
    <th><?php echo __('Description') ?></th>
    
    <th><?php echo __('Amount') ?> (&euro;)</th>
    <th><?php echo __('Reciept') ?></th>
</tr>
<?php 
$amount_total = 0;
$incrment=1;
foreach($transactions as $transaction):

if($incrment%2==0){
    $class= 'class="even"';
  }else{
    $class= 'class="odd"';
    
 }
             
$incrment++;
?>
<tr <?php echo $class; ?>>
    <td><?php echo  $transaction->getCreatedAt() ?><br /><?php echo  date('Y-m-d H:s:i',strtotime($transaction->getCreatedAt())+21600) ?></td>
    <td><?php echo ($transaction->getCompany()?$transaction->getCompany():'N/A')?></td>
    <td><?php echo __($transaction->getDescription()) ?></td>
    <td align="right"><?php echo format_number($transaction->getAmount()); $amount_total += $transaction->getAmount(); ?></td>
    <td><a href="<?php echo sfConfig::get('app_backend_url')."company/ShowReceipt?tid=".$transaction->getId()?>" target="_blank"> <img src="/sf/sf_admin/images/default_icon.png" title=<?php echo __("view")?> alt=<?php echo __("view")?>></a></td>
</tr>
<?php endforeach; ?>
<?php if(count($transactions)==0): ?>
<tr>
    <td colspan="5"><p><?php echo __('There are currently no transactions to show.') ?></p></td>
</tr>
<?php else: ?>
<tr>
    <td colspan="3" align="right"><strong><?php echo __('Total:') ?>&nbsp;&nbsp;</strong></td>
    <td align="right"><?php echo format_number($amount_total);  ?> &euro;</td>
    <td>&nbsp;</td>
    
</tr>	
<?php endif; ?>
</table>
