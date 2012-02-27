<?php

/**
 * LangType form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseLangTypeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'     => new sfWidgetFormInputHidden(),
      'name'   => new sfWidgetFormInput(),
      'code'   => new sfWidgetFormInput(),
      'status' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'     => new sfValidatorPropelChoice(array('model' => 'LangType', 'column' => 'id', 'required' => false)),
      'name'   => new sfValidatorString(array('max_length' => 300)),
      'code'   => new sfValidatorString(array('max_length' => 200)),
      'status' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('lang_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LangType';
  }


}
