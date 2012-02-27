<?php use_helper('Object') ?>

<div class="sf_admin_filters">
<?php echo form_tag('company/list', array('method' => 'get')) ?>

  <fieldset>
    <h2><?php echo __('filters') ?></h2>
    <div class="form-row">
    <label for="filters_company_name"><?php echo __('Company name:') ?></label>
    <div class="content">
    <?php echo get_partial('company_name', array('type' => 'filter', 'filters' => $filters)) ?>
    </div>
    </div>

        <div class="form-row">
    <label for="filters_vat_no"><?php echo __('Vat no:') ?></label>
    <div class="content">
    <?php echo input_tag('filters[vat_no]', isset($filters['vat_no']) ? $filters['vat_no'] : null, array (
  'size' => 7,
)) ?>
    </div>
    </div>

      </fieldset>

  <ul class="sf_admin_actions">
    <li><?php echo button_to(__('reset'), 'company/list?filter=filter', 'class=sf_admin_action_reset_filter') ?></li>
    <li><?php echo submit_tag(__('filter'), 'name=filter class=sf_admin_action_filter') ?></li>
  </ul>

</form>
</div>
