<?php

/**
 * C form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fonet_customer_id' => new sfWidgetFormInput(),
      'id'                => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'fonet_customer_id' => new sfValidatorNumber(),
      'id'                => new sfValidatorPropelChoice(array('model' => 'C', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('c[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'C';
  }


}
