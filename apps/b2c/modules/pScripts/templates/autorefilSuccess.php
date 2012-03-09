<?php use_helper('I18N') ?>
<?php use_helper('Number') ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="LandNCall AB" />
<title>LandNCall AB</title>



<body >
<?php 

$id=$order->getId();

if(isset($id) && $id>0){  ?>
    <form action="https://payment.architrade.com/cgi-ssl/ticket_auth.cgi"  method="post"  name="patment"  id="patment">
 

        
		<?php 
                
                $order_id=$order->getId();
                $total=100*$order->getExtraRefill();
			$relay_script_url = sfConfig::get('app_epay_relay_script_url');
			?>
		
		<input type="hidden" name="merchant" value="90049676" />
		<input type="hidden" name="amount" id="total" value="<?php echo $total; ?>" />
		<input type="hidden" name="currency" value="752" />
		<input type="hidden" name="orderid" value="<?php echo $order_id; ?>" />
		
		<input type="hidden" name="account" value="YTIP" />
		<input type="hidden" name="status" value="" />
                <input type="hidden" name="ticket" value="442999520" />
             
           
         <input type="hidden" name="lang" value="sv" />
		<input type="hidden" name="HTTP_COOKIE" value="<?php getenv("HTTP_COOKIE");?>" />

		<input type="hidden" name="cancelurl" value="http://landncall.zerocall.com/b2c.php/" />
                <input type="hidden" name="callbackurl" value="<?php echo $relay_script_url.url_for('@dibs_autoaccept_url', true);  ?>?accept=yes&subscriptionid=&orderid=<?php echo $order_id; ?>&amount=<?php echo $total; ?>">
		<input type="hidden" name="accepturl" id="accepturl"  value="http://landncall.zerocall.com/b2c.php/">
		    
           
            <input type="submit"  class="settingbuttonstep"  name="submit"  style="cursor: pointer;" value="Pay">

</form>
   <script type="text/javascript">
window.onload = function(){ document.getElementById('patment').submit();   }
</script>  
    <?php  } ?>

    </body>
</html>