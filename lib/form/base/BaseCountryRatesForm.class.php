<?php

/**
 * CountryRates form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCountryRatesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'destination'    => new sfWidgetFormInput(),
      'purchase_price' => new sfWidgetFormInput(),
      'sale_price'     => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'CountryRates', 'column' => 'id', 'required' => false)),
      'destination'    => new sfValidatorString(array('max_length' => 255)),
      'purchase_price' => new sfValidatorNumber(),
      'sale_price'     => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('country_rates[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CountryRates';
  }


}
