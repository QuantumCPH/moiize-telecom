<?php

/**
 * ExchangeRate form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseExchangeRateForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'currency_code' => new sfWidgetFormInput(),
      'rate'          => new sfWidgetFormInput(),
      'is_default'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'ExchangeRate', 'column' => 'id', 'required' => false)),
      'currency_code' => new sfValidatorString(array('max_length' => 50)),
      'rate'          => new sfValidatorNumber(),
      'is_default'    => new sfValidatorBoolean(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'ExchangeRate', 'column' => array('currency_code')))
    );

    $this->widgetSchema->setNameFormat('exchange_rate[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExchangeRate';
  }


}
