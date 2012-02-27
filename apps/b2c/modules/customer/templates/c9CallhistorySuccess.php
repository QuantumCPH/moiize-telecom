<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php include_partial('dashboard_header', array('customer'=> $customer, 'section'=>__('Call History')) ) ?>
<div class="alert_bar">
	<?php echo __('Call history is updated after every 5-10 minutes.') ?>
</div>
  <div class="left-col">
    <?php include_partial('navigation', array('selected'=>'callhistory', 'customer_id'=>$customer->getId())) ?>
	<div style="clear: both;"></div>
<span style="margin: 20px;">	
	<center>

		<form action="/index.php/customer/callhistory" method="post">
			<INPUT TYPE="submit" VALUE="Se LandNCall AB Out Opkaldsoversigt">
		</form>
	</center>
</span>
	<div class="split-form">
      <div class="fl col">
        <form action="<?php echo url_for('customer/c9Callhistory') ?>" method="post">
          <ul>
            <li>
              <!--Always use tables for tabular data-->
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="callhistory">
                  <tr>
                    <td class="title"><?php echo __('Date &amp; time') ?></td>
                    <td class="title" width="40%"><?php echo __('Phone Number') ?></td>
                    <td class="title"><?php echo __('Duration') ?></td>
                  
                    <td class="title"><?php echo __('Cost ') ?></td>
                   <!--
					<td class="title"><?php echo __('Balance') ?></td> -->
                  </tr>

                <?php
                $amount_total = 0;
                foreach($callRecords as $callRecord): ?>
                <?php if( (integer)$callRecord->getLegDuration() > 0): ?>
				
					<tr>
					  <td><?php  echo $callRecord->getc9Timestamp() ?></td>
					  <td><?php echo  $callRecord->getDestination() ?></td>
					  <td><?php echo date('i:s', $callRecord->getLegDuration()) ?></td>
					  
					 <?php 
					 
					 $conversion_rate = CurrencyConversionPeer::retrieveByPK(1);

					 $exchange_rate = $conversion_rate->getBppDkk();
					 ?>


					  <td><?php echo number_format($callRecord->getUserCharge() * $exchange_rate, 2, ',', '')  ?> SEK</td>
						<!--
					  <td><?php echo number_format($callRecord->getUserBalance(), 2, ',', '')  ?> SEK</td>
					  -->
					</tr>
					<?php $amount_total = $amount_total + $callRecord->getUserCharge()?> 
				
				<?php endif; ?>
                <?php endforeach; ?>
                <?php if(count($callRecords)==0): ?>
                <tr>
                	<td colspan="5"><p><?php echo __('There are currently no call records to show.') ?></p></td>
                </tr>
                <?php else: ?>
                <tr>
                	<td colspan="3" align="right"><strong><?php echo __('Subtotal') ?></strong></td>
                     	<td><?php echo number_format($amount_total * $exchange_rate, 2, ',', '')  ?> SEK</td>            
                	<td></td>
                </tr>
                <?php endif; ?>
              </table>
            </li>
            <?php if($total_pages>1): ?>
            <li>
            	<ul class="paging">
            	<?php for ($i=1; $i<=$total_pages; $i++): ?>
            		<li <?php echo $i==$page?'class="selected"':'' ?>><a href="<?php echo url_for('customer/c9Callhistory?page='.$i) ?>"><?php echo $i ?></a></li>
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