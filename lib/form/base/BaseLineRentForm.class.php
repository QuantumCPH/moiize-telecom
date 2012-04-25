<?php

/**
 * LineRent form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseLineRentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'company_id'     => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => false)),
      'rent_active'    => new sfWidgetFormInputCheckbox(),
      'number_of_days' => new sfWidgetFormInput(),
      'rent_value'     => new sfWidgetFormInput(),
      'started_date'   => new sfWidgetFormDate(),
      'created_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'LineRent', 'column' => 'id', 'required' => false)),
      'company_id'     => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id')),
      'rent_active'    => new sfValidatorBoolean(),
      'number_of_days' => new sfValidatorInteger(),
      'rent_value'     => new sfValidatorInteger(),
      'started_date'   => new sfValidatorDate(),
      'created_at'     => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'LineRent', 'column' => array('company_id')))
    );

    $this->widgetSchema->setNameFormat('line_rent[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LineRent';
  }


}
