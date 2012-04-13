<?php

/**
 * Employee form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseEmployeeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'company_id'             => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'first_name'             => new sfWidgetFormInput(),
      'last_name'              => new sfWidgetFormInput(),
      'email'                  => new sfWidgetFormInput(),
      'mobile_model'           => new sfWidgetFormInput(),
      'mobile_number'          => new sfWidgetFormInput(),
      'created_at'             => new sfWidgetFormDateTime(),
      'app_code'               => new sfWidgetFormInput(),
      'is_app_registered'      => new sfWidgetFormInputCheckbox(),
      'password'               => new sfWidgetFormInput(),
      'registration_type'      => new sfWidgetFormInput(),
      'product_price'          => new sfWidgetFormInput(),
      'product_id'             => new sfWidgetFormInput(),
      'telinta_product_id'     => new sfWidgetFormInput(),
      'telinta_routingplan_id' => new sfWidgetFormInput(),
      'country_code'           => new sfWidgetFormInput(),
      'country_mobile_number'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorPropelChoice(array('model' => 'Employee', 'column' => 'id', 'required' => false)),
      'company_id'             => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id', 'required' => false)),
      'first_name'             => new sfValidatorString(array('max_length' => 50)),
      'last_name'              => new sfValidatorString(array('max_length' => 50)),
      'email'                  => new sfValidatorString(array('max_length' => 150)),
      'mobile_model'           => new sfValidatorString(array('max_length' => 50)),
      'mobile_number'          => new sfValidatorString(array('max_length' => 50)),
      'created_at'             => new sfValidatorDateTime(),
      'app_code'               => new sfValidatorString(array('max_length' => 7, 'required' => false)),
      'is_app_registered'      => new sfValidatorBoolean(array('required' => false)),
      'password'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'registration_type'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'product_price'          => new sfValidatorInteger(array('required' => false)),
      'product_id'             => new sfValidatorInteger(array('required' => false)),
      'telinta_product_id'     => new sfValidatorInteger(array('required' => false)),
      'telinta_routingplan_id' => new sfValidatorInteger(array('required' => false)),
      'country_code'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'country_mobile_number'  => new sfValidatorString(array('max_length' => 250, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('employee[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Employee';
  }


}
