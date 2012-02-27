<?php

	$date_units = array();
	
	if ($last_billing_date!='n/a')
	{
		$date_units = explode('/', $last_billing_date);
	}

	$suggested_billing_start_date = 
		count($date_units)>0?
		$date_units[0].'/'.($date_units[1]+1).'/'.$date_units[2]
		:$company_registration_date;
?>

<script type="text/javascript">
jQuery(document).ready ( function() {
    jQuery('#start_date').datepicker({
    	duration: '',
        showTime: false,
        constrainInput: false,
        time24h: false
     });
    jQuery('#end_date').datepicker({
    	duration: '',
        showTime: false,
        constrainInput: false,
        time24h: false
     });
     
 	var d = new Date();
	
	with(d)
	{
		setMonth(getMonth());
		setDate(15);
	}

	
	//jQuery('#start_date').val('<?php echo $suggested_billing_start_date; ?>');
	
	
	d = new Date();
	d.setMonth(d.getMonth()+1);
	d.setDate(14);
	
	jQuery('#end_date').val(d.getMonth()+'/'+d.getDate()+'/'+d.getFullYear());
	
});
</script>
<style type="text/css">
	body {
		font-family: arial;
	}
	
	form {
		padding:10px;
		margin:5px;
	}
</style>
<?php if ($sf_user->hasFlash('notice')): ?>
	<div class='notice'>
	  <?php echo $sf_user->getFlash('notice') ?>
	</div>
<?php endif; ?>
<?php echo form_tag('invoice/generate') ?>
<h2>Invoice for <?php echo $company_name ?></h2>
<label>Last Paid Billing End Date:</label> <strong style="color: red; font-size: .7em;"><?php echo $last_billing_date!='n/a'?$last_billing_date:'First invoice (Registration date: '.$company_registration_date.')'; ?></strong>
<br /><br />
<label>Billing Start date/time</label>
<input type="text" id='start_date' name='start_date' value='<?php echo $suggested_billing_start_date; ?>' />
<br /><br />
<label>Billing End date/time</label>
<input type="text" id='end_date' name='end_date' />
<br /><br />
<strong style="color: red; font-size: .7em;">* Please take care of Last Billing Date while specifying the interval</strong><br />
<strong style="color: red; font-size: .7em;">* On generating new invoice, pending invoices for the company will be expired</strong>
<br /><br />
<?php echo input_hidden_tag('company_id', $company_id) ?>
<input type="submit" value="Generate Invoice" />
</form>