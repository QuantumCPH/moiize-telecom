<?php

/**
 * Invite form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseInviteForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'email'         => new sfWidgetFormInput(),
      'created_at'    => new sfWidgetFormDateTime(),
      'invite_status' => new sfWidgetFormInput(),
      'bonus_paid'    => new sfWidgetFormInputCheckbox(),
      'customer_id'   => new sfWidgetFormInput(),
      'invite_name'   => new sfWidgetFormInput(),
      'message'       => new sfWidgetFormInput(),
      'invite_number' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'Invite', 'column' => 'id', 'required' => false)),
      'email'         => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'invite_status' => new sfValidatorInteger(array('required' => false)),
      'bonus_paid'    => new sfValidatorBoolean(array('required' => false)),
      'customer_id'   => new sfValidatorInteger(),
      'invite_name'   => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'message'       => new sfValidatorString(array('max_length' => 150)),
      'invite_number' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invite[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Invite';
  }


}
