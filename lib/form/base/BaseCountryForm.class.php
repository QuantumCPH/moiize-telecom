<?php

/**
 * Country form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCountryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInput(),
      'code'         => new sfWidgetFormInput(),
      'calling_code' => new sfWidgetFormInput(),
      'cbf_rate'     => new sfWidgetFormInput(),
      'taisys_rate'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'Country', 'column' => 'id', 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 255)),
      'code'         => new sfValidatorString(array('max_length' => 50)),
      'calling_code' => new sfValidatorString(array('max_length' => 5)),
      'cbf_rate'     => new sfValidatorNumber(array('required' => false)),
      'taisys_rate'  => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('country[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Country';
  }


}
