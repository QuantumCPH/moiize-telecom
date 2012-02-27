<?php

/**
 * C9Numbers form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseC9NumbersForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'c9_number'   => new sfWidgetFormInput(),
      'id'          => new sfWidgetFormInputHidden(),
      'is_assigned' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'c9_number'   => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'id'          => new sfValidatorPropelChoice(array('model' => 'C9Numbers', 'column' => 'id', 'required' => false)),
      'is_assigned' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('c9_numbers[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'C9Numbers';
  }


}
