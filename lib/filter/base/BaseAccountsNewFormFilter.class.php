<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * AccountsNew filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseAccountsNewFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fonet_customer_id' => new sfWidgetFormFilterInput(),
      'pincode'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fonet_customer_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pincode'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('accounts_new_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AccountsNew';
  }

  public function getFields()
  {
    return array(
      'fonet_customer_id' => 'Number',
      'pincode'           => 'Text',
      'id'                => 'Number',
    );
  }
}
