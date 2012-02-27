<?php

/**
 * CompanyPackage form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCompanyPackageForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'billing_dur'        => new sfWidgetFormInput(),
      'billing_due_days'   => new sfWidgetFormInput(),
      'letter_cost'        => new sfWidgetFormInput(),
      'email_cost'         => new sfWidgetFormInput(),
      'specificatoin_cost' => new sfWidgetFormInput(),
      'R1_cost'            => new sfWidgetFormInput(),
      'R2_cost'            => new sfWidgetFormInput(),
      'activaton_cost'     => new sfWidgetFormInput(),
      'company_id'         => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => false)),
      'is_active'          => new sfWidgetFormInput(),
      'created_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'CompanyPackage', 'column' => 'id', 'required' => false)),
      'billing_dur'        => new sfValidatorInteger(),
      'billing_due_days'   => new sfValidatorInteger(array('required' => false)),
      'letter_cost'        => new sfValidatorNumber(array('required' => false)),
      'email_cost'         => new sfValidatorNumber(array('required' => false)),
      'specificatoin_cost' => new sfValidatorNumber(array('required' => false)),
      'R1_cost'            => new sfValidatorNumber(array('required' => false)),
      'R2_cost'            => new sfValidatorNumber(array('required' => false)),
      'activaton_cost'     => new sfValidatorNumber(array('required' => false)),
      'company_id'         => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id')),
      'is_active'          => new sfValidatorInteger(),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_package[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyPackage';
  }


}
