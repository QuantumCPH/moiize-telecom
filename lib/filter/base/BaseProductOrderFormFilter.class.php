<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * ProductOrder filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseProductOrderFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'product_id'       => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => true)),
      'company_id'       => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'agent_company_id' => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
      'quantity'         => new sfWidgetFormFilterInput(),
      'discount'         => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'product_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Product', 'column' => 'id')),
      'company_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Company', 'column' => 'id')),
      'agent_company_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AgentCompany', 'column' => 'id')),
      'quantity'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'discount'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('product_order_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductOrder';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'product_id'       => 'ForeignKey',
      'company_id'       => 'ForeignKey',
      'agent_company_id' => 'ForeignKey',
      'quantity'         => 'Number',
      'discount'         => 'Number',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
