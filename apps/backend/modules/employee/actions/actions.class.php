<?php
set_time_limit(10000000);
require_once(sfConfig::get('sf_lib_dir') . '/company_employe_activation.class.php');
require_once(sfConfig::get('sf_lib_dir') . '/emailLib.php');

/**
 * employee actions.
 *
 * @package    zapnacrm
 * @subpackage employee
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class employeeActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $c = new Criteria();
        $companyid = $request->getParameter('company_id');
        $this->companyval = $companyid;
        if (isset($companyid) && $companyid != '') {
            $c->addAnd(EmployeePeer::COMPANY_ID, $companyid);
        }
        $this->employees = EmployeePeer::doSelect($c);
    }

    public function executeEdit(sfWebRequest $request) {

        $e = new Criteria();
        $e->add(EmployeePeer::ID, $request->getParameter('id'));
        $this->employee = EmployeePeer::doSelectOne($e);


        $c = new Criteria();
        $this->companys = CompanyPeer::doSelect($c);

        $pr = new Criteria();
        $pr->add(ProductPeer::ID, 1);
        //$pr->add(ProductPeer::IS_IN_ZAPNA, 1);
        $this->products = ProductPeer::doSelect($pr);
        
        $pp = new Criteria();
        $pp->add(PricePlanPeer::STATUS_ID,1, Criteria::EQUAL);
        $this->pricePlans = PricePlanPeer::doSelect($pp);
        
        // created by kmmalik.com for new module of telinta product
        $tp = new Criteria();
        $this->telintaProducts = TelintaProductPeer::doSelect($tp);
        // created by kmmalik.com for new module of telinta Routing plan
        $trp = new Criteria();
        $this->telintaRoutingplans = TelintaRoutingplanPeer::doSelect($trp);
    }

    protected function addFiltersCriteria($c) {

        if (isset($this->filters['vat_no']) && $this->filters['vat_no'] !== '') {
            $c->add(CompanyPeer::VAT_NO, strtr($this->filters['vat_no'], '*', '%'), Criteria::LIKE);
            $c->addJoin(CompanyPeer::ID, EmployeePeer::COMPANY_ID);

            $this->filters['company_id'] = '';
        } else {
            parent::addFiltersCriteria($c);
        }

        //$c->add(CompanyPeer::VAT_NO, strtr($this->filters['vat_no'], '*', '%'), Criteria::LIKE);
        //$c->addJoin(CompanyPeer::ID, EmployeePeer::COMPANY_ID);
        //$tmp = $this->filters['vat_no'];
    }

    public function executeView($request) {
        $this->employee = EmployeePeer::retrieveByPK($request->getParameter('id'));
        $ct = new Criteria();
        $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, sfConfig::get("app_telinta_emp") . $this->employee->getCompanyId() . $this->employee->getId());
        $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
        $telintaAccount = TelintaAccountsPeer::doSelectOne($ct);
        $ComtelintaObj = new CompanyEmployeActivation();
        $account_info = $ComtelintaObj->getAccountInfo($telintaAccount->getIAccount());
        $this->balance = $account_info->account_info->balance;
    }

    public function executeAppCode($request) {
        $this->employee = EmployeePeer::retrieveByPK($request->getParameter('id'));


        $c = new Criteria();
        $c->add(EmployeePeer::APP_CODE, NULL);
        $employees = EmployeePeer::doSelect($c);

        foreach ($employees as $employee) {

            $emplyid = $employee->getId();
            $emplycompanyid = $employee->getCompanyId();

            $appcode = $emplyid . "" . $emplycompanyid;

            $applen = strlen($appcode);
            if (isset($applen) && $applen == 2) {

                $appcode = "00" . $appcode;
            }
            if (isset($applen) && $applen == 3) {

                $appcode = "0" . $appcode;
            }

            //   echo " <br/>".$appcode;
            //  $employee->setId($emplyid);
            $employee->setAppCode($appcode);


            $employee->save();
        }

        return $this->redirect('employee/index');
    }

    public function executeAdd($request) {

        $this->companyval = $request->getParameter('company_id');

        $c = new Criteria();
        $this->companys = CompanyPeer::doSelect($c);

        $pr = new Criteria();
        $pr->add(ProductPeer::ID, 1);
        $this->products = ProductPeer::doSelect($pr);
        // created by kmmalik.com for new module of telinta product
        $pp = new Criteria();
        $this->pricePlans = PricePlanPeer::doSelect($pp);
        // created by kmmalik.com for new module of telinta Routing plan
        $trp = new Criteria();
        $this->telintaRoutingplans = TelintaRoutingplanPeer::doSelect($trp);
    }

    public function executeAddMultiple($request) {

        $this->companyval = $request->getParameter('company_id');

        $c = new Criteria();
        $this->companys = CompanyPeer::doSelect($c);

        $pr = new Criteria();
        $pr->add(ProductPeer::ID, 1);
        $this->products = ProductPeer::doSelect($pr);
        
        $pp = new Criteria();
        $this->pricePlans = PricePlanPeer::doSelect($pp);
        
        // created by kmmalik.com for new module of telinta product
        $tp = new Criteria();
        $this->telintaProducts = TelintaProductPeer::doSelect($tp);
        // created by kmmalik.com for new module of telinta Routing plan
        $trp = new Criteria();
        $this->telintaRoutingplans = TelintaRoutingplanPeer::doSelect($trp);
    }

    public function executeSaveEmployee($request) {


        //$contrymobilenumber = $request->getParameter('country_code') . $request->getParameter('mobile_number');
        //$employeMobileNumber=$contrymobilenumber;


        $c = new Criteria();
        $c->addAnd(CompanyPeer::ID, $request->getParameter('company_id'));
        $this->companys = CompanyPeer::doSelectOne($c);
//echo $request->getParameter('telintaProductId');
//echo "<br/>".$request->getParameter('telintaRoutingplanId');
//
//die;
        /************ Select telinta product and routing plan from Price plan ***********/
        $priceplanid = $request->getParameter('pricePlanId');
        $pp = new Criteria();
        $pp->addAnd(PricePlanPeer::ID, $priceplanid);
        $priceplan = PricePlanPeer::doSelectOne($pp);
        //echo $priceplan->getTelintaRoutingplan();
        /************ End ***********/
        $employee = new Employee();
        $employee->setCompanyId($request->getParameter('company_id'));
        $employee->setFirstName($request->getParameter('first_name'));
        $employee->setProductId($request->getParameter('productid'));
        $employee->setTelintaProductId($priceplan->getTelintaProduct()->getIProduct());
        $employee->setTelintaRoutingplanId($priceplan->getTelintaRoutingplan()->getIRoutingPlan());
        $employee->setPricePlanId($priceplanid);
        $employee->save();
        $voipAccount = sfConfig::get("app_telinta_emp") . $this->companys->getId() . $employee->getId();
        $ComtelintaObj = new CompanyEmployeActivation();
        $ComtelintaObj->telintaRegisterEmployee($voipAccount, $this->companys, $employee);

        $this->getUser()->setFlash('messageAdd', 'PCO Line has been added successfully' . (isset($msg) ? "and " . $msg : ''));
        $this->redirect('employee/index?message=add');
    }

    public function executeSaveMultipleEmployee($request) {

        $numberOfEmployee = 0;
        //$contrymobilenumber = $request->getParameter('country_code') . $request->getParameter('mobile_number');
        //$employeMobileNumber=$contrymobilenumber;
        $numberOfLines = $request->getParameter('numberOfLines');
        $c = new Criteria();
        $c->addAnd(CompanyPeer::ID, $request->getParameter('company_id'));
        $this->companys = CompanyPeer::doSelectOne($c);
        
        /************ Select telinta product and routing plan from Price plan ***********/
        $priceplanid = $request->getParameter('pricePlanId');
        $pp = new Criteria();
        $pp->addAnd(PricePlanPeer::ID, $priceplanid);
        $priceplan = PricePlanPeer::doSelectOne($pp);
        //echo $priceplan->getTelintaRoutingplan();
        /************ End ***********/
        
        $ec = new Criteria();
        $ec->addAnd(EmployeePeer::COMPANY_ID, $request->getParameter('company_id'));
        $numberOfEmployee = EmployeePeer::doCount($ec);
        $numberOfEmployee++;
        $i = 1;
        while ($i <= $numberOfLines) {



            $employeeName = "Line " . $numberOfEmployee;

            $employee = new Employee();
            $employee->setCompanyId($request->getParameter('company_id'));
            $employee->setFirstName($employeeName);
            $employee->setProductId($request->getParameter('productid'));
            $employee->setTelintaProductId($priceplan->getTelintaProduct()->getIProduct());
            $employee->setTelintaRoutingplanId($priceplan->getTelintaRoutingplan()->getIRoutingPlan());
            $employee->setPricePlanId($priceplanid);
            $employee->save();
            $voipAccount = sfConfig::get("app_telinta_emp") . $this->companys->getId() . $employee->getId();
            $numberOfEmployee;
            $ComtelintaObj = new CompanyEmployeActivation();
            $ComtelintaObj->telintaRegisterEmployee($voipAccount, $this->companys, $employee);

            $numberOfEmployee++;
            $i++;
        }

        $this->getUser()->setFlash('messageAdd', 'PCO Line has been added successfully' . (isset($msg) ? "and " . $msg : ''));
        $this->redirect('employee/index?message=add');
    }

    public function executeUpdateEmployee(sfWebRequest $request) {
        $c = new Criteria();
        echo $request->getParameter('company_id');
        $c->add(CompanyPeer::ID, $request->getParameter('company_id'));

        $compny = CompanyPeer::doSelectOne($c);
        $companyCVR = $compny->getVatNo();
        // $rtype=$request->getParameter('registration_type');
        $employee = EmployeePeer::retrieveByPk($request->getParameter('id'));
        
         /************ Select telinta product and routing plan from Price plan ***********/
        $priceplanid = $request->getParameter('pricePlanId');
        $pp = new Criteria();
        $pp->addAnd(PricePlanPeer::ID, $priceplanid);
        $priceplan = PricePlanPeer::doSelectOne($pp);
        //echo $priceplan->getTelintaRoutingplan();
        /************ End ***********/
        $new_iproduct          = $priceplan->getTelintaProduct()->getIProduct();
        $new_iproduct_title    = $priceplan->getTelintaProduct()->getTitle();
        $new_routingplan       = $priceplan->getTelintaRoutingplan()->getIRoutingPlan();
        $new_routingplan_title = $priceplan->getTelintaRoutingplan()->getTitle();
        
        $ct = new Criteria();
        $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, sfConfig::get("app_telinta_emp").$employee->getCompanyId().$employee->getId());
        $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
        $telintaAccount = TelintaAccountsPeer::doSelectOne($ct);
        if($telintaAccount){
            $acc_title = $telintaAccount->getIAccount();
        }  else {
            $acc_title = "";
        }
            
        if ($employee->getTelintaProductId()!=$new_iproduct || $employee->getTelintaRoutingplanId()!=$new_routingplan) {
            $ComtelintaObj = new CompanyEmployeActivation();
            if($ComtelintaObj->updateAccount($employee, $new_iproduct, $new_routingplan)){                
                
                $employee->setFirstName($request->getParameter('first_name'));
                $employee->setLastName($request->getParameter('last_name'));

                $employee->setMobileNumber($request->getParameter('mobile_number'));
                $employee->setEmail($request->getParameter('email'));
                $employee->setProductId($request->getParameter('productid'));
                $employee->setTelintaProductId($new_iproduct);
                $employee->setTelintaRoutingplanId($new_routingplan);
                $employee->setPricePlanId($priceplanid);
                $employee->setDeleted($request->getParameter('deleted'));
                $employee->save();
                
                $pph = new PricePlanHistory();
                $pph->setCompanyId($employee->getCompanyId());
                $pph->setEmployeeId($employee->getId());
                $pph->setPricePlanId($employee->getPricePlanId());
                $pph->setPricePlanTitle($employee->getPricePlan()->getTitle());
                $pph->setTelintaProductId($employee->getTelintaProductId());
                $pph->setTelintaProductTitle($new_iproduct_title);
                $pph->setTelintaRoutingplanTitle($new_routingplan_title);
                $pph->setTelintaRoutingplanId($employee->getTelintaRoutingplanId());
                $pph->setIaccount($acc_title);
                $pph->setChangedBy("Admin");
                $pph->setAccountTitle(sfConfig::get("app_telinta_emp").$employee->getCompanyId().$employee->getId());
                $pph->save();
                
                $this->getUser()->setFlash('messageEdit', 'PCO Line has been edited successfully' . (isset($msg) ? "and " . $msg : ''));
            }else{
                $this->getUser()->setFlash('messageEditError', 'PCO Line has not been edited successfully' . (isset($msg) ? "and " . $msg : ''));
            }
        }

        $c = new Criteria();
        $c->addAnd(CompanyPeer::ID, $employee->getCompanyId());
        $this->companys = CompanyPeer::doSelectOne($c);
        $companyCVR = $this->companys->getVatNo();
        $companyCVRNumber = $companyCVR;
        

        $this->redirect('employee/index?message=edit');
        // return sfView::NONE;
    }

    public function executeDel(sfWebRequest $request) {
        $request->checkCSRFProtection();
        $employeeid = $request->getParameter('id');
        $c = new Criteria();
        $c->add(EmployeePeer::ID, $employeeid);
        $employees = EmployeePeer::doSelectOne($c);
        $registration = $employees->getRegistrationType();
        //$mobileNumber=$employees->getCountryMobileNumber();
        $companyid = $request->getParameter('company_id');
        $contrymobilenumber = $employees->getCountryMobileNumber();

        $ct = new Criteria();
        $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, sfConfig::get("app_telinta_emp") . $employees->getCompanyId() . $employees->getId());
        $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
        $telintaAccount = TelintaAccountsPeer::doSelectOne($ct);
        $ComtelintaObj = new CompanyEmployeActivation();
        if (!$ComtelintaObj->terminateAccount($telintaAccount)) {
            $this->getUser()->setFlash('messageEdit', 'PCO Line has not been deleted Sucessfully Error in Callthrough Account');
            if (isset($companyid) && $companyid != "") {
                $this->redirect('employee/index?company_id=' . $companyid . '&filter=filter');
            } else {
                $this->redirect('employee/index?message=edit');
            }
            return false;
        }
