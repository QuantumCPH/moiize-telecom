<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Employee filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseEmployeeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'             => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'first_name'             => new sfWidgetFormFilterInput(),
      'last_name'              => new sfWidgetFormFilterInput(),
      'email'                  => new sfWidgetFormFilterInput(),
      'mobile_model'           => new sfWidgetFormFilterInput(),
      'mobile_number'          => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'app_code'               => new sfWidgetFormFilterInput(),
      'is_app_registered'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'password'               => new sfWidgetFormFilterInput(),
      'registration_type'      => new sfWidgetFormFilterInput(),
      'product_price'          => new sfWidgetFormFilterInput(),
      'product_id'             => new sfWidgetFormFilterInput(),
      'telinta_product_id'     => new sfWidgetFormFilterInput(),
      'telinta_routingplan_id' => new sfWidgetFormFilterInput(),
      'price_plan_id'          => new sfWidgetFormPropelChoice(array('model' => 'PricePlan', 'add_empty' => true)),
      'country_code'           => new sfWidgetFormFilterInput(),
      'country_mobile_number'  => new sfWidgetFormFilterInput(),
      'block'                  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'company_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Company', 'column' => 'id')),
      'first_name'             => new sfValidatorPass(array('required' => false)),
      'last_name'              => new sfValidatorPass(array('required' => false)),
      'email'                  => new sfValidatorPass(array('required' => false)),
      'mobile_model'           => new sfValidatorPass(array('required' => false)),
      'mobile_number'          => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'app_code'               => new sfValidatorPass(array('required' => false)),
      'is_app_registered'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'password'               => new sfValidatorPass(array('required' => false)),
      'registration_type'      => new sfValidatorPass(array('required' => false)),
      'product_price'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'product_id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'telinta_product_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'telinta_routingplan_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'price_plan_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PricePlan', 'column' => 'id')),
      'country_code'           => new sfValidatorPass(array('required' => false)),
      'country_mobile_number'  => new sfValidatorPass(array('required' => false)),
      'block'                  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('employee_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Employee';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'company_id'             => 'ForeignKey',
      'first_name'             => 'Text',
      'last_name'              => 'Text',
      'email'                  => 'Text',
      'mobile_model'           => 'Text',
      'mobile_number'          => 'Text',
      'created_at'             => 'Date',
      'app_code'               => 'Text',
      'is_app_registered'      => 'Boolean',
      'password'               => 'Text',
      'registration_type'      => 'Text',
      'product_price'          => 'Number',
      'product_id'             => 'Number',
      'telinta_product_id'     => 'Number',
      'telinta_routingplan_id' => 'Number',
      'price_plan_id'          => 'ForeignKey',
      'country_code'           => 'Text',
      'country_mobile_number'  => 'Text',
      'block'                  => 'Text',
    );
  }
}
