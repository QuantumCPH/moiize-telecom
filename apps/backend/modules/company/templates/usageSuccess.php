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
    </div>
    
    <table width="100%" cellspacing="0" cellpadding="2" class="tblAlign" border='0'>


        <tr class="headings">
            <th width="15%"   align="left"><?php echo __('Date & Time') ?></th>

            <th  width="15%"  align="left"><?php echo __('Phone Number') ?></th>
            <th width="10%"   align="left"><?php echo __('Duration') ?></th>
            <th  width="30%"  align="left"><?php echo __('Country') ?></th>
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
                <td><?php  echo  date('i:s',$xdr->charged_quantity); 
     ?></td>
                <td><?php echo $xdr->country; ?></td>
                <td><?php echo number_format($xdr->charged_amount, 2);
            $amount_total+= number_format($xdr->charged_amount, 2); ?> &euro;</td>
                <td><?php echo $xdr->account_id; ?></td>
        </tr>

        <?php
                $callRecords = 1;
            }
        ?>        <?php if ($callRecords == 0) {
 ?>
                <tr>
                    <td colspan="6"><p><?php echo __('There are currently no call records to show.') ?></p></td>
                </tr>
<?php } else { ?>
                <tr>
                    <td colspan="4" align="right"><strong><?php echo __('Subtotal') ?></strong></td>

                    <td><?php echo number_format($amount_total, 2, ',', '') ?>  &euro;</td>
                    <td>&nbsp;</td>
                </tr>
<?php } ?>

<!--            <tr><td colspan="6" align="left"><?php echo __('Call type detail') ?> <br/> <?php echo __('Int. = International calls') ?><br/>
                <?php //echo __('Cb M = Callback mottaga')  ?><br/>
                <?php //echo __('Cb S = Callback samtal')  ?><br/>
<?php //echo __('R = resenummer samtal')    ?><br/>
            </td></tr>-->
    </table></div>