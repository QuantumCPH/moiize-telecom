<?php

/**
 * RolePermission form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseRolePermissionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_id'       => new sfWidgetFormPropelChoice(array('model' => 'Role', 'add_empty' => false)),
      'permission_id' => new sfWidgetFormPropelChoice(array('model' => 'Permission', 'add_empty' => false)),
      'id'            => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'role_id'       => new sfValidatorPropelChoice(array('model' => 'Role', 'column' => 'id')),
      'permission_id' => new sfValidatorPropelChoice(array('model' => 'Permission', 'column' => 'id')),
      'id'            => new sfValidatorPropelChoice(array('model' => 'RolePermission', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('role_permission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RolePermission';
  }


}
