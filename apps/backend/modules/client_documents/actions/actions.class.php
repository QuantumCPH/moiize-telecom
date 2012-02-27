<?php

/**
 * userguide actions.
 *
 * @package    zapnacrm
 * @subpackage userguide
 * @author     Your name here
 */
 
class client_documentsActions extends sfActions
{	
  public function executeIndex(sfWebRequest $request)
  {
  	$DB_Server 	= "localhost";
	$DB_Username 	= "root";
	$DB_Password 	= "1Qazxsw@";
	$DB_DBName   	= "landncall";
	$success= mysql_pconnect($DB_Server, $DB_Username, $DB_Password);	
	mysql_select_db($DB_DBName);	
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UserguideForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
  	
	$DB_Server 	= "localhost";
	$DB_Username 	= "root";
	$DB_Password 	= "1Qazxsw@";
	$DB_DBName   	= "landncall";
	$success= mysql_pconnect($DB_Server, $DB_Username, $DB_Password);	
	mysql_select_db($DB_DBName);
	
  	//echo sfConfig::get('sf_root_dir');
  	//
	//echo sfConfig::get('sf_environment');
    $this->setTemplate('new');	
	$error = '';
	$this->error = '';
	if(isset($_REQUEST['save']) && $_FILES['documentfile']['name']!=''){
		//echo sfConfig::get('sf_upload_dir');
		
		$uploaddir = sfConfig::get('sf_upload_dir').'/documents/';
		//Upload Image
		$resultQry = date('Y-m-d-h-s');
		$FILE_NAME = $resultQry.'_'.$_FILES['documentfile']['name'];
		$uploadfile = $uploaddir . $resultQry.'_'.basename($_FILES['documentfile']['name']);
		move_uploaded_file($_FILES['documentfile']['tmp_name'], $uploadfile);		
		mysql_query("INSERT INTO clientdocuments (title ,filename ,status) VALUES ('".$_REQUEST['docTitle']."', '".$FILE_NAME."','".$_REQUEST['DocStatus']."')");
		$this->redirect('client_documents/index');
	}elseif(isset($_REQUEST['save']) && $_FILES['documentfile']['name']==''){
		$error = 'fileerror';
		$this->error = 'Error';
	}
  }

  public function executeEdit(sfWebRequest $request)
  {
  	$EditId = $request->getParameter('id');
	$this->editId = $EditId;
  	$DB_Server 	= "localhost";
	$DB_Username 	= "root";
	$DB_Password 	= "1Qazxsw@";
	$DB_DBName   	= "landncall";
	$success= mysql_pconnect($DB_Server, $DB_Username, $DB_Password);	
	mysql_select_db($DB_DBName);
	$editid = $request->getParameter('id');	
	if(isset($_REQUEST['update']) && $_FILES['documentfile']['name']!=''){
			
		$uploaddir = sfConfig::get('sf_upload_dir').'/documents/';
		//Upload Image
		$resultQry = date('Y-m-d-h-s');
		$FILE_NAME = $resultQry.'_'.$_FILES['documentfile']['name'];
		$uploadfile = $uploaddir . $resultQry.'_'.basename($_FILES['documentfile']['name']);
		move_uploaded_file($_FILES['documentfile']['tmp_name'], $uploadfile);
				
		mysql_query("UPDATE clientdocuments SET title = '".$_REQUEST['docTitle']."' ,
		filename = '".$FILE_NAME."'
		WHERE id ='".$editid."' ");
		$this->redirect('client_documents/index');
	}elseif(isset($_REQUEST['update']) && $_FILES['documentfile']['name']==''){
		mysql_query("UPDATE clientdocuments SET title = '".$_REQUEST['docTitle']."' WHERE id ='".$editid."' ");		
		$this->redirect('client_documents/index');
	}
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
  	$DB_Server 	= "localhost";
	$DB_Username 	= "root";
	$DB_Password 	= "1Qazxsw@";
	$DB_DBName   	= "landncall";
	$success= mysql_pconnect($DB_Server, $DB_Username, $DB_Password);	
	mysql_select_db($DB_DBName);
	
    $request->checkCSRFProtection();
	$deleteId = $request->getParameter('id');	
	mysql_query("DELETE FROM clientdocuments WHERE id = '".$deleteId."' ");
	
    $this->redirect('client_documents/index');
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

      $this->redirect('client_documents/edit?id='.$userguide->getId());
    }
  }
}
