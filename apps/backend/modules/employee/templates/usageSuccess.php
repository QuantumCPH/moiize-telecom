<div id="sf_admin_container">
    <div id="sf_admin_content">
        <a href="<?php echo url_for('employee/view') . '?id=' . $employee->getId() ?>" class="external_link" target="_self"><?php echo __('PCO Line Detail') ?></a>
    </div>
    <br />
    <h1><?php echo __('Call History') ?></h1>
    <table width="100%" cellspacing="0" cellpadding="2" class="tblAlign" border='0'>
        <tr class="headings">
            <th width="15%"   align="left"><?php echo __('Date & Time') ?></th>
            <th  width="10%"  align="left"><?php echo __('Phone Number') ?></th>
            <th width="10%"   align="left"><?php echo __('Duration') ?></th>
            <th  width="25%"  align="left"><?php echo __('Country') ?></th>
               <th  width="10%"  align="left"><?php echo __('Description') ?></th>
            <th width="10%"   align="left"><?php echo __('Cost (Incl. VAT)') ?></th>
            <th  width="10%"   align="left"><?php echo __('Samtalstyp') ?></th>
        </tr>
        <?php
        $callRecords = 0;
        $callRecordscb = 0;
        $callRecordsrese = 0;
        $amount_total = 0;
      
        foreach ($callHistory->xdr_list as $xdr) {
        ?>


            <tr>
                <td><?php echo $xdr->connect_time; ?></td>
                <td><?php echo $xdr->CLD; ?></td>
                <td><?php             $callval=$xdr->charged_quantity;
if($callval>3600){

 $hval=number_format($callval/3600);

  $rval=$callval%3600;

$minute=date('i',$rval);
  $second=date('s',$rval);

  $minute=$minute+$hval*60;

  echo $minute.":".$second;
}else{


echo  date('i:s',$callval);

} ?></td>
                <td><?php echo $xdr->country; ?></td>
                   <td><?php echo $xdr->description;  ?></td>
                <td><?php echo number_format($xdr->charged_amount, 3);
            $amount_total+= number_format($xdr->charged_amount, 3); ?> &euro;</td>
                <td><?php echo $xdr->account_id; ?></td>
        </tr>

<?php
            $callRecords = 1;
        }
?> 


       

<?php if ($callRecords == 0) { ?>
            <tr>
                <td colspan="7"><p><?php echo __('There are currently no call records to show.') ?></p></td>
            </tr>
<?php } else { ?>
            <tr>
                <td colspan="5" align="right"><strong><?php echo __('Subtotal') ?></strong></td>
                <td><?php echo number_format($amount_total, 3, ',', '') ?> &euro;</td>
                <td>&nbsp;</td>
            </tr>
<?php } ?>

<!--        <tr>
            <td colspan="6" align="left"><?php echo __('Call type detail') ?> <br/> <?php echo __('Int. = International calls') ?><br/>
<?php // echo __('Cb M = Callback mottaga')  ?><br/>
                <?php //echo __('Cb S = Callback samtal') ?><br/>
                <?php //echo __('R = resenummer samtal') ?><br/>
            </td>
        </tr>-->
    </table></div>