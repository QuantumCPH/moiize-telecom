<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * AgentCommission filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseAgentCommissionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'agent_company_id'    => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
      'revenue_interval_id' => new sfWidgetFormPropelChoice(array('model' => 'RevenueInterval', 'add_empty' => true)),
      'commission_rate'     => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'agent_company_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AgentCompany', 'column' => 'id')),
      'revenue_interval_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RevenueInterval', 'column' => 'id')),
      'commission_rate'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('agent_commission_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgentCommission';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'agent_company_id'    => 'ForeignKey',
      'revenue_interval_id' => 'ForeignKey',
      'commission_rate'     => 'Number',
      'created_at'          => 'Date',
    );
  }
}
