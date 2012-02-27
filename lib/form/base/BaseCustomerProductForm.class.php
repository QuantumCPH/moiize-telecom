<?php

/**
 * CustomerProduct form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseCustomerProductForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'customer_id'       => new sfWidgetFormPropelChoice(array('model' => 'Customer', 'add_empty' => false)),
      'product_id'        => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => false)),
      'created_at'        => new sfWidgetFormDateTime(),
      'product_status_id' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorPropelChoice(array('model' => 'CustomerProduct', 'column' => 'id', 'required' => false)),
      'customer_id'       => new sfValidatorPropelChoice(array('model' => 'Customer', 'column' => 'id')),
      'product_id'        => new sfValidatorPropelChoice(array('model' => 'Product', 'column' => 'id')),
      'created_at'        => new sfValidatorDateTime(),
      'product_status_id' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('customer_product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CustomerProduct';
  }


}
