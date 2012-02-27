<?php

/**
 * employee actions.
 *
 * @package    zapnacrm
 * @subpackage employee
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class employeeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $c = new Criteria();
    $this->employee_list = EmployeePeer::getEmployeeList($this->getUser()->getAttribute('agent_company_id', '', 'agentsession'));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new EmployeeForm();

    $this->form->setDefault('company_id', $request->getParameter('company_id'));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new EmployeeForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($employee = EmployeePeer::retrieveByPk($request->getParameter('id')), sprintf('Object employee does not exist (%s).', $request->getParameter('id')));
    $this->form = new EmployeeForm($employee);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($employee = EmployeePeer::retrieveByPk($request->getParameter('id')), sprintf('Object employee does not exist (%s).', $request->getParameter('id')));
    $this->form = new EmployeeForm($employee);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($employee = EmployeePeer::retrieveByPk($request->getParameter('id')), sprintf('Object employee does not exist (%s).', $request->getParameter('id')));
    $employee->delete();

    $this->redirect('employee/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $employee = $form->save();
      $this->getUser()->setFlash('message', 'user added/updated successfully');
      $this->redirect('company/view?id='.$employee->getCompanyId());
    }
  }
}
