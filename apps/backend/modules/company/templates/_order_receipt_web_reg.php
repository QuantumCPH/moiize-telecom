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
		<td colspan="4" align="right" style="text-align:right; border:0px solid #fff"><?php echo image_tag(sfConfig::get("app_main_url").'../images/logo.gif');?></td>
	</tr>
</table>
<table class="receipt" cellspacing="0" width="600px">
  

  <tr> 
    <td><?php echo __('Date') ?></td><td><?php echo $company->getCreatedAt('m-d-Y') ?></td>
  </tr>
  <tr>
    <td><?php echo __('Vat No') ?></td><td><?php echo $company->getVatNo() ?></td>
  </tr>
  <tr>
    <td><?php echo __('Password') ?></td><td><?php echo $company->getPassword(); ?></td>
 </tr>

  
  <tr>
    <td> 
    <?php echo __('http://moiize.com/');?> </td>
  </tr>
</table>
        