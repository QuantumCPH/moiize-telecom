<div id="sf_admin_container">
    <div id="sf_admin_content">
        <!-- employee/list?filters[company_id]=1 -->
        <a href="<?php echo url_for('employee/usage') . '?employee_id=' . $employee->getId(); ?>" class="external_link" target="_self"><?php echo __('Usage') ?></a>

    </div></div>
<div id="sf_admin_container">
    <div id="sf_admin_content">
        <div id="company-info">
            <h1><?php echo __('PCO Lines Details') ?></h1>
            <fieldset>
                <div class="form-row">
                    <label class="required"><?php echo __('Name:') ?></label>
                    <div class="content">
                        <?php echo $employee->getFirstName() . " " . $employee->getLastName(); ?> &nbsp; <?php echo link_to(__('edit info'), 'employee/edit?id=' . $employee->getId()) ?>
                    </div>
                </div>

                <div class="form-row">
                    <label class="required"><?php echo __('Agent:') ?></label>
                    <div class="content">
                        <?php echo ($employee->getCompany() ? $employee->getCompany() : 'N/A') ?>
                    </div>
                </div>

                <div class="form-row">
                    <label class="required"><?php echo __('Balance:') ?></label>
                    <div class="content">
                        <?php
                        echo (float) $balance;
                        echo " &euro;";
                        ?>
                    </div>
                </div>
                <div class="form-row">
                    <label class="required"><?php echo __('Product:') ?></label>
                    <div class="content">
                        <?php
                        $pidd = $employee->getProductId();

                        $pid = new Criteria();
                        $pid->add(ProductPeer::ID, $pidd);
                        $product = ProductPeer::doSelectOne($pid);

                        echo $product->getName();
                        ?>
                    </div>
                </div>
                <div class="form-row">
                    <label class="required"><?php echo __('Line Quality:') ?></label>
                    <div class="content">
                        <?php
                        $ppid = $employee->getPricePlanId();
                        if($ppid !=""){
                            $pp = new Criteria();
                            $pp->add(PricePlanPeer::ID,$ppid);
                            $pricePlan = PricePlanPeer::doSelectOne($pp);
                            echo $pricePlan->getTitle();
                        }
                        ?>
                    </div>
                </div>

                <?php
//                           $empid=$employee->getRegistrationType();
//                          if(isset($empid) && $empid==1){ ?>

                        <!--                            <div class="form-row">
                				  <label class="required"><?php //echo __('Resenumber:')  ?></label>
                				  <div class="content">
                <?php
                        //  $voip = new Criteria();
//        $voip->addAnd(SeVoipNumberPeer::CUSTOMER_ID, $employee->getCountryMobileNumber());
//        $voipv = SeVoipNumberPeer::doSelectOne($voip);
//
//                         echo $voipv->getNumber(); ?>
                				  </div>
                				</div>-->


                <?php //}  ?>



                        <div class="form-row">
                            <label class="required"><?php echo __('Created at:') ?></label>
                            <div class="content">
                        <?php echo $employee->getCreatedAt() ?>
                    </div>
                </div>

            </fieldset>
        </div>
    </div>
</div>