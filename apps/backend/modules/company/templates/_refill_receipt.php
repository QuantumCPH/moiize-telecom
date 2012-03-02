<?php
use_helper('I18N');
use_helper('Number');
?>
<style>
    p {
        margin: 8px auto;
    }

    table.receipt {
        width: 600px;
        border: 2px solid #ccc;
    }

    table.receipt td, table.receipt th {
        padding:5px;
    }

    table.receipt th {
        text-align: left;
    }

    table.receipt .payer_details {
        padding: 10px 0;
    }

    table.receipt .receipt_header, table.receipt .order_summary_header {
        font-weight: bold;
        text-transform: uppercase;
    }

    table.receipt .footer
    {
        font-weight: bold;
    }


</style>


<table width="600px">
    <tr style="border:0px solid #fff">
        <td colspan="4" align="right" style="text-align:right; border:0px solid #fff"><?php echo image_tag('http://wls2.zerocall.com/images/logo.gif'); ?></td>
    </tr>
</table>
<table class="receipt" cellspacing="0" width="600px">
    <tr bgcolor="#CCCCCC" class="receipt_header">
        <th colspan="3"><?php echo __('Order Receipt') ?></th>
        <th><?php echo __('Transaction No.') ?> <?php echo $transaction->getId() ?></th>
    </tr>
    <tr> 
        <td colspan="4" class="payer_summary">
            <?php echo __('Vat Number') ?>   <?php echo $company->getVatNo(); ?><br/>
            <?php echo sprintf("%s", $company->getName()) ?><br/>
            <?php echo $company->getAddress() ?><br/>
            <?php echo sprintf('%s, %s', $company->getCity(), $company->getPostCode()) ?><br/>
            <br /><br />
        </td>
    </tr>
    <tr class="order_summary_header" bgcolor="#CCCCCC">
        <td><?php echo __('Date') ?></td>
        <td><?php echo __('Description') ?></td>
        <td><?php echo __('Quantity') ?></td>
        <td><?php echo __('Amount') ?></td>
    </tr>
    <tr>
        <td><?php echo $transaction->getCreatedAt('m-d-Y') ?></td>
        <td>
            <?php
            echo $transaction->getDescription();
            ?>
        </td>
        <td><?php echo "1"; ?></td>
        <td><?php echo format_number($subtotal = $transaction->getAmount()) //($order->getProduct()->getPrice() - $order->getProduct()->getPrice()*.2) * $order->getQuantity()) ?></td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom: 2px solid #c0c0c0;">&nbsp;</td>
    </tr>
    <tr class="footer">
        <td>&nbsp;</td>
        <td><?php echo __('Subtotal') ?></td>
        <td>&nbsp;</td>
        <td><?php echo format_number($subtotal) ?></td>
    </tr>
    <tr class="footer">
        <td>&nbsp;</td>
        <td><?php echo __('VAT') ?> (<?php echo $vat == 0 ? '0%' : '25%' ?>)</td>
        <td>&nbsp;</td>
        <td><?php echo format_number($vat) ?></td>
    </tr>
    <tr class="footer">
        <td>&nbsp;</td>
        <td><?php echo __('Total') ?></td>
        <td>&nbsp;</td>
        <td><?php echo format_number($transaction->getAmount()) ?></td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom: 2px solid #c0c0c0;">&nbsp;</td>
    </tr>
    <tr class="footer">
        <td class="payer_summary" colspan="4" style="font-weight:normal; white-space: nowrap;">
<?php echo __('WLS3&nbsp;&nbsp;&nbsp;Box XXXXX, XX-XXX XX XXXXXXX&nbsp;&nbsp;&nbsp; Org.nr.XXXXXX-XXXX') ?> </td>
    </tr>
</table>
