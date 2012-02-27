<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * CountryRates filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCountryRatesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'destination'    => new sfWidgetFormFilterInput(),
      'purchase_price' => new sfWidgetFormFilterInput(),
      'sale_price'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'destination'    => new sfValidatorPass(array('required' => false)),
      'purchase_price' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'sale_price'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('country_rates_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CountryRates';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'destination'    => 'Text',
      'purchase_price' => 'Number',
      'sale_price'     => 'Number',
    );
  }
}
