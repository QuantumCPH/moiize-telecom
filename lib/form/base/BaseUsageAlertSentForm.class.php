<?php

/**
 * UsageAlertSent form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseUsageAlertSentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'usage_alert_id' => new sfWidgetFormInput(),
      'customerid'     => new sfWidgetFormInput(),
      'messagetype'    => new sfWidgetFormInput(),
      'alert_amount'   => new sfWidgetFormInput(),
      'senttime'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'UsageAlertSent', 'column' => 'id', 'required' => false)),
      'usage_alert_id' => new sfValidatorInteger(),
      'customerid'     => new sfValidatorInteger(),
      'messagetype'    => new sfValidatorString(array('max_length' => 50)),
      'alert_amount'   => new sfValidatorInteger(),
      'senttime'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('usage_alert_sent[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsageAlertSent';
  }


}