//        $telintaRegisterCus1 = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=delete&name=cb'.$contrymobilenumber.'&type=account');
//        parse_str($telintaRegisterCus1);
//            if(isset($success) && $success!="OK"){
//                emailLib::sendErrorInTelinta("Error in employee  delete account", 'We have faced an issue in employee deletion on telinta. this is the error on the following url https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=delete&name=cb'.$contrymobilenumber.'&type=account');
//                $this->getUser()->setFlash('message', 'Employee has not been deleted Sucessfully! Error in Callback Account');
//                if(isset($companyid) && $companyid!=""){$this->redirect('employee/index?company_id='.$companyid.'&filter=filter');}
//                else{$this->redirect('employee/index');}
//                return false;
//            }
        $this->forward404Unless($employee = EmployeePeer::retrieveByPk($request->getParameter('id')), sprintf('Object PCO Line does not exist (%s).', $request->getParameter('id')));


//                $getvoipInfo = new Criteria();
//                $getvoipInfo->add(SeVoipNumberPeer::CUSTOMER_ID, $contrymobilenumber);
//                $getvoipInfo->addAnd(SeVoipNumberPeer::IS_ASSIGNED, 1);
//                $getvoipInfos = SeVoipNumberPeer::doSelectOne($getvoipInfo); //->getId();
//                if (isset($getvoipInfos)) {
//                    $voipnumbers = $getvoipInfos->getNumber();
//                    $voipnumbers = substr($voipnumbers, 2);
//
//                    $telintaDeactivate = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=update&name=' . $voipnumbers . '&active=N&follow_me_number=' . $contrymobilenumber . '&type=account');
//                    parse_str($telintaDeactivate);
//                    if(isset($success) && $success!="OK"){
//                        emailLib::sendErrorInTelinta("Error in employee  delete account", 'We have faced an issue in employee deletion on telinta. this is the error on the following url https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=update&name=' . $voipnumbers . '&active=N&follow_me_number=' . $contrymobilenumber . '&type=account');
//                        $this->getUser()->setFlash('message', 'Employee has not been deleted Sucessfully! Error in Deactivate Resenummer');
//                        if(isset($companyid) && $companyid!=""){$this->redirect('employee/index?company_id='.$companyid.'&filter=filter');}
//                        else{$this->redirect('employee/index');}
//                        return false;
//                    }
//                    $telintaDeleteResenummer = file_get_contents('https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=delete&name='.$voipnumbers.'&type=account');
//                    parse_str($telintaDeleteResenummer);
//                    if(isset($success) && $success!="OK"){
//                        emailLib::sendErrorInTelinta("Error in employee  delete account", 'We have faced an issue in employee deletion on telinta. this is the error on the following url https://mybilling.telinta.com/htdocs/zapna/zapna.pl?action=delete&name='.$voipnumbers.'&type=account');
//                        $this->getUser()->setFlash('message', 'Employee has not been deleted Sucessfully! Error in delete resenummer');
//                        if(isset($companyid) && $companyid!=""){$this->redirect('employee/index?company_id='.$companyid.'&filter=filter');}
//                        else{$this->redirect('employee/index');}
//                        return false;
//                    }
//                    $getvoipInfos->setUpdatedAt(Null);
//                    $getvoipInfos->setCustomerId(Null);
//                    $getvoipInfos->setIsAssigned(0);
//                    $getvoipInfos->save();
//
//                 }


        $employee->delete();
        $this->getUser()->setFlash('messageEdit', 'PCO Line has been deleted Sucessfully');
        if (isset($companyid) && $companyid != "") {
            $this->redirect('employee/index?company_id=' . $companyid . '&filter=filter');
        } else {
            $this->redirect('employee/index?message=edit');
        }
    }

    public function executeUsage($request) {
        $this->employee = EmployeePeer::retrieveByPK($request->getParameter('employee_id'));

        $c = new Criteria();
        $c->addAnd(CompanyPeer::ID, $this->employee->getCompanyId());
        $this->companys = CompanyPeer::doSelectOne($c);

        $tomorrow1 = mktime(0, 0, 0, date("m"), date("d") - 3, date("Y"));
        $fromdate = date("Y-m-d", $tomorrow1);
        $tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
        $todate = date("Y-m-d", $tomorrow);

        $mobilenumber = $this->employee->getCountryMobileNumber();
        $ct = new Criteria();
        $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, sfConfig::get("app_telinta_emp") . $this->employee->getCompanyId() . $this->employee->getId());
        $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
        $telintaAccount = TelintaAccountsPeer::doSelectOne($ct);
        $ComtelintaObj = new CompanyEmployeActivation();
        $this->callHistory = $ComtelintaObj->getAccountCallHistory($telintaAccount->getIAccount(), $fromdate. " 00:00:00", $todate. " 23:59:59");
    }

    public function executeMobile(sfWebRequest $request) {

        $c = new Criteria();
        $mobile_no = $_POST['mobile_no'];
        $c->add(EmployeePeer::MOBILE_NUMBER, $mobile_no);
        if (EmployeePeer::doSelectOne($c)) {
            echo "no";
        } else {
            echo "yes";
        }
    }

    public function executeEditMultiple($request) {

        $this->companyval = $request->getParameter('company_id');

        $c = new Criteria();
        $this->companys = CompanyPeer::doSelect($c);

        $pr = new Criteria();
        $pr->add(ProductPeer::ID, 1);
        $this->products = ProductPeer::doSelect($pr);
      
        $tp = new Criteria();
        $this->telintaProducts = TelintaProductPeer::doSelect($tp);
       
        $trp = new Criteria();
        $this->telintaRoutingplans = TelintaRoutingplanPeer::doSelect($trp);
        
        /************ Select telinta product and routing plan from Price plan ***********/
        $ppc = new Criteria();
        $ppc->add(PricePlanPeer::STATUS_ID,1 , Criteria::EQUAL);
        $priceplans = PricePlanPeer::doSelect($ppc);
        $this->priceplans = $priceplans;
        
        /************ End ***********/
        
        $ce = new Criteria();
        $companyid = $request->getParameter('company_id');
        $this->companyval = $companyid;
        $this->count = 0;
        if (isset($companyid) && $companyid != '') {
            if($request->getParameter('all_company')==1){
                $this->count=$request->getParameter('all_company');
                $ce->addAnd(EmployeePeer::COMPANY_ID, $companyid, Criteria::IN);
            }else{
                $ce->addAnd(EmployeePeer::COMPANY_ID, $companyid);
            }
                $ce->addAscendingOrderByColumn('company_id');
                $this->employees = EmployeePeer::doSelect($ce);
        }else{
                $this->employees ="";
        }
        
    }

    public function executeEditMultipleEmployee($request) {
    $block='';
        $count=count($request->getParameter('id'));
        /************ Select telinta product and routing plan from Price plan ***********/
        $priceplanid = $request->getParameter('pricePlanId');
        
        $pp = new Criteria();
        $pp->addAnd(PricePlanPeer::ID, $priceplanid);
        $priceplan = PricePlanPeer::doSelectOne($pp);
        $new_iproduct        = $priceplan->getTelintaProduct()->getIProduct();
        $new_iproduct_title  = $priceplan->getTelintaProduct()->getTitle();
        $new_routingplan = $priceplan->getTelintaRoutingplan()->getIRoutingPlan();
        $new_routingplan_title = $priceplan->getTelintaRoutingplan()->getTitle();
        
        /************ End ***********/
        for($i=0; $i<$count; $i++){
            $id = $request->getParameter('id');
            $employee = EmployeePeer::retrieveByPk($id[$i]);
            if($request->getParameter('block')!=''){
                $block=$request->getParameter('block');
            }else{
                $block=$employee->getBlock();
            }
            if ($employee->getTelintaProductId()!= $new_iproduct || $employee->getTelintaRoutingplanId()!= $new_routingplan || $block!='') {
              $ComtelintaObj = new CompanyEmployeActivation();
              $result = $ComtelintaObj->updateAccount($employee, $new_iproduct, $new_routingplan, $block);
            }
            
            if($result){
                $ct = new Criteria();
                $ct->add(TelintaAccountsPeer::ACCOUNT_TITLE, sfConfig::get("app_telinta_emp").$employee->getCompanyId().$employee->getId());
                $ct->addAnd(TelintaAccountsPeer::STATUS, 3);
                $telintaAccount = TelintaAccountsPeer::doSelectOne($ct);
                if($telintaAccount){
                    $iaccount = $telintaAccount->getIAccount();
                }  else {
                    $iaccount = "";
                }
        
                $employee->setProductId($request->getParameter('productid'));
                $employee->setTelintaProductId($new_iproduct);
                $employee->setTelintaRoutingplanId($new_routingplan);
                $employee->setPricePlanId($priceplanid);
                $employee->setBlock($block);
                $employee->save();
                
                $pph = new PricePlanHistory();
                $pph->setCompanyId($employee->getCompanyId());
                $pph->setEmployeeId($employee->getId());
                $pph->setPricePlanId($employee->getPricePlanId());
                $pph->setPricePlanTitle($employee->getPricePlan()->getTitle());
                $pph->setTelintaProductId($employee->getTelintaProductId());
                $pph->setTelintaProductTitle($new_iproduct_title);
                $pph->setTelintaRoutingplanTitle($new_routingplan_title);
                $pph->setTelintaRoutingplanId($employee->getTelintaRoutingplanId());
                $pph->setIaccount($iaccount);
                $pph->setChangedBy("Admin");
                $pph->setAccountTitle(sfConfig::get("app_telinta_emp").$employee->getCompanyId().$employee->getId());
                $pph->save();
            }else{
                continue;
            }
        }
            $this->getUser()->setFlash('message', 'PCO Lines has been updated Sucessfully');
        if($request->getParameter('all_company')==1){
            $this->redirect('employee/indexAll');
        }else{
            $this->redirect('employee/editMultiple');
        }
        
      
    }

    public function executeIndexAll(sfWebRequest $request) {
        $c = new Criteria();
        $this->companies = CompanyPeer::doSelect($c);
    }

}
