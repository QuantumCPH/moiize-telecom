<?php

/**
 * agent_user actions.
 *
 * @package    zapnacrm
 * @subpackage agent_user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class agent_userActions extends autoagent_userActions
{
         public function handleErrorSave() {
     $this->forward('agent_user','edit');
  }
    public function executeAddUser($request){

        $id = $request->getParameter('id');

        $this->form = new AgentUserForm();

        if($id){
            $this->form->setDefault('agent_company_id', $id);
        }

        $this->setTemplate('edit');
    }
}
