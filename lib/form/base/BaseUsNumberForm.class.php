<?php

/**
 * UsNumber form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseUsNumberForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'customer_id'      => new sfWidgetFormInput(),
      'iccid'            => new sfWidgetFormInput(),
      'msisdn'           => new sfWidgetFormInput(),
      'us_mobile_number' => new sfWidgetFormInput(),
      'active_status'    => new sfWidgetFormInput(),
      'created_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'UsNumber', 'column' => 'id', 'required' => false)),
      'customer_id'      => new sfValidatorInteger(array('required' => false)),
      'iccid'            => new sfValidatorString(array('max_length' => 255)),
      'msisdn'           => new sfValidatorString(array('max_length' => 255)),
      'us_mobile_number' => new sfValidatorString(array('max_length' => 255)),
      'active_status'    => new sfValidatorInteger(),
      'created_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('us_number[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsNumber';
  }


}
