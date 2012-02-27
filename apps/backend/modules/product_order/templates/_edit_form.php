<?php echo form_tag('product_order/save', array(
  'id'        => 'sf_admin_edit_form',
  'name'      => 'sf_admin_edit_form',
  'multipart' => true,
)) ?>

<?php
	
	$company_id = '';
	
	if ($sf_params->get('company_id'))
	{
		$company_id = $sf_params->get('company_id');
	}
	
?>

<?php echo object_input_hidden_tag($product_order, 'getId') ?>

<fieldset id="sf_fieldset_none" class="">

<div class="form-row">
  <?php echo label_for('product_order[product_id]', __($labels['product_order{product_id}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('product_order{product_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('product_order{product_id}')): ?>
    <?php echo form_error('product_order{product_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($product_order, 'getProductId', array (
  'related_class' => 'Product',
  'control_name' => 'product_order[product_id]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('product_order[company_id]', __($labels['product_order{company_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('product_order{company_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('product_order{company_id}')): ?>
    <?php echo form_error('product_order{company_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($product_order, 'getCompanyId', array (
  'related_class' => 'Company',
  'control_name' => 'product_order[company_id]',
  'include_blank' => true,
), $company_id); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<!-- 
<div class="form-row">
  <?php echo label_for('product_order[agent_company_id]', __($labels['product_order{agent_company_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('product_order{agent_company_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('product_order{agent_company_id}')): ?>
    <?php echo form_error('product_order{agent_company_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($product_order, 'getAgentCompanyId', array (
  'related_class' => 'AgentCompany',
  'control_name' => 'product_order[agent_company_id]',
  'include_blank' => true,
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>
 -->
 
<div class="form-row">
  <?php echo label_for('product_order[quantity]', __($labels['product_order{quantity}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('product_order{quantity}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('product_order{quantity}')): ?>
    <?php echo form_error('product_order{quantity}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($product_order, 'getQuantity', array (
  'size' => 7,
  'control_name' => 'product_order[quantity]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('product_order[discount]', __($labels['product_order{discount}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('product_order{discount}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('product_order{discount}')): ?>
    <?php echo form_error('product_order{discount}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($product_order, 'getDiscount', array (
  'size' => 7,
  'control_name' => 'product_order[discount]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

</fieldset>

<?php include_partial('edit_actions', array('product_order' => $product_order)) ?>

</form>

<ul class="sf_admin_actions">
      <li class="float-left"><?php if ($product_order->getId()): ?>
<?php echo button_to(__('delete'), 'product_order/delete?id='.$product_order->getId(), array (
  'post' => true,
  'confirm' => __('Are you sure?'),
  'class' => 'sf_admin_action_delete',
)) ?><?php endif; ?>
</li>
  </ul>
