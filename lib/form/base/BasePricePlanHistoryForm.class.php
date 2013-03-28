<?php

/**
 * PricePlanHistory form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BasePricePlanHistoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'company_id'                => new sfWidgetFormInput(),
      'employee_id'               => new sfWidgetFormInput(),
      'iaccount'                  => new sfWidgetFormInput(),
      'account_title'             => new sfWidgetFormInput(),
      'price_plan_id'             => new sfWidgetFormInput(),
      'price_plan_title'          => new sfWidgetFormInput(),
      'telinta_product_id'        => new sfWidgetFormInput(),
      'telinta_product_title'     => new sfWidgetFormInput(),
      'telinta_routingplan_id'    => new sfWidgetFormInput(),
      'telinta_routingplan_title' => new sfWidgetFormInput(),
      'created_at'                => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorPropelChoice(array('model' => 'PricePlanHistory', 'column' => 'id', 'required' => false)),
      'company_id'                => new sfValidatorInteger(array('required' => false)),
      'employee_id'               => new sfValidatorInteger(array('required' => false)),
      'iaccount'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'account_title'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'price_plan_id'             => new sfValidatorInteger(array('required' => false)),
      'price_plan_title'          => new sfValidatorString(array('max_length' => 220, 'required' => false)),
      'telinta_product_id'        => new sfValidatorInteger(array('required' => false)),
      'telinta_product_title'     => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'telinta_routingplan_id'    => new sfValidatorInteger(array('required' => false)),
      'telinta_routingplan_title' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'created_at'                => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('price_plan_history[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PricePlanHistory';
  }


}
