<?php

/**
 * CustomerOrder form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCustomerOrderForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'product_id'                  => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => false)),
      'quantity'                    => new sfWidgetFormInput(),
      'order_status_id'             => new sfWidgetFormPropelChoice(array('model' => 'EntityStatus', 'add_empty' => false)),
      'customer_id'                 => new sfWidgetFormPropelChoice(array('model' => 'Customer', 'add_empty' => false)),
      'extra_refill'                => new sfWidgetFormInput(),
      'created_at'                  => new sfWidgetFormDateTime(),
      'updated_at'                  => new sfWidgetFormDateTime(),
      'is_first_order'              => new sfWidgetFormInputCheckbox(),
      'agent_commission_package_id' => new sfWidgetFormPropelChoice(array('model' => 'AgentCommissionPackage', 'add_empty' => true)),
      'exe_status'                  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorPropelChoice(array('model' => 'CustomerOrder', 'column' => 'id', 'required' => false)),
      'product_id'                  => new sfValidatorPropelChoice(array('model' => 'Product', 'column' => 'id')),
      'quantity'                    => new sfValidatorInteger(),
      'order_status_id'             => new sfValidatorPropelChoice(array('model' => 'EntityStatus', 'column' => 'id')),
      'customer_id'                 => new sfValidatorPropelChoice(array('model' => 'Customer', 'column' => 'id')),
      'extra_refill'                => new sfValidatorNumber(),
      'created_at'                  => new sfValidatorDateTime(),
      'updated_at'                  => new sfValidatorDateTime(array('required' => false)),
      'is_first_order'              => new sfValidatorBoolean(),
      'agent_commission_package_id' => new sfValidatorPropelChoice(array('model' => 'AgentCommissionPackage', 'column' => 'id', 'required' => false)),
      'exe_status'                  => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('customer_order[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CustomerOrder';
  }


}
