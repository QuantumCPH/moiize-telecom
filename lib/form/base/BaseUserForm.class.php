<?php

/**
 * User form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInput(),
      'email'         => new sfWidgetFormInput(),
      'password'      => new sfWidgetFormInput(),
      'role_id'       => new sfWidgetFormPropelChoice(array('model' => 'Role', 'add_empty' => true)),
      'is_super_user' => new sfWidgetFormInput(),
      'created_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 150)),
      'email'         => new sfValidatorString(array('max_length' => 150)),
      'password'      => new sfValidatorString(array('max_length' => 150)),
      'role_id'       => new sfValidatorPropelChoice(array('model' => 'Role', 'column' => 'id', 'required' => false)),
      'is_super_user' => new sfValidatorInteger(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }


}
