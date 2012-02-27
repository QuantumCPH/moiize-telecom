<?php

/**
 * Getrefferredtransactionforregistrations form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseGetrefferredtransactionforregistrationsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'amount'           => new sfWidgetFormInput(),
      'amount_cur_month' => new sfWidgetFormInput(),
      'customer_id'      => new sfWidgetFormInput(),
      'created_at'       => new sfWidgetFormDateTime(),
      'referrer_id'      => new sfWidgetFormInput(),
      're_todate'        => new sfWidgetFormInput(),
      're_cur_month'     => new sfWidgetFormInput(),
      'id'               => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'amount'           => new sfValidatorNumber(array('required' => false)),
      'amount_cur_month' => new sfValidatorNumber(array('required' => false)),
      'customer_id'      => new sfValidatorInteger(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'referrer_id'      => new sfValidatorInteger(array('required' => false)),
      're_todate'        => new sfValidatorNumber(array('required' => false)),
      're_cur_month'     => new sfValidatorNumber(array('required' => false)),
      'id'               => new sfValidatorPropelChoice(array('model' => 'Getrefferredtransactionforregistrations', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('getrefferredtransactionforregistrations[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Getrefferredtransactionforregistrations';
  }


}
