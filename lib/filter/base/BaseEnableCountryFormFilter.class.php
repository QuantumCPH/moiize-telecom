<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * EnableCountry filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseEnableCountryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'            => new sfWidgetFormFilterInput(),
      'language'        => new sfWidgetFormFilterInput(),
      'language_symbol' => new sfWidgetFormFilterInput(),
      'currency'        => new sfWidgetFormFilterInput(),
      'currency_symbol' => new sfWidgetFormFilterInput(),
      'status'          => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'ceated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'base_url'        => new sfWidgetFormFilterInput(),
      'refill'          => new sfWidgetFormFilterInput(),
      'calling_code'    => new sfWidgetFormFilterInput(),
      'cbf_rate'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'            => new sfValidatorPass(array('required' => false)),
      'language'        => new sfValidatorPass(array('required' => false)),
      'language_symbol' => new sfValidatorPass(array('required' => false)),
      'currency'        => new sfValidatorPass(array('required' => false)),
      'currency_symbol' => new sfValidatorPass(array('required' => false)),
      'status'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Status', 'column' => 'id')),
      'ceated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'base_url'        => new sfValidatorPass(array('required' => false)),
      'refill'          => new sfValidatorPass(array('required' => false)),
      'calling_code'    => new sfValidatorPass(array('required' => false)),
      'cbf_rate'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('enable_country_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EnableCountry';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'name'            => 'Text',
      'language'        => 'Text',
      'language_symbol' => 'Text',
      'currency'        => 'Text',
      'currency_symbol' => 'Text',
      'status'          => 'ForeignKey',
      'ceated_at'       => 'Date',
      'base_url'        => 'Text',
      'refill'          => 'Text',
      'calling_code'    => 'Text',
      'cbf_rate'        => 'Number',
    );
  }
}
