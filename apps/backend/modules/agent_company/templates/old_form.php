<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('agent_company/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('agent_company/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'agent_company/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['cvr_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['cvr_number']->renderError() ?>
          <?php echo $form['cvr_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['ean_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['ean_number']->renderError() ?>
          <?php echo $form['ean_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['address']->renderLabel() ?></th>
        <td>
          <?php echo $form['address']->renderError() ?>
          <?php echo $form['address'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['post_code']->renderLabel() ?></th>
        <td>
          <?php echo $form['post_code']->renderError() ?>
          <?php echo $form['post_code'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['country_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['country_id']->renderError() ?>
          <?php echo $form['country_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['city_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['city_id']->renderError() ?>
          <?php echo $form['city_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['contact_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['contact_name']->renderError() ?>
          <?php echo $form['contact_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['mobile_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['mobile_number']->renderError() ?>
          <?php echo $form['mobile_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['head_phone_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['head_phone_number']->renderError() ?>
          <?php echo $form['head_phone_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['fax_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['fax_number']->renderError() ?>
          <?php echo $form['fax_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['website']->renderLabel() ?></th>
        <td>
          <?php echo $form['website']->renderError() ?>
          <?php echo $form['website'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['status_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['status_id']->renderError() ?>
          <?php echo $form['status_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['company_type_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['company_type_id']->renderError() ?>
          <?php echo $form['company_type_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['product_detail']->renderLabel() ?></th>
        <td>
          <?php echo $form['product_detail']->renderError() ?>
          <?php echo $form['product_detail'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['commission_period_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['commission_period_id']->renderError() ?>
          <?php echo $form['commission_period_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['account_manager_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['account_manager_id']->renderError() ?>
          <?php echo $form['account_manager_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_at']->renderError() ?>
          <?php echo $form['created_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['agent_commission_package_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['agent_commission_package_id']->renderError() ?>
          <?php echo $form['agent_commission_package_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['sms_code']->renderLabel() ?></th>
        <td>
          <?php echo $form['sms_code']->renderError() ?>
          <?php echo $form['sms_code'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_prepaid']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_prepaid']->renderError() ?>
          <?php echo $form['is_prepaid'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['balance']->renderLabel() ?></th>
        <td>
          <?php echo $form['balance']->renderError() ?>
          <?php echo $form['balance'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['invoice_method_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['invoice_method_id']->renderError() ?>
          <?php echo $form['invoice_method_id'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
