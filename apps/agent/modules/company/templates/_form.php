<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('company/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<?php echo $form->renderGlobalErrors() ?>
<div class="clear"></div>
    <div class="grid_5 alpha">
        <?php echo $form['name']->renderLabel() ?>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
    </div>
    <div class="grid_5 omega">
          <?php echo $form['cvr_number']->renderLabel() ?>
          <?php //if($form->getObjects()->isNew()): ?>
                <?php echo $form['cvr_number']->renderError() ?>
                <?php echo $form['cvr_number'] ?>
          <?php //else: ?>

    </div>
    <div class="grid_5 alpha">
        <?php echo $form['ean_number']->renderLabel() ?>
          <?php echo $form['ean_number']->renderError() ?>
          <?php echo $form['ean_number'] ?>
    </div>
    <div class="grid_5 omega">
        <?php echo $form['address']->renderLabel() ?>
          <?php echo $form['address']->renderError() ?>
          <?php echo $form['address'] ?>
    </div>
    <div class="grid_5 alpha">
          <?php echo $form['post_code']->renderLabel() ?>
          <?php echo $form['post_code']->renderError() ?>
          <?php echo $form['post_code'] ?>
    </div>
    <div class="clear"></div>
        <div id="countrylist">
	      	<?php include_partial('countrycity', array('form' => $form)); ?>
	</div>
    <div class="grid_5 alpha">
        <?php echo $form['contact_name']->renderLabel() ?>
          <?php echo $form['contact_name']->renderError() ?>
          <?php echo $form['contact_name'] ?>
    </div>
    <div class="grid_5 omega">
        <?php echo $form['email']->renderLabel() ?>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
    </div>
    <div class="grid_5 alpha">
        <?php echo $form['reg_nr']->renderLabel() ?>
          <?php echo $form['reg_nr']->renderError() ?>
          <?php echo $form['reg_nr'] ?>
    </div>
    <div class="grid_5 omega">
        <?php echo $form['account_number']->renderLabel() ?>
          <?php echo $form['account_number']->renderError() ?>
          <?php echo $form['account_number'] ?>
    </div>
    <div class="grid_5 alpha">
        <?php echo $form['head_phone_number']->renderLabel() ?>
          <?php echo $form['head_phone_number']->renderError() ?>
          <?php echo $form['head_phone_number'] ?>
    </div>
    <div class="grid_5 omega">
        <?php echo $form['fax_number']->renderLabel() ?>
          <?php echo $form['fax_number']->renderError() ?>
          <?php echo $form['fax_number'] ?>
    </div>
    <div class="grid_5 alpha">
        <?php echo $form['website']->renderLabel() ?>
          <?php echo $form['website']->renderError() ?>
          <?php echo $form['website'] ?>
    </div>
    <div class="grid_5 omega">
        <?php echo $form['status_id']->renderLabel() ?>
          <?php echo $form['status_id']->renderError() ?>
          <?php echo $form['status_id'] ?>
    </div>
    <div class="grid_5 alpha">
        <?php echo $form['company_size_id']->renderLabel() ?>
          <?php echo $form['company_size_id']->renderError() ?>
          <?php echo $form['company_size_id'] ?>
    </div>
    <div class="grid_5 omega">
        <?php echo $form['company_type_id']->renderLabel() ?>
          <?php echo $form['company_type_id']->renderError() ?>
          <?php echo $form['company_type_id'] ?>
    </div>
    <div class="grid_5 alpha">
        <?php echo $form['customer_type_id']->renderLabel() ?>
          <?php echo $form['customer_type_id']->renderError() ?>
          <?php echo $form['customer_type_id'] ?>
    </div>
    <div class="grid_5 omega">
        <?php echo $form['cpr_number']->renderLabel() ?>
          <?php echo $form['cpr_number']->renderError() ?>
          <?php echo $form['cpr_number'] ?>
    </div>
    <div class="grid_5 alpha">
        <?php echo $form['apartment_form_id']->renderLabel() ?>
          <?php echo $form['apartment_form_id']->renderError() ?>
          <?php echo $form['apartment_form_id'] ?>
    </div>
    <div class="grid_5 omega">
        <?php echo $form['invoice_method_id']->renderLabel() ?>
          <?php echo $form['invoice_method_id']->renderError() ?>
          <?php echo $form['invoice_method_id'] ?>
    </div>

    <div class="grid_5 alpha">
        <?php echo $form['sim_card_quantity']->renderLabel() ?>
          <?php echo $form['sim_card_quantity']->renderError() ?>
          <?php echo $form['sim_card_quantity'] ?>
    </div>
    <div class="grid_5 omega">
        <?php echo $form['price_per_sim']->renderLabel() ?>
          <?php echo $form['price_per_sim']->renderError() ?>
          <?php echo $form['price_per_sim'] ?>
    </div>

        <div class="clear"></div>
        
<?php echo $form->renderHiddenFields() ?>


<?php if (!$form->getObject()->isNew()): ?>
    &nbsp;<?php echo link_to('Delete', 'company/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
<?php endif; ?>

        <?php //echo button_to('save', 'company/'.($form->getObject()->isNew() ? 'create' : 'update'))?>
    <button type="submit"><?php echo __('Save'); ?></button>

&nbsp;<a href="<?php echo url_for('company/index') ?>">Cancel</a>
        
</form>
