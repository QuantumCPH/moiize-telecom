<?php

/**
 * telintaProduct actions.
 *
 * @package    zapnacrm
 * @subpackage telintaProduct
 * @author     Your name here
 */
class telintaProductActions extends autotelintaProductActions
{
   public function handleErrorSave() {
     $this->forward('telintaProduct','edit');
  }
}
