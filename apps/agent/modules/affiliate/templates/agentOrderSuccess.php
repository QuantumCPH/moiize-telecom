<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<style type="text/css">
	table {
		margin-bottom: 10px;
	}

	table.summary td {
		font-size: 1.2em;
		font-weight: normal;
	}
</style>
<div class="report_container">
<div id="sf_admin_container"><h1><?php echo __('Reciepts For Agent Account Refills') ?></h1></div>
        
  <div class="borderDiv">
<table cellspacing="0" width="100%" class="summary">
	<tr>
		<th style="text-align:left">&nbsp;</th>
		<th style="text-align:left"><?php echo __('Date');?></th>
		<th style="text-align:left"><?php echo __('Amount');?></th>
		<th style="text-align:left"><?php echo __('Show Reciept');?></th>

	</tr>
        <?php $i=0 ?>
        <?php foreach($agentOrders as $agentOrder){ ?>
        <tr <?php echo 'class="'.($i%2 == 0?'odd':'even').'"' ?>>
            <td><?php echo ++$i ?>.</td>
            <td><?php echo $agentOrder->getCreatedAt() ?></td>
            <td><?php echo $agentOrder->getAmount() ?></td>
            <td><a href="<?php echo url_for('affiliate/printAgentReceipt?aoid='.$agentOrder->getId(), true) ?>" ><?php echo __('Receipt');?> </a>
            </td>
            
        </tr>

        <?php } ?>
</table>
  </div>
</div>