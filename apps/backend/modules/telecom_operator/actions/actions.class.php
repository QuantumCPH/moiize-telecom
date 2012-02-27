<?php

/**
 * telecom_operator actions.
 *
 * @package    zapnacrm
 * @subpackage telecom_operator
 * @author     Your name here
 */
class telecom_operatorActions extends autotelecom_operatorActions
{
   public function handleErrorSave() {
     $this->forward('telecom_operator','edit');
  }
}
