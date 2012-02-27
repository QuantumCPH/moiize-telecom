<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * CallHistory filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCallHistoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'mobile_number' => new sfWidgetFormFilterInput(),
      'call_date'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'call_duration' => new sfWidgetFormFilterInput(),
      'destination'   => new sfWidgetFormFilterInput(),
      'user_charge'   => new sfWidgetFormFilterInput(),
      'vendor'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mobile_number' => new sfValidatorPass(array('required' => false)),
      'call_date'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'call_duration' => new sfValidatorPass(array('required' => false)),
      'destination'   => new sfValidatorPass(array('required' => false)),
      'user_charge'   => new sfValidatorPass(array('required' => false)),
      'vendor'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('call_history_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CallHistory';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'mobile_number' => 'Text',
      'call_date'     => 'Date',
      'call_duration' => 'Text',
      'destination'   => 'Text',
      'user_charge'   => 'Text',
      'vendor'        => 'Text',
    );
  }
}
