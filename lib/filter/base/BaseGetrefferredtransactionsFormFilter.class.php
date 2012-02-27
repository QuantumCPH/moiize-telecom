<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Getrefferredtransactions filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseGetrefferredtransactionsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'transaction_id'        => new sfWidgetFormFilterInput(),
      'customer_order_id'     => new sfWidgetFormFilterInput(),
      'amount'                => new sfWidgetFormFilterInput(),
      'customer_id'           => new sfWidgetFormFilterInput(),
      'is_first_order'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'registration_earning'  => new sfWidgetFormFilterInput(),
      'extra_refills_earning' => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'referrer_id'           => new sfWidgetFormFilterInput(),
      'name'                  => new sfWidgetFormFilterInput(),
      'first_name'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'transaction_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'customer_order_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'amount'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'customer_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_first_order'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'registration_earning'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'extra_refills_earning' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'referrer_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'name'                  => new sfValidatorPass(array('required' => false)),
      'first_name'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('getrefferredtransactions_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Getrefferredtransactions';
  }

  public function getFields()
  {
    return array(
      'transaction_id'        => 'Number',
      'customer_order_id'     => 'Number',
      'amount'                => 'Number',
      'customer_id'           => 'Number',
      'is_first_order'        => 'Boolean',
      'registration_earning'  => 'Number',
      'extra_refills_earning' => 'Number',
      'created_at'            => 'Date',
      'referrer_id'           => 'Number',
      'name'                  => 'Text',
      'first_name'            => 'Text',
      'id'                    => 'Number',
    );
  }
}
