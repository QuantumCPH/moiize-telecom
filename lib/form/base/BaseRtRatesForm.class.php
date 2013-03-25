<?php

/**
 * RtRates form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseRtRatesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'rate'          => new sfWidgetFormInput(),
      'rt_service_id' => new sfWidgetFormInput(),
      'rt_country_id' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'RtRates', 'column' => 'id', 'required' => false)),
      'rate'          => new sfValidatorString(array('max_length' => 10)),
      'rt_service_id' => new sfValidatorInteger(),
      'rt_country_id' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('rt_rates[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RtRates';
  }


}
