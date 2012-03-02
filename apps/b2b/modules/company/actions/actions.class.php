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
    public function executeIndex(sfWebRequest $request) {
            $this->forward404Unless($this->getUser()->getAttribute('companyname', '', 'companysession'));
        // $this->forward('default', 'module');
    }

    public function executeLogin($request) {

        //call Culture Method For Get Current Set Culture - Against Feature# 6.1 --- 01/24/11 - Ahtsham
        changeLanguageCulture::languageCulture($request, $this);
        if ($request->getParameter('new'))
            $this->getUser()->setCulture($request->getParameter('new'));
        else
            $this->getUser()->setCulture($this->getUser()->getCulture());
        $this->form = new CompanyLoginForm();

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('login'), $request->getFiles('login'));

            if ($this->form->isValid()) {

                $c = new Criteria();

                $c->Add(CompanyPeer::VAT_NO, $this->form->getValue('vat_no'));
                $c->addAnd(CompanyPeer::PASSWORD, $this->form->getValue('password'));
                $company_user = CompanyPeer::doSelectOne($c);

                if ($company_user) {
                    $this->getUser()->setAuthenticated(true);
                    $this->getUser()->setAttribute('company_id', $company_user->getId(), 'companysession');
                    $this->getUser()->setAttribute('companyname', $company_user->getName(), 'companysession');
                  

                    $this->redirect(sfConfig::get('app_main_url') . 'company/index');
                }
            }
        }
    }

    public function executeLogout() {
        $this->getUser()->getAttributeHolder()->removeNamespace('companysession');
        $this->getUser()->setAuthenticated(false);
        $this->redirect(sfConfig::get('app_main_url') . 'company/index');
    }

}
