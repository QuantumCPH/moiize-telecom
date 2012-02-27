<?php

/**
 * Company form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCompanyForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'name'                   => new sfWidgetFormInput(),
      'vat_no'                 => new sfWidgetFormInput(),
      'ean_number'             => new sfWidgetFormInput(),
      'address'                => new sfWidgetFormInput(),
      'post_code'              => new sfWidgetFormInput(),
      'country_id'             => new sfWidgetFormPropelChoice(array('model' => 'Country', 'add_empty' => true)),
      'city_id'                => new sfWidgetFormPropelChoice(array('model' => 'City', 'add_empty' => true)),
      'contact_name'           => new sfWidgetFormInput(),
      'email'                  => new sfWidgetFormInput(),
      'head_phone_number'      => new sfWidgetFormInput(),
      'fax_number'             => new sfWidgetFormInput(),
      'website'                => new sfWidgetFormInput(),
      'status_id'              => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'company_size_id'        => new sfWidgetFormPropelChoice(array('model' => 'CompanySize', 'add_empty' => true)),
      'company_type_id'        => new sfWidgetFormPropelChoice(array('model' => 'CompanyType', 'add_empty' => true)),
      'customer_type_id'       => new sfWidgetFormPropelChoice(array('model' => 'CustomerType', 'add_empty' => true)),
      'cpr_number'             => new sfWidgetFormInput(),
      'apartment_form_id'      => new sfWidgetFormPropelChoice(array('model' => 'ApartmentForm', 'add_empty' => true)),
      'invoice_method_id'      => new sfWidgetFormPropelChoice(array('model' => 'InvoiceMethod', 'add_empty' => false)),
      'account_manager_id'     => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'agent_company_id'       => new sfWidgetFormPropelChoice(array('model' => 'AgentCompany', 'add_empty' => true)),
      'confirmed_at'           => new sfWidgetFormDate(),
      'cvr_number'             => new sfWidgetFormInput(),
      'sim_card_dispatch_date' => new sfWidgetFormDate(),
      'usage_discount_pc'      => new sfWidgetFormInput(),
      'registration_date'      => new sfWidgetFormDateTime(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'file_path'              => new sfWidgetFormInput(),
      'rate_table_id'          => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id', 'required' => false)),
      'name'                   => new sfValidatorString(array('max_length' => 255)),
      'vat_no'                 => new sfValidatorString(array('max_length' => 50)),
      'ean_number'             => new sfValidatorInteger(array('required' => false)),
      'address'                => new sfValidatorString(array('max_length' => 255)),
      'post_code'              => new sfValidatorString(array('max_length' => 255)),
      'country_id'             => new sfValidatorPropelChoice(array('model' => 'Country', 'column' => 'id', 'required' => false)),
      'city_id'                => new sfValidatorPropelChoice(array('model' => 'City', 'column' => 'id', 'required' => false)),
      'contact_name'           => new sfValidatorString(array('max_length' => 150)),
      'email'                  => new sfValidatorString(array('max_length' => 255)),
      'head_phone_number'      => new sfValidatorInteger(),
      'fax_number'             => new sfValidatorInteger(array('required' => false)),
      'website'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status_id'              => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id', 'required' => false)),
      'company_size_id'        => new sfValidatorPropelChoice(array('model' => 'CompanySize', 'column' => 'id', 'required' => false)),
      'company_type_id'        => new sfValidatorPropelChoice(array('model' => 'CompanyType', 'column' => 'id', 'required' => false)),
      'customer_type_id'       => new sfValidatorPropelChoice(array('model' => 'CustomerType', 'column' => 'id', 'required' => false)),
      'cpr_number'             => new sfValidatorInteger(array('required' => false)),
      'apartment_form_id'      => new sfValidatorPropelChoice(array('model' => 'ApartmentForm', 'column' => 'id', 'required' => false)),
      'invoice_method_id'      => new sfValidatorPropelChoice(array('model' => 'InvoiceMethod', 'column' => 'id')),
      'account_manager_id'     => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'agent_company_id'       => new sfValidatorPropelChoice(array('model' => 'AgentCompany', 'column' => 'id', 'required' => false)),
      'confirmed_at'           => new sfValidatorDate(array('required' => false)),
      'cvr_number'             => new sfValidatorInteger(array('required' => false)),
      'sim_card_dispatch_date' => new sfValidatorDate(array('required' => false)),
      'usage_discount_pc'      => new sfValidatorNumber(array('required' => false)),
      'registration_date'      => new sfValidatorDateTime(array('required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'file_path'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'rate_table_id'          => new sfValidatorInteger(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Company', 'column' => array('vat_no')))
    );

    $this->widgetSchema->setNameFormat('company[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Company';
  }


}
