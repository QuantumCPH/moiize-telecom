<?php

/**
 * CustomerCommision form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCustomerCommisionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInput(),
      'commision' => new sfWidgetFormInput(),
      'status'    => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorPropelChoice(array('model' => 'CustomerCommision', 'column' => 'id', 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 255)),
      'commision' => new sfValidatorInteger(),
      'status'    => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('customer_commision[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CustomerCommision';
  }


}
