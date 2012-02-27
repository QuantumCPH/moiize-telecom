<?php

/**
 * AccountsNew form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseAccountsNewForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fonet_customer_id' => new sfWidgetFormInput(),
      'pincode'           => new sfWidgetFormInput(),
      'id'                => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'fonet_customer_id' => new sfValidatorInteger(array('required' => false)),
      'pincode'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id'                => new sfValidatorPropelChoice(array('model' => 'AccountsNew', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('accounts_new[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AccountsNew';
  }


}
