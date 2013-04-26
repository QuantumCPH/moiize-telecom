<div id="sf_admin_container"><h1><?php echo __('Change Line Quality') ?></h1></div>

<div class="borderDiv">
    <br/>
    <form action="<?php echo url_for(sfConfig::get('app_main_url').'company/changePackage')?>" name="frmChangePackage" method="post">
        <input type="hidden" name="lineid" value="<?php echo $employee->getId();?>" />
    <table cellpadding="8" cellspacing="0">
        <tr><th>Name:</th><td><?php echo $employee->getFirstName();?></td></tr>
        <tr><th>Current Line Quality:</th><td><?php echo $employee->getPricePlan()->getTitle();?></td></tr>
        <tr> 
            <th>Select Line Quality:</th>
            <td><select name="priceplan_id" class="floatnone required">
               <?php foreach($priceplans as $priceplan){ ?>
                    <option value="<?php echo $priceplan->getId();?>"><?php echo $priceplan->getTitle();?></option>
               <?php     
               }?></select>
            </td>
        </tr>
        <tr><th></th><td><input type="submit" name="submit" value="Update" /></td></tr>
    </table>
    </form>
    <div class="clr"></div>
</div>					