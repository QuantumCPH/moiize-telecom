<?php

/**
 * sms_text actions.
 *
 * @package    zapnacrm
 * @subpackage sms_text
 * @author     Your name here
 */
class sms_textActions extends autosms_textActions
{
 public function handleErrorSave() {
     $this->forward('sms_text','edit');
  }
}
