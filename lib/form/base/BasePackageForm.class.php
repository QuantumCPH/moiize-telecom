<?php

/**
 * Package form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BasePackageForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInput(),
      'billing_dur'        => new sfWidgetFormInput(),
      'billing_due_days'   => new sfWidgetFormInput(),
      'specificatoin_cost' => new sfWidgetFormInput(),
      'R1_cost'            => new sfWidgetFormInput(),
      'R2_cost'            => new sfWidgetFormInput(),
      'activaton_cost'     => new sfWidgetFormInput(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Package', 'column' => 'id', 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'billing_dur'        => new sfValidatorInteger(),
      'billing_due_days'   => new sfValidatorInteger(array('required' => false)),
      'specificatoin_cost' => new sfValidatorNumber(array('required' => false)),
      'R1_cost'            => new sfValidatorNumber(array('required' => false)),
      'R2_cost'            => new sfValidatorNumber(array('required' => false)),
      'activaton_cost'     => new sfValidatorNumber(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('package[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Package';
  }


}
