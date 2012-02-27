<?php

/**
 * Visit form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseVisitForm extends BaseFormPropel
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
      'id'         => new sfValidatorPropelChoice(array('model' => 'Visit', 'column' => 'id', 'required' => false)),
      'host_id'    => new sfValidatorInteger(array('required' => false)),
      'banner_id'  => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'status'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('visit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Visit';
  }


}
