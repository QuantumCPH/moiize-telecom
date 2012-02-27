<?php 
	use_helper('Number');
	$sf_user->setCulture('da_DK');
?>
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
		<td>&nbsp;</td>
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
			<table class="call_summary" width="100%" cellspacing="0">
				<tr class="summary_header" style="border: 1px solid #000;">
					<td width="60%">Produkt beskrivelse</td>
					<td align="center">Antal opkald enheder</td>
					<td align="center">Produkt pris</td>
					<td align="center">Total Forbrug (Kr.)</td>
				</tr>
				<tr>
					<td colspan="4" style="height:1px; background: black">
					</td>
				</tr>
					<?php if (count($groups)>0): $group_header_description = true;
							foreach($groups as $group):?>	
								<tr class="group_header">
									<td><?php echo $group[0]['from_no']; if($group_header_description) //echo ' - User phone number'; ?></td>
									<td align="right"><?php echo format_number(util::getSumForAGroupField($group, 'total_dur_secs', false)); if($group_header_description) //echo ' - total call units'; ?></td>
									<td>&nbsp;</td>
									<td align="right"><?php echo format_number(util::getSumForAGroupField($group, 'total_sale_price')); if($group_header_description) //echo ' - total usage called'; $group_header_description = false;?></td>
								</tr>
								<tr>
									<td colspan="4" style="height:1px; background: #c0c0c0;"></td>
								</tr>
								<tr class="group_subheader">
									<td class="first"><?php echo utf8_encode($group[0]['first_name'].' '.$group[0]['last_name']); //echo ' - username' ?></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<!--loop group data-->
								<?php 
								$i=0;
								foreach($group as $key=>$value):?>
								<tr class="group_data">
									<td class="first"><?php echo $group[$i]['description']; ?></td>
									<td align="right"><?php echo $group[$i]['total_dur_secs'] ?></td>
									<td align="right"><?php echo util::format_number($group[$i]['total_sale_price']) ?></td>
									<td>&nbsp;</td>
								</tr>
								<?php
									$i=$i+1;
								endforeach; ?>
								<!-- end group data -->.
							<?php endforeach; ?>
					<tr class="footer">
						<td align="right">Forbrug i alt</td>
						<td></td>
						<td></td>
						<td align="right"><?php $total = util::getCallSummaryUsageTotal($groups); echo util::format_number($total); ?></td>
					</tr>
					<tr class="footer">
						<td align="right">Forbrugsrabat</td>
						<td align="right"><?php echo $company_meta->getUsageDiscountPc()*100 . '%' ?></td>
						<td align="right"><?php echo util::format_number($total) ?></td>
						<td align="right"><?php $total = $total - ($discount = $total * $company_meta->getUsageDiscountPc()); echo '-'.util::format_number($discount); ?></td>
					</tr>
				
				<!--  products  listing -->
				<?php
					$product_orders_total = 0;
					$product_orders_discount_total = 0; 
					
					$i=0;
					foreach($product_orders as $product_order):
                                            $i=$i+1;?>
						<tr class="footer">
							<td align="right"><?php echo $product_order->getProduct()->getName() ?></td>
							<td align="right"><?php echo  $product_order->getQuantity() ?></td>
							<td align="right"><?php echo  $product_order->getProduct()->getPrice() ?></td>
							<td align="right"><?php $product_orders_total = $product_orders_total + ($prdouct_order_price = $product_order->getQuantity()*$product_order->getProduct()->getPrice()); echo util::format_number($prdouct_order_price); ?></td>
							<?php
								$product_orders_discount_total = $product_orders_discount_total + $prdouct_order_price * $product_order->getDiscount();
							?>
						</tr>
				<?php endforeach; ?>
				<?php if (count($product_orders)>1 ): ?>
						<tr class="footer">
							<td align="right">Product Order Total</td>
							<td></td>
							<td></td>
							<td align="right"><?php echo util::format_number($product_orders_total); ?></td>
						</tr>
				<?php endif; ?>
				<?php
				$discounted_product_order_total = 0;
				if (count($product_orders)>0 ): ?>
						<tr class="footer">
							<td align="right">Nedsatte produkter i alt</td>
							<td align="right"><?php echo $product_orders_total>0?($product_orders_discount_total/$product_orders_total)*100:0 . '%' ?></td>
							<td align="right"><?php echo util::format_number($product_orders_total) ?></td>
							<td align="right"><?php 
							$total = $total + $product_orders_total - $product_orders_discount_total; echo '-'.util::format_number($product_orders_discount_total); ?></td>
						</tr>
				<?php endif; ?>
				<!-- end products listing -->
				<!--  invoice fee -->
					<tr class="footer">
						<td align="right">Faktura gebyr (<?php echo $company_meta->getInvoiceMethod()->getName();?>)</td>
						<td></td>
						<td align="right"></td>
						<td align="right"><?php
						$invoice_fee = $company_meta->getInvoiceMethod()->getCost();
						$total = $total + $invoice_fee; echo util::format_number($invoice_fee); ?></td>
					</tr>				
				<!--  end invoice fee  -->
				<tr>
					<td colspan="4" style="height:1px; background: black;"></td>
				</tr>
				<tr class="footer">
					<td colspan="3">Forbrug i alt</td>
					<td align="right"><?php echo util::format_number($total); ?></td>
				</tr>
				<tr>
					<td colspan="4" style="height:1px; background: black;"></td>
				</tr>
				<tr class="footer">
					<td colspan="3">Moms udg&oslash;re</td>
					<td align="right"><?php $vat = $total*.25; echo util::format_number($vat); ?></td>
				</tr>
				<tr>
					<td colspan="4" style="height:2px; background: black;"></td>
				</tr>
				<tr class="footer grandtotal">
					<td colspan="3">Pris inkl. Moms</td>
					<td align="right"><?php echo util::format_number($total = $total+$vat); util::saveTotalPayment($invoice_meta->getId(), $total); ?></td>
				</tr>
				<tr>
					<td colspan="4" style="height:3px; background: black;"></td>
				</tr>
				<?php else: ?>
				<tr>
					<td colspan="4">No summary exists for this billing period.</td>
				</tr>
				<?php endif; ?>
			</table>
		</td>
	</tr>
</table>
<?php $html_content = ob_get_contents(); 
	//echo $html_content;
	util::saveHtmlToInvoice($invoice_meta->getId(), $html_content);
?>
<div class="invoice_options">
	<a href='<?php echo url_for('invoice/discard?id='.$invoice_meta->getId()); ?>' class='a_button'>Discard</a>
	<a href='<?php echo url_for('invoice/getPdf?id='.$invoice_meta->getId()); ?>' class='a_button'>Generate PDF</a>
	<a href='<?php echo url_for('invoice/sendEmail?id='.$invoice_meta->getId()); ?>' class='a_button'>Email</a>	
</div>