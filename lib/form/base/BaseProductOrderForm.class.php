<?php

/**
 * ProductOrder form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseProductOrderForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'product_id'       => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => false)),
      'company_id'       => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'agent_company_id' => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
      'quantity'         => new sfWidgetFormInput(),
      'discount'         => new sfWidgetFormInput(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'ProductOrder', 'column' => 'id', 'required' => false)),
      'product_id'       => new sfValidatorPropelChoice(array('model' => 'Product', 'column' => 'id')),
      'company_id'       => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id', 'required' => false)),
      'agent_company_id' => new sfValidatorPropelChoice(array('model' => 'AgentCompany', 'column' => 'id', 'required' => false)),
      'quantity'         => new sfValidatorInteger(),
      'discount'         => new sfValidatorNumber(),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_order[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductOrder';
  }


}
