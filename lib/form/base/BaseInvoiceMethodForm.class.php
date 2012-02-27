<?php

/**
 * InvoiceMethod form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseInvoiceMethodForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInput(),
      'cost'        => new sfWidgetFormInput(),
      'billingdays' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'InvoiceMethod', 'column' => 'id', 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 255)),
      'cost'        => new sfValidatorNumber(),
      'billingdays' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invoice_method[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InvoiceMethod';
  }


}
