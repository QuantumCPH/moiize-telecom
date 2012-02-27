<?php

/**
 * DestinationRate form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseDestinationRateForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'destination_name' => new sfWidgetFormInput(),
      'purchase_price'   => new sfWidgetFormInput(),
      'sale_price'       => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'DestinationRate', 'column' => 'id', 'required' => false)),
      'destination_name' => new sfValidatorString(array('max_length' => 255)),
      'purchase_price'   => new sfValidatorNumber(),
      'sale_price'       => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('destination_rate[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DestinationRate';
  }


}
