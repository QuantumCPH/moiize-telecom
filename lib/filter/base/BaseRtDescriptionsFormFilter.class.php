<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * RtDescriptions filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseRtDescriptionsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'rt_country_id' => new sfWidgetFormPropelChoice(array('model' => 'RtCountries', 'add_empty' => true)),
      'description'   => new sfWidgetFormFilterInput(),
      'rt_service_id' => new sfWidgetFormPropelChoice(array('model' => 'RtServices', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'rt_country_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RtCountries', 'column' => 'id')),
      'description'   => new sfValidatorPass(array('required' => false)),
      'rt_service_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RtServices', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('rt_descriptions_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RtDescriptions';
  }

  public function getFields()
  {
    return array(
      'code'          => 'Text',
      'rt_country_id' => 'ForeignKey',
      'description'   => 'Text',
      'rt_service_id' => 'ForeignKey',
    );
  }
}
