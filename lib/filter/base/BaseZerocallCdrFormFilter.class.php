<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * ZerocallCdr filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseZerocallCdrFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CustomID'              => new sfWidgetFormFilterInput(),
      'AnswerTimeB'           => new sfWidgetFormFilterInput(),
      'EndTimeB'              => new sfWidgetFormFilterInput(),
      'BillSec'               => new sfWidgetFormFilterInput(),
      'BillingTime'           => new sfWidgetFormFilterInput(),
      'Extension'             => new sfWidgetFormFilterInput(),
      'SourceCty'             => new sfWidgetFormFilterInput(),
      'Ani'                   => new sfWidgetFormFilterInput(),
      'DestCty'               => new sfWidgetFormFilterInput(),
      'Rounding'              => new sfWidgetFormFilterInput(),
      'UsedValue'             => new sfWidgetFormFilterInput(),
      'InitialAccount'        => new sfWidgetFormFilterInput(),
      'DST_CustomID'          => new sfWidgetFormFilterInput(),
      'DestinationName'       => new sfWidgetFormFilterInput(),
      'COST_RateMatchPhno'    => new sfWidgetFormFilterInput(),
      'COST_DestinationName'  => new sfWidgetFormFilterInput(),
      'COST_RateValue'        => new sfWidgetFormFilterInput(),
      'COST_RateValueFirst'   => new sfWidgetFormFilterInput(),
      'COST_CcsConnectCharge' => new sfWidgetFormFilterInput(),
      'COST_UsedValue'        => new sfWidgetFormFilterInput(),
      'BZ2_Rate1Minute'       => new sfWidgetFormFilterInput(),
      'BZ1_RateAddMinute'     => new sfWidgetFormFilterInput(),
      'execute_status'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'CustomID'              => new sfValidatorPass(array('required' => false)),
      'AnswerTimeB'           => new sfValidatorPass(array('required' => false)),
      'EndTimeB'              => new sfValidatorPass(array('required' => false)),
      'BillSec'               => new sfValidatorPass(array('required' => false)),
      'BillingTime'           => new sfValidatorPass(array('required' => false)),
      'Extension'             => new sfValidatorPass(array('required' => false)),
      'SourceCty'             => new sfValidatorPass(array('required' => false)),
      'Ani'                   => new sfValidatorPass(array('required' => false)),
      'DestCty'               => new sfValidatorPass(array('required' => false)),
      'Rounding'              => new sfValidatorPass(array('required' => false)),
      'UsedValue'             => new sfValidatorPass(array('required' => false)),
      'InitialAccount'        => new sfValidatorPass(array('required' => false)),
      'DST_CustomID'          => new sfValidatorPass(array('required' => false)),
      'DestinationName'       => new sfValidatorPass(array('required' => false)),
      'COST_RateMatchPhno'    => new sfValidatorPass(array('required' => false)),
      'COST_DestinationName'  => new sfValidatorPass(array('required' => false)),
      'COST_RateValue'        => new sfValidatorPass(array('required' => false)),
      'COST_RateValueFirst'   => new sfValidatorPass(array('required' => false)),
      'COST_CcsConnectCharge' => new sfValidatorPass(array('required' => false)),
      'COST_UsedValue'        => new sfValidatorPass(array('required' => false)),
      'BZ2_Rate1Minute'       => new sfValidatorPass(array('required' => false)),
      'BZ1_RateAddMinute'     => new sfValidatorPass(array('required' => false)),
      'execute_status'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('zerocall_cdr_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ZerocallCdr';
  }

  public function getFields()
  {
    return array(
      'CdrKey'                => 'Text',
      'CustomID'              => 'Text',
      'AnswerTimeB'           => 'Text',
      'EndTimeB'              => 'Text',
      'BillSec'               => 'Text',
      'BillingTime'           => 'Text',
      'Extension'             => 'Text',
      'SourceCty'             => 'Text',
      'Ani'                   => 'Text',
      'DestCty'               => 'Text',
      'Rounding'              => 'Text',
      'UsedValue'             => 'Text',
      'InitialAccount'        => 'Text',
      'DST_CustomID'          => 'Text',
      'DestinationName'       => 'Text',
      'COST_RateMatchPhno'    => 'Text',
      'COST_DestinationName'  => 'Text',
      'COST_RateValue'        => 'Text',
      'COST_RateValueFirst'   => 'Text',
      'COST_CcsConnectCharge' => 'Text',
      'COST_UsedValue'        => 'Text',
      'BZ2_Rate1Minute'       => 'Text',
      'BZ1_RateAddMinute'     => 'Text',
      'execute_status'        => 'Boolean',
    );
  }
}
