<?php

/**
 * userguide actions.
 *
 * @package    zapnacrm
 * @subpackage userguide
 * @author     Your name here
 */
 
class billing_queryActions extends sfActions
{	
  public function executeIndex(sfWebRequest $request)
  {
  	$DB_Server 	= "localhost";
	$DB_Username 	= "root";
	$DB_Password 	= "1Qazxsw@";
	$DB_DBName   	= "landncall";
	$success= mysql_pconnect($DB_Server, $DB_Username, $DB_Password);	
	mysql_select_db($DB_DBName);	
	
	if(isset($_REQUEST['update'])){
		mysql_query("insert into billing set
		time='".$_REQUEST['qrytime']."',
		customer_id='".$_REQUEST['customer_id']."',
		mobile_number='".$_REQUEST['mobile_number']."',
		to_number='".$_REQUEST['to_number']."',
		duration_minutes='".$_REQUEST['duration_minutes']."',
		billing_minutes='".$_REQUEST['billing_minutes']."',
		call_cost = '".$_REQUEST['call_cost']."',
		cost_per_minute='".$_REQUEST['cost_per_minute']."',
		vat='".$_REQUEST['vat']."',
		balance_before='".$_REQUEST['balance_before']."',
		balance_after='".$_REQUEST['balance_after']."',
		billing_status=3,
		created_at='".$_REQUEST['qrytime']."'");
		$this->redirect('billing_query/index');
	}	
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UserguideForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
  	
	
  }

  public function executeEdit(sfWebRequest $request)
  {
  	
  }

  public function executeUpdate(sfWebRequest $request)
  {
   
  }

  public function executeDelete(sfWebRequest $request)
  {
  	
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    
  }
}
