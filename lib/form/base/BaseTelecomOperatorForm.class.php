<?php

/**
 * TelecomOperator form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseTelecomOperatorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInput(),
      'status_id'  => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => false)),
      'country_id' => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'TelecomOperator', 'column' => 'id', 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'status_id'  => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id')),
      'country_id' => new sfValidatorPropelChoice(array('model' => 'EnableCountry', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('telecom_operator[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TelecomOperator';
  }


}
