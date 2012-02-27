<?php

/**
 * signup actions.
 *
 * @package    zapnacrm
 * @subpackage signup
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1 2010-05-25 13:16:55 orehman Exp $
 */
class signupActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //switch step
    
  	//get step
  	if ($request->isMethod('post'))
  	{
  		//post from step 1
  		if ($request->getParameter('customer'))
  		{
  			$step = $customer['step'];
  		}
  		
  		
  		
  		
  	}
  	else 
  	{
  		$this->forward404Unless($request->getParameter('step'));
  		$this->step = $request->getParameter('step');
  		
  		if ($this->step==1) //is customer form
  		{
  			$this->form = new CustomerForm();
  		}
  		else 
  		{
  			$this->forward404();
  		}
  	}
  	
    
  }
  
  public function executeTest(sfWebRequest $request)
  {
  	$this->form = new PaymentForm();
  	
  	echo $this->form;
  	
  	echo '<input type="submit" />';
  	
  	return sfView::NONE;
  }
}
