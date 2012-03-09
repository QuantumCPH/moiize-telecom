<?php

/**
 * companyTransaction actions.
 *
 * @package    zapnacrm
 * @subpackage companyTransaction
 * @author     Your name here
 */
//class companyTransactionActions extends sfActions
class companyTransactionActions extends autocompanyTransactionActions
{
//  public function executeIndex(sfWebRequest $request)
//  {
//    $this->company_transaction_list = CompanyTransactionPeer::doSelect(new Criteria());
//  }
//
//  public function executeNew(sfWebRequest $request)
//  {
//    $this->form = new CompanyTransactionForm();
//  }
//
//  public function executeCreate(sfWebRequest $request)
//  {
//    $this->forward404Unless($request->isMethod('post'));
//
//    $this->form = new CompanyTransactionForm();
//
//    $this->processForm($request, $this->form);
//
//    $this->setTemplate('new');
//  }
//
//  public function executeEdit(sfWebRequest $request)
//  {
//    $this->forward404Unless($company_transaction = CompanyTransactionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object company_transaction does not exist (%s).', $request->getParameter('id')));
//    $this->form = new CompanyTransactionForm($company_transaction);
//  }
//
//  public function executeUpdate(sfWebRequest $request)
//  {
//    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
//    $this->forward404Unless($company_transaction = CompanyTransactionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object company_transaction does not exist (%s).', $request->getParameter('id')));
//    $this->form = new CompanyTransactionForm($company_transaction);
//
//    $this->processForm($request, $this->form);
//
//    $this->setTemplate('edit');
//  }
//
//  public function executeDelete(sfWebRequest $request)
//  {
//    $request->checkCSRFProtection();
//
//    $this->forward404Unless($company_transaction = CompanyTransactionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object company_transaction does not exist (%s).', $request->getParameter('id')));
//    $company_transaction->delete();
//
//    $this->redirect('companyTransaction/index');
//  }
//
//  protected function processForm(sfWebRequest $request, sfForm $form)
//  {
//    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
//    if ($form->isValid())
//    {
//      $company_transaction = $form->save();
//
//      $this->redirect('companyTransaction/edit?id='.$company_transaction->getId());
//    }
//  }
}
