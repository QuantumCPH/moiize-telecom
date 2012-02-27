<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * EmailQueue filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseEmailQueueFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'message'          => new sfWidgetFormFilterInput(),
      'receipient_email' => new sfWidgetFormFilterInput(),
      'subject'          => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'receipient_name'  => new sfWidgetFormFilterInput(),
      'ref_id'           => new sfWidgetFormFilterInput(),
      'email_status_id'  => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'email_type'       => new sfWidgetFormFilterInput(),
      'cutomer_id'       => new sfWidgetFormFilterInput(),
      'agent_id'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'message'          => new sfValidatorPass(array('required' => false)),
      'receipient_email' => new sfValidatorPass(array('required' => false)),
      'subject'          => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'receipient_name'  => new sfValidatorPass(array('required' => false)),
      'ref_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'email_status_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Status', 'column' => 'id')),
      'email_type'       => new sfValidatorPass(array('required' => false)),
      'cutomer_id'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'agent_id'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('email_queue_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EmailQueue';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'message'          => 'Text',
      'receipient_email' => 'Text',
      'subject'          => 'Text',
      'created_at'       => 'Date',
      'receipient_name'  => 'Text',
      'ref_id'           => 'Number',
      'email_status_id'  => 'ForeignKey',
      'email_type'       => 'Text',
      'cutomer_id'       => 'Number',
      'agent_id'         => 'Number',
    );
  }
}
