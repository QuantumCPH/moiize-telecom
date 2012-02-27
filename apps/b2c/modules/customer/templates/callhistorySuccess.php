<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php include_partial('dashboard_header', array('customer' => $customer, 'section' => __('Call History'))) ?>

<div class="left-col">
    <?php include_partial('navigation', array('selected' => 'callhistory', 'customer_id' => $customer->getId())) ?>
    <div class="split-form-btn" style="margin-top: 70px;">
        <!--
                  <input type="button" class="butonsigninsmall"  name="button" onclick="window.location.href='<?php echo url_for('customer/paymenthistory', true); ?>'" style="cursor: pointer"  value="<?php echo __('Övrig historik') ?>" >
        -->
    </div> <br />
    <div class="alert_bar" style="width: 470px;">
        <?php echo __('Call history is updated after every 5-10 minutes.') ?>
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
            <div class="split-form">
                <div class="fl col">
                    <form action="<?php echo url_for('customer/callhistory') ?>" method="post">
                        <ul>
                    <?php ?>
                    <li>

                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="callhistory">
                            <tr>
                                <td class="title"><?php echo __('Date & time') ?></td>
                                <td class="title" ><?php echo __('Phone Number') ?></td>
                                <td class="title"><?php echo __('Duration') ?></td>
                                <td class="title"><?php echo __('VAT') ?></td>
                                <td class="title"><?php echo __('Cost <small>(Incl. VAT)</small>') ?></td>
                                <td class="title"><?php echo __('Call Type') ?></td>
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
                                $TelintaMobile = '46' . $TelintaMobile;
                            } else {
                                $TelintaMobile = '46' . $customer->getMobileNumber();
                            }


                            $numbername = $customer->getUniqueid();


                            $tilentaCallHistryResult = Telienta::callHistory($customer, $fromdate, $todate);


                            foreach ($tilentaCallHistryResult->xdr_list as $xdr) {
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
                                        <td><?php echo format_number($amount_total - $amount_total * .20) ?> SEK</td>
                        	 -->
                                        <td><?php echo number_format($amount_total, 2, ',', '') ?> &euro;</td>
                                    <td>&nbsp;</td>
                                </tr>
<?php endif; ?>
                                <tr><td colspan="6" align="left"><?php echo __('Type of call detail'); ?> <br/> Int. = <?php echo __('International calls'); ?><br/>
                                            <!--Cb M = Callback mottaga<br/>
        	Cb S = Callback samtal<br/>
        	R = resenummer samtal<br/>-->
                                        </td></tr>
                                </table>


                            </li>
                        </ul>
                    </form>
                </div>
            </div> <!-- end split-form -->
        </div> <!-- end left-col -->
<?php include_partial('sidebar') ?>