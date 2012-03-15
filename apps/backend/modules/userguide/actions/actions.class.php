<?php

/**
 * userguide actions.
 *
 * @package    zapnacrm
 * @subpackage userguide
 * @author     Your name here
 */
 class userguideActions extends sfActions
//class userguideActions extends autouserguideActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->userguide_list = UserguidePeer::doSelect(new Criteria());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UserguideForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new UserguideForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($userguide = UserguidePeer::retrieveByPk($request->getParameter('id')), sprintf('Object userguide does not exist (%s).', $request->getParameter('id')));
    $this->form = new UserguideForm($userguide);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($userguide = UserguidePeer::retrieveByPk($request->getParameter('id')), sprintf('Object userguide does not exist (%s).', $request->getParameter('id')));
    $this->form = new UserguideForm($userguide);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($userguide = UserguidePeer::retrieveByPk($request->getParameter('id')), sprintf('Object userguide does not exist (%s).', $request->getParameter('id')));
    $userguide->delete();

    $this->redirect('userguide/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
//        $file = $this->form->getValue('image');
//        $path = sfConfig::get('sf_upload_dir').'/userguide/'.$file.'_'.rand(1, 10);
//        $extension = $file->getExtension($file->getOriginalExtension());
//        $file->save($path.'.'.$extension);

        //$this->form->updateObject();

      $userguide = $form->save();

      $this->redirect('userguide/edit?id='.$userguide->getId());
    }
  }
}
