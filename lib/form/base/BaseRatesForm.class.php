<?php

/**
 * Rates form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseRatesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'tital'                  => new sfWidgetFormInput(),
      'standard_package_rates' => new sfWidgetFormInput(),
      'premium_package_rates'  => new sfWidgetFormInput(),
      'created_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorPropelChoice(array('model' => 'Rates', 'column' => 'id', 'required' => false)),
      'tital'                  => new sfValidatorString(array('max_length' => 255)),
      'standard_package_rates' => new sfValidatorString(array('max_length' => 255)),
      'premium_package_rates'  => new sfValidatorString(array('max_length' => 255)),
      'created_at'             => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('rates[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Rates';
  }


}
