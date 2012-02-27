<?php

/**
 * usage_alert_sender actions.
 *
 * @package    zapnacrm
 * @subpackage usage_alert_sender
 * @author     Your name here
 */
class usage_alert_senderActions extends autousage_alert_senderActions
{
      public function handleErrorSave() {
     $this->forward('usage_alert_sender','edit');
  }
}
