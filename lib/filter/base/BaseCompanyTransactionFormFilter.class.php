<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * CompanyTransaction filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCompanyTransactionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'            => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'amount'                => new sfWidgetFormFilterInput(),
      'extra_refill'          => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'paymentType'           => new sfWidgetFormFilterInput(),
      'description'           => new sfWidgetFormFilterInput(),
      'transaction_status_id' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'company_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Company', 'column' => 'id')),
      'amount'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'extra_refill'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'paymentType'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'description'           => new sfValidatorPass(array('required' => false)),
      'transaction_status_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('company_transaction_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyTransaction';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'company_id'            => 'ForeignKey',
      'amount'                => 'Number',
      'extra_refill'          => 'Number',
      'created_at'            => 'Date',
      'paymentType'           => 'Number',
      'description'           => 'Text',
      'transaction_status_id' => 'Number',
    );
  }
}
