<?php

/**
 * agent_commission_package actions.
 *
 * @package    zapnacrm
 * @subpackage agent_commission_package
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class agent_commission_packageActions extends autoagent_commission_packageActions
{
       public function handleErrorSave() {
     $this->forward('agent_commission_package','edit');
  }
}
