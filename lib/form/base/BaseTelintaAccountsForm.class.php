<?php

/**
 * TelintaAccounts form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseTelintaAccountsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'parent_table'  => new sfWidgetFormInput(),
      'parent_id'     => new sfWidgetFormInput(),
      'i_account'     => new sfWidgetFormInput(),
      'account_title' => new sfWidgetFormInput(),
      'i_customer'    => new sfWidgetFormInput(),
      'status'        => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'TelintaAccounts', 'column' => 'id', 'required' => false)),
      'parent_table'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'parent_id'     => new sfValidatorInteger(array('required' => false)),
      'i_account'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'account_title' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'i_customer'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'status'        => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('telinta_accounts[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TelintaAccounts';
  }


}
