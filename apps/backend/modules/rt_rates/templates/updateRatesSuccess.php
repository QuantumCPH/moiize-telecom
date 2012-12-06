<style>
    #rt-table-header span {
        width:168px;
        display: inline-block;
        font-size: 13px;
        font-weight: bold;
        padding: 5px 0px;
        background-color: #006400;
        color: #FFFFFF;
        text-align: center;

    }
    #sf_admin_container label.error{
        width: 5px;
        margin-right: 0px;
        color: red;
    }
</style>
<script type="text/javascript">
    jQuery(function(){
        jQuery.extend(jQuery.validator.messages, {
            required: "*"
    
        });
        jQuery("#rtform").validate();
    });
</script>
<div id="sf_admin_container">
    <div id="sf_admin_content" >

        <h1> Update Rates</h1>
        <div id="rt-table-header" style="position: fixed;margin-bottom: 5px; top: 0;" >
            <span>Country </span><span>Mobile Rate</span><span>Land Line Rate</span> 
            <span>Country </span><span>Mobile Rate</span><span>Land Line Rate</span> 
        </div>
        <form method="post" action="" id="rtform">
            <div id="rt-table-header" style="margin-bottom: 5px;">
                <span>Country </span><span>Mobile Rate</span><span>Land Line Rate</span> 
                <span>Country </span><span>Mobile Rate</span><span>Land Line Rate</span> 
            </div>
            <table >
                <tr>
                    <?php
                    $i = 1;
                    foreach ($countries as $country) {
                        $i++;
                        if ($i % 2 == 0)
                            echo "</tr><tr>";
                        ?>

                        <td style="width: 162px;"><?php echo $country->getTitle() ?> </td>
                        <?php
                        foreach ($services as $service) {
                            $c = new Criteria();
                            $c->add(RtRatesPeer::RT_SERVICE_ID, $service->getId());
                            $c->add(RtRatesPeer::RT_COUNTRY_ID, $country->getId());
                            $rtCount = RtRatesPeer::doCount($c);
                            
                            if ($rtCount > 0) {
                                $rate = RtRatesPeer::doSelectOne($c);
                            }
                            ?>
                            <td style="width: 162px;"><input type="text" class="required" value="<?php if ($rtCount > 0) {
                               echo $rate->getRate();
                            } ?>"name="<?php echo $country->getId() . "_" . $service->getId(); ?>" /></td>
                        <?php } ?>

                        <?php
                    }
                    ?>
                </tr>
                <tr><td colspan="6">
                        <input type="submit" value="Save Rates"/>
                    </td></tr>
            </table>    
        </form>
    </div>
</div>