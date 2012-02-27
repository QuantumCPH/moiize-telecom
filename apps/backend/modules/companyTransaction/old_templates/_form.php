<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('companyTransaction/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('companyTransaction/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'companyTransaction/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['product_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['product_id']->renderError() ?>
          <?php echo $form['product_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['company_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['company_id']->renderError() ?>
          <?php echo $form['company_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['amount']->renderLabel() ?></th>
        <td>
          <?php echo $form['amount']->renderError() ?>
          <?php echo $form['amount'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['extra_refill']->renderLabel() ?></th>
        <td>
          <?php echo $form['extra_refill']->renderError() ?>
          <?php echo $form['extra_refill'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['quantity']->renderLabel() ?></th>
        <td>
          <?php echo $form['quantity']->renderError() ?>
          <?php echo $form['quantity'] ?>
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
        <th><?php echo $form['updated_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['updated_at']->renderError() ?>
          <?php echo $form['updated_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['status']->renderLabel() ?></th>
        <td>
          <?php echo $form['status']->renderError() ?>
          <?php echo $form['status'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['transaction_status_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['transaction_status_id']->renderError() ?>
          <?php echo $form['transaction_status_id'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
