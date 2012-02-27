<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>

<div id="sf_admin_container">
    <ul class="customerMenu" style="margin:10px 0;">
            <li><a class="external_link" href="allRegisteredCustomer"><?php echo  __('View All Customer') ?></a></li>
            <li><a class="external_link" href="customerDetail?id=<?php echo $_REQUEST['id'];  ?>"><?php echo  __('Customer Detail') ?></a></li>
            <li><a class="external_link"  href="callhistory?id=<?php echo $_REQUEST['id'];  ?>"><?php echo  __('Call History') ?></a></li>
        </ul>
<h1><?php echo  __('Payment History') ?></h1>
              <!--Always use tables for tabular data-->
              <table width="100%" cellspacing="0" cellpadding="2" class="tblAlign">
                   <tr class="headings">
                       <th width="15%"  align="left"><?php echo __('Order Numer') ?></th>
                       <th width="25%"  align="left"><?php echo __('Date & Time') ?></th>
                       <th width="50%"  align="left"><?php echo __('Description') ?></th>
                       <th width="10%" align="left"><?php echo __('Amount') ?></th>
                   </tr>
                <?php 
                $amount_total = 0;
                $incrment=1;
                foreach($transactions as $transaction): ?>

                 <?php
                  
                  if($incrment%2==0){
                      $colorvalue="#FFFFFF";
                      $class= 'class="even"';
                      }else{
                        $class= 'class="odd"';
                        $colorvalue="#FCD9C9";
                     }
                  $incrment++;
                  ?>
                <tr <?php echo $class;   ?>>
                  <td><?php  echo $transaction->getOrderId() ?></td>
                  <td><?php echo  $transaction->getCreatedAt() ?></td>
                  <td><?php echo __($transaction->getDescription()) ?></td>
                  <td><?php echo $transaction->getAmount(); $amount_total += $transaction->getAmount() ?>
                              &nbsp;&euro;</td>
                
                </tr>
                <?php endforeach; ?>
                <?php if(count($transactions)==0): ?>
                <tr>
                  <td colspan="4"><p><?php echo __('There are currently no transactions to show.') ?></p></td>
                </tr>
                <?php else: ?>
                <tr>
                  <td>&nbsp;</td><td colspan="2" align="right"><strong><?php echo __('Total:') ?></strong></td>
                  <td><?php echo format_number($amount_total) ?>  &nbsp;&euro;</td>
                </tr>	
                <?php endif; ?>
              </table>
</div>         