<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * UsNumber filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseUsNumberFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'customer_id'      => new sfWidgetFormFilterInput(),
      'iccid'            => new sfWidgetFormFilterInput(),
      'msisdn'           => new sfWidgetFormFilterInput(),
      'us_mobile_number' => new sfWidgetFormFilterInput(),
      'active_status'    => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'customer_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'iccid'            => new sfValidatorPass(array('required' => false)),
      'msisdn'           => new sfValidatorPass(array('required' => false)),
      'us_mobile_number' => new sfValidatorPass(array('required' => false)),
      'active_status'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('us_number_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsNumber';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'customer_id'      => 'Number',
      'iccid'            => 'Text',
      'msisdn'           => 'Text',
      'us_mobile_number' => 'Text',
      'active_status'    => 'Number',
      'created_at'       => 'Date',
    );
  }
}
