<?php

/**
 * AgentPaymentHistory form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseAgentPaymentHistoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'agent_id'          => new sfWidgetFormInput(),
      'customer_id'       => new sfWidgetFormInput(),
      'expenese_type'     => new sfWidgetFormInput(),
      'amount'            => new sfWidgetFormInput(),
      'remaining_balance' => new sfWidgetFormInput(),
      'created_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorPropelChoice(array('model' => 'AgentPaymentHistory', 'column' => 'id', 'required' => false)),
      'agent_id'          => new sfValidatorInteger(),
      'customer_id'       => new sfValidatorInteger(),
      'expenese_type'     => new sfValidatorInteger(),
      'amount'            => new sfValidatorInteger(),
      'remaining_balance' => new sfValidatorInteger(),
      'created_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('agent_payment_history[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgentPaymentHistory';
  }


}
