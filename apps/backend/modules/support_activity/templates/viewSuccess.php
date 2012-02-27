
<div id="sf_admin_container">
	<div id="sf_admin_content">
		<div id="company-info">
		    <h1>Support Activity Details</h1>
			<fieldset>
				<div class="form-row">
				  <label class="required">Employee Name:</label>
				  <div class="content">
				  	<?php echo $support_activity->getEmployee()?($support_activity->getEmployee()->getLastName() . $support_activity->getEmployee()->getFirstName()):'N/A' ?> &nbsp; <?php echo link_to('edit info', 'support_activity/edit?id='.$support_activity->getId()) ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Ticket Number:</label>
				  <div class="content">
				  	<?php echo ($support_activity->getTicketNumber()?$support_activity->getTicketNumber():'N/A') ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Support Issue:</label>
				  <div class="content">
				  	<?php echo ($support_activity->getSupportIssue()?$support_activity->getSupportIssue()->getName():'N/A') ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Comment</label>
				  <div class="content">
				  	<?php echo $support_activity->getComment() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Solution</label>
				  <div class="content">
				  	<?php echo $support_activity->getSolution() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Attachments:</label>
				  <div class="content">
				  	<?php if ($support_activity->getFilePath()): ?>
				  			<a href="<?php echo public_path('/uploads/'.$support_activity->getFilePath()) ?>" target="_blank">download</a>
				  	<?php endif; ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Created at:</label>
				  <div class="content">
				  	<?php echo $support_activity->getCreatedAt() ?>
				  </div>
				</div>
			</fieldset>
		</div>
	</div>
</div>