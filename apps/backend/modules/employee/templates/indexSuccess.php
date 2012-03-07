<?php use_helper('I18N') ?><?php use_helper('Number') ?><div  id="sf_admin_container">
<h1><?php echo __('PCO Line List') ?></h1><br />
<?php if(isset($_REQUEST['message']) && $_REQUEST['message']=="edit"){  ?>

<?php if ($sf_user->hasFlash('messageEdit')): ?>
<div class="save-ok">
 <h2><?php echo __($sf_user->getFlash('messageEdit')) ?></h2>
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
   
 <!--         <th align="left">App code</th>
   
      <th align="left">Password</th>-->
        <th align="left"  id="sf_admin_list_th_name"><?php echo __('Action') ?></th>
    </tr>
  </thead>
  <tbody>
        <?php      $amount_total = 0;
                       $incrment=1;
   foreach ($employees as $employee): ?>

       <?php
                  if($incrment%2==0){
                  $colorvalue="#FFFFFF";
                  
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
 <!--      <td><?php echo $employee->getMobileNumber() ?></td>
     <td>
           <?php


//                            $empid=$employee->getRegistrationType();
//                          if(isset($empid) && $empid==1){ ?>


				  	<?php  //  $voip = new Criteria();
//        $voip->add(SeVoipNumberPeer::CUSTOMER_ID, $employee->getCountryMobileNumber());
//        $voip->addAnd(SeVoipNumberPeer::IS_ASSIGNED, 1);
//        $voipv = SeVoipNumberPeer::doSelectOne($voip);

//                         if(isset ($voipv)){echo $voipv->getNumber();} ?>
				 


                            <?php   //}else{ echo __('No'); } ?>
</td>-->
 <?php  if(isset($companyval) && $companyval!=""){  ?>
      <td> <?php

        $mobileID= $employee->getCountryMobileNumber();
        $telintaGetBalance = 0;

        $ct = new Criteria();
        $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, 'testesvoip'.$companyval.$employee->getId());
        $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
        $telintaAccount = TelintaAccountsPeer::doSelectOne($ct);

        $accountInfo = CompanyEmployeActivation::getAccountInfo($telintaAccount->getIAccount());
        $telintaGetBalance = $accountInfo->account_info->balance;

//$telintaGetBalance;
        $telintaGetBalance1=0;
//        $telintaGetBalance1 = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name=cb'.$mobileID.'&type=account');
//        $telintaGetBalance1 = str_replace('success=OK&Balance=', '', $telintaGetBalance1);
//        $telintaGetBalance1 = str_replace('-', '', $telintaGetBalance1);
        //$telintaGetBalance;

//         $regtype=$employee->getRegistrationType();
        $telintaGetBalancerese=0;
//        if(isset($regtype) && $regtype==1){
//        $voip = new Criteria();
//
//        $voip->add(SeVoipNumberPeer::CUSTOMER_ID, $employee->getCountryMobileNumber());
//        $voip->addAnd(SeVoipNumberPeer::IS_ASSIGNED, 1);
//        $voipv = SeVoipNumberPeer::doSelectOne($voip);
//
//        if(isset ($voipv)){
//
//       $resenummer=$voipv->getNumber();
//       $resenummer = substr($resenummer, 2);
//       $telintaGetBalancerese = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=getbalance&name='.$resenummer.'&type=account');
//       $telintaGetBalancerese = str_replace('success=OK&Balance=', '', $telintaGetBalancerese);
//       $telintaGetBalancerese = str_replace('-', '', $telintaGetBalancerese);
//
//        }
//        }
      echo  $balnc=(float)$telintaGetBalance+(float)$telintaGetBalance1+($telintaGetBalancerese>0)?(float)$telintaGetBalancerese:0;
          echo "&euro;";
                                                ?></td>

      <?php } ?>
      <td><?php echo substr($employee->getCreatedAt(),0,10); ?></td>
      <td><?php echo 'testesvoip'.$companyval.$employee->getId(); ?></td>
   
    <!--  <td align="center">  <?php //$appval=$employee->getIsAppRegistered();  if(isset($appval) && $appval==1){   ?> <img alt="Tick" src="/sf/sf_admin/images/tick.png">  <?php //} ?></td>
       <td><?php //echo $employee->getAppCode() ?></td>
       <td><?php //echo $employee->getPassword() ?></td>-->
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