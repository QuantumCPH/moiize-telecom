<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('myemployee/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('myemployee/index') ?>"><?php echo  __('Cancel') ?></a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'myemployee/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
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
        <th><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['mobile_model']->renderLabel() ?></th>
        <td>
          <?php echo $form['mobile_model']->renderError() ?>
          <?php echo $form['mobile_model'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['mobile_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['mobile_number']->renderError() ?>
          <?php echo $form['mobile_number'] ?>
        </td>
      </tr>
     <!-- <tr>
        <th><?php //echo $form['app_code']->renderLabel() ?></th>
        <td>
          <?php //echo $form['app_code']->renderError() ?>
          <?php //echo $form['app_code'] ?>
        </td>
      </tr>
      <tr>
        <th><?php //echo $form['is_app_registered']->renderLabel() ?></th>
        <td>
          <?php //echo $form['is_app_registered']->renderError() ?>
          <?php //echo $form['is_app_registered'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['password']->renderLabel() ?></th>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
      </tr>-->
    </tbody>
  </table>
</form>
