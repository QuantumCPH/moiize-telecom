<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Getrefferredtransactionsgroupbycustomer filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseGetrefferredtransactionsgroupbycustomerFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'customer_id'        => new sfWidgetFormFilterInput(),
      'is_first_order'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'amount'             => new sfWidgetFormFilterInput(),
      'amount_cur_month'   => new sfWidgetFormFilterInput(),
      'referrer_id'        => new sfWidgetFormFilterInput(),
      're_todate'          => new sfWidgetFormFilterInput(),
      're_cur_month'       => new sfWidgetFormFilterInput(),
      'ere_todate'         => new sfWidgetFormFilterInput(),
      'ere_cur_month'      => new sfWidgetFormFilterInput(),
      'total_transactions' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'customer_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_first_order'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'amount'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'amount_cur_month'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'referrer_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      're_todate'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      're_cur_month'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'ere_todate'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'ere_cur_month'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_transactions' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('getrefferredtransactionsgroupbycustomer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Getrefferredtransactionsgroupbycustomer';
  }

  public function getFields()
  {
    return array(
      'customer_id'        => 'Number',
      'is_first_order'     => 'Boolean',
      'amount'             => 'Number',
      'amount_cur_month'   => 'Number',
      'referrer_id'        => 'Number',
      're_todate'          => 'Number',
      're_cur_month'       => 'Number',
      'ere_todate'         => 'Number',
      'ere_cur_month'      => 'Number',
      'total_transactions' => 'Number',
      'id'                 => 'Number',
    );
  }
}
