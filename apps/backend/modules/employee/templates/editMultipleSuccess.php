<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>

<div id="sf_admin_content">
    <div id="sf_admin_container">
        <?php if ($sf_user->hasFlash('message')): ?>
        <div class="save-ok">
            <h2><?php echo __($sf_user->getFlash('message')) ?></h2>
        </div>
        <?php endif; ?>
        <?php if ($count!=1): ?>
            <h1><?php echo  __('Select Agent') ?></h1>
        <?php endif; ?>
    </div>
        <div id="sf_admin_content">
        <?php if ($count!=1): ?>
        <form id="sf_admin_form" name="sf_admin_edit_form" method="post" enctype="multipart/form-data" action="editMultiple">
        <table id="sf_admin_container" cellspacing="0" cellpadding="2" class="tblAlign" >
              <tr>
                <td style="padding: 5px;" width="300px"><?php echo  __('Agent:') ?></td>
                <td style="padding: 5px;">
                    <select name="company_id" id="employee_company_id" class="required"  style="width:190px;">
                        <option value="">Select Agent</option>
                        <?php foreach($companys as $company){  ?>
                        <option value="<?php echo $company->getId(); ?>"<?php echo ($companyval==$company->getId())?"selected='selected'":''?>><?php echo $company->getName()   ?></option>
                        <?php   }  ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td class="bg-img" style="height: 0; width:700px;">
                    <div class="submitButton">
                        <button type="submit">GO</button>
                    </div>
                 </td>
            </tr>
            </table>
            </form>
            <?php endif; ?>
 <?php if($employees!=''){?>
            <form id="sf_admin_form" name="sf_admin_edit_form" method="post" enctype="multipart/form-data" action="editMultipleEmployee">
                <div id="sf_admin_container">
                    <h1><?php echo  __('Edit PCO Lines') ?></h1>
                </div>
            <table id="sf_admin_container" cellspacing="0" cellpadding="2" class="tblAlign" >
            <tr>
                <td style="padding: 5px;" width="50%"><?php echo __('Product:') ?></td>
                <td style="padding: 5px;">
                    <select name="productid" id="productid"    class="required"  >
                        <?php foreach($products as $product){  ?>
                        <option value="<?php echo $product->getId();   ?>"><?php echo $product->getName()   ?></option>
                        <?php   }  ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px;"><?php echo __('Voice Package:') ?></td>
                <td style="padding: 5px;"> <select name="pricePlanId" id="pricePlanId"    class="required"  >

                <?php foreach($priceplans as $priceplan){  ?>
                        <option value="<?php echo $priceplan->getId();  ?>"><?php echo $priceplan->getTitle()   ?></option>
                <?php   }  ?>
                </select></td>
            </tr>
            <tr>
                <td style="padding: 5px;"><?php echo __('Block:') ?></td>
                <td style="padding: 5px;">
                    <select name="block">
                        <option value="">Select One</option>
                        <option value="N">Unblock</option>
                        <option value="Y">Block</option>
                    </select>

                </td>
            </tr>
        </table>
       <br>
       <table width="75%" cellspacing="0" cellpadding="2" class="tblAlign">
        <tr class="headings">
            <th><input type="checkbox" id="selectall"  checked="checked"/></th>
            <th><?php echo __('Agent') ?></th>
            <th><?php echo __('Name') ?></th>
            <th><?php echo __('Product') ?></th>
            <th><?php echo __('Voice Package') ?></th>
            <th><?php echo __('Billing Account') ?></th>
            <th><?php echo __('Password') ?></th>
            <th><?php echo __('Block') ?></th>
         
        </tr>
        <?php
                $incrment=1;
                foreach ($employees as $employee):
                if($incrment%2==0){
                  $class= 'class="even"';
                }else{
                  $class= 'class="odd"';
                }
                $incrment++; ?>
        <tr <?php echo $class; ?>>
            <td><input type="checkbox" name="id[]"  class="case"   value="<?PHP echo $employee->getId();?>" checked="checked"></td>
            <td>
                <?php  $comid=$employee->getCompanyId();
                        if(isset($comid) && $comid!=""){
                            $c = new Criteria();
                            $c->add(CompanyPeer::ID, $employee->getCompanyId());
                            $companys = CompanyPeer::doSelectOne($c);
                            echo $companys->getName();
                        }
              ?>
            </td>
            <td><?php echo htmlspecialchars($employee->getFirstName()); ?></td>
            <td>
                <?php
                    $pid=$employee->getProductId();
                    if(isset($pid) && $pid!=""){
                        $c = new Criteria();
                        $c->add(ProductPeer::ID, $pid);
                        $products = ProductPeer::doSelectOne($c);
                        echo $products->getName();
                    }
              ?>
            </td>
            <td>
                <?php
                    $pp = new Criteria();
                    $pp->addAnd(PricePlanPeer::ID, $employee->getPricePlanId());
                    $priceplan = PricePlanPeer::doSelectOne($pp);
                    if($priceplan) echo $priceplan->getTitle();
              ?>
            </td>            
            <td><?php echo sfConfig::get("app_telinta_emp").$employee->getCompanyId().$employee->getId() ?></td>
            <td><?php echo  $employee->getPassword(); ?></td>
            <td><?php echo $employee->getBlock(); ?></td>
            
        </tr>
        <?php endforeach; ?>
      </table>
    
       <div id="sf_admin_container">
            <ul class="sf_admin_actions" style="text-align:left">
                <input type="hidden" value="<?php echo $count ?>" name="all_company">
                <li><input type="submit" name="save" value="<?php echo __('Save Changings') ?>" class="sf_admin_action_save" /></li>
            </ul>
        </div>
      </form>
    <?php }?>
     </div>
</div>