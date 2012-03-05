<?php use_helper('I18N') ?>
<div id="sf_admin_container">
    <div id="sf_admin_content">
        <div id="company-info">
            <h1><?php echo __('Agent details') ?></h1>
            <fieldset>
                <div class="form-row">
                    <label class="required"><?php echo __('Agent Name:') ?></label>
                    <div class="content">
                        <?php echo $company->getName() ?>
                    </div>
                </div>

                <div class="form-row">
                    <label class="required"><?php echo __('Balance view:') ?> </label>
                    <div class="content"><?php
                        echo $balance;
                        echo "&euro;";
                        ?>

                    </div>
                </div>
                <div class="form-row">
                    <label class="required"><?php echo __('Number of PCO Lines:') ?> </label>
                    <div class="content"><?php
                        echo $employeesCount;
                        ?>

                    </div>
                </div>
                <div class="form-row">
                    <label class="required"><?php echo __('Vat Number:') ?></label>
                    <div class="content">
<?php echo $company->getVatNo() ?>
                    </div>
                </div>

                <div class="form-row">
                    <label class="required"><?php echo __('Address:') ?></label>
                    <div class="content">
<?php echo $company->getAddress() ?>
                    </div>
                </div>

                <div class="form-row">
                    <label class="required">Post Code:</label>
                    <div class="content">
<?php echo $company->getPostCode() ?>
                    </div>


                    <div class="form-row">
                        <label class="required"><?php echo __('Country:') ?></label>
                        <div class="content">
<?php echo $company->getCountry() ? $company->getCountry()->getName() : 'N/A' ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="required"><?php echo __('City:') ?></label>
                        <div class="content">
<?php echo $company->getCity() ? $company->getCity()->getName() : 'N/A' ?>
                        </div>
                    </div>


                    <div class="form-row">
                        <label class="required"><?php echo __('Contact Name:') ?></label>
                        <div class="content">
<?php echo $company->getContactName() ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="required"><?php echo __('Contact e-mail:') ?></label>
                        <div class="content">
<?php echo $company->getEmail() ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="required"><?php echo __('Head Phone No:') ?></label>
                        <div class="content">
<?php echo $company->getHeadPhoneNumber() ?>
                        </div>
                    </div>


                    <div class="form-row">
                        <label class="required"><?php echo __('Fax Number:') ?></label>
                        <div class="content">
<?php echo $company->getFaxNumber() ? $company->getFaxNumber() : 'N/A' ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="required"><?php echo __('Website:') ?></label>
                        <div class="content">
<?php echo $company->getWebsite() ? $company->getWebsite() : 'N/A' ?>
                        </div>
                    </div>



                    <div class="form-row">
                        <label class="required"><?php echo __('Status:') ?></label>
                        <div class="content">
<?php echo '' . $company->getStatus() ? $company->getStatus() : 'N/A' ?>
                        </div>
                    </div>
            </fieldset>
        </div>
    </div>
</div>