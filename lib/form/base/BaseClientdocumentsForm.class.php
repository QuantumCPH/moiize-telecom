<?php

/**
 * Clientdocuments form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseClientdocumentsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'title'    => new sfWidgetFormInput(),
      'filename' => new sfWidgetFormInput(),
      'status'   => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorPropelChoice(array('model' => 'Clientdocuments', 'column' => 'id', 'required' => false)),
      'title'    => new sfValidatorString(array('max_length' => 300)),
      'filename' => new sfValidatorString(array('max_length' => 400)),
      'status'   => new sfValidatorString(array('max_length' => 12)),
    ));

    $this->widgetSchema->setNameFormat('clientdocuments[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Clientdocuments';
  }


}
