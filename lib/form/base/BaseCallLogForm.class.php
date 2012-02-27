<?php

/**
 * CallLog form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCallLogForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'imsi'          => new sfWidgetFormInput(),
      'dest'          => new sfWidgetFormInput(),
      'mac'           => new sfWidgetFormInput(),
      'mobile_number' => new sfWidgetFormInput(),
      'created'       => new sfWidgetFormDateTime(),
      'check_status'  => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'CallLog', 'column' => 'id', 'required' => false)),
      'imsi'          => new sfValidatorString(array('max_length' => 255)),
      'dest'          => new sfValidatorInteger(),
      'mac'           => new sfValidatorInteger(),
      'mobile_number' => new sfValidatorInteger(),
      'created'       => new sfValidatorDateTime(),
      'check_status'  => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('call_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CallLog';
  }


}
