<?php use_helper('I18N') ?>
<style>
    .bordermy td{border: none !important}
    button#trigger_enddate{background-image:url(../../images/date.png) !important; margin:0px; padding:0px}
button#trigger_startdate{background-image:url(../../images/date.png) !important; margin:0px; padding:0px;}
</style>
<div id="sf_admin_container">
    <div id="sf_admin_content">
        <!-- employee/list?filters[company_id]=1 -->
        <a href="<?php echo url_for('employee/index') . '?company_id=' . $company->getId() . "&filter=filter" ?>" class="external_link" target="_self"><?php echo __('PCO Lines') ?> (<?php echo count($company->getEmployees()) ?>)</a>
        <a href="<?php echo url_for('company/usage') . '?company_id=' . $company->getId(); ?>" class="external_link" target="_self"><?php echo __('Usage') ?></a>
        <a href="<?php echo url_for('company/paymenthistory') . '?company_id=' . $company->getId() . '&filter=filter' ?>" class="external_link" target="_self"><?php echo __('Payment History') ?></a>
    </div>


    <?PHP
    $str=strlen($company->getId());
    $substr=$str+10;
?>

<!--<a href=?iaccount=<?php //echo $account->getIAccount()."&iaccountTitle=".$account->getAccountTitle(); ?>>-->
<form action="" id="searchform" method="POST" name="searchform" style=" background-color: #fff"  >

    <table width="100%" border="0" style="margin-top:20px" class="bordermy">
        <tr>
            <td>
                <?php echo __('Select PCO Line to Filter');?>
            </td>
            <td>
                <select name="iaccount" id="account">
                <option value =''></option>

             <?php foreach($telintaAccountObj as $account){
                    $employeeid=substr($account->getAccountTitle(), $substr);
                    $cn = new Criteria();
                    $cn->add(EmployeePeer::ID, $employeeid);
                    $employees = EmployeePeer::doSelectOne($cn);

             ?>
                <option value="<?PHP  echo $account->getId();?>"><?php echo $employees->getFirstName()." -- ". $account->getAccountTitle();?></option>
            <?php } ?>
            </select>
            </td>
            <td>From:</td>
            <td>
                <?php $date11= date('Y-m-d', strtotime('-15 days')); ?>
                <?php echo input_date_tag('startdate', $date11, 'rich=true') ?>
            </td>
            <td>To:</td>
            <td>
                <?php $date12= date('Y-m-d'); ?>
                <?php echo input_date_tag('enddate', $date12, 'rich=true') ?>
            </td>
            <td><input type="submit" name="Search" value="Filter"  /></td>
        </tr>

    </table>

</form>

    <h1><?php echo __('Call History'); if(isset($iAccountTitle)&&$iAccountTitle!=''){echo "($iAccountTitle)"; }?></h1>
    <table width="100%" cellspacing="0" cellpadding="2" class="tblAlign" border='0'>


        <tr class="headings">
            <th width="20%"   align="left"><?php echo __('Date & Time') ?></th>

            <th  width="20%"  align="left"><?php echo __('Phone Number') ?></th>
            <th width="10%"   align="left"><?php echo __('Duration') ?></th>
            <th  width="10%"  align="left"><?php echo __('VAT') ?></th>
            <th width="20%"   align="left"><?php echo __('Cost (Incl. VAT)') ?></th>
            <th  width="20%"   align="left"><?php echo __('Account Id') ?></th>
        </tr>
        <?php
        $callRecords = 0;

        $amount_total = 0;

       /* foreach ($callHistory->xdr_list as $xdr) {
        ?>


            <tr>
                <td><?php echo $xdr->connect_time; ?></td>
                <td><?php echo $xdr->CLD; ?></td>
                <td><?php echo number_format($xdr->charged_quantity / 60, 2); ?></td>
                <td><?php echo number_format($xdr->charged_amount / 4, 2); ?></td>
                <td><?php echo number_format($xdr->charged_amount, 2);
            $amount_total+= number_format($xdr->charged_amount, 2); ?> &euro;</td>
                <td><?php echo $xdr->account_id; ?></td>
        </tr>

        <?php
                $callRecords = 1;
            }*/
        ?>        <?php if ($callRecords == 0) {
 ?>
                <tr>
                    <td colspan="6"><p><?php echo __('There are currently no call records to show.') ?></p></td>
                </tr>
<?php } else { ?>
                <tr>
                    <td colspan="4" align="right"><strong><?php echo __('Subtotal') ?></strong></td>

                    <td><?php echo number_format($amount_total, 2, ',', '') ?> EURO</td>
                    <td>&nbsp;</td>
                </tr>
<?php } ?>

<!--            <tr><td colspan="6" align="left"><?php echo __('Call type detail') ?> <br/> <?php echo __('Int. = International calls') ?><br/>
                <?php //echo __('Cb M = Callback mottaga')  ?><br/>
                <?php //echo __('Cb S = Callback samtal')  ?><br/>
<?php //echo __('R = resenummer samtal')    ?><br/>
            </td></tr>-->
    </table></div>