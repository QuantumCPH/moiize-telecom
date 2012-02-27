<?php

/**
 * AgentUser form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseAgentUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'agent_company_id' => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
      'username'         => new sfWidgetFormInput(),
      'password'         => new sfWidgetFormInput(),
      'status_id'        => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'created_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'AgentUser', 'column' => 'id', 'required' => false)),
      'agent_company_id' => new sfValidatorPropelChoice(array('model' => 'AgentCompany', 'column' => 'id', 'required' => false)),
      'username'         => new sfValidatorString(array('max_length' => 150)),
      'password'         => new sfValidatorString(array('max_length' => 150)),
      'status_id'        => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id', 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agent_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgentUser';
  }


}
