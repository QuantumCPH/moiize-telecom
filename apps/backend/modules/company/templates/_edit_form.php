<?php echo form_tag('company/save', array(
  'id'        => 'sf_admin_edit_form',
  'name'      => 'sf_admin_edit_form',
  'multipart' => true,
)) ?>

<?php echo object_input_hidden_tag($company, 'getId') ?>

<fieldset>
<div class="form-row">
  <?php echo label_for('company[name]', __($labels['company{name}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('company{name}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{name}')): ?>
    <?php echo form_error('company{name}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($company, 'getName', array (
  'size' => 80,
  'control_name' => 'company[name]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[vat_no]', __($labels['company{vat_no}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('company{vat_no}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{vat_no}')): ?>
    <?php echo form_error('company{vat_no}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>
<?php if ($company->isNew()){ ?>
  <?php $value = object_input_tag($company, 'getVatNo', array (
  'size' => 7,
  'control_name' => 'company[vat_no]',
)); echo $value ? $value : '&nbsp;' ?>
      <?php }else{

          $value = object_input_tag($company, 'getVatNo', array (
  'size' => 7,
  'readonly'=>'true',
  'control_name' => 'company[vat_no]',
)); echo $value ? $value : '&nbsp;' ;

      }?><span id="msgbox" style="display:none"></span><br>Prefix will be 'test' of any Vat No.
 
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[address]', __($labels['company{address}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('company{address}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{address}')): ?>
    <?php echo form_error('company{address}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($company, 'getAddress', array (
  'size' => 80,
  'control_name' => 'company[address]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[post_code]', __($labels['company{post_code}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('company{post_code}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{post_code}')): ?>
    <?php echo form_error('company{post_code}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($company, 'getPostCode', array (
  'size' => 80,
  'control_name' => 'company[post_code]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>


<div class="form-row">
   <?php echo label_for('company[country_id]', __($labels['company{country_id}']), '') ?>
          <div class="content<?php if ($sf_request->hasError('company{country_id}')): ?> form-error<?php endif; ?>">
              <?php if ($sf_request->hasError('company{country_id}')): ?>
                <?php echo form_error('company{country_id}', array('class' => 'form-error-msg')) ?>
              <?php endif; ?>
              <?php $value = object_select_tag($company, 'getCountryId', array (
                      'related_class' => 'Country',
                      'control_name' => 'company[country_id]',
                      'peer_method'=>'getSortedCountries',
                      //'include_blank' => true,
                      'onchange'=> remote_function(array(
                                'update'  => 'citySelectList',
                                'url'     => 'company/countrycity',
                                        'with' => "'country_id=' + this.options[this.selectedIndex].value"
                                ))
                    ),182); echo $value ? $value : '&nbsp;' ?>
          </div>
</div>
    
<div id="countrylist">
    <div class="form-row">
      <?php echo label_for('company[city_id]', __($labels['company{city_id}']), '') ?>
      <div class="content<?php if ($sf_request->hasError('company{city_id}')): ?> form-error<?php endif; ?>">
      <?php if ($sf_request->hasError('company{city_id}')): ?>
        <?php echo form_error('company{city_id}', array('class' => 'form-error-msg')) ?>
      <?php endif; ?>
          <div id="citySelectList">
    <?php $value = object_select_tag($company, 'getCityId', array (
      'related_class' => 'City',
      'control_name' => 'company[city_id]',
         'peer_method'=>'getSortedSweedishCities',
  
    )); echo $value ? $value : '&nbsp;' ?>
     </div>
        </div>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[contact_name]', __($labels['company{contact_name}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('company{contact_name}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{contact_name}')): ?>
    <?php echo form_error('company{contact_name}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

 
 <?php $value = object_input_tag($company, 'getContactName', array (
      'size' => 80,
      'control_name' => 'company[contact_name]',
    )); echo $value ? $value : '&nbsp;' ?>
   </div>
</div>
<div class="form-row">
  <?php echo label_for('company[email]', __($labels['company{email}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('company{email}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{email}')): ?>
    <?php echo form_error('company{email}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($company, 'getEmail', array (
  'size' => 80,
  'control_name' => 'company[email]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[head_phone_number]', __($labels['company{head_phone_number}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('company{head_phone_number}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{head_phone_number}')): ?>
    <?php echo form_error('company{head_phone_number}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($company, 'getHeadPhoneNumber', array (
  'size' => 7,
  'control_name' => 'company[head_phone_number]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[fax_number]', __($labels['company{fax_number}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('company{fax_number}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{fax_number}')): ?>
    <?php echo form_error('company{fax_number}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($company, 'getFaxNumber', array (
  'size' => 7,
  'control_name' => 'company[fax_number]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[website]', __($labels['company{website}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('company{website}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{website}')): ?>
    <?php echo form_error('company{website}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_input_tag($company, 'getWebsite', array (
  'size' => 80,
  'control_name' => 'company[website]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[status_id]', __($labels['company{status_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('company{status_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{status_id}')): ?>
    <?php echo form_error('company{status_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($company, 'getStatusId', array (
  'related_class' => 'Status',
  'control_name' => 'company[status_id]',
     'include_custom' => ' ',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>
<?php   // 'include_custom' => 'Select Status',   ?>
<div class="form-row">
  <?php echo label_for('company[company_size_id]', __($labels['company{company_size_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('company{company_size_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{company_size_id}')): ?>
    <?php echo form_error('company{company_size_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($company, 'getCompanySizeId', array (
  'related_class' => 'CompanySize',
  'control_name' => 'company[company_size_id]',
  'include_custom' => ' ',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[company_type_id]', __($labels['company{company_type_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('company{company_type_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{company_type_id}')): ?>
    <?php echo form_error('company{company_type_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($company, 'getCompanyTypeId', array (
  'related_class' => 'CompanyType',
  'control_name' => 'company[company_type_id]',
  'include_custom' => ' ',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[customer_type_id]', __($labels['company{customer_type_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('company{customer_type_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{customer_type_id}')): ?>
    <?php echo form_error('company{customer_type_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($company, 'getCustomerTypeId', array (
  'related_class' => 'CustomerType',
  'control_name' => 'company[customer_type_id]',
    'include_custom' => ' ',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[invoice_method_id]', __($labels['company{invoice_method_id}'])) ?>
  <div class="content<?php if ($sf_request->hasError('company{invoice_method_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{invoice_method_id}')): ?>
    <?php echo form_error('company{invoice_method_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($company, 'getInvoiceMethodId', array (
  'related_class' => 'InvoiceMethod',
  'control_name' => 'company[invoice_method_id]',
       'include_custom' => ' ',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[agent_company_id]', __($labels['company{agent_company_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('company{agent_company_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{agent_company_id}')): ?>
    <?php echo form_error('company{agent_company_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_select_tag($company, 'getAgentCompanyId', array (
  'related_class' => 'AgentCompany',
  'control_name' => 'company[agent_company_id]',
   'include_custom' => ' ',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>
<div class="form-row">
  <?php echo label_for('company[registration_date]', __($labels['company{registration_date}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('company{registration_date}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{registration_date}')): ?>
    <?php echo form_error('company{registration_date}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

 <?php $value = object_input_date_tag($company, 'getRegistrationDate', array (
  //'rich' => true,
  //'withtime' => true,
  //'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'control_name' => 'company[registration_date]',
  'readonly' => 'true',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<div class="form-row">
  <?php echo label_for('company[created_at]', __($labels['company{created_at}']), 'class="required" ') ?>
  <div class="content<?php if ($sf_request->hasError('company{created_at}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{created_at}')): ?>
    <?php echo form_error('company{created_at}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

   <?php $value = object_input_date_tag($company, 'getCreatedAt', array (
  //'rich' => true,
 // 'withtime' => true,
 // 'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'control_name' => 'company[created_at]',
  'readonly' => 'true',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>


<div class="form-row">
  <?php echo label_for('company[file_path]', __($labels['company{file_path}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('company{file_path}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{file_path}')): ?>
    <?php echo form_error('company{file_path}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

  <?php $value = object_admin_input_file_tag($company, 'getFilePath', array (
  'control_name' => 'company[file_path]',
  'include_link' => '/',
  'include_remove' => true,
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>

<?php if($company->isNew()){ ?>
<input type="hidden" value="" id="error" name="error">
<?php }?>

</fieldset>


<?php include_partial('edit_actions', array('company' => $company)) ?>

</form>
