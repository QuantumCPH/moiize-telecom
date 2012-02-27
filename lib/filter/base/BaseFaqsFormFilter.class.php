<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Faqs filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseFaqsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'question'   => new sfWidgetFormFilterInput(),
      'answer'     => new sfWidgetFormFilterInput(),
      'country_id' => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => true)),
      'status_id'  => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'create_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'question'   => new sfValidatorPass(array('required' => false)),
      'answer'     => new sfValidatorPass(array('required' => false)),
      'country_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'EnableCountry', 'column' => 'id')),
      'status_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Status', 'column' => 'id')),
      'create_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('faqs_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Faqs';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'question'   => 'Text',
      'answer'     => 'Text',
      'country_id' => 'ForeignKey',
      'status_id'  => 'ForeignKey',
      'create_at'  => 'Date',
    );
  }
}
