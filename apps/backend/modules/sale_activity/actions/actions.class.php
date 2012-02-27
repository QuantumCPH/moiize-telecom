<?php

/**
 * sale_activity actions.
 *
 * @package    zapnacrm
 * @subpackage sale_activity
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class sale_activityActions extends autosale_activityActions
{
	protected function addFiltersCriteria ($c)
	{

	  if (isset($this->filters['vat_no']) && $this->filters['vat_no'] !== '')
	  {
			$c->add(CompanyPeer::VAT_NO, strtr($this->filters['vat_no'], '*', '%'), Criteria::LIKE);
			$c->addJoin(CompanyPeer::ID, SaleActivityPeer::COMPANY_ID);
	  }
	  else
	  {
	  	parent::addFiltersCriteria($c);
	  }
		
		
	}
	public function executeView($request){
		$this->sale_activity = SaleActivityPeer::retrieveByPK($request->getParameter('id'));
	}
}
