<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<script type="text/javascript">
    jQuery(function(){
        
            jQuery("#from").datepicker({
            defaultDate: "-1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 3,
            dateFormat: "yy-mm-dd",
            onClose: function( selectedDate ) {
                jQuery("#to").datepicker( "option", "minDate", selectedDate );
            }
        });
        jQuery("#to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            onClose: function( selectedDate ) {
                jQuery("#from").datepicker( "option", "maxDate", selectedDate );
            }
        });
        
    });
    </script>
<?Php if (isset($companyval) && $companyval != '') { ?><div id="sf_admin_container">
        <div id="sf_admin_content">
            <a href="<?php echo url_for('employee/index') . '?company_id=' . $companyval . "&filter=filter" ?>" class="external_link" target="_self"><?php echo __('PCO Lines') ?></a>
            <a href="<?php echo url_for('company/usage') . '?company_id=' . $companyval; ?>" class="external_link" target="_self"><?php echo __('Usage') ?></a>
            <a href="<?php echo url_for('company/paymenthistory') . '?company_id=' . $companyval . '&filter=filter' ?>" class="external_link" target="_self"><?php echo __('Payment History') ?></a>
        </div>
    </div>
<?php } ?>

<div id="sf_admin_container">
    <div class="sf_admin_filters">
        <form method="POST" >

            <fieldset style="padding:5px 0;">
                <table width="85%" cellspacing="0" cellpadding="2" border="0" class="filterOnPaymentHistory">
                    <tr><td>Agent Name: </td><td><select name="company_id"><option value="">Select Agent </option><?php foreach ($companies as $company) { ?>
                                    <option value="<?php echo $company->getId(); ?>" <?php if ($companyid == $company->getId()) { ?> selected="selected" <?php } ?>" ><?php echo $company->getName(); ?> </option>
                                <?php } ?> </select> </td></tr>
                    <tr><td>Transaction Type</td><td><select name="transactionType_id"><option value="">Select Transaction Type </option><?php foreach ($transactionstypes as $transactionstype) { ?>
                                    <option value="<?php echo $transactionstype->getId(); ?>" <?php if ($transactionType_id == $transactionstype->getId()) { ?> selected="selected" <?php } ?>  ><?php echo $transactionstype->getTitle(); ?> </option>
                                <?php } ?></select> </td></tr>
                    <tr><td>From Date:</td><td> <input type="text" id="from" name="from" value="<?php echo $from; ?>"/>  </td></tr>
                    <tr><td>To Date:</td><td> <input type="text" id="to" name="to" value="<?php echo $to; ?>" /> </td></tr>
                    <tr><td></td><td class="bg-img" style="height: 0; width:700px;"><br /><div class="submitButton">
                                <button type="submit" style="margin-left: 0 !important">Filter</button>
                            </div>  </td></tr>
                </table>
            </fieldset>

        </form></div>  
    <ul class="sf_admin_actions">
        <li>
            <a href="<?php echo sfConfig::get('app_backend_url'); ?>company/refill" class="refill_button">Refill</a>
        </li>
    </ul>
</div>
<div id="sf_admin_container"><h1><?php echo __('Payment History') ?></h1>
    <?php if ($sf_user->hasFlash('message')): ?>
        <div class="save-ok">
            <h2><?php echo __($sf_user->getFlash('message')) ?></h2>
        </div>
    <?php endif; ?>
</div>
<table width="75%" cellspacing="0" cellpadding="2" class="tblAlign">
    <tr class="headings">
        <th><?php echo __('Date & Time') ?></th>
        <th><?php echo __('Agent Name') ?></th>
        <th><?php echo __('Description') ?></th>

        <th><?php echo __('Amount') ?> (&euro;)</th>
        <th><?php echo __('Balance Before') ?> (&euro;)</th>
        <th><?php echo __('Balance After') ?> (&euro;)</th>
        <th><?php echo __('Reciept') ?></th>

    </tr>
    <?php
    $amount_total = 0;
    $incrment = 1;
    foreach ($transactions as $transaction):

        if ($incrment % 2 == 0) {
            $class = 'class="even"';
        } else {
            $class = 'class="odd"';
        }

        $incrment++;
        ?>
        <tr <?php echo $class; ?>>

            <td><?php echo $transaction->getCreatedAt(); ?><?php //echo $transaction->getCreatedAt(); ?></td>

            <td><?php echo ($transaction->getCompany() ? $transaction->getCompany() : 'N/A') ?></td>
            <td><?php echo __($transaction->getDescription()) ?></td>
            <td align="right"><?php echo format_number($transaction->getAmount());
    $amount_total += $transaction->getAmount(); ?></td>
            <td><?php echo $transaction->getOldBalance(); ?></td>
            <td><?php echo $transaction->getNewBalance() ?></td>

            <td><a href="<?php echo sfConfig::get('app_backend_url') . "company/ShowReceipt?tid=" . $transaction->getId() ?>" target="_blank"> <img src="/sf/sf_admin/images/default_icon.png" title=<?php echo __("view") ?> alt=<?php echo __("view") ?>></a></td>
        </tr>
    <?php endforeach; ?>
    <?php if (count($transactions) == 0): ?>
        <tr>
            <td colspan="5"><p><?php echo __('There are currently no transactions to show.') ?></p></td>
        </tr>
    <?php else: ?>
        <tr>
            <td colspan="3" align="right"><strong><?php echo __('Total:') ?>&nbsp;&nbsp;</strong></td>
            <td align="right"><?php echo format_number($amount_total); ?> &euro;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>	
    <?php endif; ?>
</table>
