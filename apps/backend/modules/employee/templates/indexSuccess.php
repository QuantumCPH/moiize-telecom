<?php use_helper('I18N') ?><?php use_helper('Number') ?><div  id="sf_admin_container">
<h1><?php echo __('PCO Line List') ?></h1><br />
<?php if(isset($_REQUEST['message']) && $_REQUEST['message']=="edit"){  ?>

<?php if ($sf_user->hasFlash('messageEdit')): ?>
<div class="save-ok">
 <h2><?php echo __($sf_user->getFlash('messageEdit')) ?></h2>
</div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('messageEditError')): ?>
<div class="form-errors">
 <h2><?php echo __($sf_user->getFlash('messageEditError')) ?></h2>
</div>
<?php endif; ?>


<?php  }   ?>

<?php if(isset($_REQUEST['message']) && $_REQUEST['message']=="add"){  ?>
<?php if ($sf_user->hasFlash('messageAdd')): ?>
<div class="save-ok">
 <h2><?php echo __($sf_user->getFlash('messageAdd')) ?></h2>
</div>
<?php endif; ?>
<?php  }   ?>


<div id="sf_admin_header">
<a target="_self" class="external_link" href="<?php echo url_for('employee/add'); if(isset($companyval) && $companyval!=""){echo "?company_id=".$companyval;} ?>" style="text-decoration:none;"><?php echo __('Create New') ?></a>
<a target="_self" class="external_link" href="<?php echo url_for('employee/addMultiple'); if(isset($companyval) && $companyval!=""){echo "?company_id=".$companyval;} ?>" style="text-decoration:none;"><?php echo __('Create Multiple PCO Line') ?></a>
</div>

<?php if ($sf_user->hasFlash('message')): ?><br />
<div class="save-ok">
 <h2><?php echo __($sf_user->getFlash('message')) ?></h2>
</div><br/>
<?php endif; ?>


