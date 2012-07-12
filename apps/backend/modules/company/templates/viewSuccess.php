<?php use_helper('I18N') ?><div id="sf_admin_container">
	<div id="sf_admin_content">
	<!-- employee/list?filters[company_id]=1 -->
	<a href="<?php echo url_for('employee/index').'?company_id='.$company->getId()."&filter=filter" ?>" class="external_link" target="_self"><?php echo  __('PCO Lines') ?> (<?php echo count($company->getEmployees()) ?>)</a>
	<a href="<?php echo url_for('company/usage').'?company_id='.$company->getId(); ?>" class="external_link" target="_self"><?php echo  __('Usage') ?></a>
        <a href="<?php echo url_for('company/paymenthistory').'?company_id='.$company->getId().'&filter=filter' ?>" class="external_link" target="_self"><?php echo  __('Payment History') ?></a>
	<!--
	<a onclick="companyShow();" style="cursor:pointer;">Company Info</a>
	&nbsp; | &nbsp;
	<a onclick="salesShow();" style="cursor:pointer;">Sales Activity</a>
	&nbsp; | &nbsp;
	<a onclick="supportShow();" style="cursor:pointer;">Support Activity</a>
	 -->
		<div id="company-info">
		    <h1><?php echo  __('Agent Details') ?></h1>
			<fieldset>
				<div class="form-row">
				  <label class="required"><?php echo  __('Agent Name:') ?></label>
				  <div class="content">
				  	<?php echo $company->getName() ?> &nbsp; <?php echo link_to(__('edit info'), 'company/edit?id='.$company->getId()) ?>
				  </div>
				</div>

	<div class="form-row">
				  <label class="required"><?php echo  __('Balance view:') ?> </label>
				  <div class="content"><?php
                                 echo $balance;
          echo " &euro;";
                           ?>
				   
				  </div>
				</div>
                            <div class="form-row">
				  <label class="required"><?php echo  __('Credit Limit:') ?></label>
				  <div class="content">
				  	<?php echo $company->getCreditLimit();     echo " &euro;";?>
				  </div>
				</div>
				<div class="form-row">
				  <label class="required"><?php echo  __('Vat Number:') ?></label>
				  <div class="content">
				  	<?php echo $company->getVatNo()?>
				  </div>
				</div>
                                <div class="form-row">
				  <label class="required"><?php echo  __('Password:') ?></label>
				  <div class="content">
				  	<?php echo $company->getPassword()?>
				  </div>
				</div>
				<div class="form-row">
				  <label class="required"><?php echo  __('Address:') ?></label>
				  <div class="content">
				  	<?php echo $company->getAddress() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Post Code:</label>
				  <div class="content">
				  	<?php echo $company->getPostCode() ?>
				  </div>
                                </div>

				<div class="form-row">
				  <label class="required"><?php echo  __('Country:') ?></label>
				  <div class="content">
				  	<?php echo $company->getCountry()?$company->getCountry()->getName():'N/A' ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required"><?php echo  __('City:') ?></label>
				  <div class="content">
				  	<?php echo $company->getCity()?$company->getCity()->getName():'N/A' ?>
				  </div>
				</div>


				<div class="form-row">
				  <label class="required"><?php echo  __('Contact Name:') ?></label>
				  <div class="content">
				  <?php echo $company->getContactName()?>
				  </div>
				</div>

                                <div class="form-row">
				  <label class="required"><?php echo  __('Contact e-mail:') ?></label>
				  <div class="content">
				  <?php echo $company->getEmail()?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required"><?php echo  __('Head Phone No:') ?></label>
				  <div class="content">
				  	<?php echo $company->getHeadPhoneNumber() ?>
				  </div>
				</div>


				<div class="form-row">
				  <label class="required"><?php echo  __('Fax Number:') ?></label>
				  <div class="content">
				  	<?php echo $company->getFaxNumber()?$company->getFaxNumber():'N/A' ?>
				  </div>
				</div>
				
				<div class="form-row">
				  <label class="required"><?php echo  __('Website:') ?></label>
				  <div class="content">
				  	<?php echo $company->getWebsite()?$company->getWebsite():'N/A' ?>
				  </div>
				</div>
 

				
				<div class="form-row">
				  <label class="required"><?php echo  __('Status:') ?></label>
				  <div class="content">
				  	<?php echo ''.$company->getStatus()?$company->getStatus():'N/A' ?>
				  </div>
				</div>
                                <div class="form-row">
				  <label class="required"><?php echo  __('Created Date:') ?></label>
				  <div class="content">
				  	<?php echo ''.date('Y-m-d',strtotime($company->getCreatedAt())); ?>
				  </div>
				</div>


			 		
				
<!--
				
				<div class="form-row">
				  <label class="required">Package:</label>
				  <div class="content">
				  	<?php //echo $company->getPackage()?$company->getPackage():'N/A' ?>
				  </div>
				</div>
				
				<div class="form-row">
				  <label class="required">Usage Discount %:</label>
				  <div class="content">
				  	<?php //echo $company->getUsageDiscountPc(). '%' ?>
				  </div>
				</div>		-->

                            

			</fieldset>
		</div>
	
	</div>
</div>