<?php

class CdrLogPeer extends BaseCdrLogPeer
{
	public static function getMissingDestinations($distinct = true)
	{
		$c = new Criteria();
		$c->add(CdrLogPeer::TO_DESTINATION_RATE_ID, null, CRITERIA::ISNULL);
		$c->addAnd(CdrLogPeer::DESCRIPTION, '', CRITERIA::NOT_EQUAL);
		
		if ($distinct)
			$c->addGroupByColumn(CdrLogPeer::DESCRIPTION);
		
		return CdrLogPeer::doSelect($c);
	}
	
	public static function getEmptyDestinations()
	{
		$c = new Criteria();
		$c->add(CdrLogPeer::DESCRIPTION, '', CRITERIA::EQUAL);
		
		return CdrLogPeer::doSelect($c);
	}
	
	public static function getUnmatchedEmployees($distinct_mobile_no = true)
	{
		$c = new Criteria();
		$c->add(CdrLogPeer::FROM_EMPLOYEE_ID, null, CRITERIA::ISNULL);
		
		if ($distinct_mobile_no)
			$c->addGroupByColumn(CdrLogPeer::FROM_NO);
		
		return CdrLogPeer::doSelect($c);		
	}
	
	public static function getAllUnmatchedRecords()
	{
		$c = new Criteria();
		$crit0 = $c->getNewCriterion(CdrLogPeer::TO_DESTINATION_RATE_ID, null, Criteria::ISNULL);
		$crit1 = $c->getNewCriterion(CdrLogPeer::FROM_EMPLOYEE_ID, null, Criteria::ISNULL);
		
		$crit0->addOr($crit1);
		
		$c->add($crit0);
		
		return CdrLogPeer::doSelect($c);
	}
	
	public static function reprocessUnmatchedRecords()
	{
		$unmatchedRecords = CdrLogPeer::getAllUnmatchedRecords();
		
		//var_dump($unmatchedRecords);

		foreach ($unmatchedRecords as $unmatchedRecord)
		{
			$cdrlog_record = CdrLogPeer::retrieveByPK($unmatchedRecord->getId());
			$cdrlog_record->setCreatedAt(date('Y-m-d'));
			$cdrlog_record->save();
		}
		
	}
	
	public static function getSuspectedRecords()
	{
		$c = new Criteria();
		$c1 = $c->getNewCriterion(CdrLogPeer::SALE_PRICE, null, CRITERIA::ISNULL);
		$c2 = $c->getNewCriterion(CdrLogPeer::PURCHASE_PRICE, null, CRITERIA::ISNULL);
		
		$c1->addOr($c2);
		
		$c->add($c1);
		
		//$c->addAsColumn('profit', '(sale_price - purchase_price)');

		//$c->addOr($c->getNewCriterion(CdrLogPeer::ID, 'profit<=0', Criteria::CUSTOM));
		 
		return CdrLogPeer::doSelect($c);		
	}
	
	public static function reprocessSuspects()
	{
		$suspectedRecords = CdrLogPeer::getSuspectedRecords();
		
		foreach ($suspectedRecords as $record)
		{
			$cdrlog_record = CdrLogPeer::retrieveByPK($record->getId());
			$cdrlog_record->setCreatedAt(date('Y-m-d'));
			$cdrlog_record->save();
		}
	}
	
	public static function reprocessAllRecords()
	{
		$allRecords = CdrLogPeer::doSelect(new Criteria());
		
		foreach ($allRecords as $record)
		{
			$cdrlog_record = CdrLogPeer::retrieveByPK($record->getId());
			$cdrlog_record->setCreatedAt(date('Y-m-d'));
			$cdrlog_record->save();
		}		
	}
}
