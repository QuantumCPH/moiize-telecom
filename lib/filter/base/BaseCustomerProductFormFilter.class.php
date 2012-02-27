<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * CustomerProduct filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCustomerProductFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'customer_id'       => new sfWidgetFormPropelChoice(array('model' => 'Customer', 'add_empty' => true)),
      'product_id'        => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => true)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'product_status_id' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'customer_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Customer', 'column' => 'id')),
      'product_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Product', 'column' => 'id')),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'product_status_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('customer_product_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CustomerProduct';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'customer_id'       => 'ForeignKey',
      'product_id'        => 'ForeignKey',
      'created_at'        => 'Date',
      'product_status_id' => 'Number',
    );
  }
}
