<div id="sf_admin_container">
<form method="post" action="">

   <?php  if(isset($message)){
   ?> 
    <div class="save-ok">
     <h2> <?php echo  __($message); ?> </h2>
    </div>
  <?php } ?> 
    <h1><?php echo __('Product For Agent:') ?> <?php
                 
             echo  $agenttdata->getName();
                
                  ?> </h1>
    <table cellspacing="0" cellpadding="2" class="tblAlign">
        <tr class="headings"><th width="20%" align="left"><?php echo __('Product Name') ?>  </th>
            <th  width="10%" align="left"><?php echo __('Action') ?></th>
            <th  width="10%" align="left"><?php echo __('Reg share value') ?></th>
            <th  width="10%" align="left"><?php echo __('Reg. share value %') ?></th>
            <th  width="10%" align="left"><?php echo __('Reg share enable') ?></th>
            <th  width="10%" align="left"><?php echo __('Extra payments share value') ?></th>
            <th  width="10%" align="left"><?php echo __('extra refill share value %') ?></th>
            <th  width="10%" align="left"><?php echo __('Extra payments share enable') ?></th>
        </tr>

<input type="hidden" name="agentid" value="<?php echo $agentid; ?>" />
 <?php    foreach($products as $product){?>
 
<tr><td><?php  echo $product->getName() ?></td> <td><input name="product['<?php echo  $product->getId() ?>']" value="<?php echo  $product->getId() ?>" type="checkbox"  <?php
                                                      $dc = new Criteria();
                  $dc->add(AgentProductPeer::AGENT_ID, $agentid);
                  $dc->add(AgentProductPeer::PRODUCT_ID, $product->getId() );
                  $temp = AgentProductPeer::doCount($dc);

                  ?>  <?php  if(isset($temp) && $temp>0){ ?>   checked="checked"  <?php  } ?> />
   </td>
   <td><input name="pv['<?php echo  $product->getId() ?>']"  <?php  if(isset($temp) && $temp>0){ ?>  value="<?php
   $varval="0";
   $dc = new Criteria();
                  $dc->add(AgentProductPeer::AGENT_ID, $agentid);
                  $dc->add(AgentProductPeer::PRODUCT_ID, $product->getId() );
                  
                     $tempv = AgentProductPeer::doSelectOne($dc);
                    $varval=$tempv->getRegShareValue();
                     $extravarval=$tempv->getExtraPaymentsShareValue();
 if(isset($varval) && $varval!="" ){  echo  $varval;  } ?>"   <?php  } ?> type="text"    />
</td>
<td><input name="pvp['<?php echo  $product->getId() ?>']" value="1" type="checkbox" <?php  if(isset($temp) && $temp>0){ ?>  <?php  if($tempv->getIsRegShareValuePc()==1 ){  ?>  checked="checked"  <?php  } ?>   <?php  } ?>  />
</td>
<td><input name="pve['<?php echo  $product->getId() ?>']" value="1" type="checkbox"   <?php  if(isset($temp) && $temp>0){ ?>  <?php  if($tempv->getRegShareEnable()==1 ){  ?>  checked="checked"  <?php  } ?>   <?php  } ?>   />
</td>
<td><input name="epv['<?php echo  $product->getId() ?>']"  type="text"   <?php  if(isset($temp) && $temp>0){ ?>  value="<?php
   $varval="0";
   $dc = new Criteria();
                  $dc->add(AgentProductPeer::AGENT_ID, $agentid);
                  $dc->add(AgentProductPeer::PRODUCT_ID, $product->getId() );
                   $tempv = AgentProductPeer::doSelectOne($dc);

                     $extravarval=$tempv->getExtraPaymentsShareValue();
 if(isset($extravarval) && $extravarval!="" ){  echo  $extravarval;  } ?>"   <?php  } ?>   />
</td>
<td><input name="epvp['<?php echo  $product->getId() ?>']" value="1" type="checkbox"   <?php  if(isset($temp) && $temp>0){ ?>  <?php  if($tempv->getIsExtraPaymentsShareValuePc()==1 ){  ?>  checked="checked"  <?php  } ?>   <?php  } ?>   />
</td>
<td><input name="epve['<?php echo  $product->getId() ?>']" value="1" type="checkbox"   <?php  if(isset($temp) && $temp>0){ ?>  <?php  if($tempv->getExtraPaymentsShareEnable()==1 ){  ?>  checked="checked"  <?php  } ?>   <?php  } ?>   />
</td>
</tr>
    <?php } ?></table>
    <div class="submitBtn"><input  type="submit" name="submit" class="UpdateBtn" style="float:right;" value="<?php echo __('Update') ?>" /></div>
</form>
</div>