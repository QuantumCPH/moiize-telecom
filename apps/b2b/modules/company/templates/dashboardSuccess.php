<h1>Available Balance: <?php echo $balance ?> &euro;</h1>
<div id="sf_admin_container"><h1><?php echo __('PCO Lines') ?></h1></div>

<div class="borderDiv">
    <table width="950"  style="border: 1px;" class="sf_admin_list" cellspacing="0">
        <thead>
            <tr>

                <th align="left"  id="sf_admin_list_th_name"><?php echo __('Name') ?></th>
                <th align="left"  id="sf_admin_list_th_name"><?php echo __('Balance Consumed') ?></th>
                <th align="left"  id="sf_admin_list_th_name"><?php echo __('Created at') ?></th>
            </tr>
        </thead>
        <?php foreach ($employees as $employee) {
        ?>
            <tr>
                <td><?php echo $employee->getFirstName(); ?></td>
                <td><?php
            $ct = new Criteria();
            $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, sfConfig::get("app_telinta_emp") . $company->getId() . $employee->getId());
            $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
            $telintaAccount = TelintaAccountsPeer::doSelectOne($ct);

            $accountInfo = CompanyEmployeActivation::getAccountInfo($telintaAccount->getIAccount());
            // print_r($accountInfo);
            echo $accountInfo->account_info->balance;
        ?> &euro;
            </td>
            <td><?php echo $employee->getCreatedAt(); ?></td>
        </tr>
        <?php } ?>
        </table>
    </div>
    <div id="sf_admin_container"><h1><?php echo __('News Box') ?></h1></div>

    <div class="borderDiv">

        <br/>
        <p>

        <?php
            $currentDate = date('Y-m-d');
            foreach ($updateNews as $updateNew) {
                $sDate = $updateNew->getStartingDate();
                $eDate = $updateNew->getExpireDate();

                if ($currentDate >= $sDate) {
        ?>


                    <b><?php echo $sDate ?></b><br/>
        <?php echo $updateNew->getHeading(); ?> :
        <?php
                    if (strlen($updateNew->getMessage()) > 100) {
                        echo substr($updateNew->getMessage(), 0, 100);
                        echo link_to('....read more', sfConfig::get('app_main_url') . 'company/newsListing');
                    } else {
                        echo $updateNew->getMessage();
                    }
        ?>
                    <br/><br/>

        <?php
                }
            }
        ?>
            <b><?php echo link_to(__('View All News & Updates'), sfConfig::get('app_main_url') . 'company/newsListing'); ?> </b>
    </p>
</div>