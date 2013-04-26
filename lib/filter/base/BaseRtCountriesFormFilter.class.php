<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * RtCountries filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseRtCountriesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'    => new sfWidgetFormFilterInput(),
      'de_title' => new sfWidgetFormFilterInput(),
      'es_title' => new sfWidgetFormFilterInput(),
      'sv_title' => new sfWidgetFormFilterInput(),
      'da_title' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'    => new sfValidatorPass(array('required' => false)),
      'de_title' => new sfValidatorPass(array('required' => false)),
      'es_title' => new sfValidatorPass(array('required' => false)),
      'sv_title' => new sfValidatorPass(array('required' => false)),
      'da_title' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rt_countries_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RtCountries';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'title'    => 'Text',
      'de_title' => 'Text',
      'es_title' => 'Text',
      'sv_title' => 'Text',
      'da_title' => 'Text',
    );
  }
}
