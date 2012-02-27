<html>
    <head>
    <title>  LandNCall AB  </title>

	 
           <style type="text/css">

            * { font-family: Verdana; font-size: 11px; line-height: 14px; align:center;}

	    .submit { background-image: <?php echo _compute_public_path('sendbesket','zerocall/images','png') ?>;margin-left: 125px; margin-top: 10px;}
	    .label { display: block; float: left; width: 90px; text-align: right; margin-right: 5px; }
	    .form-row { padding: 5px 0; clear: both; width: 700px; }
	    label.error { width: 250px; display: block; float: left; color: red; padding-left: 10px; }
	    input[type=text], text {margin-top: 10px; width: 400px; border-style: solid; border-width:  2px; border-color:#e77714;  }
            input[type=textarea], textarea { margin-top: 10px; width: 400px; border-style: solid; border-width:  2px; border-color:#e77714;  }
	    textarea { width: 400px; height: 200px; }
	  </style>
    </head>
   
	  <script type="text/javascript" src="http://www.cheapmonthlyparking.com/js/jquery.validate.js"></script>
<script type="text/javascript">
jQuery(function(){




jQuery('#form1').validate({

});


});
</script>
<body>
<div id="wrap">
    <?php if( $browser->getBrowser() == Browser::BROWSER_IE  )
          {
     ?>
<div style="padding-left:250px;width:780px;">
    <?php }
    ?>
<div style="width:780px;height:80px; float:left;display:block; background-image:url(<?php echo _compute_public_path('logo','zerocall/images','gif')?>); background-repeat:no-repeat; overflow:hidden; text-indent:9000em; white-space:nowrap;">
<h1><a href="http://zerocall.com<?php echo $test_dir ?>/"
	title="Zero Call - Zapna">Zero Call - Zapna</a></h1>
</div>
<?php echo image_tag('/zerocall/images/bannerb2b.gif') ?>

   <?php if( $browser->getBrowser() == Browser::BROWSER_IE  )
          {
     ?>
        <div class="alert_bar" style="width:800px;">
    <?php } else {
        ?>
            <div class="alert_bar" style="width:770px;">
            <?php
    }
    ?>

	<?php echo $alert ?>
</div>

<br/>
<div style="width:800px;">
    <h1>
        <span style="font-size: 14px; ">
            <font size="5" color="#e77714" face="Calibri">Her er din nye internationale mobilløsning Zapna GLOBAL. Og du skal ikke engang skifte dit mobilabonnement!</font>
        </span>
        </h1>

        <p  style="margin-top: 0cm; margin-right: 0cm; margin-bottom: 10pt; margin-left: 0cm; text-align: justify; ">
            <font color="#000000" face="Calibri" size="3">Zapna GLOBAL sikrer dig også attraktive priser når du er hjemme i Danmark og ringer til udlandet. Når du ringer vil Zapna automatisk sikre, at du kommer i kontakt med udlandet – og du kan spare helt op mod 80%.</font>
        </p>
        <p  style="margin-top: 0cm; margin-right: 0cm; margin-bottom: 10pt; margin-left: 0cm; text-align: justify; ">
        <font color="#000000" face="Calibri" size="3">Zapna GLOBAL sikrer dig også attraktive priser når du er hjemme i Danmark og ringer til udlandet. Når du ringer vil Zapna automatisk sikre, at du kommer i kontakt med udlandet – og du kan spare helt op mod 80%.</font>
        </p>
        <p class="MsoNormal" style="margin-top: 0cm; margin-right: 0cm; margin-bottom: 10pt; margin-left: 0cm; ">
            <font color="#000000" face="Calibri" size="3">Zapna sikrer, at du sparer penge både på dine opkald til/fra Danmark og de opkald du modtaget i udlandet.</font>
        </p>
        <h1>
        <span style="line-height: 115%; color: rgb(227, 108, 10); font-size: 12pt; ">
        <font face="Calibri">
            Så enkelt er det!
            <o :p=""/>
            </font>
        </span>
        </h1>
        <p  style="margin-top: 0cm; margin-right: 0cm; margin-bottom: 10pt; margin-left: 0cm;  text-align: justify;">
            <font color="#000000" face="Calibri" size="3">Zapnas unikke ”sim-kort” placerer du ovenpå eksisterende SIM-kort. Det betyder, at du faktisk kan have 2 SIM-kort i din telefon.</font>
        </p>
        <p  style="margin-top: 0cm; margin-right: 0cm; margin-bottom: 10pt; margin-left: 0cm; text-align: justify;">
            <font color="#000000" face="Calibri" size="3">Når du rejser til udlandet, benytter du helt enkelt Zapna til dine opkald fra udlandet og til at modtage dine indgående opkald.</font>
        </p>
        <p style="margin-top: 0cm; margin-right: 0cm; margin-bottom: 10pt; margin-left: 0cm; text-align: justify;">
        <font color="#000000" face="Calibri" size="3">Samtidig sikrer Zapna, at du modtager dine opkald automatisk. Helt som du plejer. Det vil sige at familie og venner altid kan ringe til dig på det nummer de kender.</font>
        </p>
        <h1>
            <span style="line-height: 115%; color: rgb(227, 108, 10); font-size: 12pt; ">
            <font face="Calibri">
                Sådan gør du nu!
                <o :p=""/>
            </font>
            </span>
          </h1>
            <p  style="margin-top: 0cm; margin-right: 0cm; margin-bottom: 10pt; margin-left: 0cm; text-align: justify; ">
               <font color="#000000" face="Calibri" size="3">Klik på linket og start med at spare penge. Du vil blive kontaktet af en af vore medarbejdere for at oprette kortet og dermed mindske regningen på rejsen.</font>
            </p>
            <form id="form1" name="form1" action="B2B" style="width: 30em; border-color:#E88937; border-left-width:2; border-right-width:2 ;border-bottom-width:2;border-top-width:2; " >
               <div>  <label>
                    Indtast dit navn
                        <em style="color: red; font-style: oblique;">*</em>
                </label>
                  <input type="text" name="name" id="name" class="required" style="margin-bottom: 0.5em; width: 100%;  border-color:#E88937; border-left-width:2px; border-right-width:2px;border-bottom-width:2px;border-top-width:2;"/>
                </div>
                <div> <label>
                    Email adresse
                    <em style="color: red; font-style: oblique;">*</em>
                </label>
                  <input type="text" name="email" class="required email"  id="name" style="margin-bottom: 0.5em; width: 100%;  border-color:#E88937; border-left-width:2px; border-right-width:2 ;border-bottom-width:2px;border-top-width:2px;"/>
                </div>
                <div>  <label>
                    Telefonnummer
                        <em style="color: red; font-style: oblique;">*</em>
                </label>
               <input type="text" name="phone" id="name"    style="margin-bottom: 0.5em; width: 100%; border-color:#E88937; border-color:#E88937; border-left-width:2px; border-right-width:2px;border-bottom-width:2px;border-top-width:2px;"/>
                </div> 
                <div>   <label>
                    Besked emne
                        <em style="color: red; font-style: oblique;">*</em>
                </label>
                  <input type="text" name="subject" id="name"  style="margin-bottom: 0.5em; width: 100%; border-color:#E88937; border-color:#E88937; border-left-width:2px; border-right-width:2px;border-bottom-width:2px;border-top-width:2px;"/>
                </div>
                <div> <label>
                             Indtast din besked
                        <em style="color: red; font-style: oblique;">*</em>
                </label>

                  <textarea name="message" cols="" rows=""   class="required"  style="width: 28em; height:15em " style="border-color:#E88937; border-left-width:2px; border-right-width:2px ;border-bottom-width:2px ; border-top-width:2px;" ></textarea>
                </div> 
                <br/><br/>

                <input type="image" src="<?php echo _compute_public_path("sendbesket","zerocall/images","png") ?>" alt="send besket">
                <input type="hidden" name="visitor" value="<?php echo $visitor->getId() ?>" />
                
<br/><br/>
            </form>
<p/>

</div>
<br/><br/>
<hr style="width:800px; color:#e77714">
    <br/><br/>
<div style="width:800px;" id="cite" class="fl">Copyright &copy; Zapna 2010</div>
<div style="width:800px;" id="sec" class="fr"><script type="text/javascript"
	src="https://seal.thawte.com/getthawteseal?host_name=zerocall.com&amp;size=S&amp;lang=en"></script>
</div>
<div style="width:800px;text-align: right;"id="ccs" class="fr"><img
	src="<?php echo image_path('../zerocall/images/ccs.png',true) ?>"
	alt="Credit Cards" /></div>
 <?php if( $browser->getBrowser() == Browser::BROWSER_IE  )
          {
     ?>
</div>
<?php } ?>
    </div>

 </body>
</html>