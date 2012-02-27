<?php
require_once(sfConfig::get('sf_lib_dir') . '/smsCharacterReplacement.php');

/**
 * Description of company_employe_activation
 *
 * @author baran
 */
class CARBORDFISH_SMS {

    //put your code here

    private static $S   = 'H';
    private static $UN  = 'zapna1';
    private static $P   = 'Zapna2010';
    private static $SA  = 'Zeorcall';
    private static $ST   = 5;
    
   /*
    * Description of Send
    *
    * @param $mobilenumber is the mobile number leading with country code;
    * @smsText is for the text that will be sent.
    * @param $Sender will be the sender name of the SMS;
    */

    public static function Send($mobileNumber,$smsText,$senderName=null) {
        if($senderName == null)
            $senderName = self::$SA;

        $data = array(
            'S' => self::$S,
            'UN' => self::$UN,
            'P' => self::$P,
            'DA' => $mobileNumber,
            'SA' => $senderName,
            'M' => $smsText,
            'ST' => self::$ST
        );
        $queryString = http_build_query($data, '', '&');
        $queryString = smsCharacter::smsCharacterReplacement($queryString);
        $res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?' . $queryString);
        sleep(0.15);

        $smsLog = new SmsLog();
        $smsLog->setMessage($smsText);
        $smsLog->setStatus($res);
        $smsLog->setSenderName($senderName);
        $smsLog->setMobileNumber($mobileNumber);
        $smsLog->save();
        if (substr($res, 0, 2) == 'OK')
            return true;
        else
            return false;
    }

}

?>
