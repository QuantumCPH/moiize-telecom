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

<?php
$wrap_content  = isset($wrap)?$wrap:false;

//wrap_content also tells  wheather its a refill or 
//a product order. we wrap the receipt with extra
// text only if its a product order.

 ?>
 
<?php if($wrap_content): ?>
	<p><?php echo __('Hi') ?>&nbsp;<?php echo $customer->getFirstName();?></p>
	
	<p>
	<?php echo __('Thank you for your order of <b>%1%</b>.', array('%1%'=>$order->getProduct()->getName())) ?>
	</p>
	
	<p>
	<?php echo __('Your goods will be shipped today. You should have delivery within two days. Your customer number is '); echo $customer->getUniqueid();?>. <?php echo __(' There, you can use in your dealings with customer service'); ?></p>
	
	<p>
	<?php echo __('Do not hesitate to contact us if you have any questions.') ?>
	</p>
        <p>
            <a href="mailto:Support@wls.com">Support@wls.com</a>
	</p>
        <p>
	<?php echo __('Yours sincerely,') ?>
	</p>
        <p>
	<?php echo __('XXXXXXX') ?>
	</p>
	<br />
<?php endif; ?>
<table width="600px">
	<tr style="border:0px solid #fff">
		<td colspan="4" align="right" style="text-align:right; border:0px solid #fff"><?php echo image_tag('http://wls2.zerocall.com/images/logo.gif');?></td>
	</tr>
</table>
<table class="receipt" cellspacing="0" width="600px">
  <tr bgcolor="#CCCCCC" class="receipt_header"> 
    <th colspan="3"><?php echo __('Order Receipt')." (".$order->getProduct()->getName()." )" ?></th>
    <th><?php echo __('Order No.') ?> <?php echo $order->getId() ?></th>
  </tr>
    <tr> 
    <td colspan="4" class="payer_summary">
      <?php echo __('Customer Number') ?>   <?php echo $customer->getUniqueId(); ?><br/>
      <?php echo sprintf("%s %s", $customer->getFirstName(), $customer->getLastName())?><br/>
      <?php echo $customer->getAddress() ?><br/>
      <?php echo sprintf('%s, %s', $customer->getCity(), $customer->getPoBoxNumber()) ?><br/>
      <?php 
	  $eC = new Criteria();
	  $eC->add(EnableCountryPeer::ID, $customer->getCountryId());
	  $eC = EnableCountryPeer::doSelectOne($eC);
	  echo $eC->getName();
	  ?>    <br /><br />
      <?php echo __('Mobile Number') ?>: <br />
      <?php echo $customer->getMobileNumber() ?><br />

      <?php if($agent_name!=''){ echo __('Agent Name') ?>:  <?php echo $agent_name; } ?>
    </td>
  </tr>
  <tr class="order_summary_header" bgcolor="#CCCCCC"> 
    <td><?php echo __('Date') ?></td>
    <td><?php echo __('Description') ?></td>
    <td><?php echo __('Quantity') ?></td>
    <td><?php echo __('Amount') ?></td>
  </tr>
  <tr> 
    <td><?php echo $order->getCreatedAt('m-d-Y') ?></td>
    <td>
    <?php 
         echo __("Registration Fee");
    
    ?>
	</td>
    <td><?php echo $order->getQuantity() ?></td>
    <td><?php echo format_number($order->getProduct()->getRegistrationFee()); ?></td>
  </tr>
  <tr>
    <td></td>
    <td>
    <?php
         echo __("Product Price");

    ?>
	</td>
    <td><?php echo $order->getQuantity() ?></td>
    <td><?php echo format_number($order->getProduct()->getPrice()); ?></td>
  </tr>
  <tr>
  	<td colspan="4" style="border-bottom: 2px solid #c0c0c0;">&nbsp;</td>
  </tr>
  <tr class="footer"> 
    <td>&nbsp;</td>
    <td><?php echo __('Subtotal') ?></td>
    <td>&nbsp;</td>
    <td><?php echo format_number($subTotal = $order->getProduct()->getPrice()+$order->getProduct()->getRegistrationFee()) ?></td>
  </tr>
  
  <tr class="footer">
    <td>&nbsp;</td>
    <td><?php echo __('Delivery and Returns') ?>  </td>
    <td>&nbsp;</td>
    <td><?php echo format_number($postalcharge) ?></td>
  </tr>
  <tr class="footer">
    <td>&nbsp;</td>
    <td><?php echo __('VAT') ?> (<?php echo $vat==0?'0%':'25%' ?>)</td>
    <td>&nbsp;</td>
    <td><?php echo format_number($vat) ?></td>
  </tr>
     
  <tr class="footer">
    <td>&nbsp;</td>
    <td><?php echo __('Total') ?></td>
    <td>&nbsp;</td>
    <td><?php echo format_number($subTotal+$vat+$postalcharge) ?></td>
  </tr>
  <tr>
  	<td colspan="4" style="border-bottom: 2px solid #c0c0c0;">&nbsp;</td>
  </tr>
  <tr class="footer">
    <td class="payer_summary" colspan="4" style="font-weight:normal; white-space: nowrap;"> 
    <?php echo __('WLS2&nbsp;&nbsp;&nbsp;Box XXXXX, XX-XXX XX XXXXXXX&nbsp;&nbsp;&nbsp; Org.nr.XXXXXX-XXXX')?> </td>
  </tr>
</table>
        