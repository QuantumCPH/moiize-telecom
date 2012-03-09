<?php use_helper('I18N') ?><div id="sf_admin_container">
    <div id="sf_admin_content">
        <!-- employee/list?filters[company_id]=1 -->
        <a href="<?php echo url_for('employee/index') . '?company_id=' . $company->getId() . "&filter=filter" ?>" class="external_link" target="_self"><?php echo __('PCO Lines') ?> (<?php echo count($company->getEmployees()) ?>)</a>
        <a href="<?php echo url_for('company/usage') . '?company_id=' . $company->getId(); ?>" class="external_link" target="_self"><?php echo __('Usage') ?></a>
        <a href="<?php echo url_for('company/paymenthistory') . '?company_id=' . $company->getId() . '&filter=filter' ?>" class="external_link" target="_self"><?php echo __('Payment History') ?></a>
    </div>
    <h1><?php echo __('Call History'); ?></h1>
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

        foreach ($callHistory->xdr_list as $xdr) {
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
            }
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