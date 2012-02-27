<?php 
	use_helper('Number');
	$sf_user->setCulture('da_DK');
?>

<html><head>
        <title><?php echo date('dmy'). $invoice_meta->getId() ?>- <?php echo $company_meta->getName() ?></title>

    </head><body>


<style type="text/css">
  .invoice {
  	border: 1px solid #f0f0f0;
  }
</style>
<?php ob_start(); ?>
<style type="text/css">

	
  .invoice *
  {
  font-family: calibri, verdana, "Courier New", Courier, mono;
font-size:16px;
  }
  
  .invoice .call_summary
  {
margin-top: 10px;
  }
  
  .summary_header
  {
    /*background: #c0c0c0;*/
    font-weight: bold;
  }
  
  .group_header
  {
  /*background: #f0f0f0;*/
  font-weight: bold;
}

.summary_header, .group_header, .group_subheader
{
 height: 30px;
 border-bottom:1px solid #000;
}

.group_subheader td.first
{
	text-indent: 10px;
	font-weight: bold;
}



.group_data td.first
{
	text-indent: 20px;
}

.footer
{
	height:25px;
	font-style:italic;
}

.footer.grandtotal
{
	background: #f0f0f0;

}
</style>
<table class='invoice' width="100%">
	<tr>
		<td align="right" colspan="2">
			<?php echo image_tag('/images/zapna_logo_small.jpg', 'absolute=true') ?>
		</td>
	</tr>
	<tr>
		<td valign="top" width="50%">
		<?php echo $company_meta->getName() ?><br />
		<?php echo $company_meta->getAddress() ?><br />
		<?php echo $company_meta->getPostCode()?>, 
		<?php echo $company_meta->getCity()?><br />
	    Att: <?php echo $company_meta->getContactName() ?>
	    </td>
		<td>LandNCall AB<br />
		 Telefonv&atilde;gen 30
	<br />
	126 37 H&atilde;gersten
	<br />
	
	<br />
	Tel:      +46 85 17 81 100
	<br />	
	<br />
	Cvr:     32068219
	<br /></td>
	</tr>
	<tr>
		<td>&nbsp; </td>
		<td>
			<table class="invoice_meta">
				<tr>
					<td colspan="2">Faktura</td>
				</tr>
				<tr>
					<td>Faktura Nummer:</td>
					<td><?php echo date('dmy'). $invoice_meta->getId() ?></td>
				</tr>
				<tr>
					<td>Faktura Periode:</td>
					<td><?php echo $invoice_meta->getBillingStartingDate('d M.') .' - '. $invoice_meta->getBillingEndingDate('d M.') ?></td>
				</tr>
				<tr>
					<td>Faktura Dato:</td>
					<td><?php echo $invoice_meta->getCreatedAt('d M. Y') ?></td>
				</tr>
				<tr>
					<td>Betalingsdato:</td>
					<td><?php echo $invoice_meta->getDueDate('d M. Y') ?></td>
				</tr>
				<tr>
					<td>Kundenummer:</td>
					<td><?php echo $company_meta->getVatNo() ?></td>
				</tr>
			</table> <!-- end invoice meta -->
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="call_summary" width="1000" cellspacing="0">
				<tr class="summary_header" style="border: 1px solid #000;">
					<td width="50%">Produkt beskrivelse</td>
					<td width="16%"align="left">Antal opkald enheder</td>
<!--                                        Produkt pris-->
                                        <td align="16%">&nbsp; </td>
					<td align="18%">Total Forbrug (Kr.)</td>
				</tr>
                                    <?php
                                    $totalcost=0.00;
                                    $fromNumber="";
                                    //$call_rate_table = CallRateTablePeer::doSelect(new Criteria());
                                    ?>

                                    <?php if(count($details)>0) { ?>
                                       <?php foreach($details as $detail){ ?>

                                
                                    <?php if ($fromNumber != $detail->getFromNumber()){  ?>
                                        <tr>
                                            <td><br/>
                                                <b><u><?php echo 'From Nummer: '. $detail->getFromNumber() ?> </u> </b>
                                                <br/><br/>
                                                <?php $fromNumber = $detail->getFromNumber()?>
                                            </td>
                                        </tr>
                                            <?php } ?>

                                        <tr>

                                            <td>
                                                 <?php 
                                                 echo $detail->getCallRateTableDescription()?>
                                            </td>
                                            <td><?php
                                                    $dc = new Criteria();
                                                    $dc->add(BillingCdrDetailsPeer::EMPLOYEE_ID, $detail->getEmployeeId());
                                                    $dc->addAnd(BillingCdrDetailsPeer::CALL_RATE_TABLE_DESCRIPTION, $detail->getCallRateTableDescription());
                                                    $dc->addAnd(BillingCdrDetailsPeer::CALL_TIME, " call_time > '".$invoice_meta->getBillingStartingDate('Y-m-d h:i:s')."' ", Criteria::CUSTOM);
                                                    $dc->addAnd(BillingCdrDetailsPeer::CALL_TIME, " call_time  < '".$invoice_meta->getBillingEndingDate('Y-m-d h:i:s')."' ", Criteria::CUSTOM);
                                                    $temp = BillingCdrDetailsPeer::doSelect($dc);

                                                    $minutes_count=0;
                                                    //echo 'count'.count($temp);
                                                    foreach($temp as $t){
                                                        $minutes_count= $minutes_count + $t->getDurationMinutes();
                                                        //echo 'total minutes'.$minutes_count;
                                                        //echo 'temp->'.$temp->getDurationMinutes();
                                                    }
                                                    
                                                ?>
                                                <?php echo $minutes_count ?>
                                            </td>

                                            <td>&nbsp; 
                                                <?php  $cost = number_format((CallRateTablePeer::retrieveByPK($detail->getCallRateTableId())->getRate()/1.00),2) ?>
                                            </td>
                                            <td>
                                                <?php echo number_format($temp_cost= $minutes_count * $cost,2) ?>
                                            </td>
                                        </tr>

                                        <?php

                                        $totalcost=$totalcost+$temp_cost;

                                        }

                                    }else{ ?>

                                <h3>No Call Data</h3>
                                <?php    }  ?>

<tr><td colspan="4"><hr/></td></tr>
<tr><td colspan="2">Forbrug i alt</td> <td></td><td><?php echo number_format($totalcost,2)  ?></td></tr>

<tr><td  colspan="2">Faktura gebyr</td><td></td><td><?php echo number_format($invoice_cost,2)  ?></td></tr>
<tr><td colspan="4"><hr/></td></tr>
<tr><td colspan="2">Forbrug i alt</td> <td></td><td><?php echo number_format($net_cost=$totalcost+$invoice_cost,2);  ?></td></tr>

<tr><td colspan="2">Moms</td> <td></td><td><?php echo number_format($moms=$net_cost*25/100,2);  ?></td></tr>
<tr><td colspan="4"><hr/></td></tr>
<tr><td colspan="2">Pris inkl. Moms</td> <td></td><td><?php echo number_format($net_cost=$net_cost+$moms,2);  ?></td></tr>
<tr><td colspan="4"><hr/></td></tr>
                </table>
                </td></tr>
</table>
                

</body>
</html>