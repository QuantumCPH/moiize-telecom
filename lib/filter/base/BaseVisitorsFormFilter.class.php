<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Visitors filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseVisitorsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'host_id'    => new sfWidgetFormFilterInput(),
      'banner_id'  => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'status'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'host_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'banner_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'status'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('visitors_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Visitors';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'host_id'    => 'Number',
      'banner_id'  => 'Number',
      'created_at' => 'Date',
      'status'     => 'Text',
    );
  }
}
