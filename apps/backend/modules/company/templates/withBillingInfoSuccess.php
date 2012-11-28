<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>

<div  id="sf_admin_container">
    <h1><?php echo __('Billing System Information') ?></h1><br />

<?php if ($sf_user->hasFlash('message')): ?>
    <br />
    <div class="save-ok">
        <h2><?php echo __($sf_user->getFlash('message')) ?></h2>
    </div>
    <br/>
<?php endif; ?>


  
       <br>
<table width="100%" cellspacing="0" cellpadding="2" class="tblAlign">
        <tr class="headings">
      <th><?php echo __('Agent Name') ?></th>
      <th><?php echo __('Vat no') ?></th>
         
      <th><?php echo __('Contact name') ?></th>
      <th><?php echo __('Mobile Number') ?></th>
      <th><?php echo __('Billing Name') ?></th>
         <th><?php echo __('Billing Currency') ?></th>
      <th><?php echo __('Billing balance') ?></th>
      <th><?php echo __('Credit Limit') ?></th>
      <th><?php echo __('Billing Credit Limit') ?></th>
    
    </tr>
<?php
$incrment=1;
foreach ($companies as $company):
    if($incrment%2==0){
        $class= 'class="even"';
    }else{
        $class= 'class="odd"';
    }
        $incrment++;
?>
    <tr <?php echo $class; ?>>
        <td><?php echo $company->getName(); ?></td>
        <td><?php echo $company->getVatNo(); ?></td>
          
        <td><?php echo $company->getContactName();?></td>
        <td><?php echo $company->getHeadPhoneNumber(); ?></td>
        <td><?php $customer = CompanyEmployeActivation::getCustomerInfo($company);
        echo $customer->name;
        
        ?></td>
        <td><?php 
        echo $customer->iso_4217;
        
        ?></td>
        <td><?php 
        echo $customer->balance;
        
        ?></td>
        <td><?php echo $company->getCreditLimit(); ?></td>
        <td><?php 
        echo $customer->credit_limit;
        
        ?></td>
    </tr>
 <?php endforeach; ?>
</table>


</div>
