<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>


<script type="text/javascript">
function countChar(str)
{
var chars = document.getElementById('chars');
var message = document.getElementById('message');

chars.innerHTML = str.length+"/434";

if(str.length > 433){
        //alert(message.value);
      //  alert(message.value.substring(0,2));
     var   temp = message.value.substring(0,434);
     message.value = temp;
        //alert();
        return false;
}

}

function isHex(entry){
validChar='0123456789'; // ok chars
strlen=entry.length; // test string length
//if(strlen<1){alert('Entry must be in numeric format!');return false;}
entry=entry.toUpperCase(); // case insensitive
// Now scan for illegal characters
for(idx=0;idx<strlen;idx++){
  if(validChar.indexOf(entry.charAt(idx))<0){
    alert("Entry must be in numeric format!");return false;}
  } // end scan
return true;}

</script>


<?php include_partial('dashboard_header', array('customer'=> $customer, 'section'=>__('Websms') ) ) ?>


<div class="left-col">
    <?php include_partial('navigation', array('selected'=>'', 'customer_id'=>$customer->getId())) ?>
	<div class="split-form">
      <div class="fl col">
  	 		
          
<?php if (!($balance <= 0.00 )){ ?>
          <form action=<?php echo url_for('customer/websms', true) ?>  method="post" id="websms" onsubmit="isHex(this.value)">
              <h3 style="width: 400px;"><?php echo __("Your Current Balance is:") ?><?php echo $balance ?> &euro;</h3>
   <?php }else{ ?>
                
                <h3 style="width: 400px;"><?php echo __("Your Current Balance is:") ?> <?php echo $balance ?> &euro;</h3>
                Du har desværre ikke penge nok på kontoen, du bedes venligst tank op <b><a href="<?php echo url_for('customer/refill', true) ?><?php echo "/customer_id/".$customer->getId()?>">her</a></b>
<?php }?>
       <ul>
        <li>  </li>
        
        <li bgcolor="f0f0f0">
            <?php echo __("NOTICE:");?> <br />
		  - <?php echo __("1 SMS constitutes 142 characters") ?><br />
		  - <?php echo __("Message upto 302 characters will be considered as 2 sms") ?> <br />
		  - <?php echo __("Message upto 432 characters will be considered as 3 SMS") ?> <br />
		  - <?php echo __("Any Text written above character limit will be automatically truncated") ?> <br />
          - <?php echo __("SMS charges may apply") ?> <br />
		  
       </li>
       
       <li>
       <?php 
		 //echo $res_cbf;
		 if($msgSent!=''){
		  if($msgSent=="Yes" && trim($res_cbf)!="Response from CBF is:"){ ?>
          <?php echo "<label style='color:#339933; white-space:nowrap'><b>".__("Message has been sent").'</b></label>'; ?>
          <?php }elseif(trim($res_cbf)=="Response from CBF is:"){?>
          <?php echo "<label style='color:#F00; white-space:nowrap'><b>".__("Your message unfortunately not sent, try again").'</b></label>'; ?>
          <?php }
		  } ?><br /><br />
                  <table cellspacing="0" class="summary" width="480">
        <tr bgcolor="#f0f0f0">
            <td>
               <label for="country"><?php echo __('Country')?></label>
            </td>
            <td>
                <select name="country" id="country" >
             
                <?php foreach($countries as $country){ ?>
                    <option value="<?php echo $country->getCallingCode() ?>"><?php echo $country->getName() ?></option>
              
                <?php } ?>
                </select>
            </td>
            <td> </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td></td>
            <td></td>
        </tr>
        <tr bgcolor="#ffffff">
            <td valign="top">
                <label for="destination"><?php echo __("Destination Number<br />(without leading 0)") ?></label>
            </td>
            <td align="left" style="width:115px;">
                <input type="text" name="number" id="number" size="15" maxlength="13" onkeydown="isHex(this.value)">
 
            </td>
            <td align="left" style="margin-left:15px;">
               <?php echo __("Characters") ?> <span id="chars">0/432</span>
                
            </td>

        </tr>
        <tr bgcolor="#ffffff">
            <td></td>
            <td></td>
        </tr>
        <tr bgcolor="#f0f0f0">
            <td valign="top">
                <label for="message"><?php echo __("Message:") ?></label>
            </td>
            <td colspan="2">
                <TEXTAREA id="message" size="434" name="message" rows="10" cols="30" maxlength="434" onkeydown="countChar(this.value)"></TEXTAREA>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td colspan="3">&nbsp;</td>
            
        </tr> </li>
    </ul>
        <tr>
            <td colspan="2">
                     
            </td>
        </tr>
    </table>
            <br />
            <input type="submit" class="buton" name="submit"  value="<?php echo __("Send SMS") ?>" onclick="
                            if(document.getElementById('number').value==''){
                                alert('Please Enter The Destination Number');
                                document.getElementById('number').focus();
                                return false;
                            }else if(document.getElementById('message').value==''){
                                alert('Please Enter The Message');
                                document.getElementById('message').focus();
                                return false;
                            }else{
                                return true;
                            }" />
            <br />
   
       
</form>

          
          <br /><br />
         
          

      </div>
    </div> <!-- end split-form -->
	
  </div> <!-- end left-col -->
  <?php include_partial('sidebar') ?>