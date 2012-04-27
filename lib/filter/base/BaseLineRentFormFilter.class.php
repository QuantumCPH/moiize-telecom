<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * LineRent filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseLineRentFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'     => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'rent_active'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'number_of_days' => new sfWidgetFormFilterInput(),
      'rent_value'     => new sfWidgetFormFilterInput(),
      'started_date'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'company_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Company', 'column' => 'id')),
      'rent_active'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'number_of_days' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rent_value'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'started_date'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('line_rent_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LineRent';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'company_id'     => 'ForeignKey',
      'rent_active'    => 'Boolean',
      'number_of_days' => 'Number',
      'rent_value'     => 'Number',
      'started_date'   => 'Date',
      'created_at'     => 'Date',
    );
  }
}
