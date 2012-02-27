<?php

/**
 * Getrefferredtransactionsgroupbycustomer form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseGetrefferredtransactionsgroupbycustomerForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'customer_id'        => new sfWidgetFormInput(),
      'is_first_order'     => new sfWidgetFormInputCheckbox(),
      'amount'             => new sfWidgetFormInput(),
      'amount_cur_month'   => new sfWidgetFormInput(),
      'referrer_id'        => new sfWidgetFormInput(),
      're_todate'          => new sfWidgetFormInput(),
      're_cur_month'       => new sfWidgetFormInput(),
      'ere_todate'         => new sfWidgetFormInput(),
      'ere_cur_month'      => new sfWidgetFormInput(),
      'total_transactions' => new sfWidgetFormInput(),
      'id'                 => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'customer_id'        => new sfValidatorInteger(array('required' => false)),
      'is_first_order'     => new sfValidatorBoolean(),
      'amount'             => new sfValidatorNumber(array('required' => false)),
      'amount_cur_month'   => new sfValidatorNumber(array('required' => false)),
      'referrer_id'        => new sfValidatorInteger(array('required' => false)),
      're_todate'          => new sfValidatorNumber(array('required' => false)),
      're_cur_month'       => new sfValidatorNumber(array('required' => false)),
      'ere_todate'         => new sfValidatorNumber(array('required' => false)),
      'ere_cur_month'      => new sfValidatorNumber(array('required' => false)),
      'total_transactions' => new sfValidatorInteger(),
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Getrefferredtransactionsgroupbycustomer', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('getrefferredtransactionsgroupbycustomer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Getrefferredtransactionsgroupbycustomer';
  }


}
