<?php use_helper('I18N') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
    
  <body>
        <div id="basic">
            <div id="header">
                <div class="logo">
<?php echo image_tag('/images/wls2-logo.png'); // link_to(image_tag('/images/logo.gif'), '@homepage');  ?>
                </div>
            </div>
            <div id="slogan">
                <h1><?php echo __('CRM/Billing/Agent Portal'); ?></h1>
<?php if ($sf_user->getAttribute('username', '', 'agentsession')) { ?>
                <div id="loggedInUser">
                    <?php echo __('Logged in as:') ?><b>&nbsp;<?php echo $sf_user->getAttribute('username', '', 'agentsession') ?></b><br />
                    <?php
                    if ($agent_company) {
                        if ($agent_company->getIsPrepaid()) {
 ?>
                    <?php echo __('Your Balance is:') ?> <b><?php echo $agent_company->getBalance(); ?></b>
                    <?php } ?>
<?php } ?>
                </div>
<?php } ?>

                <div style="vertical-align: top;float: right;margin-right: 10px;">

<?php echo link_to(image_tag('/images/german.png'), 'affiliate/changeCulture?new=de'); ?>

<?php echo link_to(image_tag('/images/english.png'), 'affiliate/changeCulture?new=en'); ?>

                </div>
                <div class="clr"></div>
            </div>

            <?php
//                $enableCountry = new Criteria();
//                $enableCountry->add(EnableCountryPeer::STATUS, '1');
//
//                $form = new sfFormLanguage(
//                $sf_user,
//                array('languages' => array('en', 'da','pl','sv'))
//                );
//                $widgetSchema = $form->getWidgetSchema();
//                $widgetSchema['language']->setAttribute('style', "width:85px");
//                $widgetSchema['language']->setAttribute('onChange', "this.form.submit();");
//                $widgetSchema['language']->setAttribute('onChange', "this.form.submit();");
//                $widgetSchema['language']->setLabel(false);
            ?>
                <!--                <div style="position:absolute; left: 846px; top: 54px;">
                                  <form action="">
            <?php echo $form; ?>
                                    <input type="hidden" value="<?php echo $sf_user->getAttribute('product_ids') ?>" name="pid" />
                                    <input type="hidden" value="<?php echo $sf_user->getAttribute('cusid') ?>" name="cid" />
                                </form>
                                </div>-->

                <div class="clr"></div>
                <div id="menu">
                    <!--                <h1>menu</h1>-->
                <?php
                if ($sf_user->isAuthenticated()) {
                    $modulName = $sf_context->getModuleName();
                    $actionName = $sf_context->getActionName();
                    // print_r($request->getPathInfoArray());
//     echo 'M '.$modulName;
//     echo '<br />';
//     echo 'A '.$actionName;
                    //var_dump($sf_context);
                    //die;
                    //$routing = $sf_context->getInstance()->getRouting();
                    //echo $routing;
                ?>
                    <ul id="sddm">
                        <li>
                        <?php
                        if ($actionName == 'report' && $modulName == "affiliate" && $sf_request->getParameter('show_summary') == 1) {
                            echo link_to(__('Overview'), 'affiliate/report?show_summary=1', array('class' => 'current'));
                        } else {
                            echo link_to(__('Overview'), 'affiliate/report?show_summary=1');
                        }
                        ?>
                    </li>
                    <li><a onmouseover="mopen('m2')" onmouseout="mclosetime()" href="#" onclick="return false;"
                            <?php echo $actionName == 'registerCustomer' || $actionName == 'setProductDetails' || $actionName == 'refill' ? 'class="current"' : ''; ?>><?php echo __('Services'); ?></a>
                        <div id="m2" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
                            <?php
                            if ($modulName == "affiliate" && $actionName == 'registerCustomer' || $actionName == 'setProductDetails') {
                                echo link_to(__('Register a Customer'), '/', array('class' => 'subSelect'));
                            } else {
                                echo link_to(__('Register a Customer'), '/');
                            }

                            if ($modulName == "affiliate" && $actionName == 'refill') {
                                echo link_to(__('Refill'), 'affiliate/refill', array('class' => 'subSelect'));
                            } else {
                                echo link_to(__('Refill'), 'affiliate/refill');
                            }
                            ?>
                        </div>
                    </li>
                    <li><?php
                            if ($modulName == "affiliate" && $actionName == 'receipts') {
                                echo link_to(__('Receipts'), 'affiliate/receipts', array('class' => 'current'));
                            } else {
                                echo link_to(__('Receipts'), 'affiliate/receipts');
                            }
                            ?></li>

                        <li><?php
                            //echo ');
                            if ($modulName == "affiliate" && $actionName == 'report' && $sf_request->getParameter('show_details') == 1) {
                                echo link_to(__('My Earnings'), 'affiliate/report?show_details=1', array('class' => 'current'));
                            } else {
                                echo link_to(__('My Earnings'), 'affiliate/report?show_details=1');
                            }
                            ?></li>
                        <li><?php
                            if ($modulName == "agentcompany" && $actionName == 'view' || $actionName == 'accountRefill' || $actionName == 'agentOrder' || $actionName == 'paymentHistory') {
                                echo link_to(__('My Company Info'), 'agentcompany/view', array('class' => 'current'));
                            } else {
                                echo link_to(__('My Company Info'), 'agentcompany/view');
                            }
                            ?></li>
    <!--                    <li><?php //echo link_to(__('Package Conversion'), 'affiliate/conversionform'); ?></li>-->
                        <li><?php
                            if ($modulName == "affiliate" && $actionName == 'supportingHandset') {
                                echo link_to(__('Supporting Handsets'), 'affiliate/supportingHandset', array('class' => 'current'));
                            } else {
                                echo link_to(__('Supporting Handsets'), 'affiliate/supportingHandset');
                            }
                            ?></li>
                        <li><?php
                            if ($modulName == "affiliate" && $actionName == 'userguide') {
                                echo link_to(__('User Guide'), 'affiliate/userguide', array('class' => 'current'));
                            } else {
                                echo link_to(__('User Guide'), 'affiliate/userguide');
                            }
                            ?></li>
                        <li><?php
                            if ($modulName == "affiliate" && $actionName == 'faq') {
                                echo link_to(__('FAQ'), 'affiliate/faq', array('class' => 'current'));
                            } else {
                                echo link_to(__('FAQ'), 'affiliate/faq');
                            }
                            ?></li>

                        <li class="last"><?php echo link_to(__('Logout'), 'Company/logout'); ?></li>

                    </ul>
<?php } ?>
                <div class="clr"></div>
            </div>
            <div id="content">
<?php if ($sf_user->hasFlash('message')): ?>
                            <div id="info-message" class="grid_9 save-ok">
<?php echo $sf_user->getFlash('message'); ?>
                            </div>
<?php endif; ?>


<?php if ($sf_user->hasFlash('decline')): ?>
                                <div id="info-message" class="grid_9 save-decl">
<?php echo $sf_user->getFlash('decline'); ?>
                                </div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>
                                    <div id="error-message" class="grid_9 save-ok">
<?php echo $sf_user->getFlash('error'); ?>
                                    </div>
<?php endif; ?>

 

<?php echo $sf_content ?>
            </div>
            <!--     <div id="footer" class="grid_12">

                 </div>This is the footer-->
            <div class="clear"></div>
        </div>

  
  </body>
</html>
