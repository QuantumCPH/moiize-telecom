<?php use_helper('I18N') ?>
<?php use_helper('Number') ?><?php /*if($sf_user->hasFlash('message')){ ?>


<div class="save-ok">
<h2><?PHP echo __($sf_user->getFlash('message'));?> </h2>
</div>
  
<?php    }*/   ?>

<div id="sf_admin_container"><h1><?php echo __('Charge') ?></h1></div>

<form id="sf_admin_form" name="sf_admin_edit_form" method="post" enctype="multipart/form-data" action="AgentCharge">
    <div id="sf_admin_content">
    <table style="padding: 0px;"  id="sf_admin_container" class="tblAlign" cellspacing="0" cellpadding="2" >
    <tr>
        <td style="padding: 5px;"><?php echo __('Agent:') ?></td>
        <td style="padding: 5px;">
            <select name="company_id" id="employee_company_id"    class="required"  style="width:190px;">
           
            <?php foreach($companys as $company){  ?>
            <option value="<?php echo $company->getId();   ?>"><?php echo $company->getName()   ?></option>
            <?php   }  ?>
            </select>
        </td>
    </tr>
        <tr>
        <td style="padding: 5px;"><?php echo __('Charge') ?>(&euro;):</td>
        <td style="padding: 5px;">
            <input type="text" id="refill" name="refill" class="required decimal" style="width:180px;">
            
        </td>
    </tr>
    <tr>
        <td style="padding: 5px;"><?php echo __('Description') ?>:</td>
        <td style="padding: 5px;">
            
            <select name="descriptionId" id="descriptionId" class="required"  style="width:190px;">
            <?php   if($transactionDesc){
                      foreach($transactionDesc as $description){  ?>
                        <option value="<?php echo $description->getId();   ?>"><?php echo $description->getTitle();   ?></option>
            <?php     }
                   }
            ?>
            </select>
        </td>
    </tr>
    </table>
        <div id="sf_admin_container">
          <ul class="sf_admin_actions">
              
           <li><input type="submit" name="save" value="<?php echo __('save') ?>" class="sf_admin_action_save" /></li>
           </ul>
        </div>
    </div>
    </form>
