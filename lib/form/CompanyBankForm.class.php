<?php

/**
 * CompanyBank form.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: CompanyBankForm.class.php,v 1.1 2010-05-25 13:15:35 orehman Exp $
 */
class CompanyBankForm extends BaseCompanyBankForm
{
  public function configure()
  {
      $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
  }
}
