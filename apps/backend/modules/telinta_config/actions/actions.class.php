<?php

/**
 * telinta_config actions.
 *
 * @package    zapnacrm
 * @subpackage telinta_config
 * @author     Your name here
 */
class telinta_configActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->telinta_config_list = TelintaConfigPeer::doSelect(new Criteria());
    }

    public function executeNew(sfWebRequest $request) {
        $c = new Criteria();
        $tilentaConfigCount = TelintaConfigPeer::doCount($c);
        if ($tilentaConfigCount == 0) {
            $this->form = new TelintaConfigForm();
            $pb = new PortaBillingSoapClient($this->getTelintaSoapUri(), 'Admin', 'Customer');
            $session = $pb->_login($this->getTelintaSoapUser(), $this->getTelintaSoapPassword());
            if ($session) {
                $telintaConfig = new TelintaConfig();
                $telintaConfig->setSession($session);
                $telintaConfig->save();
            }
        }
        $this->redirect('telinta_config/index');
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod('post'));

        $this->form = new TelintaConfigForm();

        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($telinta_config = TelintaConfigPeer::retrieveByPk($request->getParameter('id')), sprintf('Object telinta_config does not exist (%s).', $request->getParameter('id')));
        $pb = new PortaBillingSoapClient($this->getTelintaSoapUri(), 'Admin', 'Customer');
        $session = $pb->_login($this->getTelintaSoapUser(), $this->getTelintaSoapPassword());
        if($session){
            $pb->_logout($telinta_config->getSession());
            $telinta_config->setSession($session);
            $telinta_config->save();
        }
        $this->redirect('telinta_config/index');
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($telinta_config = TelintaConfigPeer::retrieveByPk($request->getParameter('id')), sprintf('Object telinta_config does not exist (%s).', $request->getParameter('id')));
        $this->form = new TelintaConfigForm($telinta_config);

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();

        $this->forward404Unless($telinta_config = TelintaConfigPeer::retrieveByPk($request->getParameter('id')), sprintf('Object telinta_config does not exist (%s).', $request->getParameter('id')));
        $telinta_config->delete();

        $this->redirect('telinta_config/index');
    }
    
    public function getTelintaSoapUri(){
        $telintaSOAPUrl = sfConfig::get("app_telinta_soap_url");
        return $telintaSOAPUrl;
    }
    
    public function getTelintaSoapUser(){
        $telintaSOAPUser = sfConfig::get("app_telinta_soap_user");
        return $telintaSOAPUser;
    }
    
    public function getTelintaSoapPassword(){
        $telintaSOAPPassword = sfConfig::get("app_telinta_soap_password");
        return $telintaSOAPPassword;
    }
    
    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $telinta_config = $form->save();

            $this->redirect('telinta_config/edit?id=' . $telinta_config->getId());
        }
    }
   
    public function executeExpireSession(){
        //$session = $request->getParameter('session');
        $ctc = new Criteria();
        $tcCount = TelintaConfigPeer::doCount($ctc);
        if($tcCount > 0){
            $telintaConfig = TelintaConfigPeer::doSelectOne($ctc);
            $pb = new PortaBillingSoapClient($this->getTelintaSoapUri(), 'Admin', 'Customer');
            try {
                $pb->_logout($telintaConfig->getSession());
                echo "Session expired: ".$telintaConfig->getSession();
            }catch (SoapFault $e){
                echo $e->faultstring;
            }
        }else{
            echo "session not found";
        }
       return sfView::NONE;
    }
}
