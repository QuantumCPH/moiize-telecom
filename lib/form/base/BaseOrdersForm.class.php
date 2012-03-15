<?php

/**
 * Orders form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseOrdersForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'O_Id'    => new sfWidgetFormInputHidden(),
      'OrderNo' => new sfWidgetFormInput(),
      'P_Id'    => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'O_Id'    => new sfValidatorPropelChoice(array('model' => 'Orders', 'column' => 'O_Id', 'required' => false)),
      'OrderNo' => new sfValidatorInteger(),
      'P_Id'    => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orders[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Orders';
  }


}
