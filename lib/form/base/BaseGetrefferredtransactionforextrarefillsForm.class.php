<?php

/**
 * Getrefferredtransactionforextrarefills form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseGetrefferredtransactionforextrarefillsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'amount'             => new sfWidgetFormInput(),
      'amount_cur_month'   => new sfWidgetFormInput(),
      'customer_id'        => new sfWidgetFormInput(),
      'referrer_id'        => new sfWidgetFormInput(),
      'ere_todate'         => new sfWidgetFormInput(),
      'ere_cur_month'      => new sfWidgetFormInput(),
      'total_transactions' => new sfWidgetFormInput(),
      'id'                 => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'amount'             => new sfValidatorNumber(array('required' => false)),
      'amount_cur_month'   => new sfValidatorNumber(array('required' => false)),
      'customer_id'        => new sfValidatorInteger(array('required' => false)),
      'referrer_id'        => new sfValidatorInteger(array('required' => false)),
      'ere_todate'         => new sfValidatorNumber(array('required' => false)),
      'ere_cur_month'      => new sfValidatorNumber(array('required' => false)),
      'total_transactions' => new sfValidatorInteger(),
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Getrefferredtransactionforextrarefills', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('getrefferredtransactionforextrarefills[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Getrefferredtransactionforextrarefills';
  }


}
