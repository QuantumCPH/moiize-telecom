<div class="form-row">
  <?php echo label_for('agent_company[country_id]', 'country', '') ?>
  <div class="content<?php if ($sf_request->hasError('agent_company{country_id}')): ?> form-error<?php endif; ?>">
  <?php if ($sf_request->hasError('agent_company{country_id}')): ?>
    <?php echo form_error('agent_company{country_id}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>

   <?php echo select_tag('agent_company[country_id]', options_for_select($countries_list, $country_id),
  								array('onchange'=> remote_function(array(
							    			'update'  => 'countrycity',
							    			'url'     => 'agent_company/countrycity',
  											'with' => "'country_id=' + this.options[this.selectedIndex].value"
							  			))
									)) ?>
    </div>
</div>

<?php if($cities_list != ''): ?>
	<div class="form-row">
	  <?php echo label_for('agent_company[city_id]', 'city', '') ?>
	  <div class="content<?php if ($sf_request->hasError('agent_company{city_id}')): ?> form-error<?php endif; ?>">
	  <?php if ($sf_request->hasError('agent_company{city_id}')): ?>
	    <?php echo form_error('agent_company{city_id}', array('class' => 'form-error-msg')) ?>
	  <?php endif; ?>
	
	  <?php echo select_tag('agent_company[city_id]', options_for_select($cities_list, $city_id)) ?>
	    </div>
	</div>
<?php endif; ?>