<?php

/**
 * EmployeeProduct form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseEmployeeProductForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'employee_id' => new sfWidgetFormPropelChoice(array('model' => 'Employee', 'add_empty' => false)),
      'product_id'  => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => false)),
      'quantity'    => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'EmployeeProduct', 'column' => 'id', 'required' => false)),
      'employee_id' => new sfValidatorPropelChoice(array('model' => 'Employee', 'column' => 'id')),
      'product_id'  => new sfValidatorPropelChoice(array('model' => 'Product', 'column' => 'id')),
      'quantity'    => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('employee_product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EmployeeProduct';
  }


}
