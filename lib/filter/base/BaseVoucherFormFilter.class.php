<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Voucher filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseVoucherFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'pin_code' => new sfWidgetFormFilterInput(),
      'amount'   => new sfWidgetFormFilterInput(),
      'type'     => new sfWidgetFormFilterInput(),
      'used_on'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'pin_code' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'amount'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'type'     => new sfValidatorPass(array('required' => false)),
      'used_on'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('voucher_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Voucher';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'pin_code' => 'Number',
      'amount'   => 'Number',
      'type'     => 'Text',
      'used_on'  => 'Date',
    );
  }
}
