<?php
	use_helper('I18N');
	
	echo $form->renderGlobalErrors();
	
	include_partial("step_1", array('form'=>$form));
?>