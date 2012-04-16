<?php

/**
 * telintaRoutingplan actions.
 *
 * @package    zapnacrm
 * @subpackage telintaRoutingplan
 * @author     Your name here
 */
class telintaRoutingplanActions extends autotelintaRoutingplanActions
{
  public function handleErrorSave() {
     $this->forward('TelintaRoutingplan','edit');
  }
}
