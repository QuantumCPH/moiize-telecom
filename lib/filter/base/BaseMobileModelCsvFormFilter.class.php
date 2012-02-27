<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * MobileModelCsv filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseMobileModelCsvFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nokia'        => new sfWidgetFormFilterInput(),
      'SonyEricsson' => new sfWidgetFormFilterInput(),
      'HTC'          => new sfWidgetFormFilterInput(),
      'iPhone'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Nokia'        => new sfValidatorPass(array('required' => false)),
      'SonyEricsson' => new sfValidatorPass(array('required' => false)),
      'HTC'          => new sfValidatorPass(array('required' => false)),
      'iPhone'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mobile_model_csv_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MobileModelCsv';
  }

  public function getFields()
  {
    return array(
      'Nokia'        => 'Text',
      'SonyEricsson' => 'Text',
      'HTC'          => 'Text',
      'iPhone'       => 'Text',
      'id'           => 'Number',
    );
  }
}
