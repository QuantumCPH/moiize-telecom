<?php

/**
 * Order form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseOrderForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'product_id'      => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => false)),
      'quantity'        => new sfWidgetFormInput(),
      'order_status_id' => new sfWidgetFormPropelChoice(array('model' => 'EntityStatus', 'add_empty' => false)),
      'customer_id'     => new sfWidgetFormPropelChoice(array('model' => 'Customer', 'add_empty' => false)),
      'extra_refill'    => new sfWidgetFormInput(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'is_first_order'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'Order', 'column' => 'id', 'required' => false)),
      'product_id'      => new sfValidatorPropelChoice(array('model' => 'Product', 'column' => 'id')),
      'quantity'        => new sfValidatorInteger(),
      'order_status_id' => new sfValidatorPropelChoice(array('model' => 'EntityStatus', 'column' => 'id')),
      'customer_id'     => new sfValidatorPropelChoice(array('model' => 'Customer', 'column' => 'id')),
      'extra_refill'    => new sfValidatorNumber(),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'is_first_order'  => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('order[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Order';
  }


}
