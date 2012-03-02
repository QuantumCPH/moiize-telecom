<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Company filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCompanyFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                   => new sfWidgetFormFilterInput(),
      'vat_no'                 => new sfWidgetFormFilterInput(),
      'password'               => new sfWidgetFormFilterInput(),
      'ean_number'             => new sfWidgetFormFilterInput(),
      'address'                => new sfWidgetFormFilterInput(),
      'post_code'              => new sfWidgetFormFilterInput(),
      'country_id'             => new sfWidgetFormPropelChoice(array('model' => 'Country', 'add_empty' => true)),
      'city_id'                => new sfWidgetFormPropelChoice(array('model' => 'City', 'add_empty' => true)),
      'contact_name'           => new sfWidgetFormFilterInput(),
      'email'                  => new sfWidgetFormFilterInput(),
      'head_phone_number'      => new sfWidgetFormFilterInput(),
      'fax_number'             => new sfWidgetFormFilterInput(),
      'website'                => new sfWidgetFormFilterInput(),
      'status_id'              => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'company_size_id'        => new sfWidgetFormPropelChoice(array('model' => 'CompanySize', 'add_empty' => true)),
      'company_type_id'        => new sfWidgetFormPropelChoice(array('model' => 'CompanyType', 'add_empty' => true)),
      'customer_type_id'       => new sfWidgetFormPropelChoice(array('model' => 'CustomerType', 'add_empty' => true)),
      'cpr_number'             => new sfWidgetFormFilterInput(),
      'apartment_form_id'      => new sfWidgetFormPropelChoice(array('model' => 'ApartmentForm', 'add_empty' => true)),
      'invoice_method_id'      => new sfWidgetFormPropelChoice(array('model' => 'InvoiceMethod', 'add_empty' => true)),
      'account_manager_id'     => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'agent_company_id'       => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
      'confirmed_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'cvr_number'             => new sfWidgetFormFilterInput(),
      'sim_card_dispatch_date' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'usage_discount_pc'      => new sfWidgetFormFilterInput(),
      'registration_date'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'file_path'              => new sfWidgetFormFilterInput(),
      'rate_table_id'          => new sfWidgetFormFilterInput(),
      'i_customer'             => new sfWidgetFormFilterInput(),
      'password'               => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'                   => new sfValidatorPass(array('required' => false)),
      'vat_no'                 => new sfValidatorPass(array('required' => false)),
      'password'               => new sfValidatorPass(array('required' => false)),
      'ean_number'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'address'                => new sfValidatorPass(array('required' => false)),
      'post_code'              => new sfValidatorPass(array('required' => false)),
      'country_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Country', 'column' => 'id')),
      'city_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'City', 'column' => 'id')),
      'contact_name'           => new sfValidatorPass(array('required' => false)),
      'email'                  => new sfValidatorPass(array('required' => false)),
      'head_phone_number'      => new sfValidatorPass(array('required' => false)),
      'fax_number'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'website'                => new sfValidatorPass(array('required' => false)),
      'status_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Status', 'column' => 'id')),
      'company_size_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CompanySize', 'column' => 'id')),
      'company_type_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CompanyType', 'column' => 'id')),
      'customer_type_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CustomerType', 'column' => 'id')),
      'cpr_number'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'apartment_form_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ApartmentForm', 'column' => 'id')),
      'invoice_method_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'InvoiceMethod', 'column' => 'id')),
      'account_manager_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'agent_company_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AgentCompany', 'column' => 'id')),
      'confirmed_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cvr_number'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sim_card_dispatch_date' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usage_discount_pc'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'registration_date'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'file_path'              => new sfValidatorPass(array('required' => false)),
      'rate_table_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'i_customer'             => new sfValidatorPass(array('required' => false)),
      'password'               => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Company';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'name'                   => 'Text',
      'vat_no'                 => 'Text',
      'password'               => 'Text',
      'ean_number'             => 'Number',
      'address'                => 'Text',
      'post_code'              => 'Text',
      'country_id'             => 'ForeignKey',
      'city_id'                => 'ForeignKey',
      'contact_name'           => 'Text',
      'email'                  => 'Text',
      'head_phone_number'      => 'Text',
      'fax_number'             => 'Number',
      'website'                => 'Text',
      'status_id'              => 'ForeignKey',
      'company_size_id'        => 'ForeignKey',
      'company_type_id'        => 'ForeignKey',
      'customer_type_id'       => 'ForeignKey',
      'cpr_number'             => 'Number',
      'apartment_form_id'      => 'ForeignKey',
      'invoice_method_id'      => 'ForeignKey',
      'account_manager_id'     => 'ForeignKey',
      'agent_company_id'       => 'ForeignKey',
      'confirmed_at'           => 'Date',
      'cvr_number'             => 'Number',
      'sim_card_dispatch_date' => 'Date',
      'usage_discount_pc'      => 'Number',
      'registration_date'      => 'Date',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'file_path'              => 'Text',
      'rate_table_id'          => 'Number',
      'i_customer'             => 'Text',
      'password'               => 'Text',
    );
  }
}
