<?php

/**
 * Employee form.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: EmployeeForm.class.php,v 1.1 2010-05-25 13:15:37 orehman Exp $
 */
class EmployeeForm extends BaseEmployeeForm
{
  public function configure()
  {
      $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
  }
}
