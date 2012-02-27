<?php

/**
 * Faqs form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseFaqsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'question'   => new sfWidgetFormInput(),
      'answer'     => new sfWidgetFormTextarea(),
      'country_id' => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => true)),
      'status_id'  => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
      'create_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Faqs', 'column' => 'id', 'required' => false)),
      'question'   => new sfValidatorString(array('max_length' => 200)),
      'answer'     => new sfValidatorString(),
      'country_id' => new sfValidatorPropelChoice(array('model' => 'EnableCountry', 'column' => 'id', 'required' => false)),
      'status_id'  => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'id', 'required' => false)),
      'create_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('faqs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Faqs';
  }


}
