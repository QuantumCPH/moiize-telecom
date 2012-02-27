<?php

/**
 * EmailQueue form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseEmailQueueForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'message'          => new sfWidgetFormTextarea(),
      'receipient_email' => new sfWidgetFormInput(),
      'subject'          => new sfWidgetFormInput(),
      'created_at'       => new sfWidgetFormDateTime(),
      'receipient_name'  => new sfWidgetFormInput(),
      'ref_id'           => new sfWidgetFormInput(),
      'email_status_id'  => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => false)),
      'email_type'       => new sfWidgetFormInput(),
      'cutomer_id'       => new sfWidgetFormInput(),
      'agent_id'         => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'EmailQueue', 'column' => 'id', 'required' => false)),
      'message'          => new sfValidatorString(),
      'receipient_email' => new sfValidatorString(array('max_length' => 100)),
      'subject'          => new sfValidatorString(array('max_length' => 500)),
      'created_at'       => new sfValidatorDateTime(),
      'receipient_name'  => new sfValidatorString(array('max_length' => 100)),
      'ref_id'           => new sfValidatorInteger(array('required' => false)),
      'email_status_id'  => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id')),
      'email_type'       => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'cutomer_id'       => new sfValidatorInteger(array('required' => false)),
      'agent_id'         => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('email_queue[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EmailQueue';
  }


}
