<div id="sf_admin_container">
    <h1><?php echo __('Select Company') ?></h1><br />
<form method="post" action="agentProduct">

  <?php echo $form['agent_company_id']->renderLabel() ?>
             <?php echo $form['agent_company_id'] ?>
    <input type="submit" name="Assign Product" value="<?php echo __('Assign Product') ?>">

</form>
</div>