<h1>Current Balance: <?php echo $balance ?> &euro;</h1>
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
                    echo link_to('....read more', sfConfig::get('app_main_url').'company/newsListing');
                } else {
                    echo $updateNew->getMessage();
                }
        ?>
                <br/><br/>

        <?php
            }
        } ?>
        <b><?php echo link_to(__('View All News & Updates'),  sfConfig::get('app_main_url').'company/newsListing'); ?> </b>
    </p>
</div>