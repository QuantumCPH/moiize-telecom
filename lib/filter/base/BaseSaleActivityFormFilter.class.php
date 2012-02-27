<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SaleActivity filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseSaleActivityFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'              => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'ticket_number'           => new sfWidgetFormFilterInput(),
      'sale_action_id'          => new sfWidgetFormPropelChoice(array('model' => 'SaleAction', 'add_empty' => true)),
      'comment'                 => new sfWidgetFormFilterInput(),
      'file_path'               => new sfWidgetFormFilterInput(),
      'user_id'                 => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'sale_activity_status_id' => new sfWidgetFormPropelChoice(array('model' => 'SaleActivityStatus', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'company_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Company', 'column' => 'id')),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'ticket_number'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sale_action_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SaleAction', 'column' => 'id')),
      'comment'                 => new sfValidatorPass(array('required' => false)),
      'file_path'               => new sfValidatorPass(array('required' => false)),
      'user_id'                 => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'sale_activity_status_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SaleActivityStatus', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sale_activity_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SaleActivity';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'company_id'              => 'ForeignKey',
      'created_at'              => 'Date',
      'ticket_number'           => 'Number',
      'sale_action_id'          => 'ForeignKey',
      'comment'                 => 'Text',
      'file_path'               => 'Text',
      'user_id'                 => 'ForeignKey',
      'sale_activity_status_id' => 'ForeignKey',
    );
  }
}
