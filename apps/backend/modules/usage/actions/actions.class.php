<?php

/**
 * usage actions.
 *
 * @package    zapnacrm
 * @subpackage usage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class usageActions extends autousageActions
{
	
	protected function addFiltersCriteria ($c)
	{
		$c->addJoin(EmployeePeer::ID, CdrLogPeer::FROM_EMPLOYEE_ID);
		$c->addJoin(EmployeePeer::COMPANY_ID, CompanyPeer::ID);

		if (isset($this->filters['company_id']) && $this->filters['company_id'] !== '')
		{
			$c->add(CompanyPeer::ID, $this->filters['company_id']);

		}
		
		if (isset($this->filters['from_no']) && $this->filters['from_no'] !== '')
		{
			$c->add(EmployeePeer::MOBILE_NUMBER, $this->filters['from_no']);

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
	

	
	
	//unmatched and also not available 

	
	public function executeCreateUnmatchedDestinations(sfRequest $request)
	{
		/*
		 * 
		 * INSERT INTO destination_rate (destination_name, purchase_price, sale_price)
SELECT DISTINCT description, 0, 0 FROM cdr_log WHERE cdr_log.to_destination_rate_id IS NULL AND cdr_log.description <> ''
		 */

		
		foreach ($destinations as $destination)
		{
			$destinationRate = new DestinationRate();
			$destinationRate->setByName($destination);
			$destinationRate->setSalePrice(0);
			$destinationRate->setPurchasePrice(0);
			$destinationRate->save();
		}
		
		echo 'number of unmatched destination = '.count($destinations);
		
		return sfView::NONE;
	}
}
