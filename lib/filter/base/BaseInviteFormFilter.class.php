<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Invite filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseInviteFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'email'         => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'invite_status' => new sfWidgetFormFilterInput(),
      'bonus_paid'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'customer_id'   => new sfWidgetFormFilterInput(),
      'invite_name'   => new sfWidgetFormFilterInput(),
      'message'       => new sfWidgetFormFilterInput(),
      'invite_number' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'email'         => new sfValidatorPass(array('required' => false)),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'invite_status' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bonus_paid'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'customer_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'invite_name'   => new sfValidatorPass(array('required' => false)),
      'message'       => new sfValidatorPass(array('required' => false)),
      'invite_number' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invite_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Invite';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'email'         => 'Text',
      'created_at'    => 'Date',
      'invite_status' => 'Number',
      'bonus_paid'    => 'Boolean',
      'customer_id'   => 'Number',
      'invite_name'   => 'Text',
      'message'       => 'Text',
      'invite_number' => 'Text',
    );
  }
}
