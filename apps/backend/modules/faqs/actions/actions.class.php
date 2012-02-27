<?php

/**
 * faqs actions.
 *
 * @package    zapnacrm
 * @subpackage faqs
 * @author     Your name here
 */
class faqsActions extends autofaqsActions
{
       public function handleErrorSave() {
     $this->forward('faqs','edit');
  }
}
