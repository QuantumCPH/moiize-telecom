<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * AgentProduct filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseAgentProductFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'agent_id'                         => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
      'Product_id'                       => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => true)),
      'reg_share_value'                  => new sfWidgetFormFilterInput(),
      'is_reg_share_value_pc'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'reg_share_enable'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'extra_payments_share_value'       => new sfWidgetFormFilterInput(),
      'is_extra_payments_share_value_pc' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'extra_payments_share_enable'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'agent_id'                         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AgentCompany', 'column' => 'id')),
      'Product_id'                       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Product', 'column' => 'id')),
      'reg_share_value'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_reg_share_value_pc'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'reg_share_enable'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'extra_payments_share_value'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_extra_payments_share_value_pc' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'extra_payments_share_enable'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('agent_product_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgentProduct';
  }

  public function getFields()
  {
    return array(
      'agent_product_id'                 => 'Number',
      'agent_id'                         => 'ForeignKey',
      'Product_id'                       => 'ForeignKey',
      'reg_share_value'                  => 'Number',
      'is_reg_share_value_pc'            => 'Boolean',
      'reg_share_enable'                 => 'Boolean',
      'extra_payments_share_value'       => 'Number',
      'is_extra_payments_share_value_pc' => 'Boolean',
      'extra_payments_share_enable'      => 'Boolean',
    );
  }
}
