<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SupportActivity filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseSupportActivityFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'employee_id'                => new sfWidgetFormPropelChoice(array('model' => 'Employee', 'add_empty' => true)),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'ticket_number'              => new sfWidgetFormFilterInput(),
      'support_issue_id'           => new sfWidgetFormPropelChoice(array('model' => 'SupportIssue', 'add_empty' => true)),
      'comment'                    => new sfWidgetFormFilterInput(),
      'solution'                   => new sfWidgetFormFilterInput(),
      'file_path'                  => new sfWidgetFormFilterInput(),
      'user_id'                    => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'support_activity_status_id' => new sfWidgetFormPropelChoice(array('model' => 'SupportActivityStatus', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'employee_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Employee', 'column' => 'id')),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'ticket_number'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'support_issue_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SupportIssue', 'column' => 'id')),
      'comment'                    => new sfValidatorPass(array('required' => false)),
      'solution'                   => new sfValidatorPass(array('required' => false)),
      'file_path'                  => new sfValidatorPass(array('required' => false)),
      'user_id'                    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'support_activity_status_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SupportActivityStatus', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('support_activity_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SupportActivity';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'employee_id'                => 'ForeignKey',
      'created_at'                 => 'Date',
      'ticket_number'              => 'Number',
      'support_issue_id'           => 'ForeignKey',
      'comment'                    => 'Text',
      'solution'                   => 'Text',
      'file_path'                  => 'Text',
      'user_id'                    => 'ForeignKey',
      'support_activity_status_id' => 'ForeignKey',
    );
  }
}
