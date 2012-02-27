<?php

/**
 * ZerocallCdr form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseZerocallCdrForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CdrKey'                => new sfWidgetFormInputHidden(),
      'CustomID'              => new sfWidgetFormInput(),
      'AnswerTimeB'           => new sfWidgetFormInput(),
      'EndTimeB'              => new sfWidgetFormInput(),
      'BillSec'               => new sfWidgetFormInput(),
      'BillingTime'           => new sfWidgetFormInput(),
      'Extension'             => new sfWidgetFormInput(),
      'SourceCty'             => new sfWidgetFormInput(),
      'Ani'                   => new sfWidgetFormInput(),
      'DestCty'               => new sfWidgetFormInput(),
      'Rounding'              => new sfWidgetFormInput(),
      'UsedValue'             => new sfWidgetFormInput(),
      'InitialAccount'        => new sfWidgetFormInput(),
      'DST_CustomID'          => new sfWidgetFormInput(),
      'DestinationName'       => new sfWidgetFormInput(),
      'COST_RateMatchPhno'    => new sfWidgetFormInput(),
      'COST_DestinationName'  => new sfWidgetFormInput(),
      'COST_RateValue'        => new sfWidgetFormInput(),
      'COST_RateValueFirst'   => new sfWidgetFormInput(),
      'COST_CcsConnectCharge' => new sfWidgetFormInput(),
      'COST_UsedValue'        => new sfWidgetFormInput(),
      'BZ2_Rate1Minute'       => new sfWidgetFormInput(),
      'BZ1_RateAddMinute'     => new sfWidgetFormInput(),
      'execute_status'        => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'CdrKey'                => new sfValidatorPropelChoice(array('model' => 'ZerocallCdr', 'column' => 'CdrKey', 'required' => false)),
      'CustomID'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'AnswerTimeB'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'EndTimeB'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'BillSec'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'BillingTime'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Extension'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'SourceCty'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Ani'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'DestCty'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Rounding'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'UsedValue'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'InitialAccount'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'DST_CustomID'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'DestinationName'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'COST_RateMatchPhno'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'COST_DestinationName'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'COST_RateValue'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'COST_RateValueFirst'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'COST_CcsConnectCharge' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'COST_UsedValue'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'BZ2_Rate1Minute'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'BZ1_RateAddMinute'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'execute_status'        => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('zerocall_cdr[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ZerocallCdr';
  }


}
