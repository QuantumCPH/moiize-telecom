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
	
        <tr><td  colspan="2"><h1>Revenue Report</h1></td></tr>
        <tr><td  colspan="2"><h1>From:  <?php echo substr($startdate,0,10); ?> </h1></td></tr>
        <tr><td  colspan="2"><h1>To:  <?php echo substr($enddate,0,10); ?></h1></td></tr>
        <tr><td  colspan="2" style="padding-left: 200px;"><h1>Total Revenue:  <?php echo number_format($totalrevenue,2);    ?></h1><td></tr>
       
        
       
<tr><td  colspan="2"><hr></hr> </td></tr>
        <tr><td colspan="2"><b>Following is the list of active companies </b></td></tr>


        <tr><td><table width="90%">
                    <tr><th  width="40%" align="left"> Company Name</th><th  width="20%"  align="left"> Vat N0</th><th  width="40%"  align="left">Generate Invoice</th></tr>
        <?php foreach($companies as $company){
            
            $companyid=$company->getId();

            if(isset($companyid) && $companyid!=""){
            ?>




 <tr><td>  <?php   echo $company->getName();  ?></td>
 <td> <?php   echo $company->getVatNo();  ?></td>
 <td>  <a style="text-decoration: none;" href="billing?company_id=<?php   echo $company->getId();  ?>&start_date=<?php echo $startdate; ?>&end_date=<?php echo $enddate;  ?>"> Generate invoice</a></td></tr>
        
<?php   }  } ?>
 
                </table></td></tr>
</table>
                

                             