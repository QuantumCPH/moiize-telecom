<?php use_helper('I18N') ?>
<?php use_helper('Number') ?><div id="sf_admin_container"><h1><?php echo __('Edit PCO Line') ?></h1>

<?php if (isset($_REQUEST['message']) && $_REQUEST['message']!= "") {
 ?>

    <div class="save-ok">
        <h2><?php echo __('PCO Line is added successfully') ?></h2>
    </div>

<?php } ?>


<form id="sf_admin_form" name="sf_admin_edit_form" method="post" enctype="multipart/form-data" action="../../updateEmployee">

    <input type="hidden" name="id"    value="<?php echo $employee->getId(); ?>"  size="25" />
 <div id="sf_admin_content">

    <table width="100%" cellspacing="0" cellpadding="2" class="tblAlign" border='0'>
        <tr>
            <td style="padding: 5px;"><?php echo __('Name:') ?></td>
            <td style="padding: 5px;"><input type="text" name="first_name" id="employee_first_name"  value="<?php echo $employee->getFirstName(); ?>"   class="required"  size="25" /></td>
        </tr>


          <tr>
            <td style="padding: 5px;"><?php echo __('Agent:') ?></td>
            <td style="padding: 5px;">
                <?php foreach ($companys as $company) { ?>
                   <?php   $comid = $company->getId(); ?>    <?php $varcom =$employee->getCompanyId();
                     if (isset($varcom) && $varcom == $comid) { ?>  <?php  echo $company->getName() ?> <?php } ?>   
<?php  } ?>
                <input type="hidden" name="company_id" id="employee_company_id"  class="required" value="<?php echo $employee->getCompanyId();   ?>" />
                </td>
        </tr>

<!--        <tr>
            <td style="padding: 5px;">Country Code:</td>
            <td style="padding: 5px;"> <input type="text" name="country_code" id="employee_country_code"   class="required digits"   value="<?php echo $employee->getCountryCode(); ?>" size="25"  /> </td>
        </tr>-->


       <?php  //$varval = $employee->getRegistrationType();
              //  if (isset($varval) && $varval == "1") { ?>
<!--        <tr>
            <td style="padding: 5px;"><?php echo __('Rese number:') ?></td>
            <td  style="padding: 5px;">
                <select name="registration_type" id="employee_company_id"   >
                  <option value="3"  <?php  $varval = $employee->getRegistrationType();
                if (isset($varval) && $varval == "1") { ?>  selected="selected" <?php  } ?> > yes</option>
                </select> </td>
        </tr>-->
  <?php // }else{ ?>


<!--          <tr>
            <td style="padding: 5px;"><?php echo __('Rese number:') ?></td>
            <td  style="padding: 5px;">
                <select name="registration_type" id="employee_company_id"   >
                    <option value="0"  <?php  $varval = $employee->getRegistrationType();
                 if (isset($varval) && $varval == "0") { ?>  selected="selected" <?php  } ?> >No</option>
                    <option value="1"  <?php  $varval = $employee->getRegistrationType();
                if (isset($varval) && $varval == "1") { ?>  selected="selected" <?php  } ?> > yes</option>
                </select> </td>
        </tr>-->
        
        <?php // } ?>
         <!-- <tr>
            <td>App code:</td>
            <td> <input type="text" name="app_code" id="employee_app_code"  value="<?php //echo $employee->getAppCode(); ?>"  size="25" /></td>
        </tr>
        <tr>
            <td>Is app registered:</td>
            <td><input type="checkbox" name="is_app_registered" id="employee_is_app_registered" value="1"  <?php // $varap = $employee->getIsAppRegistered();
             //   if (isset($varap) && $varap == 1) { ?>  checked="checked" <?php // } ?>  /> </td>
        </tr>
        <tr>
            <td>Password:</td>
            <td>  <input type="text" name="password" id="employee_password"  value="<?php // echo $employee->getPassword(); ?>"  size="25" /></td>
        </tr>-->
        <tr>
            <td style="padding: 5px;"><?php echo __('Product:') ?></td>
            <td style="padding: 5px;"> <select name="productid" id="employee_product_id"   class="required" >
<!--                    <option value="" selected="selected"></option>-->
<?php foreach ($products as $product) { ?>
                    <option value="<?php echo $pid = $product->getId(); ?>"   <?php $varp = $employee->getProductId();
                    if (isset($varp) && $varp == $pid) { ?>  selected="selected" <?php } ?>><?php echo $product->getName() ?></option>
<?php } ?>

                </select></td>
        </tr>
     <tr>
        <td style="padding: 5px;"><?php echo __('Voice Package:') ?></td>
        <td style="padding: 5px;"> <select name="pricePlanId" id="pricePlanId"    class="required"  >

      <?php foreach($pricePlans as $pricePlan){  ?>
                <option value="<?php echo $pricePlan->getId();  ?>" <?php echo $pricePlan->getId()==$employee->getPricePlanId() ?"selected='selected'":"";?>><?php echo $pricePlan->getTitle()   ?></option>
<?php   }  ?>
</select></td>
                </tr>

<!--        <tr>
            <td style="padding: 5px;">Product Price:</td>
            <td style="padding: 5px;"> <input type="text" name="price" id="employee_password"   class="required"  value="<?php //echo $employee->getProductPrice(); ?>"  size="25" />  </td>
        </tr>-->
        
    </table><ul class="sf_admin_actions">

  <li><input class="sf_admin_action_list" value="<?php echo __('list') ?>" type="button" onclick="document.location.href='../../../employee';" />
  </li><li><input type="submit" name="Update" value="<?php echo __('Update') ?>" class="sf_admin_action_save" /></li></ul> 
 </div>
</form>
</div>
