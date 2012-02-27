
<h3 style="padding-left: 250px"> Send SMS</h3>

<?php if($delievry!=""){ ?>

<h6> Your SMS have been sent, There status is as follows: </h6>

    <?php echo $delievry ?>

<?php
} 
else 
{
?>

<div style="padding-left: 100px">
<form action="sendSms" method="post">
    <table>
        <tr>
            <td>
                List of Numbers: (comma separated list, no spaces)
            </td>
        
            <td>
                <input type="text" name="numbers" style="width:350px;height:25px;"/>
            </td>
        </tr>
        <tr>
            <td>
                Message:<br/><br/>
                - max limit 432 characters<br/>
                - message above 142 characters will be split & sent as 2 SMS<br/>
                - message above 302 characters will be split & send as 3 SMS<br/>
                - message above 432 characters will be discarded<br/>
            </td>
         
            <td>
                <textarea name="message" style="width:350px;height:300px;">Your Message Here</textarea>
            </td>
        </tr>    
    </table>
    <input type="submit" value="Send SMS" />
</form>


<?php } ?>

</div>