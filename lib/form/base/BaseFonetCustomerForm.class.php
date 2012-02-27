<?php

/**
 * FonetCustomer form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseFonetCustomerForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fonet_customer_id'   => new sfWidgetFormInputHidden(),
      'fonet_customer_code' => new sfWidgetFormInput(),
      'activated_on'        => new sfWidgetFormDateTime(),
      'sip_name'            => new sfWidgetFormInput(),
      'sip_pwd'             => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'fonet_customer_id'   => new sfValidatorPropelChoice(array('model' => 'FonetCustomer', 'column' => 'fonet_customer_id', 'required' => false)),
      'fonet_customer_code' => new sfValidatorString(array('max_length' => 255)),
      'activated_on'        => new sfValidatorDateTime(array('required' => false)),
      'sip_name'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sip_pwd'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('fonet_customer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'FonetCustomer';
  }


}
