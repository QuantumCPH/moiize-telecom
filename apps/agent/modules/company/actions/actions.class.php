<?php

/**
 * company actions.
 *
 * @package    zapnacrm
 * @subpackage company
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class companyActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
      $c = new Criteria();
      $c->add(CompanyPeer::AGENT_COMPANY_ID, $this->getUser()->getAttribute('agent_company_id', '', 'agentsession'));
      $c->addDescendingOrderByColumn('created_at');

    $this->company_list = CompanyPeer::doSelect($c);
  }

  public function executeNew(sfWebRequest $request)
  {
      $this->form = new CompanyForm();

      $agent_user = AgentUserPeer::retrieveByPK($this->getUser()->getAttribute('agent_id', '', 'agentsession'));

      $this->form->setDefault('agent_company_id', $agent_user->getAgentCompanyId());

      $this->form->setDefault('status_id', sfConfig::get('app_status_pending'));
      
      $this->form->setDefault('account_manager_id', $agent_user->getAgentCompany()->getAccountManagerId());
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $rst = new Company();

    $data = $request->getParameter('company');

    if($data)
        $rst->setCountryId($data['country_id']);

    $this->form = new CompanyForm($rst);

     if($request->getParameter('refresh') == 'Y')
    {
    	$this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    	return $this->renderPartial('countrycity', array('form' => $this->form));
    }


    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($company = CompanyPeer::retrieveByPk($request->getParameter('id')), sprintf('Object company does not exist (%s).', $request->getParameter('id')));
    $this->form = new CompanyForm($company);

    $this->form->setDefault('created_at',
                    $company->getCreatedAt() == ''? date("m/d/Y H:i", time()) : $company->getCreatedAt());

    $this->form->setDefault('company_id', $company->getId());
                    
    $banks = $company->getCompanyBanks();

    if($banks){
        $this->form->setDefault('reg_nr', $banks[0]->getRegNr());
        $this->form->setDefault('account_number', $banks[0]->getAccountNumber());
    }

    $product_orders = $company->getProductOrders();

    if($product_orders){
        $this->form->setDefault('sim_card_quantity', $product_orders[0]->getSimCardQuantity());
        $this->form->setDefault('price_per_sim', $product_orders[0]->getPricePerSim());
    }

  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($company = CompanyPeer::retrieveByPk($request->getParameter('id')), sprintf('Object company does not exist (%s).', $request->getParameter('id')));
    $this->form = new CompanyForm($company);
    
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($company = CompanyPeer::retrieveByPk($request->getParameter('id')), sprintf('Object company does not exist (%s).', $request->getParameter('id')));
    $company->delete();

    $this->redirect('company/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
        $company = $form->save();

        if($form->getValue('reg_nr') || $form->getValue('account_number')){

            $c = new Criteria();

            $c->add(CompanyBankPeer::COMPANY_ID, $company->getId());

            if(!$company_bank = CompanyBankPeer::doSelectOne($c)){
               $company_bank = new CompanyBank();
            }

            $company_bank->setCompanyId($company->getId());

            $company_bank->setRegNr($form->getValue('reg_nr'));

            $company_bank->setAccountNumber($form->getValue('account_number'));

            $company_bank->save();
        }

        if($form->getValue('sim_card_quantity') || $form->getValue('price_per_sim')){

            $c2 = new Criteria();
            $c2->add(ProductOrderPeer::COMPANY_ID, $company->getId());

            if(!$product_order = ProductOrderPeer::doSelectOne($c2)){
                $product_order = new ProductOrder();
            }

            $product_order->setCompanyId($company->getId());

            $product_order->setAgentCompanyId($company->getAgentCompanyId());

            $product_order->setSimCardQuantity($form->getValue('sim_card_quantity'));

            $product_order->setPricePerSim($form->getValue('price_per_sim'));

            $product_order->save();

        }
      $this->getUser()->setFlash('message', 'company added/updated successfully');

        if($request->getParameter('action') == 'create'){
            
            $activation_code = new ActivationCode();
            $activation_code->setCompanyId($company->getId());
            $activation_code->generateCode($company->getName());
            $activation_code->save();

            $mAce = new aceMail();

            $mAce->sendMailAlt(
                    $userEmail = $company->getEmail(),
                    $userName = $company->getContactName(),
                    $subject = mail_messages::$REGISTRATION_SUBJECT,
                    $txtMailBody = null,
                    $htmlMailBody = mail_messages::html_registration_mail($company, $activation_code->getCode())
                );
         }

      $this->redirect('company/view?id='.$company->getId());
         //$this->forward('company', 'index');
    }
  }

  public function executeView($request){
      $this->company = CompanyPeer::retrieveByPK($request->getParameter('id'));
  }

  public function executeActivation($request){
      $code = $request->getParameter('code');

      if($code){

          $c = new Criteria();
          $c->add(ActivationCodePeer::CODE, $code);
          $code_check = ActivationCodePeer::doSelectOne($c);

          if($code_check){
              $company = $code_check->getCompany();

              $company->setConfirmedAt(date("m/d/Y H:i", time()));
              $company->setStatusId(sfConfig::get('app_status_confirmed'));

              $company->save();

              $code_check->delete();

              $this->getUser()->setFlash('message', 'your account is activated');
          } else {
              $this->getUser()->setFlash('message', 'Invalid Code');
          }
      } else {
          $this->getUser()->setFlash('message', 'Require unique code');
      }

      //$this->redirect('@homepage');
      $this->forward('company', 'index');
  }

  public function executeRejection($request){
      $code = $request->getParameter('code');

      if($code){

          $c = new Criteria();
          $c->add(ActivationCodePeer::CODE, $code);
          $code_check = ActivationCodePeer::doSelectOne($c);

          if($code_check){
              $company = $code_check->getCompany();
              $company->setStatusId(sfConfig::get('app_status_rejected'));
              $company->save();

              $code_check->delete();

              $this->getUser()->setFlash('message', 'some one will contact you for your feedback. We would like to know why you decided to reject the subscription');
          } else {
              $this->getUser()->setFlash('message', 'Invalid Code');
          }
      } else {
          $this->getUser()->setFlash('message', 'Require unique code');
      }

      //$this->redirect('@homepage');
      $this->forward('company', 'index');
  }

  public function executeSendActivationMail($request){

      $company = CompanyPeer::retrieveByPK($request->getParameter('id'));
      if($company){
        $activation_code = new ActivationCode();
        $activation_code->setCompanyId($company->getId());
        $activation_code->generateCode($company->getName());
        
        $activation_code->save();

        $mAce = new aceMail();

        $mAce->sendMailAlt(
                $userEmail = $company->getEmail(),
                $userName = $company->getContactName(),
                $subject = mail_messages::$REGISTRATION_SUBJECT,
                $txtMailBody = null,
                $htmlMailBody = mail_messages::html_registration_mail($company, $activation_code->getCode())
            );

        $this->getUser()->setFlash('message', 'activation mail sent');
      } else {
          $this->getUser()->setFlash('message', 'company does not exist');
      }
        $this->forward('company', 'index');
  }
}
