<?php

class ForumTel {

    public static function registerForumtel($customerid) {


        $tc = new Criteria();
        $tc->add(UsNumberPeer::CUSTOMER_ID, $customerid);
        $usnumber = UsNumberPeer::doSelectOne($tc);



        $username = "Zapna";
        $password = "ZUkATradafEfA4reYeWr";
        $msisdn = $usnumber->getMsisdn();
        $iccid = $usnumber->getIccid();
        $tarif_name = "pay as you go";
        $xml_data = '<activate-account trid="37543937592">
<authentication>
<username>' . $username . '</username>
<password>' . $password . '</password>
</authentication>
<msisdn>' . $msisdn . '</msisdn>
<iccid>' . $iccid . '</iccid>
<tariff-name>' . $tarif_name . '</tariff-name>
<balance-alert-level>0</balance-alert-level>
</activate-account>';


        $URL = "https://forumtel.com/ExternalApi/Rest/ProvisionServices.ashx";

        $ch = curl_init($URL);
        //curl_setopt($ch, CURLOPT_MUTE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        echo $output = curl_exec($ch);
        curl_close($ch);
        return true;
    }

    public static function suspendForumtel($customerid) {

        $tc = new Criteria();
        $tc->add(UsNumberPeer::CUSTOMER_ID, $customerid);
        $usnumber = UsNumberPeer::doSelectOne($tc);


        $username = "Zapna";
        $password = "ZUkATradafEfA4reYeWr";
        $msisdn = $usnumber->getMsisdn();
        $iccid = $usnumber->getIccid();

        $xml_data = '<suspend-account trid="37543937592">
<authentication>
<username>' . $username . '</username>
<password>' . $password . '</password>
</authentication>
<msisdn>' . $msisdn . '</msisdn>
<iccid>' . $iccid . '</iccid>
</suspend-account>';

        $URL = "https://forumtel.com/ExternalApi/Rest/ProvisionServices.ashx";

        $ch = curl_init($URL);
        //curl_setopt($ch, CURLOPT_MUTE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        echo $output = curl_exec($ch);
        curl_close($ch);
        return true;
    }

    public static function rechargeForumtel($customerid, $amount) {

        $tc = new Criteria();
        $tc->add(UsNumberPeer::CUSTOMER_ID, $customerid);
        $usnumber = UsNumberPeer::doSelectOne($tc);


        $username = "Zapna";
        $password = "ZUkATradafEfA4reYeWr";
        $msisdn = $usnumber->getMsisdn();
        $iccid = $usnumber->getIccid();
        $amount = $amount;

        $xml_data = '<top-up-subscriber trid="37543937592">
<authentication>
<username>' . $username . '</username>
<password>' . $password . '</password>
</authentication>
<msisdn>' . $msisdn . '</msisdn>
<iccid>' . $iccid . '</iccid>
<amount>' . $amount . '</amount>
</top-up-subscriber>';


        $URL = "https://forumtel.com/ExternalApi/Rest/BillingServices.ashx";

        $ch = curl_init($URL);
        //curl_setopt($ch, CURLOPT_MUTE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        echo $output = curl_exec($ch);
        curl_close($ch);
        return true;
    }

    public static function getBalanceForumtel($customer) {

        $customerid = $customer;

        $tc = new Criteria();
        $tc->add(UsNumberPeer::CUSTOMER_ID, $customerid);
        $usnumber = UsNumberPeer::doSelectOne($tc);


        $username = "Zapna";
        $password = "ZUkATradafEfA4reYeWr";
        $msisdn = $usnumber->getMsisdn();
        $iccid = $usnumber->getIccid();

        $url = "https://forumtel.com/ExternalApi/Rest/BillingServices.ashx";
        $post_string = '<get-subscriber-balance trid="37543937592">
<authentication>
<username>' . $username . '</username>
<password>' . $password . '</password>
</authentication>
<msisdn>' . $msisdn . '</msisdn>
 
</get-subscriber-balance>';




        $header = array();
        $header[] = "Content-type: text/xml";
        $header[] = "Content-length: " . strlen($post_string);
        $header[] = "Connection: close";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $data = curl_exec($ch);

        $data = substr($data, 215);
        $xml_obj = new SimpleXMLElement($data);
//var_dump($xml_obj);
//echo "<hr/>";
//die;
        $data = $xml_obj->balance[0]->attributes()->amount;

        return $data;
    }

}

?>