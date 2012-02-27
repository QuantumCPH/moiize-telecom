<?php echo form_tag('agent_company/save', array(
  'id'        => 'sf_admin_edit_form',
  'name'      => 'sf_admin_edit_form',
  'multipart' => true,
)) ?>

<?php echo object_input_hidden_tag($agent_company, 'getId') ?>

<fieldset id="sf_fieldset_none" class="">

<div class="form-row">
  <?php echo label_for('agent_company[name]', __($labels['agent_company{name}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{name}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{name}')): ?>
    <?php echo form_error('agent_company{name}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getName', array (
  'size' => 80,
  'control_name' => 'agent_company[name]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('agent_company[cvr_number]', "Vat Number", 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{cvr_number}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{cvr_number}')): ?>
    <?php echo form_error('agent_company{cvr_number}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getCvrNumber', array (
  'size' => 7,
  'control_name' => 'agent_company[cvr_number]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>



<div class="form-row">
  <?php echo label_for('agent_company[address]', __($labels['agent_company{address}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{address}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{address}')): ?>
    <?php echo form_error('agent_company{address}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getAddress', array (
  'size' => 80,
  'control_name' => 'agent_company[address]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('agent_company[post_code]', __($labels['agent_company{post_code}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{post_code}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{post_code}')): ?>
    <?php echo form_error('agent_company{post_code}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getPostCode', array (
  'size' => 7,
  'control_name' => 'agent_company[post_code]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>


<div id="countrycity">
	<?php //include_partial('resort/countrycity', array('resort' => $resort, 'labels' => $labels)) ?>
	<?php echo javascript_tag(
  			remote_function(array(
    			'update'  => 'countrycity',
    			'url'     => 'agent_company/countrycity'. ($agent_company->getCountryId() != ''? '?country_id='.$agent_company->getCountryId().'&city_id='.$agent_company->getCityId() : ''),
  			))
		) ?>
</div>
<div class="form-row">
  <?php echo label_for('agent_company[contact_name]', __($labels['agent_company{contact_name}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{contact_name}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{contact_name}')): ?>
    <?php echo form_error('agent_company{contact_name}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getContactName', array (
  'size' => 80,
  'control_name' => 'agent_company[contact_name]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('agent_company[email]', __($labels['agent_company{email}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{email}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{email}')): ?>
    <?php echo form_error('agent_company{email}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getEmail', array (
  'size' => 80,
  'control_name' => 'agent_company[email]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('agent_company[head_phone_number]', __($labels['agent_company{head_phone_number}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{head_phone_number}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{head_phone_number}')): ?>
    <?php echo form_error('agent_company{head_phone_number}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getHeadPhoneNumber', array (
  'size' => 7,
  'control_name' => 'agent_company[head_phone_number]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('agent_company[sms_code]', __($labels['agent_company{sms_code}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{sms_code}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{sms_code}')): ?>
    <?php echo form_error('agent_company{sms_code}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getSmsCode', array (
  'size' => 7,
  'control_name' => 'agent_company[sms_code]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>
<div class="form-row">
  <?php echo label_for('agent_company[fax_number]', __($labels['agent_company{fax_number}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{fax_number}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{fax_number}')): ?>
    <?php echo form_error('agent_company{fax_number}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getFaxNumber', array (
  'size' => 7,
  'control_name' => 'agent_company[fax_number]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('agent_company[website]', __($labels['agent_company{website}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{website}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{website}')): ?>
    <?php echo form_error('agent_company{website}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getWebsite', array (
  'size' => 80,
  'control_name' => 'agent_company[website]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('agent_company[status_id]', __($labels['agent_company{status_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{status_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{status_id}')): ?>
    <?php echo form_error('agent_company{status_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($agent_company, 'getStatusId', array (
  'related_class' => 'Status',
  'control_name' => 'agent_company[status_id]',
  'include_blank' => true,
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('agent_company[company_type_id]', __($labels['agent_company{company_type_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{company_type_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{company_type_id}')): ?>
    <?php echo form_error('agent_company{company_type_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($agent_company, 'getCompanyTypeId', array (
  'related_class' => 'CompanyType',
  'control_name' => 'agent_company[company_type_id]',
  'include_blank' => true,
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>



<div class="form-row">
  <?php echo label_for('agent_company[commission_period_id]', __($labels['agent_company{commission_period_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{commission_period_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{commission_period_id}')): ?>
    <?php echo form_error('agent_company{commission_period_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($agent_company, 'getCommissionPeriodId', array (
  'related_class' => 'CommissionPeriod',
  'control_name' => 'agent_company[commission_period_id]',
  'include_blank' => true,
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('agent_company[account_manager_id]', __($labels['agent_company{account_manager_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{account_manager_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{account_manager_id}')): ?>
    <?php echo form_error('agent_company{account_manager_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($agent_company, 'getAccountManagerId', array (
  'related_class' => 'User',
  'control_name' => 'agent_company[account_manager_id]',
  'include_blank' => true,
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>
<!-- 
<div class="form-row">
  <?php echo label_for('agent_company[created_at]', __($labels['agent_company{created_at}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{created_at}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{created_at}')): ?>
    <?php echo form_error('agent_company{created_at}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_date_tag($agent_company, 'getCreatedAt', array (
  'rich' => true,
  'withtime' => true,
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'control_name' => 'agent_company[created_at]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>
 -->
<div class="form-row">
  <?php echo label_for('agent_company[agent_commission_package_id]', __($labels['agent_company{agent_commission_package_id}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{agent_commission_package_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{agent_commission_package_id}')): ?>
    <?php echo form_error('agent_company{agent_commission_package_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($agent_company, 'getAgentCommissionPackageId', array (
  'related_class' => 'AgentCommissionPackage',
  'control_name' => 'agent_company[agent_commission_package_id]',
  'include_blank' => true,
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

 <div class="form-row">
  <?php echo label_for('agent_company[is_prepaid]', __($labels['agent_company{is_prepaid}']), 'class="" ') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{is_prepaid}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{is_prepaid}')): ?>
    <?php echo form_error('agent_company{is_prepaid}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

      <?php $value = object_checkbox_tag($agent_company, 'getIsPrepaid', array (
  'size' => 7,
  'control_name' => 'agent_company[is_prepaid]',
)); echo $value ? $value : '&nbsp;' ?>
  
    </div>
</div>

 <div class="form-row">
  <?php echo label_for('agent_company[balance]', __($labels['agent_company{balance}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{balance}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{balance}')): ?>
    <?php echo form_error('agent_company{balance}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($agent_company, 'getBalance', array (
  'size' => 7,
  'control_name' => 'agent_company[balance]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>
 
</fieldset>

<?php include_partial('edit_actions', array('agent_company' => $agent_company)) ?>

</form>

<ul class="sf_admin_actions">
      <li class="float-left"><?php if ($agent_company->getId()): ?>
<?php echo button_to(__('delete'), 'agent_company/delete?id='.$agent_company->getId(), array (
  'post' => true,
  'confirm' => __('Are you sure?'),
  'class' => 'sf_admin_action_delete',
)) ?><?php endif; ?>
</li>
  </ul>