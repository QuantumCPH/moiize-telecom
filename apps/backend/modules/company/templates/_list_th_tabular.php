  <th id="sf_admin_list_th_name">
          <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/company/sort') == 'name'): ?>
      <?php echo link_to(__('Company Name'), 'company/list?sort=name&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/company/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo __($sf_user->getAttribute('type', 'asc', 'sf_admin/company/sort')) ?>)
      <?php else: ?>
      <?php echo link_to(__('Company Name'), 'company/list?sort=name&type=asc') ?>
      <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_vat_no">
          <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/company/sort') == 'vat_no'): ?>
      <?php echo link_to(__('Vat no'), 'company/list?sort=vat_no&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/company/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo __($sf_user->getAttribute('type', 'asc', 'sf_admin/company/sort')) ?>)
      <?php else: ?>
      <?php echo link_to(__('Vat no'), 'company/list?sort=vat_no&type=asc') ?>
      <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_contact_name">
          <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/company/sort') == 'contact_name'): ?>
      <?php echo link_to(__('Contact name'), 'company/list?sort=contact_name&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/company/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo __($sf_user->getAttribute('type', 'asc', 'sf_admin/company/sort')) ?>)
      <?php else: ?>
      <?php echo link_to(__('Contact name'), 'company/list?sort=contact_name&type=asc') ?>
      <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_head_phone_number">
          <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/company/sort') == 'head_phone_number'): ?>
      <?php echo link_to(__('Head phone number'), 'company/list?sort=head_phone_number&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/company/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo __($sf_user->getAttribute('type', 'asc', 'sf_admin/company/sort')) ?>)
      <?php else: ?>
      <?php echo link_to(__('Head phone number'), 'company/list?sort=head_phone_number&type=asc') ?>
      <?php endif; ?>
          </th>
