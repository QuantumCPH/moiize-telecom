<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * CompanyPackage filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCompanyPackageFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'billing_dur'        => new sfWidgetFormFilterInput(),
      'billing_due_days'   => new sfWidgetFormFilterInput(),
      'letter_cost'        => new sfWidgetFormFilterInput(),
      'email_cost'         => new sfWidgetFormFilterInput(),
      'specificatoin_cost' => new sfWidgetFormFilterInput(),
      'R1_cost'            => new sfWidgetFormFilterInput(),
      'R2_cost'            => new sfWidgetFormFilterInput(),
      'activaton_cost'     => new sfWidgetFormFilterInput(),
      'company_id'         => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'is_active'          => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'billing_dur'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'billing_due_days'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'letter_cost'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'email_cost'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'specificatoin_cost' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'R1_cost'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'R2_cost'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'activaton_cost'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'company_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Company', 'column' => 'id')),
      'is_active'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('company_package_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyPackage';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'billing_dur'        => 'Number',
      'billing_due_days'   => 'Number',
      'letter_cost'        => 'Number',
      'email_cost'         => 'Number',
      'specificatoin_cost' => 'Number',
      'R1_cost'            => 'Number',
      'R2_cost'            => 'Number',
      'activaton_cost'     => 'Number',
      'company_id'         => 'ForeignKey',
      'is_active'          => 'Number',
      'created_at'         => 'Date',
    );
  }
}
