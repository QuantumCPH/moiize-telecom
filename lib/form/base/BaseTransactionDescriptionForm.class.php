<?php

/**
 * TransactionDescription form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseTransactionDescriptionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'title'               => new sfWidgetFormInput(),
      'transaction_type_id' => new sfWidgetFormPropelChoice(array('model' => 'TransactionType', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'TransactionDescription', 'column' => 'id', 'required' => false)),
      'title'               => new sfValidatorString(array('max_length' => 255)),
      'transaction_type_id' => new sfValidatorPropelChoice(array('model' => 'TransactionType', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('transaction_description[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TransactionDescription';
  }


}
