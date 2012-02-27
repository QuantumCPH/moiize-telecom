<?php

/**
 * Getrefferredtransactionsplitted form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseGetrefferredtransactionsplittedForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'transaction_id'    => new sfWidgetFormInput(),
      'customer_order_id' => new sfWidgetFormInput(),
      'amount'            => new sfWidgetFormInput(),
      'amount_cur_month'  => new sfWidgetFormInput(),
      'customer_id'       => new sfWidgetFormInput(),
      'is_first_order'    => new sfWidgetFormInputCheckbox(),
      'referrer_id'       => new sfWidgetFormInput(),
      're_todate'         => new sfWidgetFormInput(),
      're_cur_month'      => new sfWidgetFormInput(),
      'ere_todate'        => new sfWidgetFormInput(),
      'ere_cur_month'     => new sfWidgetFormInput(),
      'created_at'        => new sfWidgetFormDateTime(),
      'id'                => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'transaction_id'    => new sfValidatorInteger(),
      'customer_order_id' => new sfValidatorInteger(),
      'amount'            => new sfValidatorNumber(),
      'amount_cur_month'  => new sfValidatorNumber(),
      'customer_id'       => new sfValidatorInteger(array('required' => false)),
      'is_first_order'    => new sfValidatorBoolean(),
      'referrer_id'       => new sfValidatorInteger(array('required' => false)),
      're_todate'         => new sfValidatorNumber(array('required' => false)),
      're_cur_month'      => new sfValidatorNumber(array('required' => false)),
      'ere_todate'        => new sfValidatorNumber(array('required' => false)),
      'ere_cur_month'     => new sfValidatorNumber(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'id'                => new sfValidatorPropelChoice(array('model' => 'Getrefferredtransactionsplitted', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('getrefferredtransactionsplitted[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Getrefferredtransactionsplitted';
  }


}
