<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * RevenueInterval filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseRevenueIntervalFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'min_revenue' => new sfWidgetFormFilterInput(),
      'max_revenue' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'min_revenue' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'max_revenue' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('revenue_interval_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RevenueInterval';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'min_revenue' => 'Number',
      'max_revenue' => 'Number',
    );
  }
}
