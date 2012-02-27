<?php

/**
 * Taisys form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseTaisysForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'serv'                  => new sfWidgetFormInput(),
      'imsi'                  => new sfWidgetFormInput(),
      'dn'                    => new sfWidgetFormInput(),
      'smscontent'            => new sfWidgetFormInput(),
      'checksum'              => new sfWidgetFormTextarea(),
      'checksum_verification' => new sfWidgetFormInputCheckbox(),
      'created_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorPropelChoice(array('model' => 'Taisys', 'column' => 'id', 'required' => false)),
      'serv'                  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'imsi'                  => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'dn'                    => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'smscontent'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'checksum'              => new sfValidatorString(array('required' => false)),
      'checksum_verification' => new sfValidatorBoolean(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('taisys[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Taisys';
  }


}
