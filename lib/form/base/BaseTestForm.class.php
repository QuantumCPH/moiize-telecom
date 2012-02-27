<?php

/**
 * Test form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseTestForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'name'                   => new sfWidgetFormInput(),
      'cvr_number'             => new sfWidgetFormInput(),
      'ean_number'             => new sfWidgetFormInput(),
      'address'                => new sfWidgetFormInput(),
      'post_code'              => new sfWidgetFormInput(),
      'country_id'             => new sfWidgetFormInput(),
      'city_id'                => new sfWidgetFormInput(),
      'contact_name'           => new sfWidgetFormInput(),
      'email'                  => new sfWidgetFormInput(),
      'head_phone_number'      => new sfWidgetFormInput(),
      'fax_number'             => new sfWidgetFormInput(),
      'website'                => new sfWidgetFormInput(),
      'status_id'              => new sfWidgetFormInput(),
      'company_size_id'        => new sfWidgetFormInput(),
      'company_type_id'        => new sfWidgetFormInput(),
      'customer_type_id'       => new sfWidgetFormInput(),
      'cpr_number'             => new sfWidgetFormInput(),
      'apartment_form_id'      => new sfWidgetFormInput(),
      'invoice_method_id'      => new sfWidgetFormInput(),
      'account_manager_id'     => new sfWidgetFormInput(),
      'agent_company_id'       => new sfWidgetFormInput(),
      'created_at'             => new sfWidgetFormDateTime(),
      'confirmed_at'           => new sfWidgetFormDate(),
      'sim_card_dispatch_date' => new sfWidgetFormDate(),
      'package_id'             => new sfWidgetFormInput(),
      'send_letter'            => new sfWidgetFormInputCheckbox(),
      'send_email'             => new sfWidgetFormInputCheckbox(),
      'send_specification'     => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorPropelChoice(array('model' => 'Test', 'column' => 'id', 'required' => false)),
      'name'                   => new sfValidatorString(array('max_length' => 255)),
      'cvr_number'             => new sfValidatorInteger(),
      'ean_number'             => new sfValidatorInteger(array('required' => false)),
      'address'                => new sfValidatorString(array('max_length' => 255)),
      'post_code'              => new sfValidatorInteger(),
      'country_id'             => new sfValidatorInteger(array('required' => false)),
      'city_id'                => new sfValidatorInteger(array('required' => false)),
      'contact_name'           => new sfValidatorString(array('max_length' => 150)),
      'email'                  => new sfValidatorString(array('max_length' => 255)),
      'head_phone_number'      => new sfValidatorInteger(),
      'fax_number'             => new sfValidatorInteger(),
      'website'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status_id'              => new sfValidatorInteger(array('required' => false)),
      'company_size_id'        => new sfValidatorInteger(array('required' => false)),
      'company_type_id'        => new sfValidatorInteger(array('required' => false)),
      'customer_type_id'       => new sfValidatorInteger(array('required' => false)),
      'cpr_number'             => new sfValidatorInteger(array('required' => false)),
      'apartment_form_id'      => new sfValidatorInteger(array('required' => false)),
      'invoice_method_id'      => new sfValidatorInteger(array('required' => false)),
      'account_manager_id'     => new sfValidatorInteger(array('required' => false)),
      'agent_company_id'       => new sfValidatorInteger(array('required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'confirmed_at'           => new sfValidatorDate(array('required' => false)),
      'sim_card_dispatch_date' => new sfValidatorDate(array('required' => false)),
      'package_id'             => new sfValidatorInteger(),
      'send_letter'            => new sfValidatorBoolean(),
      'send_email'             => new sfValidatorBoolean(),
      'send_specification'     => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('test[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Test';
  }


}
