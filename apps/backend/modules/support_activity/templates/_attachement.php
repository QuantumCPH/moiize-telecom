<?php if($support_activity->getFilePath()): ?>
	<a href="<?php echo public_path('/uploads/'.$support_activity->getFilePath()) ?>" target="_blank">download attachement</a>
	
<?php else: ?>
	none
<?php endif; ?>