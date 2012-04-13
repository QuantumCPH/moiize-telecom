<?php

/**
 * TelintaRoutingplan form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseTelintaRoutingplanForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'i_routing_plan' => new sfWidgetFormInput(),
      'title'          => new sfWidgetFormInput(),
      'created_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'TelintaRoutingplan', 'column' => 'id', 'required' => false)),
      'i_routing_plan' => new sfValidatorString(array('max_length' => 255)),
      'title'          => new sfValidatorString(array('max_length' => 255)),
      'created_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('telinta_routingplan[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TelintaRoutingplan';
  }


}
