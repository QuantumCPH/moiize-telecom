<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Invoice filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseInvoiceFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'            => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'totalPayment'          => new sfWidgetFormFilterInput(),
      'due_date'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'billing_starting_date' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'billing_ending_date'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'invoice_status_id'     => new sfWidgetFormPropelChoice(array('model' => 'InvoiceStatus', 'add_empty' => true)),
      'invoice_html'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'company_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Company', 'column' => 'id')),
      'totalPayment'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'due_date'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'billing_starting_date' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'billing_ending_date'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'invoice_status_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'InvoiceStatus', 'column' => 'id')),
      'invoice_html'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invoice_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Invoice';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'company_id'            => 'ForeignKey',
      'totalPayment'          => 'Number',
      'due_date'              => 'Date',
      'created_at'            => 'Date',
      'billing_starting_date' => 'Date',
      'billing_ending_date'   => 'Date',
      'invoice_status_id'     => 'ForeignKey',
      'invoice_html'          => 'Text',
    );
  }
}
