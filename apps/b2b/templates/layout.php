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
                    <?php echo image_tag('/images/logo1.jpg'); // link_to(image_tag('/images/logo.gif'), '@homepage');  ?>
                </div>
            </div>
            <div id="slogan">
                <h1><?php echo __('Agent Portal'); ?></h1>
                <?php if ($sf_user->getAttribute('username', '', 'agentsession')) {
                ?>
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

                    <div style="vertical-align: top;float: right;margin-right: 10px;display: none;">

                    <?php echo link_to(image_tag('/images/german.png'), 'affiliate/changeCulture?new=de'); ?>

                    <?php echo link_to(image_tag('/images/english.png'), 'affiliate/changeCulture?new=en'); ?>

                   </div>
                <div class="clr"></div>
            </div>



            <div class="clr"></div>
            <div id="menu">
                <!--                <h1>menu</h1>-->
                <?php
                    if ($sf_user->isAuthenticated()) {
                        $modulName = $sf_context->getModuleName();
                        $actionName = $sf_context->getActionName();
//                        echo "M ".$modulName;
//                        echo "<br />";
//                        echo "A ".$actionName;
                ?>
                        <ul id="sddm">
                            <li>
                        <?php
                        if ($actionName == 'dashboard' && $modulName == "company") {
                            echo link_to(__('Dashboard'), 'company/dashboard', array('class' => 'current'));
                        } else {
                            echo link_to(__('Overview'), 'company/dashboard');
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        if ($modulName == "company" && $actionName == 'paymentHistory') {
                            echo link_to(__('Payment History'), 'company/paymentHistory', array('class' => 'current'));
                        } else {
                            echo link_to(__('Payment History'), 'company/paymentHistory');
                        }
                        ?>
                    </li>
                    <li><?php
                        if ($modulName == "company" && $actionName == 'callHisotry') {
                            echo link_to(__('Call History'), 'company/callHisotry', array('class' => 'current'));
                        } else {
                            echo link_to(__('Call History'), 'company/callHisotry');
                        }
                        ?>
                    </li>
                    <li><?php
                        if ($modulName == "company" && $actionName == 'view') {
                            echo link_to(__('Agent Info'), 'company/view', array('class' => 'current'));
                        } else {
                            echo link_to(__('Agent Info'), 'company/view');
                        }
                        ?>
                    </li>
                    <li><?php
                        if ($modulName == "rates" && $actionName == 'company') {
                            echo link_to(__('Rates'), 'company/rates', array('class' => 'current'));
                        } else {
                            echo link_to(__('Rates'), 'company/rates');
                        }
                        ?>
                    </li>
                    <li class="last"><?php echo link_to(__('Logout'), 'company/logout'); ?></li>

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
