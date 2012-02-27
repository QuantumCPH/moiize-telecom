<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Package filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BasePackageFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'               => new sfWidgetFormFilterInput(),
      'billing_dur'        => new sfWidgetFormFilterInput(),
      'billing_due_days'   => new sfWidgetFormFilterInput(),
      'specificatoin_cost' => new sfWidgetFormFilterInput(),
      'R1_cost'            => new sfWidgetFormFilterInput(),
      'R2_cost'            => new sfWidgetFormFilterInput(),
      'activaton_cost'     => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'name'               => new sfValidatorPass(array('required' => false)),
      'billing_dur'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'billing_due_days'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'specificatoin_cost' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'R1_cost'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'R2_cost'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'activaton_cost'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('package_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Package';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'name'               => 'Text',
      'billing_dur'        => 'Number',
      'billing_due_days'   => 'Number',
      'specificatoin_cost' => 'Number',
      'R1_cost'            => 'Number',
      'R2_cost'            => 'Number',
      'activaton_cost'     => 'Number',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
