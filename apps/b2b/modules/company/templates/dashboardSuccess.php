<h1>Available Balance: <?php echo $balance ?> &euro;  </h1><br/><h1 >    Credit Limit:  <?php echo  $company->getCreditLimit();  ?> &euro;   </h1><br/>
<div id="sf_admin_container" style="clear: both;float: left;">
    <?php if ($sf_user->hasFlash('messageChangeError')): ?>
    <div class="form-errors">
     <h2><?php echo __($sf_user->getFlash('messageChangeError')) ?></h2>
    </div>
    <?php endif; ?>    
</div>
<div id="sf_admin_container" style="clear: both;float: left;">    
    <?php if ($sf_user->hasFlash('messageChange')): ?>
    <div class="save-ok">
     <h2><?php echo __($sf_user->getFlash('messageChange')) ?></h2>
    </div>
    <?php endif; ?>
</div>
<br clear="all" />
<div id="sf_admin_container" style="clear: both;float: left;"><h1><?php echo __('PCO Lines') ?></h1></div>
<table class="tblAlign" width="100%" cellspacing="0" cellpadding="3">
        <thead>
            <tr class="headings">
                <th align="left"  id="sf_admin_list_th_name"><?php echo __('Name') ?></th>
                <th align="left"  id="sf_admin_list_th_name"><?php echo __('Balance Consumed') ?></th>
                <th align="left"  id="sf_admin_list_th_name"><?php echo __('Created at') ?></th>
                <th align="left"  id="sf_admin_list_th_name"><?php echo __('Voice package') ?></th>
                <th align="left"  id="sf_admin_list_th_name"><?php echo __('Change Voice package') ?></th>
            </tr>
        </thead>
        <?php
        $incrment = 1;
        foreach ($employees as $employee) {
             if($incrment%2==0){
                  $class= 'class="even"';
                  
                  }else{
                    $class= 'class="odd"';
                     
                      }
 $incrment++;

        ?>
            <tr <?php echo $class ?>>
                <td><?php echo $employee->getFirstName(); ?></td>
                <td><?php
                
            $ct = new Criteria();
            $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, sfConfig::get("app_telinta_emp") . $company->getId() . $employee->getId());
            $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
            $telintaAccount = TelintaAccountsPeer::doSelectOne($ct);
            if($telintaAccount){
                $ComtelintaObj = new CompanyEmployeActivation();
                $accountInfo = $ComtelintaObj->getAccountInfo($telintaAccount->getIAccount());
                // print_r($accountInfo);
                echo $accountInfo->account_info->balance;
            }else{
                echo "0";
            }
        ?> &euro;
            </td>
            <td><?php echo  date("Y-m-d H:i:s",strtotime($employee->getCreatedAt())+25200); ?></td>
            <td><?php echo $employee->getPricePlan()->getTitle(); ?></td>
            <td><a href="<?php echo url_for("company/changePackage?lineid=".$employee->getId(),true)?>">Click Here</a></td>
        </tr>
        <?php } ?>
        </table>

    <div id="sf_admin_container"><h1><?php echo __('News Box') ?></h1></div>

    <div class="borderDiv">

        <br/>
        <p>

        <?php
            $currentDate = date('Y-m-d');
            foreach ($updateNews as $updateNew) {
                $sDate = $updateNew->getStartingDate();
                $eDate = $updateNew->getExpireDate();

                if ($currentDate >= $sDate) {
        ?>


                    <b><?php echo $sDate ?></b><br/>
        <?php echo $updateNew->getHeading(); ?> :
        <?php
                    if (strlen($updateNew->getMessage()) > 100) {
                        echo substr($updateNew->getMessage(), 0, 100);
                        echo link_to('....read more', sfConfig::get('app_main_url') . 'company/newsListing');
                    } else {
                        echo $updateNew->getMessage();
                    }
        ?>
                    <br/><br/>

        <?php
                }
            }
        ?>
            <b><?php echo link_to(__('View All News & Updates'), sfConfig::get('app_main_url') . 'company/newsListing'); ?> </b>
    </p>
</div>


    <div id="sf_admin_container"><h1><?php echo __('Promotion Rates') ?></h1></div>

    <div class="borderDiv">

        <table width="100%">
            <tr><td><b>Destination Name</b> </td><td><b>Destination Rate</b><td/></tr>
<?php
  $rt = new Criteria();
            $rt->add(PromotionRatesPeer::AGENT_ID , $company->getId());

            $promotionRates = PromotionRatesPeer::doSelect($rt);
            foreach ($promotionRates as $promotionRate){ 
              
                ?>

<tr>
<td>
           <?php echo $promotionRate->getNetworkName();     ?> </td><td>  <?php echo $promotionRate->getNetworkRate();     ?></td></tr>


          <?php
            }
?>
    </table>
</div>