<?php use_helper('I18N') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <?php
        $va = new Criteria();
        $va->add(AgentCompanyPeer::ID, $sf_user->getAttribute('agent_company_id', '', 'agentsession'));
        $agent_company = AgentCompanyPeer::doSelectOne($va);
        ?>


        <link rel="shortcut icon" href="/favicon.ico" />
        <style>
            .error{
                color:!important:#F00000;
                margin-left:150px;
                color:#F00000;

            }

        </style>
        <script type="text/javascript">
            <!--
            // Copyright 2006-2007 javascript-array.com

            var timeout	= 500;
            var closetimer	= 0;
            var ddmenuitem	= 0;

            // open hidden layer
            function mopen(id)
            {
                // cancel close timer
                mcancelclosetime();

                // close old layer
                if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

                // get new layer and show it
                ddmenuitem = document.getElementById(id);
                ddmenuitem.style.visibility = 'visible';

            }
            // close showed layer
            function mclose()
            {
                if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
            }

            // go close timer
            function mclosetime()
            {
                closetimer = window.setTimeout(mclose, timeout);
            }

            // cancel close timer
            function mcancelclosetime()
            {
                if(closetimer)
                {
                    window.clearTimeout(closetimer);
                    closetimer = null;
                }
            }

            // close layer when click-out
            document.onclick = mclose;
            -->

        </script>
<?php use_javascript('jquery-1.4.2.min.js', '', array('absolute' => true)) ?>
        <?php if ($sf_user->getCulture() == 'en') {
 ?>
        <?php use_javascript('jquery.validate1.js', '', array('absolute' => true)) ?>
    

        <?php } else {
 ?>
        <?php use_javascript('jquery.validatede.js', '', array('absolute' => true)) ?>
<?php } ?>
    </head>
    <body>
        <div id="basic">
            <div id="header">
                <div class="logo">
<?php echo image_tag('/images/wls2-logo.png'); // link_to(image_tag('/images/logo.gif'), '@homepage');  ?>
                </div>
            </div>
            <div id="slogan">
                <h1><?php echo __('B2B Portal'); ?></h1>
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
                                echo link_to(__('Register a Customer'), '@customer_registration_step1', array('class' => 'subSelect'));
                            } else {
                                echo link_to(__('Register a Customer'), '@customer_registration_step1');
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

                        <li class="last"><?php echo link_to(__('Logout'), 'agentUser/logout'); ?></li>

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


<?php if ($sf_user->isAuthenticated()): ?>
                                        <div class="clr"></div>
                                        <p ><?php echo __('Provide this link to your customers while they signup with your reference.') ?>
                                            <a href="http://wls2.zerocall.com/b2c.php/signup/step1?ref=<?php echo $sf_user->getAttribute('agent_company_id', '', 'agentsession') ?>">
                        				http://wls2.zerocall.com/b2c.php/signup/step1?ref=<?php echo $sf_user->getAttribute('agent_company_id', '', 'agentsession') ?>
                                            </a>
                                        </p>
<?php endif; ?>

<?php echo $sf_content ?>
            </div>
            <!--     <div id="footer" class="grid_12">

                 </div>This is the footer-->
            <div class="clear"></div>
        </div>
    </body>
</html>
