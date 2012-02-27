<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('usage_alert/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('usage_alert/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'usage_alert/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['alert_amount']->renderLabel() ?></th>
        <td>
          <?php echo $form['alert_amount']->renderError() ?>
          <?php echo $form['alert_amount'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['sms_alert_message']->renderLabel() ?></th>
        <td>
          <?php echo $form['sms_alert_message']->renderError() ?>
          <?php echo $form['sms_alert_message'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['sms_active']->renderLabel() ?></th>
        <td>
          <?php echo $form['sms_active']->renderError() ?>
          <?php echo $form['sms_active'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email_alert_message']->renderLabel() ?></th>
        <td>
          <?php echo $form['email_alert_message']->renderError() ?>
          <?php echo $form['email_alert_message'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email_active']->renderLabel() ?></th>
        <td>
          <?php echo $form['email_active']->renderError() ?>
          <?php echo $form['email_active'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['country']->renderLabel() ?></th>
        <td>
          <?php echo $form['country']->renderError() ?>
          <?php echo $form['country'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['status']->renderLabel() ?></th>
        <td>
          <?php echo $form['status']->renderError() ?>
          <?php echo $form['status'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
