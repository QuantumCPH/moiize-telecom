<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * FonetCustomer filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseFonetCustomerFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fonet_customer_code' => new sfWidgetFormFilterInput(),
      'activated_on'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'sip_name'            => new sfWidgetFormFilterInput(),
      'sip_pwd'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fonet_customer_code' => new sfValidatorPass(array('required' => false)),
      'activated_on'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'sip_name'            => new sfValidatorPass(array('required' => false)),
      'sip_pwd'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('fonet_customer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'FonetCustomer';
  }

  public function getFields()
  {
    return array(
      'fonet_customer_id'   => 'Number',
      'fonet_customer_code' => 'Text',
      'activated_on'        => 'Date',
      'sip_name'            => 'Text',
      'sip_pwd'             => 'Text',
    );
  }
}
