<?php

set_time_limit(10000000);

/**
 * rt_rates actions.
 *
 * @package    zapnacrm
 * @subpackage rt_rates
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class rt_ratesActions extends autort_ratesActions {

    public function executeUpdateRates(sfWebRequest $request) {
        $this->countries = RtCountriesPeer::doSelect(new Criteria());
        $c = new Criteria();
        $c->addDescendingOrderByColumn(RtServicesPeer::ID);
        $this->services = RtServicesPeer::doSelect($c);

        if ($request->getParameter('truncate') == 'due') {
            $con = Propel::getConnection();
            $con->exec('truncate rt_rates');
        }


        if ($request->isMethod('post')) {
            $con = Propel::getConnection();
            $con->exec('truncate rt_rates');
            foreach ($this->countries as $country) {
                foreach ($this->services as $service) {
                    $rate = new RtRates();
                    $rate->setRtCountryId($country->getId());
                    $rate->setRtServiceId($service->getId());
                    $label = $country->getId() . "_" . $service->getId();
                    $rate->setRate($request->getParameter($label));
                    $rate->save();
                }
            }
            
            $this->countries = RtCountriesPeer::doSelect(new Criteria());
            $c->addDescendingOrderByColumn(RtServicesPeer::ID);
            $this->services = RtServicesPeer::doSelect($c);
        }
        $this->lang = $request->getParameter('lang');
    }

    public function executeExportRateTable(sfWebRequest $request) {


        if ($request->isMethod('post')) {

            $filename = str_replace(" ", '-', $request->getParameter("filename")) . time() . ".csv";
            $myFile = "/var/www/moiize-telecom/ratetables/" . $filename;
            $fh = fopen($myFile, 'w') or die("can't open file");
            $conn = Propel::getConnection();
            $sql = "SELECT rt_descriptions.CODE as code, rt_countries.TITLE as en, rt_countries.DA_TITLE as da, rt_countries.ES_TITLE as es, rt_countries.DE_TITLE as de,rt_countries.SV_TITLE as sv, rt_descriptions.DESCRIPTION as description, rt_rates.RATE as rate, rt_services.TITLE as service FROM `rt_descriptions` LEFT JOIN rt_countries ON (rt_descriptions.RT_COUNTRY_ID=rt_countries.ID) LEFT JOIN rt_services ON (rt_descriptions.RT_SERVICE_ID=rt_services.ID) LEFT JOIN rt_rates ON (rt_descriptions.RT_SERVICE_ID=rt_rates.RT_SERVICE_ID) WHERE rt_descriptions.RT_COUNTRY_ID=rt_rates.RT_COUNTRY_ID ORDER BY rt_countries.TITLE ASC,rt_descriptions.CODE ASC";
            $statement = $conn->prepare($sql);
            $statement->execute();

            $comma = ",";
            $stringData = "Code,Country,Description,Rate";
            $stringData.= "\n";
            fwrite($fh, $stringData);
            while ($description = $statement->fetch()) {

                if ($request->getParameter("desc") == 'on')
                    $desc = $description['description'];
                else
                    $desc = $description['service'];

                $stringData = $description['code'] . $comma . $description[$request->getParameter("lang")] . $comma . $desc . $comma . $description['rate'];
                $stringData.= "\n";
                fwrite($fh, $stringData);
            }
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($myFile));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($myFile));
            ob_clean();
            flush();
            readfile($myFile);
            exit;
        }
    }

}
