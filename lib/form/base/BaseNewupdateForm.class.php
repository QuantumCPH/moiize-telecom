<?php

/**
 * Newupdate form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseNewupdateForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'created_at'    => new sfWidgetFormDateTime(),
      'message'       => new sfWidgetFormTextarea(),
      'heading'       => new sfWidgetFormInput(),
      'starting_date' => new sfWidgetFormDate(),
      'expire_date'   => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'Newupdate', 'column' => 'id', 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'message'       => new sfValidatorString(array('required' => false)),
      'heading'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'starting_date' => new sfValidatorDate(array('required' => false)),
      'expire_date'   => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('newupdate[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Newupdate';
  }


}
