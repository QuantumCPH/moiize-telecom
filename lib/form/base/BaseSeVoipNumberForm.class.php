<?php

/**
 * SeVoipNumber form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseSeVoipNumberForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'number'      => new sfWidgetFormInput(),
      'customer_id' => new sfWidgetFormInput(),
      'is_assigned' => new sfWidgetFormInputCheckbox(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'SeVoipNumber', 'column' => 'id', 'required' => false)),
      'number'      => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'customer_id' => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'is_assigned' => new sfValidatorBoolean(),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('se_voip_number[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SeVoipNumber';
  }


}
