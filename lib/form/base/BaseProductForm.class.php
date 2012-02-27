<?php

/**
 * Product form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseProductForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'name'                  => new sfWidgetFormInput(),
      'price'                 => new sfWidgetFormInput(),
      'description'           => new sfWidgetFormInput(),
      'initial_balance'       => new sfWidgetFormInput(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'is_extra_fill_applied' => new sfWidgetFormInputCheckbox(),
      'include_in_zerocall'   => new sfWidgetFormInputCheckbox(),
      'is_in_store'           => new sfWidgetFormInputCheckbox(),
      'sms_code'              => new sfWidgetFormInput(),
      'country'               => new sfWidgetFormInput(),
      'refill'                => new sfWidgetFormInput(),
      'country_id'            => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => true)),
      'refill_options'        => new sfWidgetFormInput(),
      'product_order'         => new sfWidgetFormInput(),
      'product_type_package'  => new sfWidgetFormInputCheckbox(),
      'product_country_us'    => new sfWidgetFormInputCheckbox(),
      'registration_fee'      => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorPropelChoice(array('model' => 'Product', 'column' => 'id', 'required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'price'                 => new sfValidatorNumber(),
      'description'           => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'initial_balance'       => new sfValidatorNumber(),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
      'is_extra_fill_applied' => new sfValidatorBoolean(),
      'include_in_zerocall'   => new sfValidatorBoolean(array('required' => false)),
      'is_in_store'           => new sfValidatorBoolean(),
      'sms_code'              => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'country'               => new sfValidatorInteger(),
      'refill'                => new sfValidatorString(array('max_length' => 400)),
      'country_id'            => new sfValidatorPropelChoice(array('model' => 'EnableCountry', 'column' => 'id', 'required' => false)),
      'refill_options'        => new sfValidatorString(array('max_length' => 400)),
      'product_order'         => new sfValidatorInteger(array('required' => false)),
      'product_type_package'  => new sfValidatorBoolean(),
      'product_country_us'    => new sfValidatorBoolean(),
      'registration_fee'      => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Product';
  }


}
