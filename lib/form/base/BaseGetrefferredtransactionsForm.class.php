<?php

/**
 * Getrefferredtransactions form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseGetrefferredtransactionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'transaction_id'        => new sfWidgetFormInput(),
      'customer_order_id'     => new sfWidgetFormInput(),
      'amount'                => new sfWidgetFormInput(),
      'customer_id'           => new sfWidgetFormInput(),
      'is_first_order'        => new sfWidgetFormInputCheckbox(),
      'registration_earning'  => new sfWidgetFormInput(),
      'extra_refills_earning' => new sfWidgetFormInput(),
      'created_at'            => new sfWidgetFormDateTime(),
      'referrer_id'           => new sfWidgetFormInput(),
      'name'                  => new sfWidgetFormInput(),
      'first_name'            => new sfWidgetFormInput(),
      'id'                    => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'transaction_id'        => new sfValidatorInteger(),
      'customer_order_id'     => new sfValidatorInteger(),
      'amount'                => new sfValidatorNumber(),
      'customer_id'           => new sfValidatorInteger(array('required' => false)),
      'is_first_order'        => new sfValidatorBoolean(),
      'registration_earning'  => new sfValidatorNumber(array('required' => false)),
      'extra_refills_earning' => new sfValidatorNumber(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'referrer_id'           => new sfValidatorInteger(array('required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 50)),
      'first_name'            => new sfValidatorString(array('max_length' => 255)),
      'id'                    => new sfValidatorPropelChoice(array('model' => 'Getrefferredtransactions', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('getrefferredtransactions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Getrefferredtransactions';
  }


}
