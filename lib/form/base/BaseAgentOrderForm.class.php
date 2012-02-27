<?php

/**
 * AgentOrder form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseAgentOrderForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'agent_order_id'   => new sfWidgetFormInput(),
      'agent_company_id' => new sfWidgetFormInput(),
      'amount'           => new sfWidgetFormInput(),
      'status'           => new sfWidgetFormInput(),
      'created_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'AgentOrder', 'column' => 'id', 'required' => false)),
      'agent_order_id'   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'agent_company_id' => new sfValidatorInteger(array('required' => false)),
      'amount'           => new sfValidatorNumber(array('required' => false)),
      'status'           => new sfValidatorInteger(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('agent_order[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgentOrder';
  }


}
