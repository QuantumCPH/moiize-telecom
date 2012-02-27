<?php

/**
 * SmsText form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseSmsTextForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'for_text'     => new sfWidgetFormInput(),
      'text_heading' => new sfWidgetFormInput(),
      'message_text' => new sfWidgetFormTextarea(),
      'created_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'SmsText', 'column' => 'id', 'required' => false)),
      'for_text'     => new sfValidatorString(array('max_length' => 255)),
      'text_heading' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'message_text' => new sfValidatorString(),
      'created_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('sms_text[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SmsText';
  }


}
