<?php

/**
 * CompanyBank form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCompanyBankForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'company_id'     => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'reg_nr'         => new sfWidgetFormInput(),
      'account_number' => new sfWidgetFormInput(),
      'created_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'CompanyBank', 'column' => 'id', 'required' => false)),
      'company_id'     => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id', 'required' => false)),
      'reg_nr'         => new sfValidatorInteger(),
      'account_number' => new sfValidatorString(array('max_length' => 100)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_bank[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyBank';
  }


}
