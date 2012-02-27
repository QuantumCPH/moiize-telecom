<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>



<style type="text/css">

            * { font-family: Verdana; font-size: 11px; line-height: 14px; align:center;}

	    .submit { margin-left: 125px; margin-top: 10px;}
	    .label { display: block; float: left; width: 90px; text-align: right; margin-right: 5px; }
	    .form-row { padding: 5px 0; clear: both; width: 700px; }
	    label.error { width: 250px; display: block; float: left; color: red; padding-left: 10px; }
	    input[type=text], text { width: 200px;  }

	    textarea { height: 200px; }
</style>


<script type="text/javascript">
	    $(document).ready(function() {
	      $("#form1").validate({
	        rules: {
                  cvr:"required",
                  check:"required",
                  message:"required",
	          email: {// compound rule
	          required: true,
	          email: true
	        }
                }
	      });
	    });
	  </script>


<div id="landingcontent" style="width:800px; float:center; padding-left:100px ;padding-top:30px; padding-bottom:10px; position:relative;" >

    <table width="100%">
        <tr>
            <td width="40%"><?php echo image_tag("/zerocall/images/b2c/logo.png") ?></td>
            <td><div style="width:30%;"></div></td>
            <td width="30%" align="right">
                 
            </td>
        </tr>

    </table>

<br/>
<font color="#ffffff">
    <table style="color:white;" BORDER="0" CELLSPACING="3" CELLPADDING="15" height="400px" WIDTH="1080px" BACKGROUND="<?php echo _compute_public_path('back','zerocall/images/b2c','jpg')?>">
        <tr>
            <td colspan="4">
                <h1>Hvad er Zapna?</h1>
                <p>
                    Din forbindelse til og fra hele verden,<br />
                    med vores unikke simkort løsning.
                </p>
            </td>
            
        </tr>
        <tr>
            <td width="20%" align="center"> <?php echo image_tag("/zerocall/images/b2c/Sim.png")?><br/></td>
            <td width="20%" align="center"> <?php echo image_tag("/zerocall/images/b2c/Globe.png")?><br/></td>
            <td width="20%" align="center"><?php echo image_tag("/zerocall/images/b2c/money_saver.png")?><br/></td>
            <td width="20%" align="center"><?php echo image_tag("/zerocall/images/b2c/Computer.png")?><br/></td>
        </tr>
        <tr>
            <td width="20%">
               
                <h2>Så enkelt er det!</h2>
                <p>
                    Zapnas unikke sim-kort placerer  du ovenpå eksisterende SIM-kort.  Det betyder, at du faktisk kan  have 2 SIM-kort i din telefon.
                </p>
            </td>
            <td width="20%">
               
                <p>
                    Når du rejser til udlandet, benytter  du helt enkelt Zapna til dine opkald  fra udlandet og til at modtage dine  indgående opkald.
                </p>
            </td>
            <td width="20%">
                
                <h2>Spare op til 80%</h2>
                <p>
                    Du kan spare op til 80% på din roaming omkostninger helt uden at skifte dit  abonnement.
                </p>
            </td>
            <td width="20%">
                
                <h2>Sådan gør du nu!</h2>
                <p>
                    1. Tryk forneden og bestil zerOcall <br/>
                    2. Betal 200 kr for startpakke inkl. taletid <br/>
                    3. 2 dage efter modtager du simkort <br/>
                    4. Tilslut simkortet og du er igang med  at spare pene<br/>
                </p>
            </td>


        </tr>
    </table>

    </font>

    <br/>

    <table WIDTH="1080px" cellspacing="15">
        <tr>
            


            <td width="34%">
              

                <?php include_partial('country') ?>
            </td>
            <td width="33%">
                <?php echo image_tag("/zerocall/images/b2c/med_zerocall.png")?>

            </td>

            <td width="33%">
                <h1>Sadan Fungerer zer0call</h1>
                <object width="250px" height="250px">
                 <param name="movie" value="banner.swf" />
                 <embed src="<?php echo _compute_public_path('banner','zerocall/swf','swf')?>" width="250" height="250" ></embed>
                 </object>
            </td>
        </tr>
    </table>
</div>

<style type="text/css">

 td.padded {
 padding-top:25px;
 }
</style>



