<?php

/**
 * Cbf form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCbfForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      's'             => new sfWidgetFormInput(),
      'da'            => new sfWidgetFormInput(),
      'message'       => new sfWidgetFormInput(),
      'st'            => new sfWidgetFormInput(),
      'country_id'    => new sfWidgetFormInput(),
      'mobile_number' => new sfWidgetFormInput(),
      'created_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'Cbf', 'column' => 'id', 'required' => false)),
      's'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'da'            => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'message'       => new sfValidatorString(array('max_length' => 480, 'required' => false)),
      'st'            => new sfValidatorInteger(array('required' => false)),
      'country_id'    => new sfValidatorInteger(array('required' => false)),
      'mobile_number' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cbf[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cbf';
  }


}
