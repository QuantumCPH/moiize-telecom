<?php

/**
 * company actions.
 *
 * @package    zapnacrm
 * @subpackage company
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class companyActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeDashboard(sfWebRequest $request) {
        $this->forward404Unless($this->getUser()->getAttribute('companyname', '', 'companysession'));
        $this->company = CompanyPeer::retrieveByPK($this->getUser()->getAttribute('company_id', '', 'companysession'));
        $this->balance = CompanyEmployeActivation::getBalance($this->company);
        $nc = new Criteria();
        $nc->addDescendingOrderByColumn(NewupdatePeer::STARTING_DATE);
        $this->updateNews = NewupdatePeer::doSelect($nc);
    }

    public function executeLogin($request) {
        if ($request->getParameter('new'))
            $this->getUser()->setCulture($request->getParameter('new'));
        else
            $this->getUser()->setCulture($this->getUser()->getCulture());
 //die();
        $this->form = new CompanyLoginForm();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('login'), $request->getFiles('login'));
            if ($this->form->isValid()) {
                $c = new Criteria();
                $c->Add(CompanyPeer::VAT_NO, $this->form->getValue('vat_no'));
                $c->addAnd(CompanyPeer::PASSWORD, $this->form->getValue('password'));
                $company = CompanyPeer::doSelectOne($c);


                if ($company) {
                    $this->getUser()->setAuthenticated(true);
                    $this->getUser()->setAttribute('company_id', $company->getId(), 'companysession');
                    $this->getUser()->setAttribute('companyname', $company->getName(), 'companysession');
                    $this->redirect(sfConfig::get('app_main_url') . 'company/dashboard');
                }
            }
        }
    }

    public function executeLogout() {
        $this->getUser()->getAttributeHolder()->removeNamespace('companysession');
        $this->getUser()->setAuthenticated(false);
        $this->redirect(sfConfig::get('app_main_url') .'company/login');
    }

    public function executeNewsListing(sfWebRequest $request) {
        $this->forward404Unless($this->getUser()->isAuthenticated());


        $c = new Criteria();
        $c->addDescendingOrderByColumn(NewupdatePeer::STARTING_DATE);
        $news = NewupdatePeer::doSelect($c);
        $this->news = $news;
    }

    public function executeView($request) {

        $this->forward404Unless($this->getUser()->getAttribute('companyname', '', 'companysession'));
        $this->company = CompanyPeer::retrieveByPK($this->getUser()->getAttribute('company_id', '', 'companysession'));
        $this->balance = CompanyEmployeActivation::getBalance($this->company);
        $c = new Criteria();
        $c->Add(EmployeePeer::COMPANY_ID, $this->company->getId());
        $this->employeesCount = EmployeePeer::doCount($c);
    }

    public function executePaymentHistory(sfWebRequest $request) {
        $this->forward404Unless($this->getUser()->getAttribute('companyname', '', 'companysession'));
        $c = new Criteria();
        $c->add(CompanyTransactionPeer::TRANSACTION_STATUS_ID, 3);
        $c->addAnd(CompanyTransactionPeer::COMPANY_ID, $this->getUser()->getAttribute('company_id', '', 'companysession'));
        $c->addDescendingOrderByColumn(CompanyTransactionPeer::CREATED_AT);
        $this->transactions = CompanyTransactionPeer::doSelect($c);
    }

    public function executeShowReceipt(sfWebRequest $request) {
        $this->forward404Unless($this->getUser()->getAttribute('companyname', '', 'companysession'));
        $c = new Criteria();
        $c->add(CompanyTransactionPeer::TRANSACTION_STATUS_ID, 3);
        $c->addAnd(CompanyTransactionPeer::COMPANY_ID, $this->getUser()->getAttribute('company_id', '', 'companysession'));
        $c->addAnd(CompanyTransactionPeer::ID, $request->getParameter('tid'));
        $transactionCount = CompanyTransactionPeer::doCount($c);
        if ($transactionCount == 1) {
            $transaction = CompanyTransactionPeer::doSelectOne($c);
            $this->renderPartial('company/refill_receipt', array(
                'company' => CompanyPeer::retrieveByPK($transaction->getCompanyId()),
                'transaction' => $transaction,
                'vat' => 0,
            ));
        } else {
            die("Unable to Show the Reciept");
        }
        return sfView::NONE;
    }

    public function executeCallHisotry(sfWebRequest $request) {
        $this->forward404Unless($this->getUser()->getAttribute('companyname', '', 'companysession'));
        $this->company = CompanyPeer::retrieveByPK($this->getUser()->getAttribute('company_id', '', 'companysession'));
    if(isset($_POST['startdate']) && isset($_POST['enddate'])){
       $fromdate=$request->getParameter('startdate');
       $todate=$request->getParameter('enddate');
}else{
        $tomorrow1 = mktime(0, 0, 0, date("m"), date("d") - 15, date("Y"));
        $fromdate = date("Y-m-d", $tomorrow1);
        $tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
        $todate = date("Y-m-d", $tomorrow);
       
}
       $iaccount = $request->getParameter('iaccount');
 if (isset($iaccount) && $iaccount!='') {
        $ce = new Criteria();
        $ce->add(TelintaAccountsPeer::ID, $iaccount);
        $ce->addAnd(TelintaAccountsPeer::STATUS, 3);
        $telintaAccount = TelintaAccountsPeer::doSelectOne($ce);;

           $this->iAccountTitle = $telintaAccount->getAccountTitle();
          
            $this->callHistory = CompanyEmployeActivation::getAccountCallHistory($telintaAccount->getIAccount(), $fromdate, $todate);
        } else {
            
            $this->callHistory = CompanyEmployeActivation::callHistory($this->company, $fromdate, $todate);
        }

        $c = new Criteria();
        $c->add(TelintaAccountsPeer::I_CUSTOMER, $this->company->getICustomer());
        $c->addAnd(TelintaAccountsPeer::STATUS, 3);
        $this->telintaAccountObj = TelintaAccountsPeer::doSelect($c);
    }
    
    public function executeForgotPassword(sfWebRequest $request){
        
      if ($request->isMethod('post')) {    
        $c = new Criteria();
        $c->add(CompanyPeer::VAT_NO, $request->getParameter('vat_number'));
        $c->add(CompanyPeer::STATUS_ID, sfConfig::get('app_status_completed', 1));

        
        $company = CompanyPeer::doSelectOne($c);

        if ($company) {
            //change the password to some thing uniuque and complex
            $new_password = substr(base64_encode($company->getPassword()), 0, 8);

            $company->setPassword($new_password);
            $message_body = $this->getContext()->getI18N()->__('Hi') . ' ' . $company->getName() . '!';
            $message_body .= '<br /><br />';
            $message_body .= $this->getContext()->getI18N()->__('Your password has been changed. Please use the following information to login to your Moiize agent account.');
            $message_body .= '<br /><br />';
            $message_body .= sprintf($this->getContext()->getI18N()->__('Vat Number: %s'), $company->getVatNo());
            $message_body .= '<br />';
            $message_body .= $this->getContext()->getI18N()->__('password') . ': ' . $new_password;

            $company->save();


            $subject = $this->getContext()->getI18N()->__('Password Request');
            $sender_email = sfConfig::get('app_email_sender_email', 'rs@zapna.com');
            $sender_name = sfConfig::get('app_email_sender_name', 'support');

            $message = $message_body;
            
            
            $receipient_email = trim($company->getEmail());
            $receipient_name = sprintf('%s', $company->getContactName());
            
            $cc = new Criteria();
            $cc->add(CountryPeer::ID,$company->getCountryId());
            $country = CountryPeer::doSelectOne($cc);
            
            ////SMS Text
            
            $sms_txt = $this->getContext()->getI18N()->__('Hi') . ' ' . $company->getName() . '! ';
            $sms_txt .= $this->getContext()->getI18N()->__('Your new password is . ');
            $sms_txt .= sprintf($this->getContext()->getI18N()->__('Log In: %s'), $company->getVatNo());
            $sms_txt .= " ".$this->getContext()->getI18N()->__('Password') . ': ' . $new_password;
            
            
            $mobileNumber = $company->getHeadPhoneNumber();
            
            if(substr($mobileNumber,0,2)=="00"){
              $mobileNumber =  substr_replace($mobileNumber, "", 0, 2);
            }
            $mobileNumber = $country->getCallingCode().$mobileNumber;
            
           
            emailLib::sendAgentForgetPasswordEmail($company, $message, $subject);
            CARBORDFISH_SMS::Send($mobileNumber, $sms_txt,"Moiize");
            
            $this->getUser()->setFlash('send_password_message', $this->getContext()->getI18N()->__('Your account details have been sent to your email address and mobile number.'));
        }
        else {
            $this->getUser()->setFlash('send_password_error_message', $this->getContext()->getI18N()->__('No agent is registered with this vat number.'));
        }
        return $this->redirect(sfConfig::get('app_main_url').'company/login');
      }
    }
   public function executeRates(sfWebRequest $request)
   {
      $cr = new Criteria();
      $this->rates = RatesPeer::doSelect($cr);
   }
   public function executeChangePassword(sfWebRequest $request)
   {
       $this->forward404Unless($this->getUser()->getAttribute('companyname', '', 'companysession'));
       $this->company = CompanyPeer::retrieveByPK($this->getUser()->getAttribute('company_id', '', 'companysession'));
       $this->vatNo = $this->company->getVatNo();
       
       if($request->isMethod('post'))
       {
           $oldPassword = $request->getParameter('oldPassword');
           $newPassword = $request->getParameter('newPassword');
           
           if($oldPassword == $this->company->getPassword()){
               $this->company->setPassword($newPassword);
               $this->company->save();
               $this->getUser()->setFlash('change_password_message', $this->getContext()->getI18N()->__('Your password has been changed.'));
           }else{
               $this->getUser()->setFlash('change_password_error_message', $this->getContext()->getI18N()->__('Old Password did not match'));
           }
          return $this->redirect(sfConfig::get('app_main_url').'company/view');     
       }
   }
}
