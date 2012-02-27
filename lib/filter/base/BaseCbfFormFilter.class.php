<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Cbf filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseCbfFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      's'             => new sfWidgetFormFilterInput(),
      'da'            => new sfWidgetFormFilterInput(),
      'message'       => new sfWidgetFormFilterInput(),
      'st'            => new sfWidgetFormFilterInput(),
      'country_id'    => new sfWidgetFormFilterInput(),
      'mobile_number' => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      's'             => new sfValidatorPass(array('required' => false)),
      'da'            => new sfValidatorPass(array('required' => false)),
      'message'       => new sfValidatorPass(array('required' => false)),
      'st'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'country_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mobile_number' => new sfValidatorPass(array('required' => false)),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('cbf_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cbf';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      's'             => 'Text',
      'da'            => 'Text',
      'message'       => 'Text',
      'st'            => 'Number',
      'country_id'    => 'Number',
      'mobile_number' => 'Text',
      'created_at'    => 'Date',
    );
  }
}
