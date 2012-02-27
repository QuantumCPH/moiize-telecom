<?php
class smsCharacter{

    public static function smsCharacterReplacement($queryString)
    {  

   $replace = array(
			   '%C3%B8' => '%F8',
			   '%C3%A6' => '%E6',
			   '%C3%A5' => '%E5',
                           '%C3%86' => '%C6',
			   '%C3%98' => '%D8',
			   '%C3%85' => '%C5',
                           '%C3%96' => '%D6',
                           '%C3%B6' => '%F6',
                           '%0D%0A' => '%E4',
                           '%C3%A4' => '%E4'
			
			  );
		     $from_array = array();
		     $to_array = array();

		     foreach ($replace as $k => $v){
		         $from_array[] = $k;
		         $to_array[] = $v;
		     }

		       $queryString=str_replace($from_array,$to_array,$queryString);

				return $queryString;

	}
	
}


?>