<table width="950"  style="border: 1px;" class="sf_admin_list" cellspacing="0">
  <thead>
      <tr>
      
      <th align="left"  id="sf_admin_list_th_name"><?php echo __('Agent') ?></th>
      <th align="left"  id="sf_admin_list_th_name"><?php echo __('Name') ?></th>
      <th align="left"  id="sf_admin_list_th_name"><?php echo __('product') ?></th>
    
 <!--     <th align="left" id="sf_admin_list_th_name"><?php echo __('Mobile number') ?></th>
       <th align="left"><?php echo __('Resenumber')  ?></th>-->
       <?php  if(isset($companyval) && $companyval!=""){  ?>
        <th align="left"  id="sf_admin_list_th_name"><?php echo __('Balance') ?></th>
        <?php } ?>

        
      <th align="left"  id="sf_admin_list_th_name"><?php echo __('Created at') ?></th>
       <th align="left"  id="sf_admin_list_th_name"><?php echo __('Billing Account') ?></th>
   
 <!--         <th align="left">App code</th>-->
   
      <th align="left">Password</th>
        <th align="left"  id="sf_admin_list_th_name"><?php echo __('Action') ?></th>
    </tr>
  </thead>
  <tbody>
        <?php      $amount_total = 0;
                       $incrment=1;
   foreach ($employees as $employee): ?>

       <?php
                  if($incrment%2==0){
                  $class= 'class="even"';
                  
                  }else{
                    $class= 'class="odd"';
                     
                      }
 $incrment++;
                  ?>
    <tr <?php echo $class; ?>>
    
      <td><?php  $comid=$employee->getCompanyId();
      if(isset($comid) && $comid!=""){
               $c = new Criteria();
      $c->add(CompanyPeer::ID, $employee->getCompanyId());
  $companys = CompanyPeer::doSelectOne($c);

              echo $companys->getName();
      }
              ?></td>
      <td><?php echo htmlspecialchars($employee->getFirstName()); ?></td>
      
      
      <td>
          <?php  $pid=$employee->getProductId();
      if(isset($pid) && $pid!=""){
               $c = new Criteria();
      $c->add(ProductPeer::ID, $pid);
      $products = ProductPeer::doSelectOne($c);

              echo $products->getName();
      }
              ?>
      </td>
 <?php  if(isset($companyval) && $companyval!=""){  ?>
      <td> <?php
        //echo $companyval;
        $mobileID= $employee->getCountryMobileNumber();
        $telintaGetBalance = 0;

        $ct = new Criteria();
        $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, sfConfig::get("app_telinta_emp").$companyval.$employee->getId());
        $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
        $telintaAccount = TelintaAccountsPeer::doSelectOne($ct);
        $ComtelintaObj = new CompanyEmployeActivation();
        if($telintaAccount){            
            $accountInfo = $ComtelintaObj->getAccountInfo($telintaAccount->getIAccount());
           // print_r($accountInfo);
            $telintaGetBalance = $accountInfo->account_info->balance;
            $telintaGetBalance1=0;
            $telintaGetBalancerese=0;
            $telintaGetBalancerese =  ($telintaGetBalancerese>0)?(float)$telintaGetBalancerese:0;
            echo  $balnc = (float)$telintaGetBalance + (float)$telintaGetBalance1 + $telintaGetBalancerese;
            echo " &euro;";
        }
        ?></td>

      <?php } ?>
      <td><?php echo substr($employee->getCreatedAt(),0,10); ?></td>
      <?PHP
        //$ct1 = new Criteria();
        //$ct1->add(TelintaAccountsPeer::ACCOUNT_TITLE, 'testesvoip'.$employee->getCompanyId().$employee->getId());
        //$ct1->addAnd(TelintaAccountsPeer::STATUS, 3);
        //$telintaAccount1 = TelintaAccountsPeer::doSelectOne($ct1);
      ?>
      <td><?php echo sfConfig::get("app_telinta_emp").$employee->getCompanyId().$employee->getId() ?></td>
   
    <!--  <td align="center">  <?php //$appval=$employee->getIsAppRegistered();  if(isset($appval) && $appval==1){   ?> <img alt="Tick" src="/sf/sf_admin/images/tick.png">  <?php //} ?></td>
       <td><?php //echo $employee->getAppCode() ?></td>-->
       <td><?php //echo $employee->getPassword() 
      
        //$comid=$employee->getCompanyId();
       // $mobileID= $employee->getCountryMobileNumber();
        //$telintaGetBalance = 0;

//        $ct = new Criteria();
//        $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, sfConfig::get("app_telinta_emp").$comid.$employee->getId());
//        $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
//        $telintaAcc = TelintaAccountsPeer::doSelectOne($ct);
//        if($telintaAcc){ //echo $telintaAcc->getIAccount();
//        $accountInfo = $ComtelintaObj->getAccountInfo($telintaAcc->getIAccount());
        echo  $employee->getPassword();
//        }  

        
       
       ?></td>
       <td><a href="<?php echo url_for('employee/edit?id='.$employee->getId()) ?>"><img src="/sf/sf_admin/images/edit_icon.png" title=<?php echo __("edit")?> alt=<?php echo __("edit")?>></a>
           <a href="employee/del?id=<?php echo $employee->getId(); if(isset($companyval) && $companyval!=""){echo "&company_id=".$companyval;} ?>"  onclick="if (confirm('<?php echo __('Are you sure?') ?>')) { var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'post'; f.action = this.href;f.submit(); };return false;"> <img src="/sf/sf_admin/images/delete_icon.png" title=<?php echo __("delete")?> alt=<?php echo __("delete")?>></a>
       <a href="<?php echo url_for('employee/view?id='.$employee->getId()) ?>"><img src="/sf/sf_admin/images/default_icon.png" title=<?php echo __("view")?> alt=<?php echo __("view")?>></a>
        <!--    <a href="<?php echo url_for('employee/view?id='.$employee->getId()) ?>"><img src="/sf/sf_admin/images/default_icon.png" title="view" alt="call history"></a>
     -->  </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<br/>
  <div id="sf_admin_header">
<a target="_self" class="external_link" href="<?php echo url_for('employee/add'); if(isset($companyval) && $companyval!=""){echo "?company_id=".$companyval;} ?>" style="text-decoration:none;"><?php echo __('Create New') ?></a>

</div></div>