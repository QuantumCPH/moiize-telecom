<?php

/**
 * SupportActivity form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseSupportActivityForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'employee_id'                => new sfWidgetFormPropelChoice(array('model' => 'Employee', 'add_empty' => true)),
      'created_at'                 => new sfWidgetFormDateTime(),
      'ticket_number'              => new sfWidgetFormInput(),
      'support_issue_id'           => new sfWidgetFormPropelChoice(array('model' => 'SupportIssue', 'add_empty' => true)),
      'comment'                    => new sfWidgetFormTextarea(),
      'solution'                   => new sfWidgetFormTextarea(),
      'file_path'                  => new sfWidgetFormInput(),
      'user_id'                    => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'support_activity_status_id' => new sfWidgetFormPropelChoice(array('model' => 'SupportActivityStatus', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorPropelChoice(array('model' => 'SupportActivity', 'column' => 'id', 'required' => false)),
      'employee_id'                => new sfValidatorPropelChoice(array('model' => 'Employee', 'column' => 'id', 'required' => false)),
      'created_at'                 => new sfValidatorDateTime(array('required' => false)),
      'ticket_number'              => new sfValidatorInteger(),
      'support_issue_id'           => new sfValidatorPropelChoice(array('model' => 'SupportIssue', 'column' => 'id', 'required' => false)),
      'comment'                    => new sfValidatorString(),
      'solution'                   => new sfValidatorString(),
      'file_path'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_id'                    => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'support_activity_status_id' => new sfValidatorPropelChoice(array('model' => 'SupportActivityStatus', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('support_activity[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SupportActivity';
  }


}
