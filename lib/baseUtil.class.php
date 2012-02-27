<?php
	class BaseUtil
	{
		public static function html2pdf($html_content)
		{ // return the path to pdf file
			$html_file_path = '';
			$pdf_file_path = '';
			
			try {
				$tmpname=rand(0,9999).'-'.microtime(true);
				$fp = fopen($html_file_path = sfConfig::get('sf_upload_dir').'/tmp/'.$tmpname.'.htm', 'w');
				fwrite($fp, $html_content);
				fclose($fp);
				shell_exec($exec_path = sfConfig::get('sf_lib_dir')."/wkhtmltopdf/wkhtmltopdf ".$html_file_path.' '.($pdf_file_path = sfConfig::get('sf_upload_dir').'/tmp/'.$tmpname.'.pdf'). ' --footer-right "[page] af [toPage]" --footer-left http://www.zapna.com --footer-font-size 7 --encoding utf8 -q');
				return $pdf_file_path;
				
				//header('Content-type: application/pdf');
				//header('Content-Disposition: attachment; filename="'.$title.'.pdf"');
				//echo file_get_contents($pdf_file_path);
				
				//unlink($html_file_path);
				//unlink($pdf_file_path);
				//shell_exec('rm '.dirname(FILE).'/tmp/'.$tmpname.'.htm');
				//hell_exec('rm '.dirname(FILE).'/tmp/'.$tmpname.'.pdf');
			}
			catch (Exception $e)
			{
				throw $e;
			}
			
			return $pdf_file_path;
	     
		}
		

		static function str_replace_assoc($string){
			
			$replace = array(
			   'Ã˜' => 'ø',
			   'Ã¦' => 'æ',
			   'Ã¥' => 'å'
			  );
			  	
		     $from_array = array();
		     $to_array = array();
		    
		     foreach ($replace as $k => $v){
		         $from_array[] = $k;
		         $to_array[] = $v;
		     }
		    
		     return str_replace($from_array,$to_array,$string);
		 }
		 
		 static function format_number($number, $decimal_points = 2)
		 { //get the number in the form xxxx.x0
		 	return number_format($number, $decimal_points, ',', ' ');
		 }
		 
		 /** 
		  *  unset all fields except given parameters 
		  * 
		  * @param array $fields Array of fields 
		  */  
		static function unsetAllExcept($fields = array(), $form)  
		{  
		$tmp = array_keys($form->widgetSchema->getFields());
		   
		foreach(array_diff($tmp, $fields) as $value){  
			unset($form[$value]);  
			}  
		}

	static function request_url($url, sfWebRequest $request = null, $post_vars = array() )
	{
		//request a url using php_curl
		$result = 'error';
		$cookie= "cookie.txt";

		if (!$url)
			return $result;

		$c = curl_init($url);
		
		if (count($post_vars))
		{
			curl_setopt($c, CURLOPT_POST, 1);
			curl_setopt($c, CURLOPT_POSTFIELDS, 
				http_build_query( $post_vars )
			) ;	
		}
		
		curl_setopt($c, CURLOPT_COOKIEFILE, $cookie);

		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);

		curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3 (.NET CLR 3.5.30729)');

		curl_setopt($c, CURLOPT_TIMEOUT, 60);
	
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1); //!important
		
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); //return the content
		
		curl_setopt($c, CURLOPT_COOKIEJAR, $cookie);
		
		if ($request)
			curl_setopt($c, CURLOPT_REFERER, $request->getReferer());

		curl_setopt($c, CURLOPT_HEADER, 0);
		
		curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		
		try {
			$result = curl_exec($c);
		}
		catch (Exception $e)
		{
			// nice to see no code here
		}
		
		curl_close ($c);

		return $result;
		
	}
		
	static function post_url($url, array $query_string, sfWebRequest $request = null)
	{
		$result = 'error';
		$cookie= "cookie.txt";

		if (!$url)
			return $result;

		$c = curl_init($url);
		
		if (count($query_string))
		{
			curl_setopt($c, CURLOPT_POSTFIELDS, 
				http_build_query( $query_string )
			) ;	
		}
		
		$errors = array();
		
		curl_setopt($c, CURLOPT_POST, 1);
		print_r(curl_error($c));
		
		curl_setopt($c, CURLOPT_COOKIEFILE, $cookie);
		print_r(curl_error($c));
		
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		print_r(curl_error($c));
		
		curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3 (.NET CLR 3.5.30729)') || die('curl error @' . (++$stage));
		print_r(curl_error($c));
		
		curl_setopt($c, CURLOPT_TIMEOUT, 120) || die('curl error @' . (++$stage));
		print_r(curl_error($c));
		
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1) || die('curl error @' . (++$stage)); //!important
		print_r(curl_error($c));
		
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1) || die('curl error @' . (++$stage)); //return the content
		print_r(curl_error($c));
		
		curl_setopt($c, CURLOPT_COOKIEJAR, $cookie) || die('curl error @' . (++$stage)); // !important, coz if off only show 'default'  theme
		print_r(curl_error($c));
		
		curl_setopt($c, CURLOPT_REFERER, $request->getReferer()) || die('curl error @' . (++$stage));
		print_r(curl_error($c));
		
		curl_setopt($c, CURLOPT_HEADER, 1);
		print_r(curl_error($c));
		
		curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		
		try {
			$result = curl_exec($c);
			
			//echo 'my_result'.$result;
			//exit;
		}
		catch (Exception $e)
		{
			// nice to see no code here
			echo $e;
		}
		
		curl_close ($c);

		return $result;
	}
	
	public static function getEpayRelayScriptUrl()
	{
		return 'https://relay.ditonlinebetalingssystem.dk/relay/v2/relay.cgi/';
		
	}

	public static function moveFile($source_file, $destination_file)
	{
		$success = true;
		if (!copy($source_file, $destination_file)) $success=false;
		if (!unlink($source_file)) $success=false;

		return $success;
	}
	
	public static function trimMobileNumber($mobile_number)
	{
		//return the last 8 digits of a number
		return substr($mobile_number, strlen($mobile_number)-8);
	}
	
}
?>