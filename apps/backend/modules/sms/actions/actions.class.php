<?php
require_once(sfConfig::get('sf_lib_dir').'/smsCharacterReplacement.php');
/**
 * sms actions.
 *
 * @package    zapnacrm
 * @subpackage sms
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class smsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeSendSms(sfWebRequest $request)
  {


  $message = $request->getParameter('message');
  $delievry="";


  if($message){

 
  $list = $request->getParameter('numbers');

  $numbers = explode(',',$list);

  $messages = array();
  if(strlen($message) < 142 ){
      $messages[1] = $message."-Sent by zer0call-";
  }
  else if (strlen($message) > 142 and strlen($message) < 302){

        $messages[1]=substr($message,1,142)."-Sent by zer0call-";
        $messages[2]=substr($message,143)."-Sent by zer0call-";

  }else if (strlen($message) > 382){
     $messages[1]=substr($message,1,142)."-Sent by zer0call";
     $messages[2]=substr($message,143,302)."-Sent by zer0call";
     $messages[3]=substr($message,303,432)."-Sent by zer0call";

  }

  foreach($messages as $sms_text){
      foreach($numbers as $number){
      $cbf = new Cbf();
      $cbf->setS('H');
      $cbf->setDa($number);
      $cbf->setMessage($sms_text);
      $cbf->setCountryId(53);
      $cbf->setMobileNumber('WLS Backend');

//$sms_text='ø  æ å  Æ Ø Å Ö ö';
      $cbf->save();
//$sms_text='ø  æ å';
      $data = array(
              'S' => 'H',
              'UN'=>'zapna1',
              'P'=>'Zapna2010',
              'DA'=>$number,
              'SA' => 'WLS',
              'M'=>$sms_text,
              'ST'=>'5'
	);



                   
                   
                    
            $queryString = http_build_query($data,'', '&');

           //   die;
                sleep(0.5);

               

               $queryString=smsCharacter::smsCharacterReplacement($queryString);

 

		$res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?'.$queryString);
                $this->res_cbf = 'Response from CBF is: ';
                $this->res_cbf .= $res;

                //echo $res;


                $delievry .= 'Destination: '.$number.', Status: '.$res.'<br/>';

                
      }

  }
  }
  



    $this->delievry = $delievry;
  }
}
