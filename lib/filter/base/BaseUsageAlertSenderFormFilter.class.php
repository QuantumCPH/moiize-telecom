<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * UsageAlertSender filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseUsageAlertSenderFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'   => new sfWidgetFormFilterInput(),
      'status' => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'   => new sfValidatorPass(array('required' => false)),
      'status' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Status', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('usage_alert_sender_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsageAlertSender';
  }

  public function getFields()
  {
    return array(
      'id'     => 'Number',
      'name'   => 'Text',
      'status' => 'ForeignKey',
    );
  }
}
