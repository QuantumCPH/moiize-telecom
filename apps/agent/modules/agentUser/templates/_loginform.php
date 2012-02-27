 <form id="form1" action="<?php echo url_for('agentUser/login') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>  
<div class="bg-img" >
        <div class="left"></div>
        <div class="centerImg"> 
            <h1><?php echo __('Log in to account') ?></h1>
            <h2><?php echo __("provide your email and password");?></h2>
            <?php echo $form->renderGlobalErrors() ?>
            <div class="fieldName"> 
              <?php echo $form['username']->renderLabel() ?>
              <span class="fieldError">        
                <?php echo $form['username']->renderError() ?>
              </span>
                <div class="clr"></div>
            </div>
            <div class="Inputfield">    
               <?php echo $form['username'] ?>
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
            