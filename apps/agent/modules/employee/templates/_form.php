<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('employee/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
    <?php endif;
?>

    <?php echo $form->renderGlobalErrors() ?>
    <div class="grid_4 alpha">
        <?php echo $form['first_name']->renderLabel() ?>
        <?php echo $form['first_name']->renderError() ?>
        <?php echo $form['first_name'] ?>
    </div>
    <div class="grid_4 omega">
        <?php echo $form['last_name']->renderLabel() ?>
        <?php echo $form['last_name']->renderError() ?>
        <?php echo $form['last_name'] ?>
    </div>
    <div class="grid_4 alpha">
        <?php echo $form['email']->renderLabel() ?>
        <?php echo $form['email']->renderError() ?>
        <?php echo $form['email'] ?>
    </div>
    <div class="grid_4 omega">
        <?php echo $form['mobile_model']->renderLabel() ?>
        <?php echo $form['mobile_model']->renderError() ?>
        <?php echo $form['mobile_model'] ?>
    </div>
    <div class="grid_4 alpha">
        <?php echo $form['mobile_number']->renderLabel() ?>
        <?php echo $form['mobile_number']->renderError() ?>
        <?php echo $form['mobile_number'] ?>
    </div>
    <div class="clear"></div>
    <?php echo $form->renderHiddenFields() ?>
    
    <?php if (!$form->getObject()->isNew()): ?>
        &nbsp;<?php echo link_to('Delete', 'employee/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
    <?php endif;?>
        <button type="submit"><?php echo __('Save')?></button>
    &nbsp;<a href="<?php echo url_for('employee/index') ?>">Cancel</a>

</form>
