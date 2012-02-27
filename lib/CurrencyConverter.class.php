<?php
class CurrencyConverter {

	public static function convert1($from, $to, $amount)
	{
		
	}
	
    public static function convert($from, $to, $amount)
    {
        $curreny_converter_api = 'http://www.google.com/ig/calculator';

        $query_string_vars = array(
        	'hl'=>'en',
        	'q'=>sprintf('%d%s=?%s', $amount, $from, $to)
        );

        $url = $curreny_converter_api . '?' . http_build_query($query_string_vars);

        $json =  file_get_contents($url);
        
        if ($json)
            $json = self::fixJsonString($json);
		
	return json_decode($json, true);
		
    }

    public static function getExchangeRate($from, $to)
    {
        $curreny_converter_api = 'http://www.google.com/ig/calculator';

        $query_string_vars = array(
        	'hl'=>'en',
        	'q'=>sprintf('%d%s=?%s', 1, $from, $to)
        );

        $url = $curreny_converter_api . '?' . http_build_query($query_string_vars);

        $json =  file_get_contents($url);

        if ($json)
            $json = self::fixJsonString($json);

	$json_object = json_decode($json, true);
        $json_object['rhs'];
    }
    
    private static function fixJsonString($json)
    {
    	$pattern_replacement = array(
    		'({)' => '{"',
    		'(,)' => ',"',
    		'(:)' => '":',
    	);
    	
    	return preg_replace(array_keys($pattern_replacement), array_values($pattern_replacement), $json);
    }
    
    public static function getLastJsonError()
    {
        switch(json_last_error())
        {
            case JSON_ERROR_DEPTH:
                $error =  ' - Maximum stack depth exceeded';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = ' - Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $error = ' - Syntax error, malformed JSON';
                break;
            case JSON_ERROR_NONE:
            default:
                $error = '';                   
        }

        return $error;
    }
    public static function convertSekToUsd($amount)
	{

        $amount =$amount;
$from ='SEK';
$to ='USD';

//make string to be put in API
$string = $amount."".$from."=?".$to;

//Call Google API
 $google_url = "http://www.google.com/ig/calculator?hl=en&q=".$string;

//Get and Store API results into a variable
$result = file_get_contents($google_url);

//Explode result to convert into an array
$result = explode('"', $result);
//var_dump($result);
################################
# Right Hand Side
################################
$converted_amount = explode(' ', $result[3]);
   $conversion = $converted_amount[0];
//echo $conversion = preg_replace('/[x00-x08x0B-x1F]/', '', $conversion);

 $conversion = $conversion;
$conversion = round($conversion, 2);

//Get text for converted currency
 $rhs_text = ucwords(str_replace($converted_amount[0],"",$result[3]));

//Make right hand side string
  //$rhs = $conversion.$rhs_text;
  $rhs = $conversion;

################################
# Left Hand Side
################################
$google_lhs = explode(' ', $result[1]);
  $from_amount = $google_lhs[0];

//Get text for converted from currency
$from_text = ucwords(str_replace($from_amount,"",$result[1]));

//Make left hand side string
//$lhs = $amount." ".$from_text;
$lhs = $amount;

################################
# Make the result
################################
return $rhs;
	}

}

?>