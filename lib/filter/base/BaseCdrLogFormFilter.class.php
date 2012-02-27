<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * CdrLog filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCdrLogFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'date'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'from_land'              => new sfWidgetFormFilterInput(),
      'from_no'                => new sfWidgetFormFilterInput(),
      'to_destination_rate_id' => new sfWidgetFormPropelChoice(array('model' => 'DestinationRate', 'add_empty' => true)),
      'from_employee_id'       => new sfWidgetFormPropelChoice(array('model' => 'Employee', 'add_empty' => true)),
      'to_no'                  => new sfWidgetFormFilterInput(),
      'dur_hms'                => new sfWidgetFormFilterInput(),
      'dur_secs'               => new sfWidgetFormFilterInput(),
      'price'                  => new sfWidgetFormFilterInput(),
      'purchase_price'         => new sfWidgetFormFilterInput(),
      'sale_price'             => new sfWidgetFormFilterInput(),
      'description'            => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'date'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'from_land'              => new sfValidatorPass(array('required' => false)),
      'from_no'                => new sfValidatorPass(array('required' => false)),
      'to_destination_rate_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'DestinationRate', 'column' => 'id')),
      'from_employee_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Employee', 'column' => 'id')),
      'to_no'                  => new sfValidatorPass(array('required' => false)),
      'dur_hms'                => new sfValidatorPass(array('required' => false)),
      'dur_secs'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'price'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'purchase_price'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'sale_price'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'description'            => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('cdr_log_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CdrLog';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'date'                   => 'Date',
      'from_land'              => 'Text',
      'from_no'                => 'Text',
      'to_destination_rate_id' => 'ForeignKey',
      'from_employee_id'       => 'ForeignKey',
      'to_no'                  => 'Text',
      'dur_hms'                => 'Text',
      'dur_secs'               => 'Number',
      'price'                  => 'Number',
      'purchase_price'         => 'Number',
      'sale_price'             => 'Number',
      'description'            => 'Text',
      'created_at'             => 'Date',
    );
  }
}
