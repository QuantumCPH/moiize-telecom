<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div id="sf_admin_container">

<h1>Add  News Update</h1>

<div id="sf_admin_header">
</div>

<div id="sf_admin_content">
<form action="newsEdit?id=<?php echo $message->getId()?>" method="post">
    <label >Enter the Topic   </label><br/> <input type="text" name="heading" value="<?php echo $message->getHeading()?>"/><br>
    <label>Enter the Message </label><br/><textarea cols="50" rows="10" name="message" value=""><?php echo $message->getMessage()?></textarea><br>

    <label>
        Starting Date </label>
       <div class="jcalendar-wrapper">
       <div class="jcalendar-selects">
         <select name="day" id="day"  class="jcalendar-select-day"> 
           <?php

           for($i=1;$i<=31;$i++){

           ?>
           <option value="<?php echo $i ?>" <?php
           if($i == (integer) substr($message->getStartingDate(),8,10 ))
                   echo "selected";
           ?> >
           <?php echo $i ?>
           </option>
           <?php } ?>
         </select>
         <select name="month" id="month" class="jcalendar-select-month">
           <?php
           
           for($i=1;$i<=12;$i++){
           ?>
             <option value="<?php echo $i ?>"
           <?php

            if($i == (integer) substr($message->getStartingDate(),5,7 ))
               echo "selected";

           ?>

           ><?php echo $months[$i] ?> </option>
           <?php

           
           }
           
           ?>

         </select>
         <select name="year" id="year" class="jcalendar-select-year">
           <?php

           for($i=2010;$i<=2011;$i++){

           ?>
           <option value="<?php echo $i ?>" <?php 
           if($i==(integer) substr($message->getStartingDate(),0,4 ))
                   echo "selected";
           ?> >
           <?php echo $i ?>
           </option>
           <?php } ?>
           
         </select>
 <input type="hidden" id="id" name="id" value="<?php echo $id ?>" />
  <input type="hidden" id="value" name="value" value="update" />
       </div>
       </div>
  <ul class="sf_admin_actions">

      <li><input class="sf_admin_action_list" value="list" type="button" onclick="document.location.href='newsList';" /></li><li>
 </li>
 
 <input type="submit" value="Update"/></li></ul>
</form>
</div>
</div>