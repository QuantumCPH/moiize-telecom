<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * TmpCdrLog filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseTmpCdrLogFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'date'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'from_land'   => new sfWidgetFormFilterInput(),
      'from_no'     => new sfWidgetFormFilterInput(),
      'to_no'       => new sfWidgetFormFilterInput(),
      'dur_hms'     => new sfWidgetFormFilterInput(),
      'dur_secs'    => new sfWidgetFormFilterInput(),
      'price'       => new sfWidgetFormFilterInput(),
      'description' => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'date'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'from_land'   => new sfValidatorPass(array('required' => false)),
      'from_no'     => new sfValidatorPass(array('required' => false)),
      'to_no'       => new sfValidatorPass(array('required' => false)),
      'dur_hms'     => new sfValidatorPass(array('required' => false)),
      'dur_secs'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'price'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'description' => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('tmp_cdr_log_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TmpCdrLog';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'date'        => 'Date',
      'from_land'   => 'Text',
      'from_no'     => 'Text',
      'to_no'       => 'Text',
      'dur_hms'     => 'Text',
      'dur_secs'    => 'Number',
      'price'       => 'Number',
      'description' => 'Text',
      'created_at'  => 'Date',
    );
  }
}
