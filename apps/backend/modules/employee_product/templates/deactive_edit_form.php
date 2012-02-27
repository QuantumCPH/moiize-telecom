<?php echo form_tag('employee_product/save', array(
  'id'        => 'sf_admin_edit_form',
  'name'      => 'sf_admin_edit_form',
  'multipart' => true,
)) ?>

<?php
	
	$employee_id = '';
	
	if ($sf_params->get('employee_id'))
	{
		$employee_id = $sf_params->get('employee_id');
	}
	
?>

<?php echo object_input_hidden_tag($employee_product, 'getId') ?>

<fieldset id="sf_fieldset_none" class="">

<div class="form-row">
  <?php echo label_for('employee_product[employee_id]', __($labels['employee_product{employee_id}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('employee_product{employee_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('employee_product{employee_id}')): ?>
    <?php echo form_error('employee_product{employee_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($employee_product, 'getEmployeeId', array (
  'related_class' => 'Employee',
  'control_name' => 'employee_product[employee_id]',
), $employee_id); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('employee_product[product_id]', __($labels['employee_product{product_id}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('employee_product{product_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('employee_product{product_id}')): ?>
    <?php echo form_error('employee_product{product_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($employee_product, 'getProductId', array (
  'related_class' => 'Product',
  'control_name' => 'employee_product[product_id]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('employee_product[quantity]', __($labels['employee_product{quantity}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('employee_product{quantity}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('employee_product{quantity}')): ?>
    <?php echo form_error('employee_product{quantity}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($employee_product, 'getQuantity', array (
  'size' => 7,
  'control_name' => 'employee_product[quantity]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

</fieldset>

<?php include_partial('edit_actions', array('employee_product' => $employee_product)) ?>

</form>

<ul class="sf_admin_actions">
      <li class="float-left"><?php if ($employee_product->getId()): ?>
<?php echo button_to(__('delete'), 'employee_product/delete?id='.$employee_product->getId(), array (
  'post' => true,
  'confirm' => __('Are you sure?'),
  'class' => 'sf_admin_action_delete',
)) ?><?php endif; ?>
</li>
  </ul>
