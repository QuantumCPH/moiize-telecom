<?php

/**
 * product actions.
 *
 * @package    zapnacrm
 * @subpackage product
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1 2010-05-25 13:17:35 orehman Exp $
 */
class productActions extends autoproductActions
{
      public function handleErrorSave() {
     $this->forward('product','edit');
  }
}
