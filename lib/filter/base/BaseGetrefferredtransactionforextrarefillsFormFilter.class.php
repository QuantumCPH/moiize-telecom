<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Getrefferredtransactionforextrarefills filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseGetrefferredtransactionforextrarefillsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'amount'             => new sfWidgetFormFilterInput(),
      'amount_cur_month'   => new sfWidgetFormFilterInput(),
      'customer_id'        => new sfWidgetFormFilterInput(),
      'referrer_id'        => new sfWidgetFormFilterInput(),
      'ere_todate'         => new sfWidgetFormFilterInput(),
      'ere_cur_month'      => new sfWidgetFormFilterInput(),
      'total_transactions' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'amount'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'amount_cur_month'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'customer_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'referrer_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ere_todate'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'ere_cur_month'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_transactions' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('getrefferredtransactionforextrarefills_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Getrefferredtransactionforextrarefills';
  }

  public function getFields()
  {
    return array(
      'amount'             => 'Number',
      'amount_cur_month'   => 'Number',
      'customer_id'        => 'Number',
      'referrer_id'        => 'Number',
      'ere_todate'         => 'Number',
      'ere_cur_month'      => 'Number',
      'total_transactions' => 'Number',
      'id'                 => 'Number',
    );
  }
}
