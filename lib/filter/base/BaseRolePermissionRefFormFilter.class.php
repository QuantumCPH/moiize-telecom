<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * RolePermissionRef filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseRolePermissionRefFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_id'       => new sfWidgetFormPropelChoice(array('model' => 'Role', 'add_empty' => true)),
      'permission_id' => new sfWidgetFormPropelChoice(array('model' => 'Permission', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'role_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Role', 'column' => 'id')),
      'permission_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Permission', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('role_permission_ref_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RolePermissionRef';
  }

  public function getFields()
  {
    return array(
      'role_id'       => 'ForeignKey',
      'permission_id' => 'ForeignKey',
      'id'            => 'Number',
    );
  }
}
