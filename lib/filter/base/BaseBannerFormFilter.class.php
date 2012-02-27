<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Banner filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseBannerFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'banner_name' => new sfWidgetFormFilterInput(),
      'host_id'     => new sfWidgetFormFilterInput(),
      'status'      => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'counter'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'banner_name' => new sfValidatorPass(array('required' => false)),
      'host_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'status'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'counter'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('banner_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banner';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'banner_name' => 'Text',
      'host_id'     => 'Number',
      'status'      => 'Number',
      'created_at'  => 'Date',
      'counter'     => 'Number',
    );
  }
}
