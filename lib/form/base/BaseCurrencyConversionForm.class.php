<?php

/**
 * CurrencyConversion form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCurrencyConversionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'bpp_dkk' => new sfWidgetFormInput(),
      'dkk_bpp' => new sfWidgetFormInput(),
      'plz_dkk' => new sfWidgetFormInput(),
      'dkk_plz' => new sfWidgetFormInput(),
      'eur_dkk' => new sfWidgetFormInput(),
      'dkk_eur' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorPropelChoice(array('model' => 'CurrencyConversion', 'column' => 'id', 'required' => false)),
      'bpp_dkk' => new sfValidatorNumber(array('required' => false)),
      'dkk_bpp' => new sfValidatorNumber(array('required' => false)),
      'plz_dkk' => new sfValidatorNumber(array('required' => false)),
      'dkk_plz' => new sfValidatorNumber(array('required' => false)),
      'eur_dkk' => new sfValidatorNumber(array('required' => false)),
      'dkk_eur' => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('currency_conversion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CurrencyConversion';
  }


}
