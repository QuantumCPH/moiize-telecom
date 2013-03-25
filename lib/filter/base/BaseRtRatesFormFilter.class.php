<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * RtRates filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseRtRatesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'rate'          => new sfWidgetFormFilterInput(),
      'rt_service_id' => new sfWidgetFormFilterInput(),
      'rt_country_id' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'rate'          => new sfValidatorPass(array('required' => false)),
      'rt_service_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rt_country_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('rt_rates_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RtRates';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'rate'          => 'Text',
      'rt_service_id' => 'Number',
      'rt_country_id' => 'Number',
    );
  }
}
