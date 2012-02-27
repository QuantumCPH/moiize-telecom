<?php

/**
 * newupdate actions.
 *
 * @package    zapnacrm
 * @subpackage newupdate
 * @author     Your name here
 */
//class newupdateActions extends sfActions
class newupdateActions extends autonewupdateActions
{
     public function handleErrorSave() {
     $this->forward('newupdate','edit');
  }


//  public function executeIndex(sfWebRequest $request)
//  {
//    $this->newupdate_list = NewupdatePeer::doSelect(new Criteria());
//  }
//
//  public function executeNew(sfWebRequest $request)
//  {
//    $this->form = new NewupdateForm();
//  }
//
//  public function executeCreate(sfWebRequest $request)
//  {
//    $this->forward404Unless($request->isMethod('post'));
//
//    $this->form = new NewupdateForm();
//
//    $this->processForm($request, $this->form);
//
//    $this->setTemplate('new');
//  }
//
//  public function executeEdit(sfWebRequest $request)
//  {
//    $this->forward404Unless($newupdate = NewupdatePeer::retrieveByPk($request->getParameter('id')), sprintf('Object newupdate does not exist (%s).', $request->getParameter('id')));
//    $this->form = new NewupdateForm($newupdate);
//  }
//
//  public function executeUpdate(sfWebRequest $request)
//  {
//    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
//    $this->forward404Unless($newupdate = NewupdatePeer::retrieveByPk($request->getParameter('id')), sprintf('Object newupdate does not exist (%s).', $request->getParameter('id')));
//    $this->form = new NewupdateForm($newupdate);
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
//    $this->forward404Unless($newupdate = NewupdatePeer::retrieveByPk($request->getParameter('id')), sprintf('Object newupdate does not exist (%s).', $request->getParameter('id')));
//    $newupdate->delete();
//
//    $this->redirect('newupdate/index');
//  }
//
//  protected function processForm(sfWebRequest $request, sfForm $form)
//  {
//    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
//    if ($form->isValid())
//    {
//      $newupdate = $form->save();
//
//      $this->redirect('newupdate/edit?id='.$newupdate->getId());
//    }
//  }
}
