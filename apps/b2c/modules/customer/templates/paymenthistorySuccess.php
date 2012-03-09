<style>
    .split-form-btn {
    clear: both;
    float: left;
    padding-top: 20px;
    width: 515px;
}

</style>
<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php include_partial('dashboard_header', array('customer'=> $customer, 'section'=>__('Övrig historik')) ) ?>
  <div class="left-col">
    <?php include_partial('navigation', array('selected'=>'callhistory', 'customer_id'=>$customer->getId())) ?>
      <div class="split-form-btn" style="">
          
          
          <input type="button" class="butonsigninsmall"  name="button" onclick="window.location.href='<?php echo url_for('customer/callhistory', true); ?>'" style="cursor: pointer"  value="<?php echo __('Samtalshistorik') ?>" >
                     
         
      </div>
	<div class="split-form">
      <div class="fl col">
        <form>
          <ul>
<?php /* 
            <li>
              <label>Phone number:</label>
              <select>
                <option>&nbsp;</option>
              </select>
            </li>
            <li>
              <label>From:</label>
              <select class="quater">
                <option>&nbsp;</option>
              </select>
              <select class="quater">
                <option>&nbsp;</option>
              </select>
              <select class="quater">
                <option>&nbsp;</option>
              </select>
            </li>
            <li>
              <label>To:</label>
              <select class="quater">
                <option>&nbsp;</option>
              </select>
              <select class="quater">
                <option>&nbsp;</option>
              </select>
              <select class="quater">
                <option>&nbsp;</option>
              </select>
            </li>
            <li>
              <button><?php echo __('Show') ?></button>
            </li>
*/ ?>
            <li>
              <!--Always use tables for tabular data-->
			  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="callhistory">
                <tr>
                  <td class="title"><?php echo __('Order Numer') ?></td>
                  <td class="title"><?php echo __('Date & time') ?></td>
                  <td class="title"><?php echo __('Description') ?></td>
                  <td class="title"><?php echo __('Amount') ?></td>
<!--                  <td class="title"><?php echo __('Type') ?></td>-->
                </tr>
                <?php 
                $amount_total = 0;
                foreach($transactions as $transaction): ?>
                <tr>
                  <td><?php  echo $transaction->getOrderId() ?></td>
                  <td><?php echo  $transaction->getCreatedAt() ?></td>
                  <td><?php 
                  if($transaction->getDescription()=="Anmeldung inc. sprechen"){
                      echo "Smartsim inklusive pott";
                      
                  }else{
                    echo  $transaction->getDescription();
                  }
                   ?></td>
                  <td><?php echo $transaction->getAmount(); $amount_total += $transaction->getAmount() ?>
                            <?php if($lang=="pl"){
                                echo ('plz');
                            }else if($lang=="en"){
                                echo ('eur');
                            }else{
                                echo ('SEK');
                            } ?></td>
<!--                  <td><a href="#" class="receipt" onclick="javascript: window.open('<?php echo url_for('payments/showReceipt?tid='.$transaction->getId(), true) ?>')"><?php echo $transaction->getAmount()>=0?__('Paid'):__('Refund') ?></a></td>-->
                </tr>
                <?php endforeach; ?>
                <?php if(count($transactions)==0): ?>
                <tr>
                	<td colspan="5"><p><?php echo __('There are currently no transactions to show.') ?></p></td>
                </tr>
                <?php else: ?>
                <tr>
                	<td colspan="3" align="right"><strong>Total</strong></td>
                	<td><?php echo format_number($amount_total) ?>
                            <?php if($lang=="pl"){
                                echo ('plz');
                            }else if($lang=="en"){
                                echo ('eur');
                            }else{
                                echo ('SEK');
                            } ?></td>
                	<td>&nbsp;</td>
                </tr>	
                <?php endif; ?>
              </table>
            </li>
            <?php if($total_pages>1): ?>
            <li>
            	<ul class="paging">
            	<?php for ($i=1; $i<=$total_pages; $i++): ?>
            		<li <?php echo $i==$page?'class="selected"':'' ?>><a href="<?php echo url_for('customer/paymenthistory?page='.$i) ?>"><?php echo $i ?></a></li>
            	<?php endfor; ?>
            	</ul>
            </li>
            <?php endif; ?>
          </ul>
        </form>
      </div>
    </div> <!-- end split-form -->
  </div> <!-- end left-col -->
  <?php include_partial('sidebar') ?>