<?php

/**
 * promotionRates actions.
 *
 * @package    zapnacrm
 * @subpackage promotionRates
 * @author     Your name here
 */
class promotionRatesActions extends autopromotionRatesActions
{
     public function handleErrorSave() {
     $this->forward('promotionRates','edit');
  }
}
