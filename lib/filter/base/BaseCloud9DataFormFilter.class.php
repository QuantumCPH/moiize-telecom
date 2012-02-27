<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Cloud9Data filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCloud9DataFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'request_type'    => new sfWidgetFormFilterInput(),
      'c9_timestamp'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'transaction_id'  => new sfWidgetFormFilterInput(),
      'call_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'cdr'             => new sfWidgetFormFilterInput(),
      'cid'             => new sfWidgetFormFilterInput(),
      'mcc'             => new sfWidgetFormFilterInput(),
      'mnc'             => new sfWidgetFormFilterInput(),
      'imsi'            => new sfWidgetFormFilterInput(),
      'msisdn'          => new sfWidgetFormFilterInput(),
      'destination'     => new sfWidgetFormFilterInput(),
      'leg'             => new sfWidgetFormFilterInput(),
      'leg_duration'    => new sfWidgetFormFilterInput(),
      'reseller_charge' => new sfWidgetFormFilterInput(),
      'client_charge'   => new sfWidgetFormFilterInput(),
      'user_charge'     => new sfWidgetFormFilterInput(),
      'iot'             => new sfWidgetFormFilterInput(),
      'user_balance'    => new sfWidgetFormFilterInput(),
      'ecc'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'request_type'    => new sfValidatorPass(array('required' => false)),
      'c9_timestamp'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'transaction_id'  => new sfValidatorPass(array('required' => false)),
      'call_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cdr'             => new sfValidatorPass(array('required' => false)),
      'cid'             => new sfValidatorPass(array('required' => false)),
      'mcc'             => new sfValidatorPass(array('required' => false)),
      'mnc'             => new sfValidatorPass(array('required' => false)),
      'imsi'            => new sfValidatorPass(array('required' => false)),
      'msisdn'          => new sfValidatorPass(array('required' => false)),
      'destination'     => new sfValidatorPass(array('required' => false)),
      'leg'             => new sfValidatorPass(array('required' => false)),
      'leg_duration'    => new sfValidatorPass(array('required' => false)),
      'reseller_charge' => new sfValidatorPass(array('required' => false)),
      'client_charge'   => new sfValidatorPass(array('required' => false)),
      'user_charge'     => new sfValidatorPass(array('required' => false)),
      'iot'             => new sfValidatorPass(array('required' => false)),
      'user_balance'    => new sfValidatorPass(array('required' => false)),
      'ecc'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cloud9_data_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cloud9Data';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'request_type'    => 'Text',
      'c9_timestamp'    => 'Date',
      'transaction_id'  => 'Text',
      'call_date'       => 'Date',
      'cdr'             => 'Text',
      'cid'             => 'Text',
      'mcc'             => 'Text',
      'mnc'             => 'Text',
      'imsi'            => 'Text',
      'msisdn'          => 'Text',
      'destination'     => 'Text',
      'leg'             => 'Text',
      'leg_duration'    => 'Text',
      'reseller_charge' => 'Text',
      'client_charge'   => 'Text',
      'user_charge'     => 'Text',
      'iot'             => 'Text',
      'user_balance'    => 'Text',
      'ecc'             => 'Text',
    );
  }
}
