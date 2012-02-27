<?php

/**
 * ApartmentForm form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseApartmentFormForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'   => new sfWidgetFormInputHidden(),
      'name' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'   => new sfValidatorPropelChoice(array('model' => 'ApartmentForm', 'column' => 'id', 'required' => false)),
      'name' => new sfValidatorString(array('max_length' => 150)),
    ));

    $this->widgetSchema->setNameFormat('apartment_form[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ApartmentForm';
  }


}
