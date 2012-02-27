<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * ExchangeRate filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseExchangeRateFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'currency_code' => new sfWidgetFormFilterInput(),
      'rate'          => new sfWidgetFormFilterInput(),
      'is_default'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'currency_code' => new sfValidatorPass(array('required' => false)),
      'rate'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_default'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('exchange_rate_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExchangeRate';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'currency_code' => 'Text',
      'rate'          => 'Number',
      'is_default'    => 'Boolean',
    );
  }
}
