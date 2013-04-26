<?php use_helper('I18N') ?>
<div id="sf_admin_container">
    <h1><?php echo __('Rates') ?></h1>
</div>  
<table width="100%" cellspacing="0" cellpadding="2" class="tblAlign">
<tr class="headings">
    <th width="50%"><?php echo __('Title') ?></th>
    <th width="23%"><?php echo __('Standard Package Rates') ?></th>
    <th width="27%"><?php echo __('Premium Package Rates') ?></th>
</tr>
<?php 

$incrment=1;
foreach($rates as $rate):

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
    <td><?php echo  $rate->getTital() ?></td>
    <td><?php echo ($rate->getStandardPackageRates())?></td>
    <td><?php echo ($rate->getPremiumPackageRates())?></td>
</tr>
<?php endforeach; ?>
<?php if(count($rates)==0): ?>
<tr>
    <td colspan="4"><p><?php echo __('There are currently no rates to show.') ?></p></td>
</tr>
<?php endif; ?>
</table>  
         