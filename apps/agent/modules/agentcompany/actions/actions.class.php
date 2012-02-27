<?php
require_once(sfConfig::get('sf_lib_dir').'/changeLanguageCulture.php');
/**
 * agentcompany actions.
 *
 * @package    zapnacrm
 * @subpackage agentcompany
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1 2010-05-25 13:17:35 orehman Exp $
 */
class agentcompanyActions extends sfActions
{
  private function executeIndex(sfWebRequest $request)
  {
     //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11 - Ahtsham
     changeLanguageCulture::languageCulture($request,$this);
    $this->agent_company_list = AgentCompanyPeer::doSelect(new Criteria());
  }

  private function executeNew(sfWebRequest $request)
  {
      //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11 - Ahtsham
     changeLanguageCulture::languageCulture($request,$this);
     
    $this->form = new AgentCompanyForm();
  }

  private function executeCreate(sfWebRequest $request)
  {
      //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11 - Ahtsham
     changeLanguageCulture::languageCulture($request,$this);
     
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new AgentCompanyForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  private function executeEdit(sfWebRequest $request)
  {
     //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11 - Ahtsham
     changeLanguageCulture::languageCulture($request,$this);
     
    $this->forward404Unless($agent_company = AgentCompanyPeer::retrieveByPk($request->getParameter('id')), sprintf('Object agent_company does not exist (%s).', $request->getParameter('id')));
    $this->form = new AgentCompanyForm($agent_company);
  }

  private function executeUpdate(sfWebRequest $request)
  {
      //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11 - Ahtsham
     changeLanguageCulture::languageCulture($request,$this);
     
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($agent_company = AgentCompanyPeer::retrieveByPk($request->getParameter('id')), sprintf('Object agent_company does not exist (%s).', $request->getParameter('id')));
    $this->form = new AgentCompanyForm($agent_company);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  private function executeDelete(sfWebRequest $request)
  {
      //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11 - Ahtsham
     changeLanguageCulture::languageCulture($request,$this);
     
    $request->checkCSRFProtection();

    $this->forward404Unless($agent_company = AgentCompanyPeer::retrieveByPk($request->getParameter('id')), sprintf('Object agent_company does not exist (%s).', $request->getParameter('id')));
    $agent_company->delete();

    $this->redirect('agentcompany/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
     //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11 - Ahtsham
     changeLanguageCulture::languageCulture($request,$this);
     
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $agent_company = $form->save();

      $this->redirect('agentcompany/edit?id='.$agent_company->getId());
    }
  }

  public function executeView(sfWebRequest $request){

      //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11 - Ahtsham
     changeLanguageCulture::languageCulture($request,$this);
     
      $agent_id = $this->getUser()->getAttribute('agent_id', '', 'agentsession');

      $agent = AgentUserPeer::retrieveByPK($agent_id);

      if($agent->getAgentCompanyId()){
        $this->agent_company = $agent->getAgentCompany();
      } else {

          $this->getUser()->setFlash('message', 'the company does not exist, please contact your administrator');
          $this->redirect('@homepage');
      }
      
  }
}
