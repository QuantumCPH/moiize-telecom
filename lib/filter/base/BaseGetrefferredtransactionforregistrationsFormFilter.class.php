<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Getrefferredtransactionforregistrations filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseGetrefferredtransactionforregistrationsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'amount'           => new sfWidgetFormFilterInput(),
      'amount_cur_month' => new sfWidgetFormFilterInput(),
      'customer_id'      => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'referrer_id'      => new sfWidgetFormFilterInput(),
      're_todate'        => new sfWidgetFormFilterInput(),
      're_cur_month'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'amount'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'amount_cur_month' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'customer_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'referrer_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      're_todate'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      're_cur_month'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('getrefferredtransactionforregistrations_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Getrefferredtransactionforregistrations';
  }

  public function getFields()
  {
    return array(
      'amount'           => 'Number',
      'amount_cur_month' => 'Number',
      'customer_id'      => 'Number',
      'created_at'       => 'Date',
      'referrer_id'      => 'Number',
      're_todate'        => 'Number',
      're_cur_month'     => 'Number',
      'id'               => 'Number',
    );
  }
}
