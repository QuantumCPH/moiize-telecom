<?php

/**
 * SmsLog form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseSmsLogForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'mobile_number' => new sfWidgetFormInput(),
      'message'       => new sfWidgetFormInput(),
      'sender_name'   => new sfWidgetFormInput(),
      'status'        => new sfWidgetFormInput(),
      'created_at'    => new sfWidgetFormDateTime(),
      'customer_id'   => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'SmsLog', 'column' => 'id', 'required' => false)),
      'mobile_number' => new sfValidatorString(array('max_length' => 50)),
      'message'       => new sfValidatorString(array('max_length' => 255)),
      'sender_name'   => new sfValidatorString(array('max_length' => 30)),
      'status'        => new sfValidatorString(array('max_length' => 20)),
      'created_at'    => new sfValidatorDateTime(),
      'customer_id'   => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sms_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SmsLog';
  }


}
