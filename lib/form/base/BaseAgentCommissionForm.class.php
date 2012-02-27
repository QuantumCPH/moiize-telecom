<?php

/**
 * AgentCommission form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseAgentCommissionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'agent_company_id'    => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
      'revenue_interval_id' => new sfWidgetFormPropelChoice(array('model' => 'RevenueInterval', 'add_empty' => true)),
      'commission_rate'     => new sfWidgetFormInput(),
      'created_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'AgentCommission', 'column' => 'id', 'required' => false)),
      'agent_company_id'    => new sfValidatorPropelChoice(array('model' => 'AgentCompany', 'column' => 'id', 'required' => false)),
      'revenue_interval_id' => new sfValidatorPropelChoice(array('model' => 'RevenueInterval', 'column' => 'id', 'required' => false)),
      'commission_rate'     => new sfValidatorInteger(),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agent_commission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgentCommission';
  }


}
