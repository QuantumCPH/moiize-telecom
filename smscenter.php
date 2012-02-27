<?php

$sms_text="Kære Kunde
Vi har nu ændret dit nummer hos zerOcall fra 28927524 til 40550368. Du kan nu bruge dit nye nummer til at lave opkald til udlandet. Vi ønsker dig en glædelig jul og godt nytår.
Mvh.
zerOcall";
$sms_text='here are text messagse  for denish characters like  ø, æ, å';

$data = array(
              'S' => 'H',
              'UN'=>'zapna1',
              'P'=>'Zapna2010',
              'DA'=>'923006826451',
              'SA' =>'zer0call',
              'M'=>$sms_text,
              'ST'=>'5'
	);



echo $queryString = http_build_query($data,'', '&');
die;


$res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString);

echo 'http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString;

echo $res;

?>
