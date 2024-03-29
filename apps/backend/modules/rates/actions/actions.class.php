<?php

/**
 * rates actions.
 *
 * @package    zapnacrm
 * @subpackage rates
 * @author     Your name here
 */
class ratesActions extends autoratesActions
{
   public function executeUploadRates(sfWebRequest $request)
   {
      //echo "here"; 
       $pp = new Criteria();
       $this->pricePlans = PricePlanPeer::doSelect($pp);
        
       if($request->isMethod('post'))
       {
          $fileTmpName = $_FILES['csv_upload']['tmp_name'];
          $fileName = $_FILES['csv_upload']['name'];
          $path_info = pathinfo($fileName);
          $extension = $path_info['extension'];  
          $fileSize = $_FILES['csv_upload']['size'];
          if(!$fileSize)
          {
              $this->getUser()->setFlash('file_error', $this->getContext()->getI18N()->__('File is Empty.'));
              exit;
          }
          elseif($extension !='csv')
          {
              $this->getUser()->setFlash('file_error', $this->getContext()->getI18N()->__('Just csv files are allowed.'));
              exit;
          }
          else
          {
              $file = fopen($fileTmpName,"r");
              if(!$file) {
               $this->getUser()->setFlash('file_error', $this->getContext()->getI18N()->__('Error opening data file.'));   
               exit;
              }
              $csv = fread($file, $fileSize); 
              $csv = str_replace('"', '', $csv);
              fclose($file);
              $fieldsArray = array('title','standard_rates','premium_rates');
              $data = explode("\n", $csv);
              $updatedRate = array();
              //print_r($rates);
              $already = 0;
              for($i=1;$i <count($data); $i++){
                 if(trim($data[$i])!=""){
                  $c = explode (",",$data[$i]);
                  $combine = array_combine($fieldsArray,$c);
                     foreach($combine as $key => $values){ 
                       $combine[$key] = trim($values);
                     }                   
                 }
              $cR = new Criteria();
              $cR->add(RatesPeer::TITAL,$combine["title"]);
              $rateCount = RatesPeer::doCount($cR);
              
                  if($rateCount > 0){
                   $rate = RatesPeer::doSelectOne($cR);   
                   $rate->setStandardPackageRates($combine['standard_rates']);
                   $rate->setPremiumPackageRates($combine['premium_rates']);
                   $rate->save();
                   $updatedRate[] = $rate->getTital();
                  }else{
                   $new_rates = new Rates();   
                   $new_rates->setTital($combine["title"]);
                   $new_rates->setStandardPackageRates($combine['standard_rates']);
                   $new_rates->setPremiumPackageRates($combine['premium_rates']);
                   $new_rates->save(); 
                  }   
              }
              $this->getUser()->setFlash('file_done', $this->getContext()->getI18N()->__('New rates are added.'));
              $this->updatedRec = $updatedRate;             
              //print_r($this->updatedRec);
          }
       }
   }
   
}
