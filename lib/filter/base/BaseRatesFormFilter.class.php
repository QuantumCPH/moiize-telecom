<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Rates filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseRatesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tital'                  => new sfWidgetFormFilterInput(),
      'standard_package_rates' => new sfWidgetFormFilterInput(),
      'premium_package_rates'  => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'tital'                  => new sfValidatorPass(array('required' => false)),
      'standard_package_rates' => new sfValidatorPass(array('required' => false)),
      'premium_package_rates'  => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('rates_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Rates';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'tital'                  => 'Text',
      'standard_package_rates' => 'Text',
      'premium_package_rates'  => 'Text',
      'created_at'             => 'Date',
    );
  }
}
