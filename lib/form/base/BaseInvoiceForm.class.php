<?php

/**
 * Invoice form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseInvoiceForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'company_id'            => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => false)),
      'totalPayment'          => new sfWidgetFormInput(),
      'due_date'              => new sfWidgetFormDateTime(),
      'created_at'            => new sfWidgetFormDateTime(),
      'billing_starting_date' => new sfWidgetFormDateTime(),
      'billing_ending_date'   => new sfWidgetFormDateTime(),
      'invoice_status_id'     => new sfWidgetFormPropelChoice(array('model' => 'InvoiceStatus', 'add_empty' => false)),
      'invoice_html'          => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorPropelChoice(array('model' => 'Invoice', 'column' => 'id', 'required' => false)),
      'company_id'            => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id')),
      'totalPayment'          => new sfValidatorNumber(),
      'due_date'              => new sfValidatorDateTime(),
      'created_at'            => new sfValidatorDateTime(),
      'billing_starting_date' => new sfValidatorDateTime(),
      'billing_ending_date'   => new sfValidatorDateTime(),
      'invoice_status_id'     => new sfValidatorPropelChoice(array('model' => 'InvoiceStatus', 'column' => 'id')),
      'invoice_html'          => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('invoice[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Invoice';
  }


}
