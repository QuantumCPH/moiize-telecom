<?php

/**
 * support_activity actions.
 *
 * @package    zapnacrm
 * @subpackage support_activity
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class support_activityActions extends autosupport_activityActions
{
	protected function addFiltersCriteria ($c)
	{
		$c->addJoin(EmployeePeer::ID, SupportActivityPeer::EMPLOYEE_ID);
		$c->addJoin(EmployeePeer::COMPANY_ID, CompanyPeer::ID);

		if (isset($this->filters['company_id']) && $this->filters['company_id'] !== '')
		{
			$c->add(CompanyPeer::ID, $this->filters['company_id']);

		}
			  
		if (isset($this->filters['vat_no']) && $this->filters['vat_no'] !== '')
		{
			$c->add(CompanyPeer::VAT_NO, $this->filters['vat_no']);
		}
		else
		{
			parent::addFiltersCriteria($c);
		}
	}
	
	public function executeView($request){
		$this->support_activity = SupportActivityPeer::retrieveByPK($request->getParameter('id'));
	}
	
	public function executeGetEmployeeChoice($request)
	{
			$c = new Criteria();
			$c->add(CompanyPeer::ID, $request->getParameter('cid')?$request->getParameter('cid'):-1);
			$c->addAscendingOrderbyColumn(EmployeePeer::FIRST_NAME);
			$c->addAscendingOrderbyColumn(EmployeePeer::LAST_NAME);
			$employees = EmployeePeer::doSelectJoinCompany($c);
			
			$employee_list = array();
			foreach ($employees as $employee)
			{
				$employee_list[$employee->getId()] = $employee->getFirstName(). ' ' . $employee->getLastName();
			}
			
			//Tag fixes _parse_attributes() fetal error when
			//helpers are tried to be used in actions
			
			sfLoader::loadHelpers(array('Form', 'Tag'));
			
			return $this->renderText(
				select_tag('support_activity[employee_id]', options_for_select($employee_list, $request->getParameter('eid')?$request->getParameter('eid'):null, array('include_blank' => false)))
			);
	}
	
	public function executeSave1($request){
		$form = new SupportActivityForm();
		
	 $form->bind($request->getParameter('support_activity'), $request->getFiles('support_activity'));
	 $form->setDefault('ticket_number', 2132123123);
     //if ($form->isValid())
     //{
       $support_activity = $form->save();

       $this->redirect('support_activity/edit?id='.$support_activity->getId());
     //}
		
		
		
	}
}
