<?php

/**
 * UsageAlertSender form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseUsageAlertSenderForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'     => new sfWidgetFormInputHidden(),
      'name'   => new sfWidgetFormInput(),
      'status' => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'     => new sfValidatorPropelChoice(array('model' => 'UsageAlertSender', 'column' => 'id', 'required' => false)),
      'name'   => new sfValidatorString(array('max_length' => 400)),
      'status' => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('usage_alert_sender[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsageAlertSender';
  }


}
