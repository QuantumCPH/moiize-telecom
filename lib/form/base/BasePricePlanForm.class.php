<?php

/**
 * PricePlan form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BasePricePlanForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'title'                  => new sfWidgetFormInput(),
      'telinta_product_id'     => new sfWidgetFormPropelChoice(array('model' => 'TelintaProduct', 'add_empty' => false)),
      'telinta_routingplan_id' => new sfWidgetFormPropelChoice(array('model' => 'TelintaRoutingplan', 'add_empty' => false)),
      'status_id'              => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => false)),
      'created_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorPropelChoice(array('model' => 'PricePlan', 'column' => 'id', 'required' => false)),
      'title'                  => new sfValidatorString(array('max_length' => 220)),
      'telinta_product_id'     => new sfValidatorPropelChoice(array('model' => 'TelintaProduct', 'column' => 'id')),
      'telinta_routingplan_id' => new sfValidatorPropelChoice(array('model' => 'TelintaRoutingplan', 'column' => 'id')),
      'status_id'              => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id')),
      'created_at'             => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('price_plan[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PricePlan';
  }


}
