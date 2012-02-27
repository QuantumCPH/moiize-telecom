<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * CurrencyConversion filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCurrencyConversionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'bpp_dkk' => new sfWidgetFormFilterInput(),
      'dkk_bpp' => new sfWidgetFormFilterInput(),
      'plz_dkk' => new sfWidgetFormFilterInput(),
      'dkk_plz' => new sfWidgetFormFilterInput(),
      'eur_dkk' => new sfWidgetFormFilterInput(),
      'dkk_eur' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'bpp_dkk' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'dkk_bpp' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'plz_dkk' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'dkk_plz' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'eur_dkk' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'dkk_eur' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('currency_conversion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CurrencyConversion';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'bpp_dkk' => 'Number',
      'dkk_bpp' => 'Number',
      'plz_dkk' => 'Number',
      'dkk_plz' => 'Number',
      'eur_dkk' => 'Number',
      'dkk_eur' => 'Number',
    );
  }
}
