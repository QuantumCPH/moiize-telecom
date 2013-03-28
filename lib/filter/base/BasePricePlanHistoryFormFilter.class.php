<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * PricePlanHistory filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BasePricePlanHistoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'                => new sfWidgetFormFilterInput(),
      'employee_id'               => new sfWidgetFormFilterInput(),
      'iaccount'                  => new sfWidgetFormFilterInput(),
      'account_title'             => new sfWidgetFormFilterInput(),
      'price_plan_id'             => new sfWidgetFormFilterInput(),
      'price_plan_title'          => new sfWidgetFormFilterInput(),
      'telinta_product_id'        => new sfWidgetFormFilterInput(),
      'telinta_product_title'     => new sfWidgetFormFilterInput(),
      'telinta_routingplan_id'    => new sfWidgetFormFilterInput(),
      'telinta_routingplan_title' => new sfWidgetFormFilterInput(),
      'changed_by'                => new sfWidgetFormFilterInput(),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'company_id'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'employee_id'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'iaccount'                  => new sfValidatorPass(array('required' => false)),
      'account_title'             => new sfValidatorPass(array('required' => false)),
      'price_plan_id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'price_plan_title'          => new sfValidatorPass(array('required' => false)),
      'telinta_product_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'telinta_product_title'     => new sfValidatorPass(array('required' => false)),
      'telinta_routingplan_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'telinta_routingplan_title' => new sfValidatorPass(array('required' => false)),
      'changed_by'                => new sfValidatorPass(array('required' => false)),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('price_plan_history_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PricePlanHistory';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'company_id'                => 'Number',
      'employee_id'               => 'Number',
      'iaccount'                  => 'Text',
      'account_title'             => 'Text',
      'price_plan_id'             => 'Number',
      'price_plan_title'          => 'Text',
      'telinta_product_id'        => 'Number',
      'telinta_product_title'     => 'Text',
      'telinta_routingplan_id'    => 'Number',
      'telinta_routingplan_title' => 'Text',
      'changed_by'                => 'Text',
      'created_at'                => 'Date',
    );
  }
}
