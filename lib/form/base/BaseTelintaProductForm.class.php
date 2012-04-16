<?php

/**
 * TelintaProduct form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseTelintaProductForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'i_product'  => new sfWidgetFormInput(),
      'title'      => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'TelintaProduct', 'column' => 'id', 'required' => false)),
      'i_product'  => new sfValidatorString(array('max_length' => 255)),
      'title'      => new sfValidatorString(array('max_length' => 255)),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('telinta_product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TelintaProduct';
  }


}
