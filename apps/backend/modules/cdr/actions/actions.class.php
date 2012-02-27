<?php

/**
 * cdr actions.
 *
 * @package    zapnacrm
 * @subpackage cdr
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1 2010-05-25 13:17:20 orehman Exp $
 */
class cdrActions extends autocdrActions
{
	public function executeCreateMissingDestinations(sfRequest $request)
	{
		$destinations = CdrLogPeer::getMissingDestinations();
		
		foreach ($destinations as $destination)
		{
			//print_r($destination->toArray());
			
			$destinationRate = new DestinationRate();
			$destinationRate->setDestinationName($destination->getDescription());
			$destinationRate->setSalePrice(0);
			$destinationRate->setPurchasePrice(0);
			$destinationRate->save();
		}
		
		//reprocess the unmatched records
		
		$this->forward('cdr', 'reprocess');
	}
	
	
	public function executeReprocess(sfRequest $request)
	{
		CdrLogPeer::reprocessUnmatchedRecords();
		
		$this->redirect('cdr/list');
	}
	
	public function executeReprocessSuspects(sfRequest $request)
	{
		CdrLogPeer::reprocessSuspects();
		
		$this->redirect('cdr/list');
	}
}
