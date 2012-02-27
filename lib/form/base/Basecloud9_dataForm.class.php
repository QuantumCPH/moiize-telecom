<?php

/**
 * cloud9_data form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class Basecloud9_dataForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'request_type'    => new sfWidgetFormInput(),
      'c9_timestamp'    => new sfWidgetFormDateTime(),
      'transaction_id'  => new sfWidgetFormInput(),
      'call_date'       => new sfWidgetFormDateTime(),
      'cdr'             => new sfWidgetFormInput(),
      'cid'             => new sfWidgetFormInput(),
      'mcc'             => new sfWidgetFormInput(),
      'mnc'             => new sfWidgetFormInput(),
      'imsi'            => new sfWidgetFormInput(),
      'msisdn'          => new sfWidgetFormInput(),
      'destination'     => new sfWidgetFormInput(),
      'leg'             => new sfWidgetFormInput(),
      'leg_duration'    => new sfWidgetFormInput(),
      'reseller_charge' => new sfWidgetFormInput(),
      'client_charge'   => new sfWidgetFormInput(),
      'user_charge'     => new sfWidgetFormInput(),
      'iot'             => new sfWidgetFormInput(),
      'user_balance'    => new sfWidgetFormInput(),
      'ecc'             => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'cloud9_data', 'column' => 'id', 'required' => false)),
      'request_type'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'c9_timestamp'    => new sfValidatorDateTime(array('required' => false)),
      'transaction_id'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'call_date'       => new sfValidatorDateTime(array('required' => false)),
      'cdr'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cid'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mcc'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mnc'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'imsi'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'msisdn'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'destination'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'leg'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'leg_duration'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'reseller_charge' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'client_charge'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_charge'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'iot'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_balance'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ecc'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cloud9_data[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'cloud9_data';
  }


}
