<?php use_helper('I18N') ?><center>
		<?php if($sf_user->hasFlash('message')): ?>
			<div class="message">
				<?php echo $sf_user->getFlash('message'); ?>
			</div>
		<?php endif; ?>
                
                    <?php include_partial('loginform', array('form' => $loginForm)) ?>
                
               

</center>