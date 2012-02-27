<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Getrefferredtransactionsplitted filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseGetrefferredtransactionsplittedFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'transaction_id'    => new sfWidgetFormFilterInput(),
      'customer_order_id' => new sfWidgetFormFilterInput(),
      'amount'            => new sfWidgetFormFilterInput(),
      'amount_cur_month'  => new sfWidgetFormFilterInput(),
      'customer_id'       => new sfWidgetFormFilterInput(),
      'is_first_order'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'referrer_id'       => new sfWidgetFormFilterInput(),
      're_todate'         => new sfWidgetFormFilterInput(),
      're_cur_month'      => new sfWidgetFormFilterInput(),
      'ere_todate'        => new sfWidgetFormFilterInput(),
      'ere_cur_month'     => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'transaction_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'customer_order_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'amount'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'amount_cur_month'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'customer_id'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_first_order'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'referrer_id'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      're_todate'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      're_cur_month'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'ere_todate'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'ere_cur_month'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('getrefferredtransactionsplitted_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Getrefferredtransactionsplitted';
  }

  public function getFields()
  {
    return array(
      'transaction_id'    => 'Number',
      'customer_order_id' => 'Number',
      'amount'            => 'Number',
      'amount_cur_month'  => 'Number',
      'customer_id'       => 'Number',
      'is_first_order'    => 'Boolean',
      'referrer_id'       => 'Number',
      're_todate'         => 'Number',
      're_cur_month'      => 'Number',
      'ere_todate'        => 'Number',
      'ere_cur_month'     => 'Number',
      'created_at'        => 'Date',
      'id'                => 'Number',
    );
  }
}
