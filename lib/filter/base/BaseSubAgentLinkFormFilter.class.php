<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SubAgentLink filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseSubAgentLinkFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'agent_company_id' => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
      'sub_agent_id'     => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'agent_company_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AgentCompany', 'column' => 'id')),
      'sub_agent_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AgentCompany', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sub_agent_link_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SubAgentLink';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'agent_company_id' => 'ForeignKey',
      'sub_agent_id'     => 'ForeignKey',
    );
  }
}
