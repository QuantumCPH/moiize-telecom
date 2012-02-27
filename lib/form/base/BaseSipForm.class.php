<?php

/**
 * Sip form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseSipForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'user'        => new sfWidgetFormInput(),
      'pwd'         => new sfWidgetFormInput(),
      'customer_id' => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
      'assigned'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Sip', 'column' => 'id', 'required' => false)),
      'user'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'pwd'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'customer_id' => new sfValidatorInteger(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'assigned'    => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sip[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sip';
  }


}
