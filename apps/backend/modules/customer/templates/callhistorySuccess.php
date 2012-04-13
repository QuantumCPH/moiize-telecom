<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<div id="sf_admin_container">
    <div class="alert_bar">
        <?php echo __('Call history is updated after every 1 minutes.') ?>
    </div>

    <?php if ($customer->getC9CustomerNumber()): ?>
            <div style="clear: both;"></div>
            <span style="margin: 20px;">
                <center>

                    <form action="/index.php/customer/c9Callhistory" method="post">
                        <INPUT TYPE="submit" VALUE="<?php echo __('Se LandNCall AB Global opkaldsoversigt') ?>">
                    </form>
                </center>
            </span>
    <?php endif; ?>


    <?php $unid = $customer->getUniqueid(); ?>


            <div id="sf_admin_content">
                <ul class="customerMenu" style="margin:10px 0;">
                    <li><a class="external_link" href="allRegisteredCustomer"><?php echo __('View All Customer') ?></a></li>
                    <li><a class="external_link" href="paymenthistory?id=<?php echo $_REQUEST['id']; ?>"><?php echo __('Payment History') ?></a></li>
                    <li><a class="external_link"  href="customerDetail?id=<?php echo $_REQUEST['id']; ?>"><?php echo __('Customer Detail') ?></a></li>
                </ul></div>
            <h1><?php echo __('Call History') ?></h1>
            <table width="100%" cellspacing="0" cellpadding="2" class="tblAlign" border='0'>


                <tr class="headings">
                    <th width="20%"   align="left"><?php echo __('Date & Time') ?></th>
                    <th  width="20%"  align="left"><?php echo __('Phone Number') ?></th>
                    <th width="10%"   align="left"><?php echo __('Duration') ?></th>
                    <th  width="10%"  align="left"><?php echo __('VAT') ?></th>
                    <th width="20%"   align="left"><?php echo __('Cost (Incl. VAT)') ?></th>
                    <th  width="20%"   align="left"><?php echo __('Samtalstyp') ?></th>
                </tr>
        <?php
            $amount_total = 0;




            $tomorrow1 = mktime(0, 0, 0, date("m"), date("d") - 15, date("Y"));
            $fromdate = date("Y-m-d", $tomorrow1);
            $tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
            $todate = date("Y-m-d", $tomorrow);

            $getFirstnumberofMobile = substr($customer->getMobileNumber(), 0, 1);
            if ($getFirstnumberofMobile == 0) {
                $TelintaMobile = substr($customer->getMobileNumber(), 1);
                $TelintaMobile = '49' . $TelintaMobile;
            } else {
                $TelintaMobile = '49' . $customer->getMobileNumber();
            }

            $uniqueId = $customer->getUniqueid();

            $tilentaCallHistryResult = Telienta::callHistory($customer, $fromdate, $todate);

            //$urlval = "https://mybilling.telinta.com/htdocs/zapna/zapna.pl?type=customer&action=get_xdrs&name=".$numbername."&tz=Europe/Stockholm&from_date=".$fromdate."&to_date=".$todate;
//No records for the entered period of

            foreach ($tilentaCallHistryResult->xdr_list as $xdr) {
        ?>



<?php
                $counters++;
?>


                <tr>
                    <td><?php echo $xdr->connect_time; ?></td>
                    <td><?php echo $xdr->CLD; ?></td>
                    <td><?php echo number_format($xdr->charged_quantity / 60, 2); ?></td>
                    <td><?php echo number_format($xdr->charged_amount / 4, 2); ?></td>
                    <td><?php echo number_format($xdr->charged_amount, 2);
                $amount_total+= number_format($xdr->charged_amount, 2); ?> &euro;</td>
                    <td><?php
                $typecall = substr($xdr->account_id, 0, 1);
                if ($typecall == 'a') {
                    echo "Int.";
                }
                if ($typecall == '4') {
                    echo "R";
                }
                if ($typecall == 'c') {
                    if ($CLI == '**24') {
                        echo "Cb M";
                    } else {
                        echo "Cb S";
                    }
                } ?> </td>
                </tr>

<?php
            }
?>


<?php if (count($callRecords) == 0): ?>
                <tr>
                    <td colspan="6"><p><?php echo __('There are currently no call records to show.') ?></p></td>
            </tr>
<?php else: ?>
                <tr>
                    <td colspan="4" align="right"><strong><?php echo __('Subtotal') ?></strong></td>
                        <!--
                        <td><?php //echo format_number($amount_total-$amount_total*.20) ?> SEK</td>
                    	 -->
                <td><?php echo number_format($amount_total, 2, ',', '') ?>&euro;</td>
                <td>&nbsp;</td>
            </tr>
<?php endif; ?>
            <tr><td colspan="6" align="left"><?php echo __('Call type detail') ?> <br/> <?php echo __('Int. = International calls') ?><br/>
<?php //echo  __('Cb M = Callback mottaga')  ?><br/>
<?php // echo  __('Cb S = Callback samtal')  ?><br/>
<?php //echo  __('R = resenummer samtal')  ?><br/>
            </td></tr>
    </table>


    <!-- end split-form -->


</div>