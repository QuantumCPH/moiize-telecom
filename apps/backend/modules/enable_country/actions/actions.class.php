<?php

/**
 * enable_country actions.
 *
 * @package    zapnacrm
 * @subpackage enable_country
 * @author     Your name here
 */
class enable_countryActions extends autoenable_countryActions
{
      public function handleErrorSave() {
     $this->forward('enable_country','edit');
  }
}
