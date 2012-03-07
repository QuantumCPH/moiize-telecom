<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Customer filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCustomerFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_name'               => new sfWidgetFormFilterInput(),
      'last_name'                => new sfWidgetFormFilterInput(),
      'country_id'               => new sfWidgetFormPropelChoice(array('model' => 'Country', 'add_empty' => true)),
      'city'                     => new sfWidgetFormFilterInput(),
      'po_box_number'            => new sfWidgetFormFilterInput(),
      'mobile_number'            => new sfWidgetFormFilterInput(),
      'device_id'                => new sfWidgetFormPropelChoice(array('model' => 'Device', 'add_empty' => true)),
      'email'                    => new sfWidgetFormFilterInput(),
      'password'                 => new sfWidgetFormFilterInput(),
      'is_newsletter_subscriber' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'customer_status_id'       => new sfWidgetFormPropelChoice(array('model' => 'EntityStatus', 'add_empty' => true)),
      'address'                  => new sfWidgetFormFilterInput(),
      'fonet_customer_id'        => new sfWidgetFormPropelChoice(array('model' => 'FonetCustomer', 'add_empty' => true)),
      'referrer_id'              => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
      'telecom_operator_id'      => new sfWidgetFormPropelChoice(array('model' => 'TelecomOperator', 'add_empty' => true)),
      'date_of_birth'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'other'                    => new sfWidgetFormFilterInput(),
      'subscription_type'        => new sfWidgetFormFilterInput(),
      'auto_refill_amount'       => new sfWidgetFormFilterInput(),
      'subscription_id'          => new sfWidgetFormFilterInput(),
      'last_auto_refill'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'auto_refill_min_balance'  => new sfWidgetFormFilterInput(),
      'c9_customer_number'       => new sfWidgetFormFilterInput(),
      'registration_type_id'     => new sfWidgetFormFilterInput(),
      'imsi'                     => new sfWidgetFormFilterInput(),
      'uniqueid'                 => new sfWidgetFormFilterInput(),
      'plain_text'               => new sfWidgetFormFilterInput(),
      'ticketval'                => new sfWidgetFormFilterInput(),
      'to_date'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'from_date'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'i_customer'               => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'first_name'               => new sfValidatorPass(array('required' => false)),
      'last_name'                => new sfValidatorPass(array('required' => false)),
      'country_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Country', 'column' => 'id')),
      'city'                     => new sfValidatorPass(array('required' => false)),
      'po_box_number'            => new sfValidatorPass(array('required' => false)),
      'mobile_number'            => new sfValidatorPass(array('required' => false)),
      'device_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Device', 'column' => 'id')),
      'email'                    => new sfValidatorPass(array('required' => false)),
      'password'                 => new sfValidatorPass(array('required' => false)),
      'is_newsletter_subscriber' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'customer_status_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'EntityStatus', 'column' => 'id')),
      'address'                  => new sfValidatorPass(array('required' => false)),
      'fonet_customer_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'FonetCustomer', 'column' => 'fonet_customer_id')),
      'referrer_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AgentCompany', 'column' => 'id')),
      'telecom_operator_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TelecomOperator', 'column' => 'id')),
      'date_of_birth'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'other'                    => new sfValidatorPass(array('required' => false)),
      'subscription_type'        => new sfValidatorPass(array('required' => false)),
      'auto_refill_amount'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'subscription_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'last_auto_refill'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'auto_refill_min_balance'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'c9_customer_number'       => new sfValidatorPass(array('required' => false)),
      'registration_type_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'imsi'                     => new sfValidatorPass(array('required' => false)),
      'uniqueid'                 => new sfValidatorPass(array('required' => false)),
      'plain_text'               => new sfValidatorPass(array('required' => false)),
      'ticketval'                => new sfValidatorPass(array('required' => false)),
      'to_date'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'from_date'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'i_customer'               => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('customer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Customer';
  }

  public function getFields()
  {
    return array(
      'id'                       => 'Number',
      'first_name'               => 'Text',
      'last_name'                => 'Text',
      'country_id'               => 'ForeignKey',
      'city'                     => 'Text',
      'po_box_number'            => 'Text',
      'mobile_number'            => 'Text',
      'device_id'                => 'ForeignKey',
      'email'                    => 'Text',
      'password'                 => 'Text',
      'is_newsletter_subscriber' => 'Boolean',
      'created_at'               => 'Date',
      'updated_at'               => 'Date',
      'customer_status_id'       => 'ForeignKey',
      'address'                  => 'Text',
      'fonet_customer_id'        => 'ForeignKey',
      'referrer_id'              => 'ForeignKey',
      'telecom_operator_id'      => 'ForeignKey',
      'date_of_birth'            => 'Date',
      'other'                    => 'Text',
      'subscription_type'        => 'Text',
      'auto_refill_amount'       => 'Number',
      'subscription_id'          => 'Number',
      'last_auto_refill'         => 'Date',
      'auto_refill_min_balance'  => 'Number',
      'c9_customer_number'       => 'Text',
      'registration_type_id'     => 'Number',
      'imsi'                     => 'Text',
      'uniqueid'                 => 'Text',
      'plain_text'               => 'Text',
      'ticketval'                => 'Text',
      'to_date'                  => 'Date',
      'from_date'                => 'Date',
      'i_customer'               => 'Text',
    );
  }
}
