<?php

/**
 * Host form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseHostForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'host_name'  => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'status'     => new sfWidgetFormInput(),
      'url'        => new sfWidgetFormInput(),
      'start_date' => new sfWidgetFormDateTime(),
      'end_date'   => new sfWidgetFormDateTime(),
      'counter'    => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Host', 'column' => 'id', 'required' => false)),
      'host_name'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'status'     => new sfValidatorInteger(array('required' => false)),
      'url'        => new sfValidatorString(array('max_length' => 75, 'required' => false)),
      'start_date' => new sfValidatorDateTime(array('required' => false)),
      'end_date'   => new sfValidatorDateTime(array('required' => false)),
      'counter'    => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('host[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Host';
  }


}
