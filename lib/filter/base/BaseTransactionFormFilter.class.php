<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Transaction filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseTransactionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'amount'                => new sfWidgetFormFilterInput(),
      'description'           => new sfWidgetFormFilterInput(),
      'order_id'              => new sfWidgetFormPropelChoice(array('model' => 'CustomerOrder', 'add_empty' => true)),
      'customer_id'           => new sfWidgetFormPropelChoice(array('model' => 'Customer', 'add_empty' => true)),
      'transaction_status_id' => new sfWidgetFormPropelChoice(array('model' => 'EntityStatus', 'add_empty' => true)),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'agent_company_id'      => new sfWidgetFormFilterInput(),
      'commission_amount'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'amount'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'description'           => new sfValidatorPass(array('required' => false)),
      'order_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CustomerOrder', 'column' => 'id')),
      'customer_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Customer', 'column' => 'id')),
      'transaction_status_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'EntityStatus', 'column' => 'id')),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'agent_company_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'commission_amount'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('transaction_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Transaction';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'amount'                => 'Number',
      'description'           => 'Text',
      'order_id'              => 'ForeignKey',
      'customer_id'           => 'ForeignKey',
      'transaction_status_id' => 'ForeignKey',
      'created_at'            => 'Date',
      'agent_company_id'      => 'Number',
      'commission_amount'     => 'Number',
    );
  }
}
