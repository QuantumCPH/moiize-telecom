<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('customer/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('customer/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'customer/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['first_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['first_name']->renderError() ?>
          <?php echo $form['first_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['last_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['last_name']->renderError() ?>
          <?php echo $form['last_name'] ?>
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
        <th><?php echo $form['city']->renderLabel() ?></th>
        <td>
          <?php echo $form['city']->renderError() ?>
          <?php echo $form['city'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['po_box_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['po_box_number']->renderError() ?>
          <?php echo $form['po_box_number'] ?>
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
        <th><?php echo $form['device_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['device_id']->renderError() ?>
          <?php echo $form['device_id'] ?>
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
        <th><?php echo $form['password']->renderLabel() ?></th>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_newsletter_subscriber']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_newsletter_subscriber']->renderError() ?>
          <?php echo $form['is_newsletter_subscriber'] ?>
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
        <th><?php echo $form['product']->renderLabel() ?></th>
        <td>
          <?php echo $form['product']->renderError() ?>
          <?php echo $form['product'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['manufacturer']->renderLabel() ?></th>
        <td>
          <?php echo $form['manufacturer']->renderError() ?>
          <?php echo $form['manufacturer'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['password_confirm']->renderLabel() ?></th>
        <td>
          <?php echo $form['password_confirm']->renderError() ?>
          <?php echo $form['password_confirm'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['terms_conditions']->renderLabel() ?></th>
        <td>
          <?php echo $form['terms_conditions']->renderError() ?>
          <?php echo $form['terms_conditions'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
