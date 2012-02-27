<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * CompanyBank filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCompanyBankFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'     => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'reg_nr'         => new sfWidgetFormFilterInput(),
      'account_number' => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'company_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Company', 'column' => 'id')),
      'reg_nr'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'account_number' => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('company_bank_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyBank';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'company_id'     => 'ForeignKey',
      'reg_nr'         => 'Number',
      'account_number' => 'Text',
      'created_at'     => 'Date',
    );
  }
}
