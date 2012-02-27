<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Order filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseOrderFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'product_id'      => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => true)),
      'quantity'        => new sfWidgetFormFilterInput(),
      'order_status_id' => new sfWidgetFormPropelChoice(array('model' => 'EntityStatus', 'add_empty' => true)),
      'customer_id'     => new sfWidgetFormPropelChoice(array('model' => 'Customer', 'add_empty' => true)),
      'extra_refill'    => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'is_first_order'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'product_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Product', 'column' => 'id')),
      'quantity'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'order_status_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'EntityStatus', 'column' => 'id')),
      'customer_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Customer', 'column' => 'id')),
      'extra_refill'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'is_first_order'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('order_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Order';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'product_id'      => 'ForeignKey',
      'quantity'        => 'Number',
      'order_status_id' => 'ForeignKey',
      'customer_id'     => 'ForeignKey',
      'extra_refill'    => 'Number',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'is_first_order'  => 'Number',
    );
  }
}
