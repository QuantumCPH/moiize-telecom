<?php

/**
 * scripts actions.
 *
 * @package    zapnacrm
 * @subpackage scripts
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class scriptsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
  
  public function executeRMV_USR_NEW(sfWebRequest $request)
  {
  	$c = new Criteria();
  	
  	$c->add(CustomerOrderPeer::CUSTOMER_ID, 
  		'customer_id IN (SELECT id FROM customer WHERE TIMESTAMPDIFF(MINUTE, NOW(), created_at) >= -30 AND customer_status_id = 1)'
  	, Criteria::CUSTOM);
  	
  	$this->remove_propel_object_list(CustomerOrderPeer::doSelect($c));
  	
  	//now transaction
  	$c = new Criteria();
  	
  	$c->add(TransactionPeer::CUSTOMER_ID, 
  		'customer_id IN (SELECT id FROM customer WHERE TIMESTAMPDIFF(MINUTE, NOW(), created_at) >= -30 AND customer_status_id = 1)'
  	, Criteria::CUSTOM);
  	
  	$this->remove_propel_object_list(TransactionPeer::doSelect($c));  	
  	
  	//now customer
   	$c = new Criteria();
  	
  	$c->add(CustomerPeer::ID, 
  		'id IN (SELECT id FROM customer WHERE TIMESTAMPDIFF(MINUTE, NOW(), created_at) >= -30 AND customer_status_id = 1)'
  	, Criteria::CUSTOM);
  	
  	$this->remove_propel_object_list(CustomerPeer::doSelect($c));  
  	
  	$this->renderText('last deleted on '. date(DATE_RFC822));
  	
  	return sfView::NONE;
  	 	
  }
  
  private function remove_propel_object_list($list)
  {
  	foreach($list as $list_item)
  	{
  		$list_item->delete();
  	}
  }
}