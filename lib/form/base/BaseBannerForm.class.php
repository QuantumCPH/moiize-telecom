<?php

/**
 * Banner form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseBannerForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'banner_name' => new sfWidgetFormInput(),
      'host_id'     => new sfWidgetFormInput(),
      'status'      => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
      'counter'     => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Banner', 'column' => 'id', 'required' => false)),
      'banner_name' => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'host_id'     => new sfValidatorInteger(array('required' => false)),
      'status'      => new sfValidatorInteger(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'counter'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('banner[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banner';
  }


}
