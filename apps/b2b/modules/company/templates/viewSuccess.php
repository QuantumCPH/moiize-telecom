<?php use_helper('I18N') ?>
<div id="sf_admin_container">
 <?php if ($sf_user->hasFlash('change_password_error_message')): ?>
	<p style="color: red; margin:6px auto;text-align: left;border:0px !important;"><?php echo $sf_user->getFlash('change_password_error_message') ?></p>
    <?php endif;?>
    <?php if ($sf_user->hasFlash('change_password_message')): ?>
	<p style="color: green; margin:6px auto;text-align: left;border:0px !important;"><?php echo $sf_user->getFlash('change_password_message') ?></p>
    <?php endif;?>
</div>
<div id="sf_admin_container">
    <h1><?php echo __('Agent details') ?></h1>
</div>

  <table cellpadding="5" cellspacing="0" width="100%" class="tblAlign">
                <tr class="headings">
                    <th width="27%">
                       <?php echo __('Agent Name') ?>:                    </th>
                    <td width="73%"><?php echo $company->getName() ?></td>
    </tr>
                <tr class="headings">
                    <th>
                       <?php echo __('Balance view') ?>:
                    </th>
                    <td><?php echo $balance;
                        echo "&euro;"; ?></td>
                </tr>
                <tr class="headings">
                    <th>
                       <?php echo __('Number of PCO Lines') ?>:
                    </th>
                    <td><?php echo $employeesCount; ?></td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('Vat Number') ?>:
                    </th>
                    <td><?php echo $company->getVatNo() ?></td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('Password') ?>:
                    </th>
                    <td><?php echo $company->getPassword() ?>&nbsp;(<a href="<?php echo sfConfig::get('app_main_url');?>company/changePassword">Change</a>)</td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('Address') ?>:
                    </th>
                    <td><?php echo $company->getAddress() ?></td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('Post Code') ?>:
                    </th>
                    <td><?php echo $company->getPostCode() ?></td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('Country') ?>:
                    </th>
                    <td><?php echo $company->getCountry() ? $company->getCountry()->getName() : 'N/A' ?></td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('City') ?>:
                    </th>
                    <td><?php echo $company->getCity() ? $company->getCity()->getName() : 'N/A' ?></td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('Contact Name') ?>:
                    </th>
                    <td><?php echo $company->getContactName() ?></td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('Contact e-mail') ?>:
                    </th>
                    <td><?php echo $company->getEmail() ?></td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('Head Phone No') ?>:
                    </th>
                    <td><?php echo $company->getHeadPhoneNumber() ?></td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('Fax Number') ?>:
                    </th>
                    <td><?php echo $company->getFaxNumber() ? $company->getFaxNumber() : 'N/A' ?></td>
                </tr>
                <tr class="headings">
                    <th>
                      <?php echo __('Website') ?>:
                    </th>
                    <td><?php echo $company->getWebsite() ? $company->getWebsite() : 'N/A' ?></td>
                </tr>
                 <tr class="headings">
                    <th>
                      <?php echo __('Status') ?>:
                    </th>
                    <td><?php echo '' . $company->getStatus() ? $company->getStatus() : 'N/A' ?></td>
                </tr>
            </table>

             