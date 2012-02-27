<?php

/**
 * OtherCost form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseOtherCostForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'company_id' => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'OtherCost', 'column' => 'id', 'required' => false)),
      'name'       => new sfValidatorString(),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'company_id' => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('other_cost[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OtherCost';
  }


}
