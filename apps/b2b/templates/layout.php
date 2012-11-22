<?php use_helper('I18N') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="<?php echo sfConfig::get("app_web_url");?>images/favicon.ico" type="image/x-icon" />
    </head>

    <body>
        <div id="basic">
            <?php if($_SERVER["HTTP_REFERER"]!="http://mw.zerocall.com/login/"):?>
            <div id="header">
                <div class="logo">
                    <?php echo image_tag('/images/logo.jpg'); // link_to(image_tag('/images/logo.gif'), '@homepage');  ?>
                </div>
            </div>
            <?php endif;?>
            <div id="slogan">
                
                <?php if ($sf_user->getAttribute('username', '', 'agentsession')) {
                ?>
                <h1><?php echo __('Agent Portal'); ?></h1>
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
            
                <!--                <h1>menu</h1>-->
                <?php
                    if ($sf_user->isAuthenticated()) {
                        $modulName = $sf_context->getModuleName();
                        $actionName = $sf_context->getActionName();
//                        echo "M ".$modulName;
//                        echo "<br />";
//                        echo "A ".$actionName;
                ?><div id="menu">
                        <ul id="sddm">
                            <li>
                        <?php
                        if ($actionName == 'dashboard' && $modulName == "company") {
                        ?>
                            <a href="<?php echo sfConfig::get('app_main_url');?>company/dashboard" class="current"><?php echo  __('Dashboard');?></a>
                        <?php    
                        } else {
                        ?>
                            <a href="<?php echo sfConfig::get('app_main_url');?>company/dashboard"><?php echo  __('Dashboard');?></a>
                        <?php    
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        if ($modulName == "company" && $actionName == 'paymentHistory') {
                        ?>
                            <a href="<?php echo sfConfig::get('app_main_url');?>company/paymentHistory" class="current"><?php echo  __('Payment History');?></a>
                        <?php     
                        } else {
                        ?>
                            <a href="<?php echo sfConfig::get('app_main_url');?>company/paymentHistory"><?php echo  __('Payment History');?></a>
                        <?php  
                        }
                        ?>
                    </li>
                    <li><?php
                        if ($modulName == "company" && $actionName == 'callHisotry') {
                        ?>
                            <a href="<?php echo sfConfig::get('app_main_url');?>company/callHisotry" class="current"><?php echo  __('Call History');?></a>
                        <?php 
                        } else {
                        ?>
                            <a href="<?php echo sfConfig::get('app_main_url');?>company/callHisotry"><?php echo  __('Call History');?></a>
                        <?php 
                        }
                        ?>
                    </li>
                    <li><?php
                        if ($modulName == "company" && $actionName == 'view') {
                        ?>
                            <a href="<?php echo sfConfig::get('app_main_url');?>company/view" class="current"><?php echo  __('Agent Info');?></a>
                        <?php    
                        } else {
                        ?>
                            <a href="<?php echo sfConfig::get('app_main_url');?>company/view"><?php echo  __('Agent Info');?></a>
                        <?php     
                        }
                        ?>
                    </li>
                    <li><?php
                        if ($modulName == "rates" && $actionName == 'company') {
                        ?>
                            <a href="<?php echo sfConfig::get('app_main_url');?>company/rates" class="current"><?php echo  __('Rates');?></a>
                        <?php 
                        } else {
                        ?>
                            <a href="<?php echo sfConfig::get('app_main_url');?>company/rates" ><?php echo  __('Rates');?></a>
                        <?php 
                        }
                        ?>
                    </li>
                    <li class="last"><a href="<?php echo sfConfig::get('app_main_url');?>company/logout" ><?php echo  __('Logout');?></a></li>

                </ul><div class="clr"></div>
                </div>
                <?php } ?>
                    
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
