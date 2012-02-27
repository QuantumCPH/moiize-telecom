<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * BillingCdrDetails filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseBillingCdrDetailsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'call_time'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'from_country'                => new sfWidgetFormFilterInput(),
      'from_number'                 => new sfWidgetFormFilterInput(),
      'to_number'                   => new sfWidgetFormFilterInput(),
      'duration'                    => new sfWidgetFormFilterInput(),
      'duration_second'             => new sfWidgetFormFilterInput(),
      'purchase_price'              => new sfWidgetFormFilterInput(),
      'fonet_description'           => new sfWidgetFormFilterInput(),
      'billing_status'              => new sfWidgetFormFilterInput(),
      'created_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'duration_minutes'            => new sfWidgetFormFilterInput(),
      'employee_id'                 => new sfWidgetFormFilterInput(),
      'call_rate_table_description' => new sfWidgetFormFilterInput(),
      'call_rate_table_id'          => new sfWidgetFormFilterInput(),
      'processing_comment'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'call_time'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'from_country'                => new sfValidatorPass(array('required' => false)),
      'from_number'                 => new sfValidatorPass(array('required' => false)),
      'to_number'                   => new sfValidatorPass(array('required' => false)),
      'duration'                    => new sfValidatorPass(array('required' => false)),
      'duration_second'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'purchase_price'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fonet_description'           => new sfValidatorPass(array('required' => false)),
      'billing_status'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'duration_minutes'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'employee_id'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'call_rate_table_description' => new sfValidatorPass(array('required' => false)),
      'call_rate_table_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'processing_comment'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('billing_cdr_details_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BillingCdrDetails';
  }

  public function getFields()
  {
    return array(
      'id'                          => 'Number',
      'call_time'                   => 'Date',
      'from_country'                => 'Text',
      'from_number'                 => 'Text',
      'to_number'                   => 'Text',
      'duration'                    => 'Text',
      'duration_second'             => 'Number',
      'purchase_price'              => 'Number',
      'fonet_description'           => 'Text',
      'billing_status'              => 'Number',
      'created_at'                  => 'Date',
      'duration_minutes'            => 'Number',
      'employee_id'                 => 'Number',
      'call_rate_table_description' => 'Text',
      'call_rate_table_id'          => 'Number',
      'processing_comment'          => 'Text',
    );
  }
}
