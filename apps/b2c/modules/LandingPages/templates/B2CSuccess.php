<?php use_helper('I18N') ?>
<?php $test_dir =  ''; // '/testwp'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_http_metas() ?>
<?php include_metas()  ?>
<?php include_title() ?>

<?php use_javascript('../zerocall/js/jquery-1.4.2.min.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/cufon-yui.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/Barmeno_400-Barmeno_400.font.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/Barmeno-Medium_400.font.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/cufon-replace.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/jquery.jcarousel.min.js', '', array('absolute'=>true)) ?>
<?php use_javascript('../zerocall/js/carousel.js', '', array('absolute'=>true)) ?>

<?php use_javascript('jquery.formatCurrency-1.3.0.min.js', '', array('absolute'=>true)) ?>
<?php use_javascript('i18n/jquery.formatCurrency.all.js', '', array('absolute'=>true)) ?>

<?php use_stylesheet('../zerocall/style/style.css', 'last', array('absolute'=>true)) ?>
<?php use_stylesheet('admin.css', '', array('absolute'=>true)) ?>
<?php use_stylesheet('../sf/sf_admin/css/main.css', '', array('absolute'=>true)) ?>

<!--[if IE 7]>
	<link href="<?php echo stylesheet_path('../zerocall/style/ie-7.css', true) ?>" rel="stylesheet" type="text/css" />
	<![endif]-->
</head>
<body>
<div id="wrap">
<div style="width:780px;">
<div style="float:left;display:block; background-image:url(../images/logo.jpg); background-repeat:no-repeat; overflow:hidden; text-indent:9000em; white-space:nowrap;">
<h1><a href="http://zerocall.com<?php echo $test_dir ?>/"
	title="Zero Call - Zapna">Zero Call - Zapna</a></h1>
</div><br/>
<?php include_partial('dashboard_header') ?>

</div>

   

<br/><br/>
<h3 style="font-size: 18px; ;color:#e77714">Til dig som selv betaler for din telefonregning</h3>
<br/>
<p>
Her er din nye globale mobiltelefonløsning. Og du skal ikke engang skifte
dit abonnement..
</p><br/>
<p>
LandNCall AB global sikrer dig også attraktive priser når du er hjemme i Danmark og gerne vil kontakte udlandet. Når du ringer til udlandet vil LandNCall AB automatisk overtage dit opkald og sikre at du kommer i kontakt med udlandet – og du kan spare helt op mod 75%. LandNCall AB sikrer også at du sparer penge både på dine opkald til/fra Danmark og de opkald du modtaget i udlandet.
</p>

<br/>
<br/>
<h3 style="font-size: 18px; ;color:#e77714"> Så enkelt er det</h3>
<br/>
<p>Du modtager LandNCall AB unikke SIM-kort som du kan placere ovenpå dit
eksisterende SIM-kort. Det betyder at du faktisk kan have 2 SIM-kort i
din telefon. Når du rejser til udlandet, skifter du helt enkelt over dit
LandNCall AB SIM-kortet og benytter dette til dine opkald fra udlandet og
til at modtage dine indgående opkald.</p>
<br/>
<p>
 Samtidig sikre LandNCall AB kortet at de opkald du modtager på dit normale
SIM-kort hos din danske teleudbyder automatisk omstilles til dit LandNCall AB
SIM-kort. Det vil sige at familie og venner altid kan ringe til dig på det
nummer de kender.
</p>
<br/>
<br/><h3 style="font-size: 18px; ;color:#e77714">Se demo´en her</h3>
<br /><br /><br />
<div style="color:#e77714;border:3px solid;width:508px;height:305px">
    <object width="508px" height="305px">
    <param name="movie" value="tutorial" />
    <embed src="<?php echo _compute_public_path('tutorial','zerocall/swf','swf')?>" width="508" height="305" ></embed>
    </object>

</div>
<br/>
<h3 style="font-size: 18px; ;color:#e77714">Sådan gør du nu!</h3>
<br/>
<p>
Klik på linket forneden og start med at spare penge.
</p>
<br/>
<p>
Du får LandNCall AB AB ved at benytte linket – og du kommer ind på zerOcalls bestillingsside og kan taste dine oplysninger ind. Du bestiller for 200 kr. taletid . Herefter går der kun ganske kort tid og så modtager du dit zerOcall SIM-kort med posten sammen med en enkelt vejleding – det tager under 2 minutter, så er du i gang med at spare penge.
</p>
<br/>

<center>

<h2><a href="<?php echo $host->getUrl()?><?php echo $visitor->getId() ?>"><?php echo image_tag("/zerocall/images/button.png","border=0px") ?></a></h2>
</center>






<!-- end wrap -->

  <br/><br/>
<hr style="color:#e77714">
    <br/><br/>
<div id="cite" class="fl">Copyright &copy; Zer0Call 2010</div>
<div id="sec" class="fr"><script type="text/javascript"
	src="https://seal.thawte.com/getthawteseal?host_name=zerocall.com&amp;size=S&amp;lang=en"></script>
</div>
<div id="ccs" class="fr"><img
	src="<?php echo image_path('../zerocall/images/ccs.png',true) ?>"
	alt="Credit Cards" /></div>

</div>
</body>
</html>