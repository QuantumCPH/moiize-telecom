<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * TelecomOperator filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseTelecomOperatorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'       => new sfWidgetFormFilterInput(),
      'status_id'  => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'country_id' => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'       => new sfValidatorPass(array('required' => false)),
      'status_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Status', 'column' => 'id')),
      'country_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'EnableCountry', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('telecom_operator_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TelecomOperator';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'name'       => 'Text',
      'status_id'  => 'ForeignKey',
      'country_id' => 'ForeignKey',
    );
  }
}
