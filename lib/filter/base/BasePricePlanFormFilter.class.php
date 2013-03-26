<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * PricePlan filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BasePricePlanFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'                  => new sfWidgetFormFilterInput(),
      'telinta_product_id'     => new sfWidgetFormPropelChoice(array('model' => 'TelintaProduct', 'add_empty' => true)),
      'telinta_routingplan_id' => new sfWidgetFormPropelChoice(array('model' => 'TelintaRoutingplan', 'add_empty' => true)),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'title'                  => new sfValidatorPass(array('required' => false)),
      'telinta_product_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TelintaProduct', 'column' => 'id')),
      'telinta_routingplan_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TelintaRoutingplan', 'column' => 'id')),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('price_plan_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PricePlan';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'title'                  => 'Text',
      'telinta_product_id'     => 'ForeignKey',
      'telinta_routingplan_id' => 'ForeignKey',
      'created_at'             => 'Date',
    );
  }
}
