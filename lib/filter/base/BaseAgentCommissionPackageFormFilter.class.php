<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * AgentCommissionPackage filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseAgentCommissionPackageFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                             => new sfWidgetFormFilterInput(),
      'reg_share_value'                  => new sfWidgetFormFilterInput(),
      'is_reg_share_value_pc'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'extra_payments_share_value'       => new sfWidgetFormFilterInput(),
      'is_extra_payments_share_value_pc' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'name'                             => new sfValidatorPass(array('required' => false)),
      'reg_share_value'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_reg_share_value_pc'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'extra_payments_share_value'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_extra_payments_share_value_pc' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('agent_commission_package_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgentCommissionPackage';
  }

  public function getFields()
  {
    return array(
      'id'                               => 'Number',
      'name'                             => 'Text',
      'reg_share_value'                  => 'Number',
      'is_reg_share_value_pc'            => 'Boolean',
      'extra_payments_share_value'       => 'Number',
      'is_extra_payments_share_value_pc' => 'Boolean',
    );
  }
}
