<?php

/**
 * RtCountries form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseRtCountriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'title'    => new sfWidgetFormInput(),
      'de_title' => new sfWidgetFormInput(),
      'es_title' => new sfWidgetFormInput(),
      'sv_title' => new sfWidgetFormInput(),
      'da_title' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorPropelChoice(array('model' => 'RtCountries', 'column' => 'id', 'required' => false)),
      'title'    => new sfValidatorString(array('max_length' => 100)),
      'de_title' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'es_title' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'sv_title' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'da_title' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rt_countries[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RtCountries';
  }


}
