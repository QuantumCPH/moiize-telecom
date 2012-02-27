<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Billing filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseBillingFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'time'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'customer_id'            => new sfWidgetFormFilterInput(),
      'mobile_number'          => new sfWidgetFormFilterInput(),
      'to_number'              => new sfWidgetFormFilterInput(),
      'duration_second'        => new sfWidgetFormFilterInput(),
      'duration_minutes'       => new sfWidgetFormFilterInput(),
      'billing_minutes'        => new sfWidgetFormFilterInput(),
      'cost_per_minute'        => new sfWidgetFormFilterInput(),
      'call_cost'              => new sfWidgetFormFilterInput(),
      'vat'                    => new sfWidgetFormFilterInput(),
      'balance_before'         => new sfWidgetFormFilterInput(),
      'balance_after'          => new sfWidgetFormFilterInput(),
      'rate_table_description' => new sfWidgetFormFilterInput(),
      'rate_table_id'          => new sfWidgetFormFilterInput(),
      'billing_status'         => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'cdr_id'                 => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'time'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'customer_id'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mobile_number'          => new sfValidatorPass(array('required' => false)),
      'to_number'              => new sfValidatorPass(array('required' => false)),
      'duration_second'        => new sfValidatorPass(array('required' => false)),
      'duration_minutes'       => new sfValidatorPass(array('required' => false)),
      'billing_minutes'        => new sfValidatorPass(array('required' => false)),
      'cost_per_minute'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'call_cost'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'vat'                    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'balance_before'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'balance_after'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'rate_table_description' => new sfValidatorPass(array('required' => false)),
      'rate_table_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'billing_status'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cdr_id'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('billing_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Billing';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'time'                   => 'Date',
      'customer_id'            => 'Number',
      'mobile_number'          => 'Text',
      'to_number'              => 'Text',
      'duration_second'        => 'Text',
      'duration_minutes'       => 'Text',
      'billing_minutes'        => 'Text',
      'cost_per_minute'        => 'Number',
      'call_cost'              => 'Number',
      'vat'                    => 'Number',
      'balance_before'         => 'Number',
      'balance_after'          => 'Number',
      'rate_table_description' => 'Text',
      'rate_table_id'          => 'Number',
      'billing_status'         => 'Number',
      'created_at'             => 'Date',
      'cdr_id'                 => 'Number',
    );
  }
}
