<?php

/**
 * Voucher form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseVoucherForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'pin_code' => new sfWidgetFormInput(),
      'amount'   => new sfWidgetFormInput(),
      'type'     => new sfWidgetFormInput(),
      'used_on'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorPropelChoice(array('model' => 'Voucher', 'column' => 'id', 'required' => false)),
      'pin_code' => new sfValidatorNumber(),
      'amount'   => new sfValidatorNumber(),
      'type'     => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'used_on'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('voucher[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Voucher';
  }


}
