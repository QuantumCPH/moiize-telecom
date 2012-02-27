<?php

/**
 * SaleActivity form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseSaleActivityForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'company_id'              => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'created_at'              => new sfWidgetFormDateTime(),
      'ticket_number'           => new sfWidgetFormInput(),
      'sale_action_id'          => new sfWidgetFormPropelChoice(array('model' => 'SaleAction', 'add_empty' => true)),
      'comment'                 => new sfWidgetFormTextarea(),
      'file_path'               => new sfWidgetFormInput(),
      'user_id'                 => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'sale_activity_status_id' => new sfWidgetFormPropelChoice(array('model' => 'SaleActivityStatus', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorPropelChoice(array('model' => 'SaleActivity', 'column' => 'id', 'required' => false)),
      'company_id'              => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id', 'required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'ticket_number'           => new sfValidatorInteger(),
      'sale_action_id'          => new sfValidatorPropelChoice(array('model' => 'SaleAction', 'column' => 'id', 'required' => false)),
      'comment'                 => new sfValidatorString(),
      'file_path'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_id'                 => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'sale_activity_status_id' => new sfValidatorPropelChoice(array('model' => 'SaleActivityStatus', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sale_activity[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SaleActivity';
  }


}
