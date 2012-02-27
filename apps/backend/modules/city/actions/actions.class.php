<?php

/**
 * city actions.
 *
 * @package    zapnacrm
 * @subpackage city
 * @author     Your name here
 */
class cityActions extends autocityActions
{
   public function handleErrorSave() {
     $this->forward('city','edit');
  }
}
