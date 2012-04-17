<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>


<div id="sf_admin_container"><h1><?php echo __('Payment History') ?></h1>
<?php if ($sf_user->hasFlash('message')): ?>
<div class="save-ok">
  <h2><?php echo __($sf_user->getFlash('message')) ?></h2>
</div>
<?php endif; ?>
</div>
<table width="100%" cellspacing="0" cellpadding="2" class="tblAlign">
<tr class="headings">
    <th><?php echo __('Date & Time') ?></th>
    <th><?php echo __('Company & Name') ?></th>
    <th><?php echo __('Description') ?></th>
    <th><?php echo __('Amount') ?> (&euro;)</th>
    <th><?php echo __('Reciept') ?></th>
</tr>
<?php 
$amount_total = 0;
$incrment=1;
foreach($transactions as $transaction):

if($incrment%2==0){
  $colorvalue="#FFFFFF";
  $class= 'class="even"';
  }else{
    $class= 'class="odd"';
    $colorvalue="#FCD9C9";
 }
//                  
$incrment++;
?>
<tr  style="background-color:<?php //echo $colorvalue;?>" <?php echo $class;?>>
    <td><?php echo  date("Y-m-d H:i:s",strtotime($transaction->getCreatedAt())+25200); ?></td>
    <td><?php echo ($transaction->getCompany()?$transaction->getCompany():'N/A')?></td>
    <td><?php echo __($transaction->getDescription()) ?></td>
    <td align=""><?php echo format_number($transaction->getAmount()); $amount_total += $transaction->getAmount(); ?></td>
    <td><a href="<?php echo sfConfig::get('app_main_url')."company/ShowReceipt?tid=".$transaction->getId(); ?>" target="_blank"><img src="/sf/sf_admin/images/default_icon.png" title=<?php echo __("view")?> alt=<?php echo __("view")?>></a></td>
</tr>
<?php endforeach; ?>
<?php if(count($transactions)==0): ?>
<tr>
    <td colspan="5"><p><?php echo __('There are currently no transactions to show.') ?></p></td>
</tr>
<?php else: ?>
<tr><td>&nbsp;</td>
    <td colspan="2" align="right"><strong><?php echo __('Total:') ?>&nbsp;&nbsp;</strong></td>
    <td align="" colspan="2" ><?php echo format_number($amount_total);  ?> &euro;</td>
    
</tr>	
<?php endif; ?>
</table>
