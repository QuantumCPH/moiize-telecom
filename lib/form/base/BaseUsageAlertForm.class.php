<?php

/**
 * UsageAlert form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseUsageAlertForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'alert_amount'        => new sfWidgetFormInput(),
      'sms_alert_message'   => new sfWidgetFormTextarea(),
      'sms_active'          => new sfWidgetFormInputCheckbox(),
      'email_alert_message' => new sfWidgetFormTextarea(),
      'email_active'        => new sfWidgetFormInputCheckbox(),
      'country'             => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => false)),
      'sender_name'         => new sfWidgetFormPropelChoice(array('model' => 'UsageAlertSender', 'add_empty' => false)),
      'status'              => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'UsageAlert', 'column' => 'id', 'required' => false)),
      'alert_amount'        => new sfValidatorInteger(),
      'sms_alert_message'   => new sfValidatorString(),
      'sms_active'          => new sfValidatorBoolean(),
      'email_alert_message' => new sfValidatorString(),
      'email_active'        => new sfValidatorBoolean(),
      'country'             => new sfValidatorPropelChoice(array('model' => 'EnableCountry', 'column' => 'id')),
      'sender_name'         => new sfValidatorPropelChoice(array('model' => 'UsageAlertSender', 'column' => 'id')),
      'status'              => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('usage_alert[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsageAlert';
  }


}
