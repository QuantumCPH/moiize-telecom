<?php

/**
 * usage_alert actions.
 *
 * @package    zapnacrm
 * @subpackage usage_alert
 * @author     Your name here
 */
class usage_alertActions extends autousage_alertActions
{
  public function handleErrorSave() {
     $this->forward('usage_alert','edit');
  }
}
