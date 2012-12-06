<?php

/**
 * RtDescriptions form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseRtDescriptionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'          => new sfWidgetFormInputHidden(),
      'rt_country_id' => new sfWidgetFormPropelChoice(array('model' => 'RtCountries', 'add_empty' => true)),
      'description'   => new sfWidgetFormInput(),
      'rt_service_id' => new sfWidgetFormPropelChoice(array('model' => 'RtServices', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'code'          => new sfValidatorPropelChoice(array('model' => 'RtDescriptions', 'column' => 'code', 'required' => false)),
      'rt_country_id' => new sfValidatorPropelChoice(array('model' => 'RtCountries', 'column' => 'id', 'required' => false)),
      'description'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'rt_service_id' => new sfValidatorPropelChoice(array('model' => 'RtServices', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rt_descriptions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RtDescriptions';
  }


}
