<div id="sf_admin_container"><h1><?php echo __('Change Password') ?></h1></div>

<div class="borderDiv">
    <br/>
    <div>
        <form action="<?php echo url_for(sfConfig::get('app_main_url').'company/changePassword') ?>" name="frmChangePassword" method="post">
            <input type="hidden" value="<?php echo $vatNo;?>" name="vatNum" />
            <table cellspacing="0" cellpadding="5" border="0" class="tblChangePassword">
                <tr>
                    <th>Old Password:</th><td><input type="text" value="" name="oldPassword" /></td>
                </tr>
                <tr>
                    <th>New Password:</th><td><input type="text" value="" name="newPassword" /></td>
                </tr>
                <tr><td colspan="2" align="right"><input type="submit" name="submit" value="Change" /></td></tr>
            </table>
            </table>
        </form>        
        
    </div>

    <div class="clr"></div>
</div>					