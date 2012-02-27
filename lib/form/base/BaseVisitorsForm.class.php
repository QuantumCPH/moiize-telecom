<?php

/**
 * Visitors form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseVisitorsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'host_id'    => new sfWidgetFormInput(),
      'banner_id'  => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'status'     => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Visitors', 'column' => 'id', 'required' => false)),
      'host_id'    => new sfValidatorInteger(array('required' => false)),
      'banner_id'  => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'status'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('visitors[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Visitors';
  }


}
