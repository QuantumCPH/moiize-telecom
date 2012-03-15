<?php

/**
 * postal_charges actions.
 *
 * @package    zapnacrm
 * @subpackage postal_charges
 * @author     Your name here
 */
class postal_chargesActions extends autopostal_chargesActions
{
     public function handleErrorSave() {
     $this->forward('postal_charges','edit');
  }
}
