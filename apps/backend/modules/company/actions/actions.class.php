<?php

set_time_limit(10000000);
require_once(sfConfig::get('sf_lib_dir') . '/company_employe_activation.class.php');
require_once(sfConfig::get('sf_lib_dir') . '/emailLib.php');

/**
 * autoCompany actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage autoCompany
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class companyActions extends sfActions {

    public function executeCountrycity(sfWebRequest $request) {

        $this->country_id = $request->getParameter('country_id');

        $c = new Criteria();
        $c->add(CityPeer::COUNTRY_ID, $this->country_id);
        $c->addAscendingOrderByColumn('name');
        $Lcities = CityPeer::doSelect($c);
        $cities_List = $Lcities;
        foreach ($Lcities as $city) {

            $cities_List[$city->getId()] = $city->getName();
        }
        $this->cities_list = $cities_List;
        $this->setLayout(false);
    }

    public function executeIndex(sfWebRequest $request) {
        return $this->forward('company', 'list');
    }

    public function executeList($request) {


        $this->processSort();

        $this->processFilters();

        $this->filters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/company/filters');

        // pager
        $this->pager = new sfPropelPager('Company', 1000);
        $c = new Criteria();
        $this->addSortCriteria($c);
        $this->addFiltersCriteria($c);
        $this->pager->setCriteria($c);
        $this->pager->setPage($this->getRequestParameter('page', $this->getUser()->getAttribute('page', 1, 'sf_admin/company')));
        $this->pager->init();

        // save page
        if ($this->getRequestParameter('page')) {
            $this->getUser()->setAttribute('page', $this->getRequestParameter('page'), 'sf_admin/company');
        }
    }

    public function executeCreate(sfWebRequest $request) {
        return $this->forward('company', 'edit');
    }

    public function executeSave(sfWebRequest $request) {
        return $this->forward('company', 'edit');
    }

    public function executeDeleteSelected(sfWebRequest $request) {
        $this->selectedItems = $this->getRequestParameter('sf_admin_batch_selection', array());

        try {
            foreach (CompanyPeer::retrieveByPks($this->selectedItems) as $object) {
                $object->delete();
            }
        } catch (PropelException $e) {
            $request->setError('delete', 'Could not delete the selected Agent. Make sure they do not have any associated items.');
            return $this->forward('company', 'list');
        }

        return $this->redirect('company/list');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->company = $this->getCompanyOrCreate();

        if ($request->isMethod('post')) {
            $this->updateCompanyFromRequest();

            try {
                $this->saveCompany($this->company);
            } catch (PropelException $e) {
                $request->setError('edit', $e.'<br />Could not save the edited Agent.');
                return $this->forward('company', 'list');
            }

            $this->getUser()->setFlash('notice', 'Your modifications have been saved');

            if ($this->getRequestParameter('save_and_add')) {
                return $this->redirect('company/create');
            } else if ($this->getRequestParameter('save_and_list')) {
                return $this->redirect('company/list');
            } else {
                return $this->redirect('company/edit?id=' . $this->company->getId());
            }
        } else {
            $this->labels = $this->getLabels();
        }
    }

    public function executeDelete(sfWebRequest $request) {
        $this->company = CompanyPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($this->company);

        try {
            $this->deleteCompany($this->company);
        } catch (PropelException $e) {
            $request->setError('delete', 'Could not delete the selected Agent. Make sure it does not have any associated items.');
            return $this->forward('company', 'list');
        }

        $currentFile = sfConfig::get('sf_upload_dir') . "//" . $this->company->getFilePath();
        if (is_file($currentFile)) {
            unlink($currentFile);
        }

        return $this->redirect('company/list');
    }

    public function handleErrorEdit() {
        $this->preExecute();
        $this->company = $this->getCompanyOrCreate();
        $this->updateCompanyFromRequest();

        $this->labels = $this->getLabels();

        return sfView::SUCCESS;
    }

    protected function saveCompany(Company $company) {
        $companyData = $this->getRequestParameter('company');
        $ComtelintaObj = new CompanyEmployeActivation();
        
        if ($company->isNew()) {     
            $res = $ComtelintaObj->telintaRegisterCompany($company);
            //var_dump($res);
        }
        //$company->isNew() . ":" . $res;
//die;
        if ($company->isNew() && $res) {
            $company->setInvoiceMethodId(2);
            $company->save();
            //$this->admin = UserPeer::retrieveByPK($this->getUser()->getAttribute('user_id', '', 'backendsession'));
            //send email
            emailLib::sendBackendAgentRegistration($company);

            $cc = new Criteria();
            $cc->add(CountryPeer::ID, $company->getCountryId());
            $country = CountryPeer::doSelectOne($cc);

            $mobile = $country->getCallingCode() . $company->getHeadPhoneNumber();
            //send sms
            $sm = new Criteria();
            $sm->add(SmsTextPeer::ID, 1);
            $smstext = SmsTextPeer::doSelectOne($sm);
            $sms_text = $smstext->getMessageText() . " Your Login is: " . $company->getVatNo() . " and Your Password is: " . $company->getPassword();
            CARBORDFISH_SMS::Send($mobile, $sms_text, "Moiize");
        } elseif (!$company->isNew()) {
            $update_customer['i_customer'] = $company->getICustomer();
            $update_customer['credit_limit'] = ($company->getCreditLimit() != '') ? $company->getCreditLimit() : '0';
            $res = $ComtelintaObj->updateCustomer($update_customer);
            $company->save();
        } elseif (!$res) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }
    }

    protected function deleteCompany($company) {
        $company->delete();
    }

    protected function updateCompanyFromRequest() {
        $company = $this->getRequestParameter('company');


        if (isset($company['name'])) {
            $this->company->setName($company['name']);
        }
        if (isset($company['vat_no'])) {
            $this->company->setVatNo(sfConfig::get("app_telinta_comp") . $company['vat_no']);
        }
        if (isset($company['password'])) {
            $this->company->setPassword($company['password']);
        }
        if (isset($company['address'])) {
            $this->company->setAddress($company['address']);
        }
        if (isset($company['post_code'])) {
            $this->company->setPostCode($company['post_code']);
        }
        if (isset($company['city_id'])) {
            $this->company->setCityId($company['city_id'] ? $company['city_id'] : null);
        }
        if (isset($company['country_id'])) {
            $this->company->setCountryId($company['country_id'] ? $company['country_id'] : null);
        }
        if (isset($company['contact_name'])) {
            $this->company->setContactName($company['contact_name']);
        }
        if (isset($company['email'])) {
            $this->company->setEmail($company['email']);
        }
        if (isset($company['head_phone_number'])) {
            $this->company->setHeadPhoneNumber($company['head_phone_number']);
        }
        if (isset($company['fax_number'])) {
            $this->company->setFaxNumber($company['fax_number']);
        }
        if (isset($company['website'])) {
            $this->company->setWebsite($company['website']);
        }
        if (isset($company['status_id'])) {
            $this->company->setStatusId($company['status_id'] ? $company['status_id'] : null);
        }
        if (isset($company['company_size_id'])) {
            $this->company->setCompanySizeId($company['company_size_id'] ? $company['company_size_id'] : null);
        }
        if (isset($company['company_type_id'])) {
            $this->company->setCompanyTypeId($company['company_type_id'] ? $company['company_type_id'] : null);
        }
        if (isset($company['customer_type_id'])) {
            $this->company->setCustomerTypeId($company['customer_type_id'] ? $company['customer_type_id'] : null);
        }
        if (isset($company['invoice_method_id'])) {
            $this->company->setInvoiceMethodId($company['invoice_method_id'] ? $company['invoice_method_id'] : null);
        }
        if (isset($company['agent_company_id'])) {
            $this->company->setAgentCompanyId($company['agent_company_id'] ? $company['agent_company_id'] : null);
        }
        if (isset($company['credit_limit'])) {
            $this->company->setCreditLimit($company['credit_limit'] ? $company['credit_limit'] : null);
        }
        if (isset($company['registration_date'])) {
            if ($company['registration_date']) {
                try {
                    $dateFormat = new sfDateFormat($this->getUser()->getCulture());
                    if (!is_array($company['registration_date'])) {
                        $value = $dateFormat->format($company['registration_date'], 'I', $dateFormat->getInputPattern('g'));
                    } else {
                        $value_array = $company['registration_date'];
                        $value = $value_array['year'] . '-' . $value_array['month'] . '-' . $value_array['day'] . (isset($value_array['hour']) ? ' ' . $value_array['hour'] . ':' . $value_array['minute'] . (isset($value_array['second']) ? ':' . $value_array['second'] : '') : '');
                    }
                    $this->company->setRegistrationDate($value);
                } catch (sfException $e) {
                    // not a date
                }
            } else {
                $this->company->setRegistrationDate(null);
            }
        }
        if (isset($company['created_at'])) {
            if ($company['created_at']) {
                try {
                    $dateFormat = new sfDateFormat($this->getUser()->getCulture());
                    if (!is_array($company['created_at'])) {
                        $value = $dateFormat->format($company['created_at'], 'I', $dateFormat->getInputPattern('g'));
                    } else {
                        $value_array = $company['created_at'];
                        $value = $value_array['year'] . '-' . $value_array['month'] . '-' . $value_array['day'] . (isset($value_array['hour']) ? ' ' . $value_array['hour'] . ':' . $value_array['minute'] . (isset($value_array['second']) ? ':' . $value_array['second'] : '') : '');
                    }
                    $this->company->setCreatedAt($value);
                } catch (sfException $e) {
                    // not a date
                }
            } else {
                $this->company->setCreatedAt(null);
            }
        }
        $currentFile = sfConfig::get('sf_upload_dir') . "//" . $this->company->getFilePath();
        if (!$this->getRequest()->hasErrors() && isset($company['file_path_remove'])) {
            $this->company->setFilePath('');
            if (is_file($currentFile)) {
                unlink($currentFile);
            }
        }

        if (!$this->getRequest()->hasErrors() && $this->getRequest()->getFileSize('company[file_path]')) {
            $fileName = md5($this->getRequest()->getFileName('company[file_path]') . time() . rand(0, 99999));
            $ext = $this->getRequest()->getFileExtension('company[file_path]');
            if (is_file($currentFile)) {
                unlink($currentFile);
            }
            $this->getRequest()->moveFile('company[file_path]', sfConfig::get('sf_upload_dir') . "//" . $fileName . $ext);
            $this->company->setFilePath($fileName . $ext);
        }
    }

    protected function getCompanyOrCreate($id = 'id') {
        if ($this->getRequestParameter($id) === ''
                || $this->getRequestParameter($id) === null) {
            $company = new Company();
        } else {
            $company = CompanyPeer::retrieveByPk($this->getRequestParameter($id));

            $this->forward404Unless($company);
        }

        return $company;
    }

    protected function processFilters() {
        if ($this->getRequest()->hasParameter('filter')) {
            $this->getUser()->getAttributeHolder()->removeNamespace('sf_admin/company/filters');

            $filters = $this->getRequestParameter('filters');
            if (is_array($filters)) {
                $this->getUser()->getAttributeHolder()->removeNamespace('sf_admin/company');
                $this->getUser()->getAttributeHolder()->removeNamespace('sf_admin/company/filters');
                $this->getUser()->getAttributeHolder()->add($filters, 'sf_admin/company/filters');
            }
        }
    }

    protected function processSort() {
        if ($this->getRequestParameter('sort')) {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/company/sort');
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/company/sort');
        }

        if (!$this->getUser()->getAttribute('sort', null, 'sf_admin/company/sort')) {
            
        }
    }

    protected function addFiltersCriteria($c) {
        if (isset($this->filters['company_name_is_empty'])) {
            $criterion = $c->getNewCriterion(CompanyPeer::COMPANY_NAME, '');
            $criterion->addOr($c->getNewCriterion(CompanyPeer::COMPANY_NAME, null, Criteria::ISNULL));
            $c->add($criterion);
        } else if (isset($this->filters['id']) && $this->filters['id'] !== '') {
            $c->add(CompanyPeer::ID, $this->filters['id']);
        }
        if (isset($this->filters['vat_no_is_empty'])) {
            $criterion = $c->getNewCriterion(CompanyPeer::VAT_NO, '');
            $criterion->addOr($c->getNewCriterion(CompanyPeer::VAT_NO, null, Criteria::ISNULL));
            $c->add($criterion);
        } else if (isset($this->filters['vat_no']) && $this->filters['vat_no'] !== '') {
            $c->add(CompanyPeer::VAT_NO, $this->filters['vat_no']);
        }
    }

    protected function addSortCriteria($c) {
        if ($sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/company/sort')) {
            // camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
            $sort_column = CompanyPeer::translateFieldName(sfInflector::camelize(strtolower($sort_column)), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
            if ($this->getUser()->getAttribute('type', null, 'sf_admin/company/sort') == 'asc') {

                $c->addAscendingOrderByColumn($sort_column);
            } else {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }

    protected function getLabels() {
        return array(
            'company{name}' => 'Name:',
            'company{vat_no}' => 'Vat no:',
            'company{password}' => 'Password:',
            'company{address}' => 'Address:',
            'company{post_code}' => 'Post code:',
            'company{city_id}' => 'City:',
            'company{country_id}' => 'Country:',
            'company{contact_name}' => 'Contact name:',
            'company{email}' => 'Email:',
            'company{head_phone_number}' => 'Mobile Number:',
            'company{fax_number}' => 'Fax number:',
            'company{website}' => 'Website:',
            'company{status_id}' => 'Status:',
            'company{company_size_id}' => 'Company size:',
            'company{company_type_id}' => 'Company type:',
            'company{customer_type_id}' => 'Customer type:',
            'company{invoice_method_id}' => 'Invoice method:',
            'company{agent_company_id}' => 'Agent company:',
            'company{registration_date}' => 'Registration date:',
            'company{created_at}' => 'Created at:',
            'company{file_path}' => 'Registration Doc:',
            'company{credit_limit}' => 'Credit Limit:',
        );
    }

    public function executeView($request) {
        $this->company = CompanyPeer::retrieveByPK($request->getParameter('id'));
        $ComtelintaObj = new CompanyEmployeActivation();
        $this->balance = $ComtelintaObj->getBalance($this->company);
    }

    public function executeUsage($request) {
        $ComtelintaObj = new CompanyEmployeActivation();
        /* $this->company = CompanyPeer::retrieveByPK($request->getParameter('company_id'));
          $tomorrow1 = mktime(0, 0, 0, date("m"), date("d") - 15, date("Y"));
          $fromdate = date("Y-m-d", $tomorrow1);
          $tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
          $todate = date("Y-m-d", $tomorrow);
          $this->callHistory = $ComtelintaObj->callHistory($this->company, $fromdate, $todate);
         */

        $this->company = CompanyPeer::retrieveByPK($request->getParameter('company_id'));
        if (isset($_POST['startdate']) && isset($_POST['enddate'])) {
            $this->fromdate = $request->getParameter('startdate');
            $this->todate = $request->getParameter('enddate');
        } else {
            $tomorrow1 = mktime(0, 0, 0, date("m"), date("d") - 3, date("Y"));
            $this->fromdate = date("Y-m-d", $tomorrow1);
            //$tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
            $this->todate = date("Y-m-d");
        }
        $this->iaccount = $request->getParameter('iaccount');
        if (isset($this->iaccount) && $this->iaccount != '') {
            $ce = new Criteria();
            $ce->add(TelintaAccountsPeer::ID, $this->iaccount);
            $ce->addAnd(TelintaAccountsPeer::STATUS, 3);
            $telintaAccount = TelintaAccountsPeer::doSelectOne($ce);
            ;

            $this->iAccountTitle = $telintaAccount->getAccountTitle();

            $this->callHistory = $ComtelintaObj->getAccountCallHistory($telintaAccount->getIAccount(), $this->fromdate . " 00:00:00", $this->todate . " 23:59:59");
        } else {
            //$tomorrow1 = mktime(0, 0, 0, date("m"), date("d") - 15, date("Y"));
            // $this->fromdate = date("Y-m-d", $tomorrow1);
            //$tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
            //$this->todate = date("Y-m-d");

            $this->callHistory = $ComtelintaObj->callHistory($this->company, $this->fromdate . " 00:00:00", $this->todate . " 23:59:59");
            /* var_dump($this->callHistory);die; */
        }

        $c = new Criteria();
        $c->add(TelintaAccountsPeer::I_CUSTOMER, $this->company->getICustomer());
        $c->addAnd(TelintaAccountsPeer::STATUS, 3);
        $this->telintaAccountObj = TelintaAccountsPeer::doSelect($c);
    }

    public function executeRefill(sfWebRequest $request) {

        $c = new Criteria();
        $this->companys = CompanyPeer::doSelect($c);

        $cTD = new Criteria();
        $cTD->addAnd(TransactionDescriptionPeer::TRANSACTION_TYPE_ID, 1);
        $this->transactionDesc = TransactionDescriptionPeer::doSelect($cTD);

        if ($request->isMethod('post')) {
            $ComtelintaObj = new CompanyEmployeActivation();
            $company_id = $request->getParameter('company_id');
            $refill_amount = $request->getParameter('refill');
            $descriptionId = $request->getParameter('descriptionId');

            ////// Transaction Description//////
            $cT = new Criteria();
            $cT->add(TransactionDescriptionPeer::ID, $descriptionId);
            $description = TransactionDescriptionPeer::doSelectOne($cT);

            ////// End Transaction Description//////

            $c1 = new Criteria();
            $c1->addAnd(CompanyPeer::ID, $company_id);
            $this->company = CompanyPeer::doSelectOne($c1);
            $companyCVR = $this->company->getVatNo();

            $transaction = new CompanyTransaction();
            $transaction->setAmount($refill_amount);
            $transaction->setCompanyId($company_id);
            $transaction->setExtraRefill($refill_amount);
            $transaction->setTransactionStatusId(1);
            $oldBalance = $ComtelintaObj->getBalance($this->company);
            $transaction->setOldBalance($oldBalance);
            $transaction->setPaymenttype(2); //Refill
            $transaction->setDescription($description->getTitle());
            $transaction->setTransactionDescriptionId($description->getId());
            $transaction->setTransactionType($description->getTransactionTypeId());
            $transaction->save();

            if ($ComtelintaObj->recharge($this->company, $refill_amount, $transaction)) {
                $newBalance = $ComtelintaObj->getBalance($this->company);
                $transaction->setNewBalance($newBalance);
                $transaction->setTransactionStatusId(3);
                $transaction->save();
                //$adminUser = UserPeer::retrieveByPK($this->getUser()->getAttribute('user_id', '', 'backendsession'));
                emailLib::sendCompanyRefillEmail($this->company, $transaction);
                $this->getUser()->setFlash('message', 'Agent Refill Successfully');
                $this->redirect('company/paymenthistory');
            } else {

                $this->getUser()->setFlash('message', 'Please Select Agent');
            }
            //$telintaAddAccount='success=OK&Amount=$amount{$cust_info->{iso_4217}}';
            //parse_str($telintaAddAccount, $success);print_r($success);echo $success['success'];
        }
    }

    public function executeAgentCharge(sfWebRequest $request) {

        $c = new Criteria();
        $this->companys = CompanyPeer::doSelect($c);
        $cTD = new Criteria();
        $cTD->addAnd(TransactionDescriptionPeer::TRANSACTION_TYPE_ID, 2);
        $this->transactionDesc = TransactionDescriptionPeer::doSelect($cTD);
        $ComtelintaObj = new CompanyEmployeActivation();
        if ($request->isMethod('post')) {
            $company_id = $request->getParameter('company_id');
            $charge_amount = $request->getParameter('refill');
            $descriptionId = $request->getParameter('descriptionId');
            ////// Transaction Description//////
            $cT = new Criteria();
            $cT->add(TransactionDescriptionPeer::ID, $descriptionId);
            $description = TransactionDescriptionPeer::doSelectOne($cT);

            ////// End Transaction Description//////

            $c1 = new Criteria();
            $c1->addAnd(CompanyPeer::ID, $company_id);
            $this->company = CompanyPeer::doSelectOne($c1);
            $companyCVR = $this->company->getVatNo();

            $transaction = new CompanyTransaction();
            $transaction->setAmount(-$charge_amount);
            $transaction->setCompanyId($company_id);
            $transaction->setExtraRefill(-$charge_amount);
            $transaction->setTransactionStatusId(1);
            $transaction->setPaymenttype(2); //Refill
            $transaction->setDescription($description->getTitle());
            $transaction->setTransactionDescriptionId($description->getId());
            $oldBalance = $ComtelintaObj->getBalance($this->company);
            $transaction->setOldBalance($oldBalance);


            $transaction->setTransactionType($description->getTransactionTypeId());
            $transaction->save();


            if ($ComtelintaObj->charge($this->company, $charge_amount)) {
                $transaction->setTransactionStatusId(3);
                $newBalance = $ComtelintaObj->getBalance($this->company);
                $transaction->setNewBalance($newBalance);
                $transaction->save();
                //$adminUser = UserPeer::retrieveByPK($this->getUser()->getAttribute('user_id', '', 'backendsession'));
                emailLib::sendCompanyRefillEmail($this->company, $transaction);
                $this->getUser()->setFlash('message', 'Agent Charged Successfully');
                $this->redirect('company/paymenthistory');
            } else {

                $this->getUser()->setFlash('message', 'Please Select Agent');
            }
            //$telintaAddAccount='success=OK&Amount=$amount{$cust_info->{iso_4217}}';
            //parse_str($telintaAddAccount, $success);print_r($success);echo $success['success'];
        }
    }

    public function executePaymenthistory(sfWebRequest $request) {

        $cm = new Criteria();
        $cm->addAscendingOrderByColumn(CompanyPeer::NAME);
        $this->companies = CompanyPeer::doSelect($cm);
        $tr = new Criteria();
        $this->transactionstypes = TransactionTypePeer::doSelect($tr);



        $c = new Criteria();
        $companyid = $request->getParameter('company_id');
        $this->companyid = $companyid;
        $transactionType_id = $request->getParameter('transactionType_id');
        $this->transactionType_id = $transactionType_id;
       // $this->$transactionType_id = $transactionType_id;

        $this->transactionDescription_id = $request->getParameter('transaction_description_id');

        $this->from = $request->getParameter('from');
        $this->to = $request->getParameter('to');
        if ($this->from == '') {
            $this->from = date('Y-m-d', strtotime('-15 days'));
        }
        if ($this->to == '') {
            $this->to = date('Y-m-d');
        }


        $c->add(CompanyTransactionPeer::TRANSACTION_STATUS_ID, 3);

        if (isset($companyid) && $companyid != '') {
            $c->addAnd(CompanyTransactionPeer::COMPANY_ID, $companyid);
        }
        $this->cntTransaction = 0;
        if (isset($transactionType_id) && $transactionType_id != '') {
            $c->addAnd(CompanyTransactionPeer::TRANSACTION_TYPE, $transactionType_id);
            $tc = new Criteria();
            $tc->add(TransactionDescriptionPeer::TRANSACTION_TYPE_ID, $transactionType_id);
            $this->transactionDescriptions = TransactionDescriptionPeer::doSelect($tc);
            $this->cntTransaction = TransactionDescriptionPeer::doCount($tc);
        }
        if ($this->transactionDescription_id != "") {
            $c->addAnd(CompanyTransactionPeer::TRANSACTION_DESCRIPTION_ID, $this->transactionDescription_id);
        }

        $c->addAnd(CompanyTransactionPeer::CREATED_AT, $this->from . " 00:00:00", Criteria::GREATER_EQUAL);
        $c->addAnd(CompanyTransactionPeer::CREATED_AT, $this->to . " 23:59:59", Criteria::LESS_EQUAL);
        $c->addDescendingOrderByColumn(CompanyTransactionPeer::CREATED_AT);
        $this->transactions = CompanyTransactionPeer::doSelect($c);
    }

    public function executeVat(sfWebRequest $request) {

        $c = new Criteria();
        $vat_no = $_POST['vat_no'];
        $c->add(CompanyPeer::VAT_NO, $vat_no);
        if (CompanyPeer::doSelectOne($c)) {

            echo "no";
        } else {
            echo "yes";
        }
    }

    public function executeShowReceipt(sfWebRequest $request) {
        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 02/28/11
        changeLanguageCulture::languageCulture($request, $this);
        $transaction_id = $request->getParameter('tid');
        $transaction = CompanyTransactionPeer::retrieveByPK($transaction_id);

        $this->renderPartial('company/refill_receipt', array(
            'company' => CompanyPeer::retrieveByPK($transaction->getCompanyId()),
            'transaction' => $transaction,
            'vat' => 0,
        ));

        return sfView::NONE;
    }

    public function executeIndexAll(sfWebRequest $request) {
        $c = new Criteria();
        $this->companies = CompanyPeer::doSelect($c);
    }

    public function executeWithBillingInfo(sfWebRequest $request) {
        $c = new Criteria();
        $c->add(CompanyPeer::STATUS_ID, 1);
        $this->companies = CompanyPeer::doSelect($c);
    }

    public function executeEditCreditLimit(sfWebRequest $request) {
        $count = 0;
        $count = count($request->getParameter('company_id'));
        $creditlimit = $request->getParameter('creditlimit');
        $ComtelintaObj = new CompanyEmployeActivation();
        for ($i = 0; $i < $count; $i++) {
            $id = $request->getParameter('company_id');

            $company = CompanyPeer::retrieveByPk($id[$i]);
            $oldcreditlimit = $company->getCreditLimit();
            $company->setCreditLimit($creditlimit);
            $company->save();
            $update_customer['i_customer'] = $company->getICustomer();
            $update_customer['credit_limit'] = ($company->getCreditLimit() != '') ? $company->getCreditLimit() : '0';
            if (!$ComtelintaObj->updateCustomer($update_customer)) {
                $company->setCreditLimit($oldcreditlimit);
                $company->save();
            }
        }

        $this->getUser()->setFlash('message', 'All Selected Agent Credit Limit is updated');
        $this->redirect('company/indexAll');
        return sfView::NONE;
    }

    public function executeUpdateCreditLimit(sfWebRequest $request) {
        $c = new Criteria();
        $companies = CompanyPeer::doSelect($c);
        $ComtelintaObj = new CompanyEmployeActivation();
        foreach ($companies as $company) {
            $companyinfo = $ComtelintaObj->getCustomerInfo($company);
            $company->setCreditLimit($companyinfo->credit_limit);
            $company->save();
        }

        return sfView::NONE;
    }

    public function executeGetTransactionDescriptionDropDown(sfWebRequest $request) {
        $transactionType_id = $request->getParameter('type_id');
        $tc = new Criteria();
        $tc->add(TransactionDescriptionPeer::TRANSACTION_TYPE_ID, $transactionType_id);
        $transactionDescriptions = TransactionDescriptionPeer::doSelect($tc);

        $str = '<option value="">Select Transaction Description </option>';
        foreach ($transactionDescriptions as $d) {
            $str.= '<option value="' . $d->getId() . '"   >' . $d->getTitle() . '</option>';
        }

        echo $str;
        return sfView::NONE;
    }

}
