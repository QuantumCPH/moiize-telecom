<?php

/**
 * CallHistory form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCallHistoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'mobile_number' => new sfWidgetFormInput(),
      'call_date'     => new sfWidgetFormDateTime(),
      'call_duration' => new sfWidgetFormInput(),
      'destination'   => new sfWidgetFormInput(),
      'user_charge'   => new sfWidgetFormInput(),
      'vendor'        => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'CallHistory', 'column' => 'id', 'required' => false)),
      'mobile_number' => new sfValidatorString(array('max_length' => 255)),
      'call_date'     => new sfValidatorDateTime(array('required' => false)),
      'call_duration' => new sfValidatorString(array('max_length' => 13, 'required' => false)),
      'destination'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_charge'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'vendor'        => new sfValidatorString(array('max_length' => 5)),
    ));

    $this->widgetSchema->setNameFormat('call_history[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CallHistory';
  }


}
