 <form id="form1" action="<?php echo url_for('company/login') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>  
<div class="bg-img" >
        <div class="left"></div>
        <div class="centerImg"> 
            <h1><?php echo __('Log in to account') ?></h1>
            <h2><?php echo __("Provide your Vat No and Password");?></h2>
            <?php echo $form->renderGlobalErrors() ?>
            <div class="fieldName"> 
              <?php echo $form['vat_no']->renderLabel() ?>
              <span class="fieldError">        
                <?php echo $form['vat_no']->renderError() ?>
              </span>
                <div class="clr"></div>
            </div>
            <div class="Inputfield">    
               <?php echo $form['vat_no'] ?>
                <div class="clr"></div> 
            </div>
            <div class="fieldName"> 
              <?php echo $form['password']->renderLabel() ?>
              <span class="fieldError">        
                <?php echo $form['password']->renderError() ?>
              </span> <div class="clr"></div> 
            </div>
            <div class="Inputfield">    
               <?php echo $form['password'] ?>
                <div class="clr"></div> 
            </div>
            <div class="submitButton">
                 <button  type="submit"><?php echo __('login') ?></button>
            </div>     

    <div class="clr"></div>
    
    </div>
            <div class="right"></div>  
    </div>
</form>
      <a href="<?php sfConfig::get('app_main_url');?>findPassword" class="forgotUrl">Forgot Password?</a>      