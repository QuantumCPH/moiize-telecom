<?php

/**
 * BillingCdrDetails form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseBillingCdrDetailsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'call_time'                   => new sfWidgetFormDateTime(),
      'from_country'                => new sfWidgetFormInput(),
      'from_number'                 => new sfWidgetFormInput(),
      'to_number'                   => new sfWidgetFormInput(),
      'duration'                    => new sfWidgetFormInput(),
      'duration_second'             => new sfWidgetFormInput(),
      'purchase_price'              => new sfWidgetFormInput(),
      'fonet_description'           => new sfWidgetFormInput(),
      'billing_status'              => new sfWidgetFormInput(),
      'created_at'                  => new sfWidgetFormDateTime(),
      'duration_minutes'            => new sfWidgetFormInput(),
      'employee_id'                 => new sfWidgetFormInput(),
      'call_rate_table_description' => new sfWidgetFormInput(),
      'call_rate_table_id'          => new sfWidgetFormInput(),
      'processing_comment'          => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorPropelChoice(array('model' => 'BillingCdrDetails', 'column' => 'id', 'required' => false)),
      'call_time'                   => new sfValidatorDateTime(),
      'from_country'                => new sfValidatorString(array('max_length' => 255)),
      'from_number'                 => new sfValidatorString(array('max_length' => 255)),
      'to_number'                   => new sfValidatorString(array('max_length' => 255)),
      'duration'                    => new sfValidatorString(array('max_length' => 255)),
      'duration_second'             => new sfValidatorInteger(),
      'purchase_price'              => new sfValidatorInteger(),
      'fonet_description'           => new sfValidatorString(array('max_length' => 255)),
      'billing_status'              => new sfValidatorInteger(),
      'created_at'                  => new sfValidatorDateTime(),
      'duration_minutes'            => new sfValidatorInteger(array('required' => false)),
      'employee_id'                 => new sfValidatorInteger(array('required' => false)),
      'call_rate_table_description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'call_rate_table_id'          => new sfValidatorInteger(array('required' => false)),
      'processing_comment'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('billing_cdr_details[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BillingCdrDetails';
  }


}
