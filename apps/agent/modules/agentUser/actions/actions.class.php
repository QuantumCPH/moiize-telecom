<?php
require_once(sfConfig::get('sf_lib_dir').'/changeLanguageCulture.php');
/**
 * agentUser actions.
 *
 * @package    zapnacrm
 * @subpackage agentUser
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1 2010-05-25 13:17:42 orehman Exp $
 */
class agentUserActions extends sfActions {
    public function executeIndex(sfWebRequest $request) {
        //$this->agent_user_list = AgentUserPeer::doSelect(new Criteria());
    }

    private function executeNew(sfWebRequest $request) {
        $this->form = new AgentUserForm();
    }

    private function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod('post'));

        $this->form = new AgentUserForm();

        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }

    private function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($agent_user = AgentUserPeer::retrieveByPk($request->getParameter('id')), sprintf('Object agent_user does not exist (%s).', $request->getParameter('id')));
        $this->form = new AgentUserForm($agent_user);
    }

    private function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($agent_user = AgentUserPeer::retrieveByPk($request->getParameter('id')), sprintf('Object agent_user does not exist (%s).', $request->getParameter('id')));
        $this->form = new AgentUserForm($agent_user);

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    private function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();

        $this->forward404Unless($agent_user = AgentUserPeer::retrieveByPk($request->getParameter('id')), sprintf('Object agent_user does not exist (%s).', $request->getParameter('id')));
        $agent_user->delete();

        $this->redirect('agentUser/index');
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $agent_user = $form->save();

            $this->redirect('agentUser/edit?id='.$agent_user->getId());
        }
    }

    public function executeLogin($request){

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11 - Ahtsham
         changeLanguageCulture::languageCulture($request,$this);
  if($request->getParameter('new'))
                $this->getUser()->setCulture($request->getParameter('new'));
        else
            $this->getUser()->setCulture($this->getUser()->getCulture());
        $this->form = new AgentLoginForm();

        if($request->isMethod('post')){
            $this->form->bind($request->getParameter('login'), $request->getFiles('login'));

            if($this->form->isValid()){

                $c = new Criteria();

                $c->Add(AgentUserPeer::USERNAME, $this->form->getValue('username'));
                $c->addAnd(AgentUserPeer::PASSWORD, $this->form->getValue('password'));
                $agent_user = AgentUserPeer::doSelectOne($c);

                if($agent_user){
                    $this->getUser()->setAuthenticated(true);
                    $this->getUser()->setAttribute('agent_id', $agent_user->getId(), 'agentsession');
                      $this->getUser()->setAttribute('username', $agent_user->getUsername(), 'agentsession');
                    $this->getUser()->setAttribute('agent_company_id', $agent_user->getAgentCompanyId(), 'agentsession');
                    //$this->redirect('@homepage');

        
                     $this->redirect( sfConfig::get('app_main_url').'affiliate/report?show_summary=1');


                   
                }
            }
        }
    }

    public function executeLogout(){
        $this->getUser()->getAttributeHolder()->removeNamespace('agentsession');
        $this->getUser()->setAuthenticated(false);
        $this->redirect('@homepage');
    }
}
