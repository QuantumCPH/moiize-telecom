<?php

/**
 * CompanyTransaction form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCompanyTransactionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'company_id'            => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => false)),
      'amount'                => new sfWidgetFormInput(),
      'extra_refill'          => new sfWidgetFormInput(),
      'created_at'            => new sfWidgetFormDateTime(),
      'paymentType'           => new sfWidgetFormInput(),
      'description'           => new sfWidgetFormTextarea(),
      'transaction_status_id' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorPropelChoice(array('model' => 'CompanyTransaction', 'column' => 'id', 'required' => false)),
      'company_id'            => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id')),
      'amount'                => new sfValidatorNumber(),
      'extra_refill'          => new sfValidatorNumber(),
      'created_at'            => new sfValidatorDateTime(),
      'paymentType'           => new sfValidatorInteger(),
      'description'           => new sfValidatorString(),
      'transaction_status_id' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('company_transaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyTransaction';
  }


}
