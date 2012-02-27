<?php

/**
 * Userguide form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseUserguideForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormInput(),
      'description' => new sfWidgetFormTextarea(),
      'country_id'  => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => true)),
      'status_id'   => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'image'       => new sfWidgetFormInput(),
      'create_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Userguide', 'column' => 'id', 'required' => false)),
      'title'       => new sfValidatorString(array('max_length' => 300)),
      'description' => new sfValidatorString(),
      'country_id'  => new sfValidatorPropelChoice(array('model' => 'EnableCountry', 'column' => 'id', 'required' => false)),
      'status_id'   => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id', 'required' => false)),
      'image'       => new sfValidatorString(array('max_length' => 400)),
      'create_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('userguide[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Userguide';
  }


}
