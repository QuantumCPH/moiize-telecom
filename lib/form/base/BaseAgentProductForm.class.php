<?php

/**
 * AgentProduct form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseAgentProductForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'agent_product_id'                 => new sfWidgetFormInputHidden(),
      'agent_id'                         => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => false)),
      'Product_id'                       => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => false)),
      'reg_share_value'                  => new sfWidgetFormInput(),
      'is_reg_share_value_pc'            => new sfWidgetFormInputCheckbox(),
      'reg_share_enable'                 => new sfWidgetFormInputCheckbox(),
      'extra_payments_share_value'       => new sfWidgetFormInput(),
      'is_extra_payments_share_value_pc' => new sfWidgetFormInputCheckbox(),
      'extra_payments_share_enable'      => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'agent_product_id'                 => new sfValidatorPropelChoice(array('model' => 'AgentProduct', 'column' => 'agent_product_id', 'required' => false)),
      'agent_id'                         => new sfValidatorPropelChoice(array('model' => 'AgentCompany', 'column' => 'id')),
      'Product_id'                       => new sfValidatorPropelChoice(array('model' => 'Product', 'column' => 'id')),
      'reg_share_value'                  => new sfValidatorNumber(),
      'is_reg_share_value_pc'            => new sfValidatorBoolean(),
      'reg_share_enable'                 => new sfValidatorBoolean(),
      'extra_payments_share_value'       => new sfValidatorNumber(),
      'is_extra_payments_share_value_pc' => new sfValidatorBoolean(),
      'extra_payments_share_enable'      => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('agent_product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgentProduct';
  }


}
