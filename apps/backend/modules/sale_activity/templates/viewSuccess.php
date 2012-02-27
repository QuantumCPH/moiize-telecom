
<div id="sf_admin_container">
	<div id="sf_admin_content">
		<div id="company-info">
		    <h1>Support Activity Details</h1>
			<fieldset>
				<div class="form-row">
				  <label class="required">Employee Name:</label>
				  <div class="content">
				  	<?php echo $sale_activity->getCompany()?$sale_activity->getCompany()->getName():'N/A' ?> &nbsp; <?php echo link_to('edit info', 'sale_activity/edit?id='.$sale_activity->getId()) ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Ticket Number:</label>
				  <div class="content">
				  	<?php echo ($sale_activity->getTicketNumber()?$sale_activity->getTicketNumber():'N/A') ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Sale Action:</label>
				  <div class="content">
				  	<?php echo ($sale_activity->getSaleAction()?$sale_activity->getSaleAction()->getName():'N/A') ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Comment</label>
				  <div class="content">
				  	<?php echo $sale_activity->getComment() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Attachments:</label>
				  <div class="content">
				  	<?php if ($sale_activity->getFilePath()): ?>
				  			<a href="<?php echo public_path('/uploads/'.$sale_activity->getFilePath()) ?>" target="_blank">download</a>
				  	<?php endif; ?>
				  </div>
				</div>
				
				<div class="form-row">
				  <label class="required">Assigned to:</label>
				  <div class="content">
				  	<?php echo $sale_activity->getUser()?$sale_activity->getUser()->getName():'Not yet assigned to anyone' ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Created at:</label>
				  <div class="content">
				  	<?php echo $sale_activity->getCreatedAt() ?>
				  </div>
				</div>
			</fieldset>
		</div>
	</div>
</div>