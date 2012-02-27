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
            <td align="left" colspan="2">
			Here is Total Revenue For you Selected Date From  <?php echo $startdate; ?> To  <?php echo $enddate; ?>
		</td>
	</tr>
        <tr><td><table width="90%">
                    <tr><th  width="40%" align="left">Total revenue</th><th  width="40%"  align="left"> <?php echo $totalrevenue;    ?></th></tr>
      
 
                </table></td></tr>
</table>
                

                             