<?php

/**
 * device actions.
 *
 * @package    zapnacrm
 * @subpackage device
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 *
 * validation rules
 * fields:
  districtmaster{district_name}:
    required:                  Yes
    required_msg:              The district name cannot be left blank.
    validators:                [sfStringValidator]
    sfStringValidator:
      max:                     50
      max_error:               Please enter at most 50 characters.
      min:                     5
      min_error:               The name should not be less than 5 characters.

 */


//validation rules  http://forum.symfony-project.org/viewtopic.php?f=3&t=11336
class deviceActions extends autodeviceActions
{
  public function handleErrorSave() {
     $this->forward('device','edit');
  }
}
