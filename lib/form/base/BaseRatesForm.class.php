<?php

/**
 * Rates form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseRatesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'tital'         => new sfWidgetFormInput(),
      'rate'          => new sfWidgetFormInput(),
      'price_plan_id' => new sfWidgetFormPropelChoice(array('model' => 'PricePlan', 'add_empty' => false)),
      'created_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'Rates', 'column' => 'id', 'required' => false)),
      'tital'         => new sfValidatorString(array('max_length' => 255)),
      'rate'          => new sfValidatorString(array('max_length' => 255)),
      'price_plan_id' => new sfValidatorPropelChoice(array('model' => 'PricePlan', 'column' => 'id')),
      'created_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('rates[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Rates';
  }


}
