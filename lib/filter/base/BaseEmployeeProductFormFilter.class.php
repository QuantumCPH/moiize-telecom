<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * EmployeeProduct filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseEmployeeProductFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'employee_id' => new sfWidgetFormPropelChoice(array('model' => 'Employee', 'add_empty' => true)),
      'product_id'  => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => true)),
      'quantity'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'employee_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Employee', 'column' => 'id')),
      'product_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Product', 'column' => 'id')),
      'quantity'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('employee_product_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EmployeeProduct';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'employee_id' => 'ForeignKey',
      'product_id'  => 'ForeignKey',
      'quantity'    => 'Number',
    );
  }
}
