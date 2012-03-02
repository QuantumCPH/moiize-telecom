<?php use_helper('I18N') ?>
<?php use_helper('Number') ?><div id="sf_admin_content">


<div id="sf_admin_container">
    <?php if ($sf_user->hasFlash('messageError')): ?>
        <div class="form-errors">
          <h2><?php echo __($sf_user->getFlash('messageError')) ?></h2>
        </div>
    <?php endif; ?>
<h1><?php echo  __('New My employee') ?></h1></div>
<form id="sf_admin_form" name="sf_admin_edit_form" method="post" enctype="multipart/form-data" action="saveEmployee">
    <div id="sf_admin_content">
  
    <table id="sf_admin_container" cellspacing="0" cellpadding="2" class="tblAlign" >
        <tr>
        <td style="padding: 5px;"><?php echo  __('First name:') ?></td>
        <td style="padding: 5px;"><input type="text" name="first_name" id="employee_first_name"  class="required"  size="25" /></td>
                </tr>

                 <tr>
        <td style="padding: 5px;"><?php echo  __('Company:') ?></td>
        <td style="padding: 5px;">
  <select name="company_id" id="employee_company_id"    class="required"  style="width:190px;">
   
      <?php foreach($companys as $company){  ?>
<option value="<?php echo $company->getId(); ?>"<?php echo ($companyval==$company->getId())?"selected='selected'":''?>><?php echo $company->getName()   ?></option>
<?php   }  ?>
</select>  </td>
                </tr>
<!--                  <tr>
        <td style="padding: 5px;"><?php echo  __('Country Code:') ?></td>
        <td style="padding: 5px;"> <input type="text" name="country_code" id="employee_country_code"   size="25"   class="required digits" /> </td>
                </tr>-->


<!--                 <tr>
        <td style="padding: 5px;"><?php echo  __('Rese number:') ?></td>
        <td style="padding: 5px;">
  <select name="registration_type" id="employee_registration_type">
         <option value="0"><?php echo  __('no') ?></option>
      <option value="1"><?php echo  __('yes') ?></option>
    
</select> </td>
                </tr>-->
  <!--<tr>
        <td>App code:</td>
        <td> <input type="text" name="app_code" id="employee_app_code" value="" size="25" /></td>
                </tr>
   <tr>
        <td>Is app registered:</td>
        <td><input type="checkbox" name="is_app_registered" id="employee_is_app_registered" value="1" /> </td>
                </tr>
             <tr>
        <td>Password:</td>
        <td>  <input type="text" name="password" id="employee_password" value="" size="25" /></td>
                </tr>    <tr>
        <td style="padding: 5px;">Product Price:</td>
        <td style="padding: 5px;"> <input type="text" name="price" id="employee_password"   size="25" />  </td>
                </tr>-->
                  <tr>
        <td style="padding: 5px;"><?php echo __('Product:') ?></td>
        <td style="padding: 5px;"> <select name="productid" id="productid"    class="required"  >
<!--      <option value="" selected="selected"></option>-->
      <?php foreach($products as $product){  ?>
<option value="<?php echo $product->getId();   ?>"><?php echo $product->getName()   ?></option>
<?php   }  ?>
</select></td>
                </tr>
    </table>
        <div id="sf_admin_container">
            <ul class="sf_admin_actions"><input type="hidden" value="" id="error" name="error">

  <li>  <input class="sf_admin_action_list" value="<?php echo __('list') ?>" type="button" onclick="document.location.href='../employee';" /></li>
  <li><input type="submit" name="save" value="<?php echo __('save') ?>" class="sf_admin_action_save" /> </li>

</ul> </div>
    </div>
</form>
</div>