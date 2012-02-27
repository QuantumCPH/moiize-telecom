<?php

/**
 * SystemLog form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseSystemLogForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'description' => new sfWidgetFormInput(),
      'type'        => new sfWidgetFormInput(),
      'module'      => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'SystemLog', 'column' => 'id', 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 1000)),
      'type'        => new sfValidatorInteger(array('required' => false)),
      'module'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'created_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('system_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystemLog';
  }


}
