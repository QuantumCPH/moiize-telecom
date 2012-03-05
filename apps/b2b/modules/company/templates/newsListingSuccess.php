<div id="sf_admin_container"><h1><?php echo __('News & Updates Listing') ?></h1></div>

<div class="borderDiv">
    <br/>
    <?php
    $currentDate = date('Y-m-d');
    foreach ($news as $single_news) {


        if ($currentDate >= $single_news->getStartingDate()) {
    ?>

            <p>
                <font size="3">
                    <b><?php echo $single_news->getStartingDate() ?></b><br/>
            <?php echo $single_news->getHeading(); ?> :  <?php echo $single_news->getMessage(); ?>
            <br/><br/>
        </font>
    </p>

    <?php }
    } ?>

    <div class="clr"></div>
</div>					