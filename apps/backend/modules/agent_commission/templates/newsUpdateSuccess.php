<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>
  <script type="text/javascript">
   $(document).ready(function() {                
     $("#form1").validate({
       rules: {
         heading:{
                required: true,
                maxlength: 200
                },
         message:{
                    required: true,
                    maxlength: 2000
                 }
                   }
     });
   });
  </script>
<script type="text/javascript">
    function selectedItem()
    {
        var day=document.getElementById('day').value;
        var month=document.getElementById('month').value;
        var year=document.getElementById('year').value;
        alert(day + month + year);
        //document.write("Plase enter the date");
        if(day==0 ||month==0 ||year==0)
            {
          
                document.getElementById('dateError').innerHTML='The date is required';

            }
    }
</script>

<form action="<?php echo url_for('agent_company/newsUpdate')?>" method="post">  
    <label >Enter the Topic   </label><br/> <input type="text" name="heading"/><br>
    <label>Enter the Message </label><br/><textarea cols="50" rows="10" name="message"></textarea><br>
  
    <fieldset class="jcalendar" name="eDate" style="width:400px">
       <legend>Starting Date</legend>
       <div class="jcalendar-wrapper">
       <div class="jcalendar-selects">
         <select name="day" id="day" class="jcalendar-select-day">
           <option value="0"></option>
           <option value="1">1</option>
           <option value="2">2</option>
           <option value="3">3</option>
           <option value="4">4</option>
           <option value="5">5</option>
           <option value="6">6</option>
           <option value="7">7</option>
           <option value="8">8</option>
           <option value="9">9</option>
           <option value="10">10</option>
           <option value="11">11</option>
           <option value="12">12</option>
           <option value="13">13</option>
           <option value="14">14</option>
           <option value="15">15</option>
           <option value="16">16</option>
           <option value="17">17</option>
           <option value="18">18</option>
           <option value="19">19</option>
           <option value="20">20</option>
           <option value="21">21</option>
           <option value="22">22</option>
           <option value="23">23</option>
           <option value="24">24</option>
           <option value="25">25</option>
           <option value="26">26</option>
           <option value="27">27</option>
           <option value="28">28</option>
           <option value="29">29</option>
           <option value="30">30</option>
           <option value="31">31</option>
         </select>
         <select name="month" id="month" class="jcalendar-select-month">
           <option value="0"></option>
           <option value="1">January</option>
           <option value="2">February</option>
           <option value="3">March</option>
           <option value="4">April</option>
           <option value="5">May</option>
           <option value="6">June</option>
           <option value="7">July</option>
           <option value="8">August</option>
           <option value="9">September</option>
           <option value="10">October</option>
           <option value="11">November</option>
           <option value="12">December</option>
         </select>
         <select name="year" id="year" class="jcalendar-select-year">
           <option value="0"></option>
           
           <option value="2010">2010</option>
           <option value="2011">2011</option>
           
         </select>        
       
       </div>
       </div>
    </fieldset>
    

  <br><input type="submit" value="Create"/>
</form>


