<?php

/**
 * CommissionPeriod form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCommissionPeriodForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'number_months' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'CommissionPeriod', 'column' => 'id', 'required' => false)),
      'number_months' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('commission_period[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CommissionPeriod';
  }


}
