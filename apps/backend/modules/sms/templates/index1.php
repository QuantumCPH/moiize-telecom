<?php

//$setdate=date('Y');
// $setstartdate=$setdate-8;
// $setenddate=$setdate-110;
// $years = range($setstartdate, $setenddate);
// foreach($years as $year)
//     echo $year;
 //echo array_combine($years, $years);

//$a="(479) 002-5216";
//$a=str_replace(' ','',str_replace('-','',str_replace(')','',str_replace('(','',$a))));
//echo  $a;

//  'DA'=>'45'.$number,

$sms_text='here are text messagse  for denish characters like  ø, æ, å';
//$sms_text=$_REQUEST['message'];
      $data = array(
              'S' => 'H',
              'UN'=>'zapna1',
              'P'=>'Zapna2010',
              'DA'=>'923006826451',
              'SA' => 'zer0call',
              'M'=>$sms_text,
              'ST'=>'5'
	);


	echo	$queryString = http_build_query($data,'', '&amp;');
die;
                sleep(0.5);
    $queryString=smsCharacter::smsCharacterReplacement($queryString);
		$res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString);
             
             echo $res;

?>