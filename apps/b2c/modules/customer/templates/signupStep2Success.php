<?php

//$customer_id = $sf_request->getParameter('cid');
//$customer = CustomerPeer::retrieveByPK($customer_id);
if($callbackdibs=='yes'){
    print_r($_REQUEST);
    echo 'ss';
}else{
    use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form);

$product_price_vat = ($order->getProduct()->getPrice()-$order->getProduct()->getInitialBalance())*.20;
//$product_price = ($order->getProduct()->getPrice()) - ($order->getProduct()->getPrice()*.20); echo $product_price;
$product_price = ($order->getProduct()->getPrice()-$order->getProduct()->getInitialBalance()) - $product_price_vat;

//echo $product_price;
$extra_refill = $order->getExtraRefill();
$vat = .25 * ($product_price);
$total = $product_price + $extra_refill + $vat;
$customer_form = new CustomerForm();
$customer_form->unsetAllExcept(array('auto_refill_amount', 'auto_refill_min_balance'));
define("DIBS_MD5KEY2","r!oRvYT8}L5%,7XFj~Rlr$+Y[W3t3vho");
define("DIBS_MD5KEY1","cBI&R8y*KsGD.o}1z^WF]HqK5,*R[Y^w");
//define("PATH_WEB","http://landncall.zerocall.com/");
$md5key   =  md5(DIBS_MD5KEY2.md5(DIBS_MD5KEY1.'merchant=90049676&orderid='.$order_id.'&currency=752&amount='.$total));

//print_r($_REQUEST);
?>

<form action="https://payment.architrade.com/paymentweb/start.action" method="post" id="frmarchitrade" >
  <input type="hidden" name="merchant" value="90049676" />
  <input type="hidden" name="amount" value="<?php echo $total;?>" />
  <input type="hidden" name="currency" value="752" />
  <input type="hidden" name="orderid" value="<?php echo $order_id;?>" />
  <input type="hidden" name="textreply" value="true" />
  <input type="hidden" name="calcfee" value="yes" />
   <input type="hidden" name="account" value="YTIP" />
  <input type="hidden" name="md5key" value="<?php echo $md5key;?>">
  <input type="hidden" name="cancelurl" value="http://landncall.zerocall.com/b2c.php/customer/signupStep2">
  <input type="hidden" name="callbackurl" value="http://landncall.zerocall.com/b2c.php/customer/signupStep2">
  <input type="hidden" name="accepturl" value="http://landncall.zerocall.com/b2c.php/customer/signupStep2">
  <input type="submit" value="Click to call ticket_auth.cgi" style="display:none;" />

</form>

<!--<form action="https://payment.architrade.com/cgi-ssl/ticket_auth.cgi" method="post" id="frmarchitrade">
  <input type="hidden" name="merchant" value="90049676" />
  <input type="hidden" name="ticket" value="270000543" />
  <input type="hidden" name="amount" value="500" />
  <input type="hidden" name="currency" value="752" />
  <input type="hidden" name="orderid" value="45676512" />
  <input type="hidden" name="textreply" value="true" />
  <input type="hidden" name="test" value="yes" />
  <input type="hidden" name="calcfee" value="yes" />
  <input type="hidden" name="md5key" value="<?php echo $md5key;?>">

  <input type="hidden" name="cancelurl" value="http://landncall.zerocall.com/b2c.php/customer/signupStep2">
  <input type="hidden" name="callbackurl" value="http://landncall.zerocall.com/b2c.php/customer/signupStep2">
  <input type="hidden" name="accepturl" value="http://landncall.zerocall.com/b2c.php/customer/signupStep2">

  <input type="hidden" name="uniqueoid" value="YES">



  <input type="submit" value="Click to call ticket_auth.cgi" style="display:none" />
</form>-->

<script type="text/javascript">

        $(function () {
            $("#frmarchitrade").submit();
        });

	//$('#cardno_error, #cvc_error, #quantity_error').hide();
</script>

<script type="text/javascript">
	//$('#cardno_error, #cvc_error, #quantity_error').hide();
</script>
<?php } ?>
