<?php

/**
 * MobileModelCsv form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseMobileModelCsvForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nokia'        => new sfWidgetFormInput(),
      'SonyEricsson' => new sfWidgetFormInput(),
      'HTC'          => new sfWidgetFormInput(),
      'iPhone'       => new sfWidgetFormInput(),
      'id'           => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'Nokia'        => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'SonyEricsson' => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'HTC'          => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'iPhone'       => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'id'           => new sfValidatorPropelChoice(array('model' => 'MobileModelCsv', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mobile_model_csv[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MobileModelCsv';
  }


}
