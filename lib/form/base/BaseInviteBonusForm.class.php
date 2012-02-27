<?php

/**
 * InviteBonus form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseInviteBonusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'invite_id'   => new sfWidgetFormInput(),
      'customer_id' => new sfWidgetFormInput(),
      'bonus_paid'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'InviteBonus', 'column' => 'id', 'required' => false)),
      'invite_id'   => new sfValidatorInteger(array('required' => false)),
      'customer_id' => new sfValidatorInteger(array('required' => false)),
      'bonus_paid'  => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invite_bonus[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InviteBonus';
  }


}
