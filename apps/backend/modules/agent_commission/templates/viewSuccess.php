<div id="sf_admin_container">
	<div id="sf_admin_content">

        <a onclick="companyShow();" style="cursor:pointer;">Company Info</a>
	&nbsp; | &nbsp;
	<a onclick="showUsers();" style="cursor:pointer;">User info</a>
	&nbsp; | &nbsp;
	<a onclick="showCommission();" style="cursor:pointer;">Commission info</a>
        &nbsp; | &nbsp;
	<a onclick="showBank();" style="cursor:pointer;">Bank info</a>
        
		<div id="company-info">
		    <h1>agent company details</h1>
			<fieldset>
				<div class="form-row">
				  <label class="required">Company Name:</label>
				  <div class="content">
				  	<?php echo $agent_company->getName() ?> &nbsp; <?php echo link_to('edit info', 'agent_company/edit?id='.$agent_company->getId()) ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">CVR Number:</label>
				  <div class="content">
				  	<?php echo $agent_company->getCVRNumber() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Address:</label>
				  <div class="content">
				  	<?php echo $agent_company->getAddress() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Post Code:</label>
				  <div class="content">
				  	<?php echo $agent_company->getPostCode() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Country:</label>
				  <div class="content">
				  	<?php echo $agent_company->getCountry()->getName() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">City:</label>
				  <div class="content">
				  	<?php echo $agent_company->getCity()->getName() ?>
				  </div>
				</div>

                                <div class="form-row">
				  <label class="required">contact name:</label>
				  <div class="content">
				  	<?php echo $agent_company->getContactName() ?>
				  </div>
				</div>

                                <div class="form-row">
				  <label class="required">contact email:</label>
				  <div class="content">
				  	<?php echo $agent_company->getEmail() ?>
				  </div>
				</div>


				<div class="form-row">
				  <label class="required">Head Phone Nr:</label>
				  <div class="content">
				  	<?php echo $agent_company->getHeadPhoneNumber() ?>
				  </div>
				</div>


				<div class="form-row">
				  <label class="required">Fax Number:</label>
				  <div class="content">
				  	<?php echo $agent_company->getFaxNumber() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">company form:</label>
				  <div class="content">
				  	<?php echo ''.$agent_company->getCompanyForm() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Product Details:</label>
				  <div class="content">
				  	<?php echo ''.$agent_company->getProductDetail() ?>
				  </div>
				</div>

                                <div class="form-row">
				  <label class="required">Commission period:</label>
				  <div class="content">
				  	<?php echo ''.$agent_company->getCommissionPeriod() ?>
				  </div>
				</div>

                                <div class="form-row">
				  <label class="required">Account Manager:</label>
				  <div class="content">
				  	<?php echo ''.$agent_company->getAccountManager() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Registered at:</label>
				  <div class="content">
				  	<?php echo $agent_company->getCreatedAt() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">total reg. users</label>
				  <div class="content">
				  	<?php echo count($agent_company->getAgentUsers()) ?> &nbsp; <?php echo link_to('view list', 'agent_user/list', array('query_string' => 'filter=filter&filters[company_id]='.$agent_company->getId())) ?>
				  </div>
				</div>
			</fieldset>
		</div>
                <div id="user-info" style="display:none;">
                     <h1>agent company users list</h1>
			<?php echo javascript_tag(
                            remote_function(array(
                            'update'  => 'user-info',
                            'url'     => 'agent_user/list?filter=filter&filters[agent_company_id]='.$agent_company->getId() ,
                            ))
                        ) ?>
                </div>
                <div id="commission-info" style="display:none;">
                    <?php echo javascript_tag(
                            remote_function(array(
                            'update'  => 'commission-info',
                            'url'     => 'agent_commission/list?filter=filter&filters[agent_company_id]='.$agent_company->getId() ,
                            ))
                        ) ?>
                </div>
        
                <div id="bank-info" style="display:none;">
                    <?php echo javascript_tag(
                            remote_function(array(
                            'update'  => 'bank-info',
                            'url'     => 'agent_bank/view?id='.$agent_company->getId() ,
                            ))
                        ) ?>
                </div>
	</div>
</div>
<script type="text/javascript">
		function companyShow() {
		  var companyShow = document.getElementById("company-info");
		  var userInfo = document.getElementById("user-info");
		  var commissionInfo = document.getElementById("commission-info");
                  var bankInfo = document.getElementById("bank-info");

		  companyShow.style.display = "block";
		  userInfo.style.display = "none";
		  commissionInfo.style.display = "none";
                  bankInfo.style.display = "none";

		};

		function showUsers() {
		  var companyShow = document.getElementById("company-info");
		  var userInfo = document.getElementById("user-info");
		  var commissionInfo = document.getElementById("commission-info");
                  var bankInfo = document.getElementById("bank-info");

		  companyShow.style.display = "none";
		  userInfo.style.display = "block";
		  commissionInfo.style.display = "none";
                  bankInfo.style.display = "none";

		};

		function showCommission() {
		  var companyShow = document.getElementById("company-info");
		  var userInfo = document.getElementById("user-info");
		  var commissionInfo = document.getElementById("commission-info");
                  var bankInfo = document.getElementById("bank-info");

		  companyShow.style.display = "none";
		  userInfo.style.display = "none";
		  commissionInfo.style.display = "block";
                  bankInfo.style.display = "none";
		};

                function showBank() {
		  var companyShow = document.getElementById("company-info");
		  var userInfo = document.getElementById("user-info");
		  var commissionInfo = document.getElementById("commission-info");
                  var bankInfo = document.getElementById("bank-info");

		  companyShow.style.display = "none";
		  userInfo.style.display = "none";
		  commissionInfo.style.display = "none";
                  bankInfo.style.display = "block";
		};
</script> 