<?php

/**
 * EmailText form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseEmailTextForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'subject'     => new sfWidgetFormInput(),
      'bodyText'    => new sfWidgetFormTextarea(),
      'senderName'  => new sfWidgetFormInput(),
      'senderEmail' => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'EmailText', 'column' => 'id', 'required' => false)),
      'subject'     => new sfValidatorString(array('max_length' => 255)),
      'bodyText'    => new sfValidatorString(),
      'senderName'  => new sfValidatorString(array('max_length' => 255)),
      'senderEmail' => new sfValidatorString(array('max_length' => 255)),
      'created_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('email_text[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EmailText';
  }


}
