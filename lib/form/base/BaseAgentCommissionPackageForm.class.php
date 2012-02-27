<?php

/**
 * AgentCommissionPackage form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseAgentCommissionPackageForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'name'                             => new sfWidgetFormInput(),
      'reg_share_value'                  => new sfWidgetFormInput(),
      'is_reg_share_value_pc'            => new sfWidgetFormInputCheckbox(),
      'extra_payments_share_value'       => new sfWidgetFormInput(),
      'is_extra_payments_share_value_pc' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorPropelChoice(array('model' => 'AgentCommissionPackage', 'column' => 'id', 'required' => false)),
      'name'                             => new sfValidatorString(array('max_length' => 50)),
      'reg_share_value'                  => new sfValidatorNumber(),
      'is_reg_share_value_pc'            => new sfValidatorBoolean(),
      'extra_payments_share_value'       => new sfValidatorNumber(),
      'is_extra_payments_share_value_pc' => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('agent_commission_package[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgentCommissionPackage';
  }


}
