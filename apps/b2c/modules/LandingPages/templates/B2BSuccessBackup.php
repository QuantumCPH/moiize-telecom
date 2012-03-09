<html>
    <head><title>  LandNCall AB  </title>
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	  <script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>

	  <script type="text/javascript">
	    $(document).ready(function() {
	      $("#form1").validate({
	        rules: {
	          name: "required",// simple rule, converted to {required:true}
	          email: {// compound rule
	          required: true,
	          email: true
	        },
	        message: {
	          required: true
	        }
	        },
	        messages: {
	          message: "Please enter a comment."
	        }
	      });
	    });
	  </script>
           <style type="text/css">

            * { font-family: Verdana; font-size: 11px; line-height: 14px; align:center;}

	    .submit { margin-left: 125px; margin-top: 10px;}
	    .label { display: block; float: left; width: 90px; text-align: right; margin-right: 5px; }
	    .form-row { padding: 5px 0; clear: both; width: 700px; }
	    label.error { width: 250px; display: block; float: left; color: red; padding-left: 10px; }
	    input[type=text], text { width: 200px;  }
            input[type=textarea], textarea { width: 400px;  }
	    textarea { height: 200px; }
	  </style>
</head>
    <body>
        <div id="cimy_div_id_banner">
            <img src="http://test.zapna.com/wp-content/uploads/2010/11/bannerb2b.gif"/>
        </div>
        <br />
        <h1>
        <span style="font-size: 14px; ">
            <font color="#000000" face="Calibri">Her er din nye internationale mobilløsning Zapna GLOBAL. Og du skal ikke engang skifte dit mobilabonnement!</font>
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
            <form id="form1" action="B2B" style="width: 30em; border-color:#E88937; border-left-width:2; border-right-width:2 ;border-bottom-width:2;border-top-width:2; " >
                <label>
                    Indtast dit navn
                        <em style="color: red; font-style: oblique;">*</em>
                </label>                
                <input type="text" name="name" id="name" style="margin-bottom: 0.5em; width: 100%;  border-color:#E88937; border-left-width:2px; border-right-width:2px;border-bottom-width:2px;border-top-width:2;"/>
                <label>
                    Email adresse
                    <em style="color: red; font-style: oblique;">*</em>
                </label>
                <input type="text" name="email" id="name" style="margin-bottom: 0.5em; width: 100%;  border-color:#E88937; border-left-width:2px; border-right-width:2 ;border-bottom-width:2px;border-top-width:2px;"/>
                <label>
                    Besked emne
                        <em style="color: red; font-style: oblique;">*</em>
                </label>
                <input type="text" name="email" id="name" style="margin-bottom: 0.5em; width: 100%; border-color:#E88937; border-color:#E88937; border-left-width:2px; border-right-width:2px;border-bottom-width:2px;border-top-width:2px;"/>
                <label>
                    Indtast din besked
                        <em style="color: red; font-style: oblique;">*</em>
                </label>

                <textarea cols="" rows=""  style="width: 28em; height:15em " style="border-color:#E88937; border-left-width:2px; border-right-width:2px ;border-bottom-width:2px ; border-top-width:2px;" ></textarea>
                <p></p>
                <input type="submit" value=" Send Besked " style="border: #ffffff; width: 27em; background-color: #ffcc00" />

            </form>
<p/>

 </body>
</html>