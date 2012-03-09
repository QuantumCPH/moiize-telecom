<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('newupdate/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('newupdate/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'newupdate/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['created_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_at']->renderError() ?>
          <?php echo $form['created_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['message']->renderLabel() ?></th>
        <td>
          <?php echo $form['message']->renderError() ?>
          <?php echo $form['message'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['heading']->renderLabel() ?></th>
        <td>
          <?php echo $form['heading']->renderError() ?>
          <?php echo $form['heading'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['starting_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['starting_date']->renderError() ?>
          <?php echo $form['starting_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['expire_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['expire_date']->renderError() ?>
          <?php echo $form['expire_date'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
