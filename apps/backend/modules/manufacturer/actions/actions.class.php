<?php

/**
 * manufacturer actions.
 *
 * @package    zapnacrm
 * @subpackage manufacturer
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class manufacturerActions extends automanufacturerActions
{
     public function handleErrorSave() {
     $this->forward('manufacturer','edit');
  }
}
