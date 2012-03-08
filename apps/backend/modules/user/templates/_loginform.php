<?php use_helper('I18N') ?><?php //if($request->getMethod() != 'post') $is_postback = true; ?>

<div style="">
<form id="form1" action="<?php echo url_for('user/login') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>  

    <?php echo $form->renderGlobalErrors() ?>
    <div class="bg-img" >
        <div class="left"></div>
        <div class="centerImg">        
            <h1>
               <?php echo __("Administrator Login");?>
            </h1>
            <h2><?php echo __("Provide your email and password");?></h2>
            
            <div class="fieldName"> 
           <?php echo $form['email']->renderLabel() ?>
                <?php
	      if(($sf_request->getMethod()=='POST')){
            ?>
            <span class="fieldError">    
             <?php   echo $form['email']->renderError();   ?>
            </span>
            <?php
              }
	     ?>
            </div>
            <div class="Inputfield">
            <?php echo $form['email'] ?>
            </div>
             
            
            <div class="fieldName"> 
                  <?php echo $form['password']->renderLabel() ?>
           <?php
            if(($sf_request->getMethod()=='POST')){ ?>
            <span class="fieldError"> 
            	<?php echo $form['password']->renderError() ?>                
            </span>  
             <?php } ?> 
            </div>
            <div class="Inputfield">
            <?php echo $form['password'] ?>
            <?php // echo input_hidden_tag('referer', $_SERVER["HTTP_REFERER"])  ?>
            </div>
              
            <div class="submitButton">
                <button  type="submit"><?php echo __('Login') ?></button>
            </div>
            <span class="powered">Powered by <a href="http://zapna.com/" target="_blank">Zapna</a></span>
        </div>
            <div class="right"></div>  
    </div>
</form>
</div>
<div class="clear"></div>