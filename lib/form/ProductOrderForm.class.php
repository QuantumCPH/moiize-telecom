<?php

/**
 * ProductOrder form.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: ProductOrderForm.class.php,v 1.1 2010-05-25 13:15:35 orehman Exp $
 */
class ProductOrderForm extends BaseProductOrderForm
{
  public function configure()
  {
      $this->widgetSchema['agent_company_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
  }
}
