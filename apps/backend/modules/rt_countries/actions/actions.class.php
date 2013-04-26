<?php

set_time_limit(10000000);

/**
 * rt_countries actions.
 *
 * @package    zapnacrm
 * @subpackage rt_countries
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class rt_countriesActions extends autort_countriesActions {

    public function executeUploadCSV(sfWebRequest $request) {
        //echo "here"; 
        if ($request->isMethod('post')) {
            $fileTmpName = $_FILES['csv_upload']['tmp_name'];
            $fileName = $_FILES['csv_upload']['name'];
            $path_info = pathinfo($fileName);
            $extension = $path_info['extension'];
            $fileSize = $_FILES['csv_upload']['size'];
            if (!$fileSize) {
                $this->getUser()->setFlash('file_error', $this->getContext()->getI18N()->__('File is Empty.'));
                exit;
            } elseif ($extension != 'csv') {
                $this->getUser()->setFlash('file_error', $this->getContext()->getI18N()->__('Just csv files are allowed.'));
                exit;
            } else {
                $file = fopen($fileTmpName, "r");
                if (!$file) {
                    $this->getUser()->setFlash('file_error', $this->getContext()->getI18N()->__('Error opening data file.'));
                    exit;
                }
                $csv = fread($file, $fileSize);
                $csv = str_replace('"', '', $csv);
                fclose($file);
                $fieldsArray = array('country', 'description', 'code');
                $data = explode("\n", $csv);
                $updatedRate = array();

                $already = 0;
                $con = Propel::getConnection();
                $con->exec('truncate rt_descriptions');
                $con->exec('truncate rt_countries');
                $ct = "";
                for ($i = 1; $i < count($data); $i++) {
                    if ($data[$i] != "") {
                        $c = explode(",", $data[$i]);
                        $combine = array_combine($fieldsArray, $c);
                        foreach ($combine as $key => $values) {
                            $combine[$key] = trim($values);
                        }
                    }

                    if ($combine["country"] != $ct) {
                        $ct=$combine["country"];
                        $cR = new Criteria();
                        $cR->add(RtCountriesPeer::TITLE, $combine["country"]);
                        $countryCount = RtCountriesPeer::doCount($cR);

                        if ($countryCount > 0) {
                            $country = RtCountriesPeer::doSelectOne($cR);
                        } else {
                            $country = new RtCountries();
                            $country->setTitle($combine["country"]);
                            $country->save();
                        }
                    }

                    if (substr_count(strtolower($combine["description"]), "satellite") > 0) {
                        continue;
                    }

                    $description = new RtDescriptions();
                    $description->setCode($combine["code"]);
                    $description->setDescription($combine["description"]);
                    $description->setRtCountryId($country->getId());
                    if (substr_count(strtolower($combine["description"]), "cellular") > 0 || substr_count(strtolower($combine["description"]), "telef") > 0 || substr_count(strtolower($combine["description"]), "mobile") > 0)
                        $description->setRtServiceId(1);
                    else
                        $description->setRtServiceId(2);
                    $description->save();
                }
                $this->getUser()->setFlash('file_done', $this->getContext()->getI18N()->__('New rates are added.'));
                $this->updatedRec = $updatedRate;
                //print_r($this->updatedRec);
            }
        }
    }

}
