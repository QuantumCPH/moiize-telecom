<div id="sf_admin_container">
	<div id="sf_admin_content">
		<div id="bank-info">
		    <h1>Agent company bank account details</h1>
			<fieldset>
				<div class="form-row">
				  <label class="required">Company Name:</label>
				  <div class="content">
				  	<?php echo $agent_bank->getAgentCompany() ?> &nbsp; <?php echo link_to('edit info', 'agent_bank/edit?id='.$agent_bank->getId()) ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Reg nr:</label>
				  <div class="content">
				  	<?php echo $agent_bank->getRegNr() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Account Number:</label>
				  <div class="content">
				  	<?php echo $agent_bank->getAccountNumber() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">created at:</label>
				  <div class="content">
				  	<?php echo $agent_bank->getCreatedAt() ?>
				  </div>
				</div>

			</fieldset>
		</div>
	</div>
</div>