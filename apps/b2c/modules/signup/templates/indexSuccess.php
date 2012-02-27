<?php
	use_helper('I18N');
	
	echo $form->renderGlobalErrors();
	
	include_partial("step_$step", array('form'=>$form));
?>