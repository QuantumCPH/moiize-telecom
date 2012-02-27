<?php

/**
 * Counter form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: BaseCounterForm.class.php,v 1.1 2010-05-25 13:16:00 orehman Exp $
 */
class BaseCounterForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id' => new sfValidatorPropelChoice(array('model' => 'Counter', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('counter[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Counter';
  }


}
