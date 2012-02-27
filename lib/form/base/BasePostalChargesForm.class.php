<?php

/**
 * PostalCharges form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BasePostalChargesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'charges' => new sfWidgetFormInput(),
      'country' => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => false)),
      'status'  => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorPropelChoice(array('model' => 'PostalCharges', 'column' => 'id', 'required' => false)),
      'charges' => new sfValidatorInteger(),
      'country' => new sfValidatorPropelChoice(array('model' => 'EnableCountry', 'column' => 'id')),
      'status'  => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('postal_charges[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PostalCharges';
  }


}
