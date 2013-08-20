<?php use_helper('I18N') ?>
<style>
    button#trigger_enddate{background-image:url(../../images/date.png) !important; margin:0px; padding:0px; border:none !important;width: 22px; height: 22px; vertical-align: middle !important}
    button#trigger_startdate{background-image:url(../../images/date.png) !important; margin:0px; padding:0px; border:none !important;width: 22px; height: 22px; vertical-align: middle !important}
</style>
<?PHP
    $str=strlen($company->getId());
    $str1=strlen(sfConfig::get("app_telinta_emp"));
    $substr=$str+$str1;
?>
<div id="sf_admin_container">
    <div id="sf_admin_content">
       
        <a href="<?php echo url_for('employee/index') . '?company_id=' . $company->getId() . "&filter=filter" ?>" class="external_link" target="_self"><?php echo __('PCO Lines') ?> (<?php echo count($company->getEmployees()) ?>)</a>
        <a href="<?php echo url_for('company/usage') . '?company_id=' . $company->getId(); ?>" class="external_link" target="_self"><?php echo __('Usage') ?></a>
        <a href="<?php echo url_for('company/paymenthistory') . '?company_id=' . $company->getId() . '&filter=filter' ?>" class="external_link" target="_self"><?php echo __('Payment History') ?></a>

        <h1><?php echo __('Call History'); if(isset($iAccountTitle)&&$iAccountTitle!=''){echo "($iAccountTitle)"; }?></h1>
        <div class="sf_admin_filters">
            <form action="" id="searchform" method="POST" name="searchform">
                <fieldset>
                    <div class="form-row">
                        <label><?php echo __('Select PCO Line to Filter');?>:</label>
                        <div class="content">
                            <select name="iaccount" id="account">
                                <option value =''></option>
                             <?php foreach($telintaAccountObj as $account){
                                $employeeid=substr($account->getAccountTitle(), $substr);
                                $cn = new Criteria();
                                $cn->add(EmployeePeer::ID, $employeeid);
                                $employees = EmployeePeer::doSelectOne($cn);
                            ?>
                                <option value="<?PHP  echo $account->getId();?>" <?PHP echo ($account->getId()==$iaccount)?'selected="selected"':''?>><?php echo $employees->getFirstName()." -- ". $account->getAccountTitle();?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label><?php echo __('From');?>:</label>
                        <div class="content">
                            
                            <?php echo input_date_tag('startdate', $fromdate, 'rich=true') ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <label><?php echo __('To');?>:</label>
                        <div class="content">
                           
                            <?php echo input_date_tag('enddate', $todate, 'rich=true') ?>
                        </div>
                    </div>
                    
                </fieldset>

                <ul class="sf_admin_actions">
                   <li><input type="button" class="sf_admin_action_filter" value="reset" name="reset" onclick="document.location.href='<?PHP echo sfConfig::get('app_backend_url')."company/usage?company_id=". $company->getId();?>'"></li>
                   <li><input type="submit" class="sf_admin_action_filter" value="filter" name="filter"></li>
                </ul>
            </form>
        </div>
    </div><br />
    <br /><br />
    <h1><?php echo __('Call History'); if(isset($iAccountTitle)&&$iAccountTitle!=''){echo "($iAccountTitle)"; }?></h1>
    <table width="100%" cellspacing="0" cellpadding="2" class="tblAlign" border='0'>


        <tr class="headings">
            <th width="15%"   align="left"><?php echo __('Date & Time') ?></th>

            <th  width="10%"  align="left"><?php echo __('Phone Number') ?></th>
            <th width="10%"   align="left"><?php echo __('Duration') ?></th>
            <th  width="17%"  align="left"><?php echo __('Country') ?></th>
            <th  width="13%"  align="left"><?php echo __('Description') ?></th>
            <th  width="15%"  align="left"><?php echo __('Disconnect Cause') ?></th>
           
            <th width="10%"   align="left"><?php echo __('Cost') ?></th>
            <th  width="10%"   align="left"><?php echo __('Account Id') ?></th>
        </tr>
        <?php
        $callRecords = 0;

        $amount_total = 0;
       
       foreach ($callHistory->xdr_list as $xdr) {
        ?>


            <tr>
                <td><?php echo $xdr->connect_time; ?></td>
                <td><?php echo $xdr->CLD; ?></td>
                <td><?php    
                        $callval=$xdr->charged_quantity;
if($callval>3600){

 $hval=number_format($callval/3600);

  $rval=$callval%3600;

$minute=date('i',$rval);
  $second=date('s',$rval);

  $minute=$minute+$hval*60;

  echo $minute.":".$second;
}else{


echo  date('i:s',$callval);

}                           ?></td>
                <td><?php echo $xdr->country; ?></td>
                  <td><?php echo $xdr->description;  ?></td>
                    <td><?php
                     $dCouse = DisconectCausePeer::retrieveByPk($xdr->disconnect_cause);
                    
                    echo $dCouse->getName();  ?></td>
                   

                <td><?php echo number_format($xdr->charged_amount, 3);
            $amount_total+= number_format($xdr->charged_amount, 3); ?> &euro;</td>
                <td><?php echo $xdr->account_id; ?></td>
        </tr>

        <?php
                $callRecords = 1;
            }
        ?>        <?php if ($callRecords == 0) {
 ?>
                <tr>
                    <td colspan="7"><p><?php echo __('There are currently no call records to show.') ?></p></td>
                </tr>
<?php } else { ?>
                <tr>
                    <td colspan="6" align="right"><strong><?php echo __('Subtotal') ?></strong></td>

                    <td><?php echo number_format($amount_total, 3, ',', '') ?>  &euro;</td>
                    <td>&nbsp;</td>
                </tr>
<?php } ?>

<!--            <tr><td colspan="6" align="left"><?php echo __('Call type detail') ?> <br/> <?php echo __('Int. = International calls') ?><br/>
                <?php //echo __('Cb M = Callback mottaga')  ?><br/>
                <?php //echo __('Cb S = Callback samtal')  ?><br/>
<?php //echo __('R = resenummer samtal')    ?><br/>
            </td></tr>-->
    </table>
<br/><br/>
    <h1><?php echo __("Other events"); ?> </h1>
    <table width="100%" cellspacing="0" cellpadding="2" class="tblAlign" border='0'>
        <tr class="headings">
            <th  width="10%"  align="left"><?php echo __('Date and time') ?></th>
            <th  width="10%"  align="left"><?php echo __('Description') ?></th>
            <th  width="10%"  align="left" style="text-align: right;"><?php echo __('Amount') ?></th>
       </tr>
        <?php
        $othertotal = 0;
        $ComtelintaObj = new CompanyEmployeActivation();
      //  foreach ($ems as $emp) {
         $otherEvents = $ComtelintaObj->callHistory($company, $fromdate, $todate, false, 1);   
        if(count($otherEvents)>0){
        foreach ($otherEvents->xdr_list as $xdr) {
         ?>
            <tr>
                <td><?php echo date("Y-m-d H:i:s", strtotime($xdr->bill_time)); ?><?php //echo $emp->getId();?></td>
                <td><?php echo __($xdr->CLD); ?></td>
                <td align="right"><?php echo number_format($xdr->charged_amount,2); $othertotal +=$xdr->charged_amount;?><?php echo sfConfig::get('app_currency_code')?></td>
            </tr>
            <?php } }else {
             ?>
                    <tr>
                        <td>
             <?php
                echo __('There are currently no records to show.'); ?>
                        </td>
                    </tr>
          <?php                  
            }
      //  }  ?>
            <tr align="right">
                <td colspan="2"><strong><?php echo __('Subtotal');?></strong></td><td><?php echo number_format($othertotal,2)?><?php echo sfConfig::get('app_currency_code')?></td>
            </tr>         
            <tr align="right">
            <td colspan="2"><strong><?php echo __('Total');?></strong></td><td><strong><?php echo number_format($amount_total+$othertotal,2)?><?php echo sfConfig::get('app_currency_code')?></strong></td>
        </tr> 
        </table><br/><br/>
        <h1><?php echo __("Payment History"); ?> </h1>
    <table width="100%" cellspacing="0" cellpadding="2" class="tblAlign" border='0'>
        <tr class="headings">
            <th  width="10%"  align="left"><?php echo __('Date and time') ?></th>
            <th  width="10%"  align="left"><?php echo __('Description') ?></th>
            <th  width="10%"  align="left" style="text-align: right;"><?php echo __('Amount') ?></th>
       </tr>
        <?php
        $paymenttotal = 0;
        $otherEvent = $ComtelintaObj->callHistory($company, $fromdate, $todate , false, 2);
       // var_dump($otherEvents);
        if(count($otherEvent)>0){
        foreach ($otherEvent->xdr_list as $xdr) {
         ?>
            <tr>
                <td><?php echo date("Y-m-d H:i:s", strtotime($xdr->bill_time)); ?></td>
                <td><?php echo __($xdr->CLD); ?></td>
                <td align="right"><?php echo number_format(-1 * $xdr->charged_amount,2); $paymenttotal +=$xdr->charged_amount;?><?php echo sfConfig::get('app_currency_code')?></td>
            </tr>
            <?php } 
            
            }else {
             ?>
                    <tr>
                        <td>
             <?php
                echo __('There are currently no records to show.'); ?>
                        </td>
                    </tr>
          <?php                  
            }
      ?>
        <tr align="right">
                <td colspan="2"><strong><?php echo __('Total');?></strong></td><td><strong><?php echo number_format(-1 * $paymenttotal,2);?><?php echo sfConfig::get('app_currency_code')?></strong></td>
        </tr>
       
        </table><br/><br/>
</div>