
<form method="post" action="">
    <div class="save-ok">
  <h2>Your modifications have been saved</h2>
</div>
    <table>

        <tr bgcolor="#5970B2" style="color:#FFF;"><th  colspan="2" align="left" > Product For Agent: <?php
                 
             echo  $agenttdata->getName();
                
                  ?> </th></tr>
        <tr bgcolor="#5970B2" style="color:#FFF;"><th width="30%" align="left">Product Name  </th> <th  width="30%" align="left"> Action</th></tr>

<input type="hidden" name="agentid" value="<?php echo $agentid; ?>" />
 <?php    foreach($products as $product){?>
 
<tr><td><?php  echo $product->getName() ?></td> <td><input name="product['<?php echo  $product->getId() ?>']" value="<?php echo  $product->getId() ?>" type="checkbox"  <?php
                                                      $dc = new Criteria();
                  $dc->add(AgentProductPeer::AGENT_ID, $agentid);
                  $dc->add(AgentProductPeer::PRODUCT_ID, $product->getId() );
                  $temp = AgentProductPeer::doCount($dc); ?>  <?php  if(isset($temp) && $temp>0){ ?>   checked="checked"  <?php  } ?> />
   </td></tr>
    <?php } ?><tr><td colspan="2" align="center">&nbsp; </td></tr> <tr><td colspan="2" align="center">
<input  type="submit" name="submit" value="Upadte" />
      </td></tr> </table>
</form>