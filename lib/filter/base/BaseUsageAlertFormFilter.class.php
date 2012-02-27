<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * UsageAlert filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseUsageAlertFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'alert_amount'        => new sfWidgetFormFilterInput(),
      'sms_alert_message'   => new sfWidgetFormFilterInput(),
      'sms_active'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'email_alert_message' => new sfWidgetFormFilterInput(),
      'email_active'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'country'             => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => true)),
      'sender_name'         => new sfWidgetFormPropelChoice(array('model' => 'UsageAlertSender', 'add_empty' => true)),
      'status'              => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'alert_amount'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sms_alert_message'   => new sfValidatorPass(array('required' => false)),
      'sms_active'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'email_alert_message' => new sfValidatorPass(array('required' => false)),
      'email_active'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'country'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'EnableCountry', 'column' => 'id')),
      'sender_name'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'UsageAlertSender', 'column' => 'id')),
      'status'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Status', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('usage_alert_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsageAlert';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'alert_amount'        => 'Number',
      'sms_alert_message'   => 'Text',
      'sms_active'          => 'Boolean',
      'email_alert_message' => 'Text',
      'email_active'        => 'Boolean',
      'country'             => 'ForeignKey',
      'sender_name'         => 'ForeignKey',
      'status'              => 'ForeignKey',
    );
  }
}
