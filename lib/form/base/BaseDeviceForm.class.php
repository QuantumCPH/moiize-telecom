<?php

/**
 * Device form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseDeviceForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInput(),
      'manufacturer_id' => new sfWidgetFormPropelChoice(array('model' => 'Manufacturer', 'add_empty' => false)),
      'image_file_name' => new sfWidgetFormInput(),
      'sort_order'      => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'Device', 'column' => 'id', 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'manufacturer_id' => new sfValidatorPropelChoice(array('model' => 'Manufacturer', 'column' => 'id')),
      'image_file_name' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'sort_order'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('device[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Device';
  }


}
