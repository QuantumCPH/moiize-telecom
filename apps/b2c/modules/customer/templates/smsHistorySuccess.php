<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php include_partial('dashboard_header', array('customer'=> $customer, 'section'=>__('SMS History')) ) ?>
<div class="alert_bar">
	<?php echo __('SMS history is updated after every 5-10 minutes.') ?>
</div>
  <div class="left-col">
    <?php include_partial('navigation', array('selected'=>'websms', 'customer_id'=>$customer->getId())) ?>
	
	<div class="split-form">
      <div class="fl col">
        <form action="<?php echo url_for('customer/smshistory') ?>" method="post">
          <ul>
<?php /*
            <li>
              <label><?php echo $filter['to_no']->renderLabel() ?>:</label>
              <?php echo $filter['to_no'] ?>
            </li>
            <li>
            	<?php echo $filter['date']->render(array('class' => 'quater')) ?>
            </li>
            <!--
            <li>
              <label><?php echo __('From') ?>:</label>
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
              <label><?php echo __('To') ?>:</label>
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
             -->
            <li>
              <button><?php echo __('Show') ?></button>
            </li>
 */ ?>
            <li>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="callhistory">
                  <tr>
                    <td class="title"><?php echo __('Date & time') ?></td>
                    <td class="title" width="40%"><?php echo __('Phone Number') ?></td>                    
                    <td class="title"><?php echo __('Cost <small>(Incl. VAT)</small>') ?></td>
                  </tr>

                <?php
                $amount_total = 0;
                foreach($smsRecords as $smsRecord): ?>
                <tr>
                  <td><?php  echo $smsRecord->getCreatedAt('Y-m-d H:i:s') ?></td>
                  <td><?php echo  $smsRecord->getDa() ?></td>
                  

                  <?php
                  $c = new Criteria();
                  $c->add(CountryPeer::ID, $smsRecord->getCountryId());
                  $country = CountryPeer::doSelectOne($c);
                  $amt = $country->getCbfRate();
                  
                  ?>
                  <td><?php $amount_total += $amt; echo number_format($amt, 2, ',', '') ?> &euro;</td>
                </tr>
                <?php endforeach; ?>
                <?php if(count($smsRecords)==0): ?>
                <tr>
                	<td colspan="5"><p><?php echo __('There are currently no SMS records to show.') ?></p></td>
                </tr>
                <?php else: ?>
                <tr>
                	<td colspan="2" align="right"><strong><?php echo __('Subtotal') ?></strong></td>
                	<!--
                	<td><?php echo format_number($amount_total-$amount_total*.20) ?> dkk</td>
                	 -->
                         <td><?php echo number_format($amount_total, 2, ',', '') ?> &euro;</td>
                </tr>
                <?php endif; ?>
              </table>
            </li>
            <?php if($total_pages>1): ?>
            <li>
            	<ul class="paging">
            	<?php for ($i=1; $i<=$total_pages; $i++): ?>
            		<li <?php echo $i==$page?'class="selected"':'' ?>><a href="<?php echo url_for('customer/smshistory?page='.$i) ?>"><?php echo $i ?></a></li>
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