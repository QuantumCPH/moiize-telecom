<?php

/**
 * Billing form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseBillingForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'time'                   => new sfWidgetFormDateTime(),
      'customer_id'            => new sfWidgetFormInput(),
      'mobile_number'          => new sfWidgetFormInput(),
      'to_number'              => new sfWidgetFormInput(),
      'duration_second'        => new sfWidgetFormInput(),
      'duration_minutes'       => new sfWidgetFormInput(),
      'billing_minutes'        => new sfWidgetFormInput(),
      'cost_per_minute'        => new sfWidgetFormInput(),
      'call_cost'              => new sfWidgetFormInput(),
      'vat'                    => new sfWidgetFormInput(),
      'balance_before'         => new sfWidgetFormInput(),
      'balance_after'          => new sfWidgetFormInput(),
      'rate_table_description' => new sfWidgetFormInput(),
      'rate_table_id'          => new sfWidgetFormInput(),
      'billing_status'         => new sfWidgetFormInput(),
      'created_at'             => new sfWidgetFormDateTime(),
      'cdr_id'                 => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorPropelChoice(array('model' => 'Billing', 'column' => 'id', 'required' => false)),
      'time'                   => new sfValidatorDateTime(),
      'customer_id'            => new sfValidatorInteger(),
      'mobile_number'          => new sfValidatorString(array('max_length' => 20)),
      'to_number'              => new sfValidatorString(array('max_length' => 20)),
      'duration_second'        => new sfValidatorString(array('max_length' => 10)),
      'duration_minutes'       => new sfValidatorString(array('max_length' => 10)),
      'billing_minutes'        => new sfValidatorString(array('max_length' => 10)),
      'cost_per_minute'        => new sfValidatorNumber(),
      'call_cost'              => new sfValidatorNumber(),
      'vat'                    => new sfValidatorNumber(),
      'balance_before'         => new sfValidatorNumber(array('required' => false)),
      'balance_after'          => new sfValidatorNumber(array('required' => false)),
      'rate_table_description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'rate_table_id'          => new sfValidatorInteger(array('required' => false)),
      'billing_status'         => new sfValidatorInteger(array('required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'cdr_id'                 => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('billing[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Billing';
  }


}
