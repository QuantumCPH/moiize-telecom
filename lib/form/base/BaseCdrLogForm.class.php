<?php

/**
 * CdrLog form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCdrLogForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'date'                   => new sfWidgetFormDateTime(),
      'from_land'              => new sfWidgetFormInput(),
      'from_no'                => new sfWidgetFormInput(),
      'to_destination_rate_id' => new sfWidgetFormPropelChoice(array('model' => 'DestinationRate', 'add_empty' => true)),
      'from_employee_id'       => new sfWidgetFormPropelChoice(array('model' => 'Employee', 'add_empty' => true)),
      'to_no'                  => new sfWidgetFormInput(),
      'dur_hms'                => new sfWidgetFormInput(),
      'dur_secs'               => new sfWidgetFormInput(),
      'price'                  => new sfWidgetFormInput(),
      'purchase_price'         => new sfWidgetFormInput(),
      'sale_price'             => new sfWidgetFormInput(),
      'description'            => new sfWidgetFormInput(),
      'created_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorPropelChoice(array('model' => 'CdrLog', 'column' => 'id', 'required' => false)),
      'date'                   => new sfValidatorDateTime(),
      'from_land'              => new sfValidatorString(array('max_length' => 100)),
      'from_no'                => new sfValidatorString(array('max_length' => 50)),
      'to_destination_rate_id' => new sfValidatorPropelChoice(array('model' => 'DestinationRate', 'column' => 'id', 'required' => false)),
      'from_employee_id'       => new sfValidatorPropelChoice(array('model' => 'Employee', 'column' => 'id', 'required' => false)),
      'to_no'                  => new sfValidatorString(array('max_length' => 50)),
      'dur_hms'                => new sfValidatorString(array('max_length' => 10)),
      'dur_secs'               => new sfValidatorInteger(),
      'price'                  => new sfValidatorNumber(),
      'purchase_price'         => new sfValidatorNumber(array('required' => false)),
      'sale_price'             => new sfValidatorNumber(array('required' => false)),
      'description'            => new sfValidatorString(array('max_length' => 200)),
      'created_at'             => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cdr_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CdrLog';
  }


}
