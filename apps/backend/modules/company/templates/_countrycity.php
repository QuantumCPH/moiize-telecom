<?php //include the prototype.js otherwise the following js code will not work ?>

<div class="form-row">
   <?php echo label_for('company[country_id]', __($labels['company{country_id}']), '') ?>
          <div class="content<?php if ($sf_request->hasError('company{country_id}')): ?> form-error<?php endif; ?>">
              <?php if ($sf_request->hasError('company{country_id}')): ?>
                <?php echo form_error('company{country_id}', array('class' => 'form-error-msg')) ?>
              <?php endif; ?>
              <?php $value = object_select_tag($company, 'getCountryId', array (
                      'related_class' => 'Country',
                      'control_name' => 'company[country_id]',
                      'include_blank' => true,
                      'onchange'=> remote_function(array(
                                'update'  => 'countrycity',
                                'url'     => 'company/countrycity',
                                        'with' => "'country_id=' + this.options[this.selectedIndex].value"
                                ))
                    )); echo $value ? $value : '&nbsp;' ?>
          </div>

</div>
<div class="form-row">
  <?php echo label_for('company[city_id]', __($labels['company{city_id}']), '') ?>
  <div class="content<?php if ($sf_request->hasError('company{city_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('company{city_id}')): ?>
    <?php echo form_error('company{city_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>
<?php $value = object_select_tag($company, 'getCityId', array (
  'related_class' => 'City',
  'control_name' => 'company[city_id]',
  'include_blank' => false,
)); echo $value ? $value : '&nbsp;' ?>
  <?php $value = object_input_tag($company, 'getContactName', array (
  'size' => 80,
  'control_name' => 'company[contact_name]',
)); echo $value ? $value : '&nbsp;' ?>
    </div>
</div>