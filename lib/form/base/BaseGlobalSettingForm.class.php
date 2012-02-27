<?php

/**
 * GlobalSetting form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseGlobalSettingForm extends BaseFormPropel
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
      'id'          => new sfValidatorPropelChoice(array('model' => 'GlobalSetting', 'column' => 'id', 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 100)),
      'value'       => new sfValidatorString(array('max_length' => 999, 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 999, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'GlobalSetting', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('global_setting[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'GlobalSetting';
  }


}
