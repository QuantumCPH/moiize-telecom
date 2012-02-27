<?php

/**
 * GlobalSettings form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseGlobalSettingsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInput(),
      'value'       => new sfWidgetFormInput(),
      'description' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'GlobalSettings', 'column' => 'id', 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 100)),
      'value'       => new sfValidatorString(array('max_length' => 999, 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 999, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('global_settings[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'GlobalSettings';
  }


}
