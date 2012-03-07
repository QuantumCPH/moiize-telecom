<?php use_helper('I18N') ?>

 <form id="frm" action="<?php echo url_for('company/findPassword') ?>" method="post">  
<div class="bg-img" >
        <div class="left"></div>
        <div class="centerImg"> 
            <h1><?php echo __('Forgot Password?') ?></h1>
            <h2><?php echo __("Provide your Vat No");?></h2>
            <div class="fieldName"> 
              <label>Vat No</label>
              <span class="fieldError">   
                 
              </span>
                <div class="clr"></div>
            </div>
            <div class="Inputfield">    
               <input class="input"  type="text" name="vat_number" id="forgot_password_mobile" />
                <div class="clr"></div> 
            </div>
           
            <div class="submitButton">
                 <button  type="submit"><?php echo __('Submit') ?></button>
            </div>     

    <div class="clr"></div>
    <a href="<?php sfConfig::get('app_main_url');?>" class="forgotUrl">Cancel</a>
    </div>
            <div class="right"></div>  
    </div>
</form>
            
