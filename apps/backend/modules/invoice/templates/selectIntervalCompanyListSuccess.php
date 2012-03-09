<?php


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
<?php  // echo form_tag('invoice/generate') ?>
<?php echo form_tag('invoice/companies') ?>
<h3>View Total Revenue Report with Companies lists that uses services In selected Duration</h3>
<br /><br />
<label>Billing Start date/time</label>
<input type="text" id='start_date' name='start_date'  />
<br /><br />
<label>Billing End date/time</label>
<input type="text" id='end_date' name='end_date' />
<br /><br />
<strong style="color: red; font-size: .7em;">* Please take care of Last Billing Date while specifying the interval</strong><br />
<strong style="color: red; font-size: .7em;">* On generating new invoice, pending invoices for the company will be expired</strong>
<br /><br />

<input type="submit" value="Generate Invoice" />
</form>