<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * City filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCityFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'country_id' => new sfWidgetFormPropelChoice(array('model' => 'Country', 'add_empty' => true)),
      'name'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'country_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Country', 'column' => 'id')),
      'name'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('city_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'City';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'country_id' => 'ForeignKey',
      'name'       => 'Text',
    );
  }
}
