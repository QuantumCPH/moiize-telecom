<?php

/**
 * InvalidPinTry form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseInvalidPinTryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'mobile_number'           => new sfWidgetFormInputHidden(),
      'last_invalid_pin'        => new sfWidgetFormInput(),
      'last_invalid_entry_time' => new sfWidgetFormDateTime(),
      'invalid_pin_tries'       => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'mobile_number'           => new sfValidatorPropelChoice(array('model' => 'InvalidPinTry', 'column' => 'mobile_number', 'required' => false)),
      'last_invalid_pin'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'last_invalid_entry_time' => new sfValidatorDateTime(array('required' => false)),
      'invalid_pin_tries'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invalid_pin_try[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InvalidPinTry';
  }


}
