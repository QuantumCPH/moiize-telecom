<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * InvalidPinTry filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseInvalidPinTryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'last_invalid_pin'        => new sfWidgetFormFilterInput(),
      'last_invalid_entry_time' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'invalid_pin_tries'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'last_invalid_pin'        => new sfValidatorPass(array('required' => false)),
      'last_invalid_entry_time' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'invalid_pin_tries'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('invalid_pin_try_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InvalidPinTry';
  }

  public function getFields()
  {
    return array(
      'mobile_number'           => 'Text',
      'last_invalid_pin'        => 'Text',
      'last_invalid_entry_time' => 'Date',
      'invalid_pin_tries'       => 'Number',
    );
  }
}
