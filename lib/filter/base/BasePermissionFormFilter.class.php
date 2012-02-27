<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Permission filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BasePermissionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'module_name' => new sfWidgetFormFilterInput(),
      'action_name' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'module_name' => new sfValidatorPass(array('required' => false)),
      'action_name' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('permission_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Permission';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'module_name' => 'Text',
      'action_name' => 'Text',
    );
  }
}
