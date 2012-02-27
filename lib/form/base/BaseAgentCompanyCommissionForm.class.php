<?php

/**
 * AgentCompanyCommission form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseAgentCompanyCommissionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'agent_company_id'            => new sfWidgetFormInput(),
      'agent_commission_package_id' => new sfWidgetFormInput(),
      'start_date'                  => new sfWidgetFormDateTime(),
      'end_date'                    => new sfWidgetFormDateTime(),
      'is_current'                  => new sfWidgetFormInput(),
      'created_at'                  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorPropelChoice(array('model' => 'AgentCompanyCommission', 'column' => 'id', 'required' => false)),
      'agent_company_id'            => new sfValidatorInteger(array('required' => false)),
      'agent_commission_package_id' => new sfValidatorInteger(array('required' => false)),
      'start_date'                  => new sfValidatorDateTime(array('required' => false)),
      'end_date'                    => new sfValidatorDateTime(array('required' => false)),
      'is_current'                  => new sfValidatorInteger(array('required' => false)),
      'created_at'                  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agent_company_commission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgentCompanyCommission';
  }


}
