<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('userguide/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
    <div id="sf_admin_container">
        <input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table cellspacing="0" cellpadding="2" class="tblUserguide" width="100%">
    <tfoot>
      <tr>
        <td class="noBorder"></td><td class="noBorder" align="left"><br />
            <?php echo $form->renderHiddenFields() ?>

          <a href="<?php echo url_for('userguide/index') ?>" class="user_external_link"><?php echo __('Cancel');?></a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to(__('Delete'), 'userguide/delete?id='.$form->getObject()->getId(), array('class'=>'user_external_link','method' => 'delete', 'confirm' => __('Are you sure?'))) ?>
          <?php endif; ?> &nbsp;
            <input type="submit" value="<?php echo __('Save');?>" class="saveUserGuide" />
            <p>&nbsp;</p>
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th class="noBorder"><b><?php echo $form['title']->renderLabel() ?></b></th>
        <td class="noBorder">
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
        </td>
      </tr>
      <tr>
        <th class="noBorder"><b><?php echo $form['description']->renderLabel() ?></b></th>
        <td class="noBorder">
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th class="noBorder"><b><?php echo $form['country_id']->renderLabel() ?></b></th>
        <td class="noBorder">
          <?php echo $form['country_id']->renderError() ?>
          <?php echo $form['country_id'] ?>
        </td>
      </tr>
      <tr>
        <th class="noBorder"><b><?php echo $form['status_id']->renderLabel() ?></b></th>
        <td class="noBorder">
          <?php echo $form['status_id']->renderError() ?>
          <?php echo $form['status_id'] ?>
        </td>
      </tr>
      <tr>
        <th class="noBorder"><b><?php echo $form['image']->renderLabel() ?></b></th>
        <td class="noBorder">
          <?php echo $form['image']->renderError() ?>
          <?php echo $form['image'] ?>
        </td>
      </tr>
      <tr>
        <th class="noBorder"><b><?php echo $form['create_at']->renderLabel() ?></b></th>
        <td class="noBorder">
          <?php echo $form['create_at']->renderError() ?>
          <?php echo $form['create_at'] ?>
        </td>
      </tr>
    </tbody>
  </table>
        </div>
</form>
<br />
