<?php

/**
 * PromotionRates form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BasePromotionRatesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'agent_id'     => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => false)),
      'network_name' => new sfWidgetFormInput(),
      'network_rate' => new sfWidgetFormInput(),
      'created_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'PromotionRates', 'column' => 'id', 'required' => false)),
      'agent_id'     => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'id')),
      'network_name' => new sfValidatorString(array('max_length' => 255)),
      'network_rate' => new sfValidatorString(array('max_length' => 255)),
      'created_at'   => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PromotionRates', 'column' => array('agent_id')))
    );

    $this->widgetSchema->setNameFormat('promotion_rates[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PromotionRates';
  }


}
