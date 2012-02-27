<?php

/**
 * CallbackLog form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCallbackLogForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'mobile_number' => new sfWidgetFormInput(),
      'callingcode'   => new sfWidgetFormInput(),
      'uniqueid'      => new sfWidgetFormInput(),
      'imsi'          => new sfWidgetFormInput(),
      'created'       => new sfWidgetFormDateTime(),
      'check_status'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'CallbackLog', 'column' => 'id', 'required' => false)),
      'mobile_number' => new sfValidatorString(array('max_length' => 255)),
      'callingcode'   => new sfValidatorInteger(),
      'uniqueid'      => new sfValidatorString(array('max_length' => 255)),
      'imsi'          => new sfValidatorString(array('max_length' => 250)),
      'created'       => new sfValidatorDateTime(),
      'check_status'  => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('callback_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CallbackLog';
  }


}
