<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * CallRateTableLandcall filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCallRateTableLandcallFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'destination_name'    => new sfWidgetFormFilterInput(),
      'destination_no_from' => new sfWidgetFormFilterInput(),
      'connect_charge'      => new sfWidgetFormFilterInput(),
      'rate'                => new sfWidgetFormFilterInput(),
      'rate_status'         => new sfWidgetFormFilterInput(),
      'ratecreated'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'destination_name'    => new sfValidatorPass(array('required' => false)),
      'destination_no_from' => new sfValidatorPass(array('required' => false)),
      'connect_charge'      => new sfValidatorPass(array('required' => false)),
      'rate'                => new sfValidatorPass(array('required' => false)),
      'rate_status'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ratecreated'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('call_rate_table_landcall_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CallRateTableLandcall';
  }

  public function getFields()
  {
    return array(
      'call_rate_table_id'  => 'Number',
      'destination_name'    => 'Text',
      'destination_no_from' => 'Text',
      'connect_charge'      => 'Text',
      'rate'                => 'Text',
      'rate_status'         => 'Number',
      'ratecreated'         => 'Date',
    );
  }
}
